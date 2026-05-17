<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PaymentController;
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

// --- PASSWORD RECOVERY ROUTES ---
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'resetMpin'])->name('password.update');


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
    
    Route::post('/send-payment', [PaymentController::class, 'send'])->name('payment.send');

    // --- ADD MONEY ---
    Route::get('/add-money', function () {
        return view('addmoney'); 
    })->name('add.money');
    
    // FIXED: Form routes to PaymentController@deposit and matches name('deposit.process') perfectly!
    Route::post('/deposit', [PaymentController::class, 'deposit'])->name('deposit.process');

    // --- TRANSACTIONS ---
    Route::get('/transactions', function () {
        $transactions = DB::table('transactions')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('transaction', compact('transactions'));
    })->name('transactions.index');

    // --- REQUEST PAYMENT ---
    Route::get('/request-payment', function () {
        return view('requestpayment');
    })->name('request.payment');

    Route::post('/request-payment', [AuthController::class, 'storePaymentRequest'])->name('payment.request.store');

    // --- BILLS PAYMENT GROUP ---
    Route::prefix('pay-bill')->group(function () {
        Route::get('/', function () { return view('paybill'); })->name('pay.bill');
        
        // Electricity
        Route::get('/electricity', function () { return view('electricity'); })->name('pay.electricity');
        Route::post('/electricity', [PaymentController::class, 'processElectricity'])->name('pay.electricity.process');

        // Insurance
        Route::get('/insurance', function () { return view('insurance'); })->name('pay.insurance');
        // ADDED: POST handler to cleanly accept the form processing requests
        Route::post('/insurance', [PaymentController::class, 'processInsurance'])->name('pay.insurance.process');

        // Other Bills
        Route::get('/water', function () { return view('water'); })->name('pay.water');
        Route::get('/internet', function () { return view('internet'); })->name('pay.internet');
        Route::get('/mobile', function () { return view('mobile'); })->name('pay.mobile');
        Route::get('/cable', function () { return view('cable'); })->name('pay.cable');
        Route::get('/rent', function () { return view('rent'); })->name('pay.rent');
    });

    // --- SETTINGS ---
    Route::get('/settings', function () {
        return view('settings');
    })->name('settings');

    // FIXED: Form now routes directly to AuthController@updateSettings to keep your update logic functional!
    Route::post('/update-settings', [AuthController::class, 'updateSettings'])->name('settings.update');

});