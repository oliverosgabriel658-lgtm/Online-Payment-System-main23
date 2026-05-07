<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// --- PUBLIC ROUTES ---
Route::get('/', function () {
    return view('login'); 
})->name('login');

Route::get('/register', function () {
    return view('register');
});

// Auth Actions
Route::post('/register-user', [AuthController::class, 'register']);
Route::post('/login-user', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// --- PROTECTED ROUTES (Requires Login) ---
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- SEND PAYMENT ---
    Route::get('/send-payment', function () {
        return view('sendpayment');
    })->name('payment.view');
    
    // Updated this line to use AuthController and match the URL in your form
    Route::post('/send-payment', [AuthController::class, 'sendPayment'])->name('payment.send');

    // --- ADD MONEY ---
    Route::get('/add-money', function () {
        return view('addmoney'); 
    })->name('add.money');
    
    Route::post('/add-money', [WalletController::class, 'deposit'])->name('deposit.store');

    // --- TRANSACTIONS ---
    Route::get('/transactions', function () {
        // Fetching transactions from the DB table for the logged-in user
        $transactions = DB::table('transactions')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('transaction', compact('transactions'));
    })->name('transactions.index');

    Route::get('/request-payment', function () {
        return view('requestpayment');
    })->name('request.payment');

    // Bills Payment Group
    Route::prefix('pay-bill')->group(function () {
        Route::get('/', function () { return view('paybill'); })->name('pay.bill');
        Route::get('/electricity', function () { return view('electricity'); });
        Route::get('/water', function () { return view('water'); });
        Route::get('/internet', function () { return view('internet'); });
        Route::get('/mobile', function () { return view('mobile'); });
        Route::get('/insurance', function () { return view('insurance'); });
        Route::get('/cable', function () { return view('cable'); });
        Route::get('/rent', function () { return view('rent'); });
    });

    // Settings
    Route::get('/settings', function () {
        return view('settings');
    });
});