<?php

use Illuminate\Support\Facades\Route;
// This line connects your routes to the Controller you just created
use App\Http\Controllers\AuthController;

// 1. LOGIN PAGE (The home page)
Route::get('/', function () {
    return view('login');
});

// 2. REGISTER PAGE
Route::get('/register', function () {
    return view('register');
});

// 3. DASHBOARD PAGE
Route::get('/dashboard', function () {
    return view('dashboard');
});

// 4. THE ACTION: This handles the data when you click "Register"
Route::post('/register-user', [AuthController::class, 'register']);
Route::post('/login-user', [AuthController::class, 'login']);