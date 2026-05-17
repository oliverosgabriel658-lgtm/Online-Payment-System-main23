<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Update user profile or MPIN securely
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        // 1. Validate Form Inputs against your exact 'paythru_users' table
        $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255|unique:paythru_users,email,' . $user->id,
            'current_mpin' => 'required|string|digits:6',
            'new_mpin'     => 'nullable|string|digits:6|confirmed', // Must match new_mpin_confirmation
        ], [
            'new_mpin.digits' => 'The new MPIN must be exactly 6 digits.',
            'new_mpin.confirmed' => 'The new MPIN confirmation does not match.',
            'current_mpin.digits' => 'The current MPIN must be exactly 6 digits.',
        ]);

        // 2. Security Check: Since your DB stores plain text pins (e.g. '123123'), compare directly
        if ($request->current_mpin !== $user->mpin) {
            return redirect()->back()->withErrors(['current_mpin' => 'The current MPIN you entered is incorrect.']);
        }

        // 3. Prepare data mutations
        $updateData = [
            'full_name'  => $request->full_name,
            'email'      => $request->email,
            'updated_at' => now(),
        ];

        // 4. Check if user wants to change their login pin
        if ($request->filled('new_mpin')) {
            $updateData['mpin'] = $request->new_mpin;
        }

        // 5. Query builder direct save to guarantee matching database targets
        DB::table('paythru_users')
            ->where('id', $user->id)
            ->update($updateData);

        return redirect()->back()->with('success', 'Your account settings have been successfully updated.');
    }
}