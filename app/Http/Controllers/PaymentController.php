<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'amount' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // 1. Check if user has enough balance
        if ($user->balance < $amount) {
            return back()->withErrors(['amount' => 'Insufficient balance.']);
        }

        // 2. Perform the transaction using a Database Transaction for safety
        DB::transaction(function () use ($user, $amount, $request) {
            // Deduct from sender
            DB::table('paythru_users')
                ->where('id', $user->id)
                ->decrement('balance', $amount);

            // Record the transaction
            Transaction::create([
                'user_id' => $user->id,
                'type' => 'payment',
                'amount' => $amount,
                'reference_number' => 'PAY-' . strtoupper(bin2hex(random_bytes(4))),
                'status' => 'completed'
            ]);
        });

        return redirect('/dashboard')->with('success', '₱' . number_format($amount, 2) . ' sent successfully!');
    }
}