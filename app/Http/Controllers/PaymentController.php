<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Deposit via Simulated Xendit API Gateway (100% Bulletproof Demo Mode)
     */
    public function deposit(Request $request)
    {
        $user = Auth::user();

        // 1. Validate the user input amount (Max ₱50,000 at a time constraint)
        $request->validate([
            'amount' => 'required|numeric|min:1|max:50000',
        ], [
            'amount.max' => 'Transaction declined. The maximum deposit limit per transaction is ₱50,000.00.',
            'amount.min' => 'The minimum deposit amount is ₱1.00.',
        ]);

        $amount = $request->amount;

        // 2. COMPLIANCE CHECK: Enforce a strict ₱600,000 maximum wallet balance ceiling
        $maxWalletCap = 600000;
        if (($user->balance + $amount) > $maxWalletCap) {
            return back()->withInput()->withErrors([
                'amount' => "Deposit declined. This transaction would push your wallet balance over the maximum allowed limit of ₱" . number_format($maxWalletCap, 2) . "."
            ]);
        }

        // Generate final transaction reference string matching system format
        $reference = 'DEP-' . strtoupper(bin2hex(random_bytes(4)));

        /**
         * LOCAL GATEWAY SIMULATOR
         */
        DB::transaction(function () use ($user, $amount, $reference) {
            // Credit balance cleanly inside your paythru_users table
            DB::table('paythru_users')
                ->where('id', $user->id)
                ->increment('balance', $amount);

            // Save record cleanly matching your model schema
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'deposit',
                'amount' => $amount,
                'reference_number' => $reference,
                'description' => 'Xendit(Sandbox)', 
                'status' => 'completed'
            ]);
        });

        // Refresh user session data so dashboard instantly reflects new balance
        $user->refresh();

        // Redirect back to dashboard with your clean green success alert message
        return redirect('/dashboard')->with('success', '₱' . number_format($amount, 2) . ' deposited successfully!');
    }

    /**
     * Peer-to-Peer Transfer
     */
    public function send(Request $request)
    {
        $request->validate([
            'account_number' => 'required|string', 
            'amount' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:255'
        ]);

        $sender = Auth::user();
        $amount = $request->amount;

        $recipient = DB::table('paythru_users')
            ->where('account_number', $request->account_number)
            ->first();

        if (!$recipient) {
            return back()->withInput()->withErrors(['account_number' => 'Account number not found.']);
        }

        if ($sender->account_number === $request->account_number) {
            return back()->withInput()->withErrors(['account_number' => 'You cannot send money to yourself.']);
        }

        if ($sender->balance < $amount) {
            return back()->withInput()->withErrors(['amount' => 'Insufficient balance.']);
        }

        $reference = 'PAY-' . strtoupper(bin2hex(random_bytes(4)));

        DB::transaction(function () use ($sender, $recipient, $amount, $request, $reference) {
            DB::table('paythru_users')->where('id', $sender->id)->decrement('balance', $amount);
            DB::table('paythru_users')->where('id', $recipient->id)->increment('balance', $amount);

            Transaction::create([
                'user_id' => $sender->id,
                'type' => 'payment',
                'amount' => $amount,
                'reference_number' => $reference,
                'description' => $request->description ?: 'Sent to ' . $recipient->full_name,
                'status' => 'completed'
            ]);
        });

        // Refresh dynamic user data instance fields
        $sender->refresh();

        $details = [
            'amount' => $amount,
            'ref' => $reference,
            'reference_number' => $reference,
            'receiver' => $recipient->full_name,
            'type' => 'Peer-to-Peer Transfer'
        ];

        if (!empty($sender->email)) {
            try {
                if (View::exists('emails.transaction_notif')) {
                    Mail::send('emails.transaction_notif', $details, function($message) use ($sender) {
                        $message->to($sender->email)->subject('Transaction Successful - PayThru');
                    });
                }
            } catch (\Exception $e) {
                Log::error('P2P Mail delivery failed: ' . $e->getMessage());
            }
        }

        return redirect('/dashboard')->with('success', '₱' . number_format($amount, 2) . ' sent to ' . $recipient->full_name . ' successfully!');
    }

    /**
     * Bill Payments - Electricity & Fallbacks
     */
    public function processElectricity(Request $request)
    {
        $billerName = $request->input('biller_name') ?? $request->input('company') ?? 'Utility Provider';
        $request->merge(['biller_name' => $billerName]);

        $accountRules = 'required|numeric';
        $serviceFee = 15.00; 
        $expectedDigits = 6;

        $mobileProviders = ['Smart Communications', 'Globe Telecom', 'DITO Telecommunity', 'Smart', 'Globe', 'DITO'];

        if (in_array($billerName, $mobileProviders)) {
            $accountRules .= '|starts_with:09|digits:11';
            $expectedDigits = 11;
            $serviceFee = 0.00; 
        } elseif ($billerName === 'PhilHealth') {
            $accountRules .= '|digits:12'; 
            $expectedDigits = 12;
        } elseif ($billerName === 'SSS') {
            $accountRules .= '|digits:10';
            $expectedDigits = 10;
        } else {
            $accountRules .= '|digits:6'; 
            $expectedDigits = 6;
        }

        $customMessages = [
            'account_number.digits' => "Invalid account number. Account number should be exactly {$expectedDigits} digits.",
            'account_number.numeric' => 'Account number must contain numbers only.',
        ];

        $request->validate([
            'biller_name' => 'required|string',
            'account_number' => $accountRules,
            'amount' => 'required|numeric|min:1',
        ], $customMessages);

        $user = Auth::user();
        $totalDeduction = $request->amount + $serviceFee;

        if ($user->balance < $totalDeduction) {
            return back()->withInput()->withErrors(['amount' => 'Insufficient balance.']);
        }

        $reference = 'BILL-' . strtoupper(bin2hex(random_bytes(4)));
        $formattedDescription = trim($billerName) . ' (' . trim($request->account_number) . ') | Fee: ₱' . number_format($serviceFee, 2);

        DB::transaction(function () use ($user, $totalDeduction, $reference, $formattedDescription) {
            DB::table('paythru_users')->where('id', $user->id)->decrement('balance', $totalDeduction);

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'bill_payment',
                'amount' => $totalDeduction, 
                'reference_number' => $reference,
                'description' => $formattedDescription,
                'status' => 'completed'
            ]);
        });

        $user->refresh();

        $details = [
            'amount' => $totalDeduction, 
            'ref' => $reference,
            'reference_number' => $reference,
            'receiver' => $billerName,
            'type' => 'Bill Payment'
        ];

        if (!empty($user->email)) {
            try {
                if (View::exists('emails.transaction_notif')) {
                    Mail::send('emails.transaction_notif', $details, function($message) use ($user) {
                        $message->to($user->email)->subject('Bill Payment Successful - PayThru');
                    });
                }
            } catch (\Exception $e) {
                Log::error('Utility Bill Mail delivery failed: ' . $e->getMessage());
            }
        }

        return redirect('/dashboard')->with('success', 'Payment of ₱' . number_format($totalDeduction, 2) . ' (including fee) to ' . $billerName . ' was successful!');
    }

    /**
     * Bill Payments - Insurance (PhilHealth / SSS)
     */
    public function processInsurance(Request $request)
    {
        $billerName = $request->input('biller_name');
        $serviceFee = 15.00;
        
        if ($billerName === 'PhilHealth') {
            $accountRules = 'required|numeric|digits:12';
            $expectedDigits = 12;
        } else {
            $accountRules = 'required|numeric|digits:10'; 
            $expectedDigits = 10;
        }

        $customMessages = [
            'account_number.digits' => "Invalid account number. Account number should be exactly {$expectedDigits} digits.",
            'account_number.numeric' => 'Account number must contain numbers only.',
        ];

        $request->validate([
            'biller_name' => 'required|string',
            'account_number' => $accountRules,
            'amount' => 'required|numeric|min:1',
        ], $customMessages);

        $user = Auth::user();
        $totalDeduction = $request->amount + $serviceFee;

        if ($user->balance < $totalDeduction) {
            return back()->withInput()->withErrors(['amount' => 'Insufficient balance to complete payment, including the ₱15.00 service fee.']);
        }

        $reference = 'BILL-' . strtoupper(bin2hex(random_bytes(4)));
        $formattedDescription = trim($billerName) . ' (' . trim($request->account_number) . ') | Fee: ₱' . number_format($serviceFee, 2);

        DB::transaction(function () use ($user, $totalDeduction, $reference, $formattedDescription) {
            DB::table('paythru_users')->where('id', $user->id)->decrement('balance', $totalDeduction);

            Transaction::create([
                'user_id' => $user->id,
                'type' => 'bill_payment',
                'amount' => $totalDeduction, 
                'reference_number' => $reference,
                'description' => $formattedDescription,
                'status' => 'completed'
            ]);
        });

        $user->refresh();

        $details = [
            'amount' => $totalDeduction, 
            'ref' => $reference,
            'reference_number' => $reference,
            'receiver' => $billerName,
            'type' => 'Insurance Contribution'
        ];

        if (!empty($user->email)) {
            try {
                if (View::exists('emails.transaction_notif')) {
                    Mail::send('emails.transaction_notif', $details, function($message) use ($user) {
                        $message->to($user->email)->subject('Insurance Payment Successful - PayThru');
                    });
                }
            } catch (\Exception $e) {
                Log::error('Insurance Mail delivery failed: ' . $e->getMessage());
            }
        }

        return redirect('/dashboard')->with('success', 'Insurance payment of ₱' . number_format($totalDeduction, 2) . ' (including fee) to ' . $billerName . ' was processed successfully!');
    }
}