<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
class AuthController extends Controller
{
    // This handles the Registration
    public function register(Request $request)
    {
        // 1. Save to the database
        DB::table('paythru_users')->insert([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'mpin' => $request->mpin, // In a real app, we'd encrypt this!
            'balance' => 500.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Send them to login page after success
        return redirect('/')->with('success', 'Account created! Please login.');
    }

    // Add this inside the AuthController class
    public function login(Request $request)
    {
    // 1. Look for the user in our table
    $user = DB::table('paythru_users')
                ->where('email', $request->email)
                ->where('mpin', $request->mpin)
                ->first();

    // 2. Check if we found them
    if ($user) {
        // Success! Send them to the dashboard
        return redirect('/dashboard');
    } else {
        // Failed! Send them back with an error
        return back()->with('error', 'Invalid Email or MPIN.');
    }
    }
}