<?php

use App\Http\Controllers\Admin\OpertatorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'verif'])->name('login.verif');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function() {
        Route::resource('petugas', OpertatorController::class)->only(['index', 'create', 'edit', 'destroy'])->names('operator');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});