<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CrewController;
use App\Http\Controllers\Admin\EquipmentController;
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
        Route::resource('kru', CrewController::class)->only(['index', 'create', 'edit', 'destroy'])->names('crew');
        Route::resource('kategori-alat', CategoryController::class)->only(['index', 'create', 'edit', 'destroy'])->names('category');
        Route::resource('alat', EquipmentController::class)->only(['index', 'create', 'edit', 'destroy'])->names('equipment');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});