<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller;
use App\Notifications\PaymentReceived;
use App\Models\User; 

class AuthController extends Controller
{
    // --- REGISTRATION ---
    public function register(Request $request)
    {
        $accountNumber = 'PT-' . rand(10000000, 99999999);

        DB::table('paythru_users')->insert([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'account_number' => $accountNumber,
            'phone_number' => $request->phone_number,
            'mpin' => $request->mpin, 
            'balance' => 0.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/')->with('success', 'Registration successful!');
    }

    // --- LOGIN (Fixes the "Undefined Method" error) ---
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)
                    ->where('mpin', $request->mpin)
                    ->first();

        if ($user) {
            Auth::login($user); 
            return redirect('/dashboard');
        } else {
            return back()->with('error', 'Invalid Email or MPIN.');
        }
    }

    // --- SEND PAYMENT (With Notification API) ---
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
                'user_id' => $sender->id,
                'type' => 'Send Money',
                'method' => 'Wallet Transfer',
                'amount' => $amount,
                'reference_number' => $reference,
                'description' => "Sent to " . $recipient->full_name,
                'status' => 'Completed',
                'created_at' => now()
            ]);

            DB::table('transactions')->insert([
                'user_id' => $recipient->id,
                'type' => 'Receive Money',
                'method' => 'Wallet Transfer',
                'amount' => $amount,
                'reference_number' => $reference,
                'description' => "Received from " . $sender->full_name,
                'status' => 'Completed',
                'created_at' => now()
            ]);
        });

        // Trigger Notification
        $recipientUser = User::find($recipient->id);
        if ($recipientUser) {
            $recipientUser->notify(new PaymentReceived($amount, $sender->full_name));
        }

        return redirect('/dashboard')->with('success', "₱" . number_format($amount, 2) . " sent successfully!");
    }

    // --- LOGOUT ---
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}