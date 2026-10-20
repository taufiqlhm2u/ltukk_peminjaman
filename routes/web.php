<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'verif'])->name('login.verif');
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return 'Dashboard';
    });
});