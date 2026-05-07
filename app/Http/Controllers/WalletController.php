<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function deposit(Request $request)
    {
        // This validates that the user entered at least 100
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        // This updates the 'balance' column in your 'paythru_users' table
        DB::table('paythru_users')
            ->where('id', $user->id)
            ->increment('balance', $amount);

        // Redirects back to dashboard with a success message
        return redirect('/dashboard')->with('success', '₱' . number_format($amount, 2) . ' added successfully!');
    }
}