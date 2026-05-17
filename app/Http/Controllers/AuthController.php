<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Http; 
use Illuminate\Support\Facades\Hash; // Handles secure Bcrypt encryption
use App\Http\Controllers\Controller;
use App\Notifications\PaymentReceived;
use App\Notifications\MoneyRequested; 
use App\Models\User; 

class AuthController extends Controller
{
    // --- REGISTRATION ---
    public function register(Request $request)
    {
        $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|string|email|unique:paythru_users,email',
            'phone_number' => 'required|string',
            'mpin'         => 'required|numeric|digits:6',
        ]);

        $accountNumber = 'PT-' . rand(10000000, 99999999);

        DB::table('paythru_users')->insert([
            'full_name'      => $request->full_name,
            'email'          => $request->email,
            'account_number' => $accountNumber,
            'phone_number'   => $request->phone_number,
            'mpin'           => Hash::make($request->mpin), 
            'balance'        => 0.00,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        return redirect('/')->with('success', 'Registration successful!');
    }

    // --- LOGIN ---
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mpin'  => 'required|numeric|digits:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->mpin, $user->mpin)) {
            Auth::login($user); 
            return redirect('/dashboard');
        } else {
            return back()->withInput()->withErrors([
                'email' => 'Invalid Email or MPIN credentials.'
            ]);
        }
    }

    // --- UPDATE ACCOUNT SETTINGS (FUNCTIONAL WORKFLOW) ---
    public function updateSettings(Request $request)
    {
        $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email',
            'current_mpin' => 'required|numeric|digits:6',
            'new_mpin'     => 'nullable|numeric|digits:6|confirmed', 
        ]);

        $user = Auth::user();
        $isMpinCorrect = false;

        // SMART AUTH CHECK: Handles both plain-text entries and encrypted secure hashes
        if (str_starts_with($user->mpin, '$2y$')) {
            if (Hash::check($request->current_mpin, $user->mpin)) {
                $isMpinCorrect = true;
            }
        } else {
            if ($request->current_mpin === $user->mpin) {
                $isMpinCorrect = true;
            }
        }

        if (!$isMpinCorrect) {
            return back()->withInput()->withErrors([
                'current_mpin' => 'The current MPIN you entered is incorrect.'
            ]);
        }

        $updateData = [
            'full_name'  => $request->full_name,
            'email'      => $request->email,
            'updated_at' => now(),
        ];

        if ($request->filled('new_mpin')) {
            $updateData['mpin'] = Hash::make($request->new_mpin);
        }

        DB::table('paythru_users')
            ->where('id', $user->id)
            ->update($updateData);

        return redirect('/settings')->with('success', 'Account settings updated successfully!');
    }

    // --- SEND PAYMENT ---
    public function sendPayment(Request $request)
    {
        $sender = Auth::user();
        $amount = $request->amount;
        $recipientAcc = $request->account_number;

        $recipient = DB::table('paythru_users')
                        ->where('account_number', $recipientAcc)
                        ->first();

        if (!$recipient) {
            return back()->with('error', 'Recipient account number not found.');
        }

        if ($recipient->id === $sender->id) {
            return back()->with('error', 'You cannot send money to yourself.');
        }

        if ($sender->balance < $amount) {
            return back()->with('error', 'Insufficient balance!');
        }

        $reference = 'REF' . strtoupper(uniqid());

        DB::transaction(function () use ($sender, $recipient, $amount, $reference) {
            DB::table('paythru_users')->where('id', $sender->id)->decrement('balance', $amount);
            DB::table('paythru_users')->where('id', $recipient->id)->increment('balance', $amount);

            DB::table('transactions')->insert([
                'user_id'          => $sender->id,
                'type'             => 'Send Money',
                'method'           => 'Wallet Transfer',
                'amount'           => $amount,
                'reference_number' => $reference,
                'description'      => "Sent to " . $recipient->full_name,
                'status'           => 'Completed',
                'created_at'       => now()
            ]);

            DB::table('transactions')->insert([
                'user_id'          => $recipient->id,
                'type'             => 'Receive Money',
                'method'           => 'Wallet Transfer',
                'amount'           => $amount,
                'reference_number' => $reference,
                'description'      => "Received from " . $sender->full_name,
                'status'           => 'Completed',
                'created_at'       => now()
            ]);
        });

        $recipientUser = User::find($recipient->id);
        if ($recipientUser) {
            $recipientUser->notify(new PaymentReceived($amount, $sender->full_name));
        }

        return redirect('/dashboard')->with('success', "₱" . number_format($amount, 2) . " sent successfully!");
    }

    // --- REQUEST PAYMENT ---
    public function storePaymentRequest(Request $request)
    {
        $request->validate([
            'recipient_email' => 'required|email',
            'amount'          => 'required|numeric|min:1',
            'reason'          => 'nullable|string',
            'due_date'        => 'nullable',
        ]);

        $amount = $request->amount;
        $apiKey = env('EXCHANGE_RATE_API_KEY');
        $usdAmount = 0;

        try {
            $response = Http::timeout(5)->get("https://v6.exchangerate-api.com/v6/{$apiKey}/pair/PHP/USD/{$amount}");
            if ($response->successful()) {
                $usdAmount = $response->json()['conversion_result'] ?? 0;
            }
        } catch (\Exception $e) {
            $usdAmount = 0; 
        }

        DB::table('payment_requests')->insert([
            'requester_id'    => Auth::id(),
            'recipient_email' => $request->recipient_email,
            'amount'          => $amount,
            'usd_equivalent'  => $usdAmount, 
            'reason'          => $request->reason,
            'due_date'        => $request->due_date,
            'status'          => 'Pending',
            'created_at'      => now(),
        ]);

        $recipient = User::where('email', $request->recipient_email)->first();
        if ($recipient) {
            $recipient->notify(new MoneyRequested(
                $amount, 
                Auth::user()->full_name, 
                $request->reason, 
                $usdAmount
            ));
        }

        return redirect('/dashboard')->with('success', 'Request sent successfully! Amount: ₱' . number_format($amount, 2));
    }

    // --- PASSWORD RECOVERY (Functional Reset Workflow) ---
    public function showForgotForm()
    {
        return view('forgot');
    }

    public function resetMpin(Request $request)
    {
        $request->validate([
            'email'        => 'required|email',
            'phone_number' => 'required|string',
            'new_mpin'     => 'required|numeric|digits:6', 
        ]);

        $userRecord = DB::table('paythru_users')
            ->where('email', $request->email)
            ->where('phone_number', $request->phone_number)
            ->first();

        if (!$userRecord) {
            return redirect()->back()->withInput()->withErrors([
                'email' => 'The provided account credentials do not match our system records.'
            ]);
        }

        DB::table('paythru_users')
            ->where('id', $userRecord->id)
            ->update([
                'mpin'       => Hash::make($request->new_mpin),
                'updated_at' => now()
            ]);

        $user = User::find($userRecord->id);
        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Your MPIN has been reset successfully.');
    }

    // --- LOGOUT ---
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}