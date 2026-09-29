<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\PerangkatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Data Perangkat
    Route::resource('perangkat', PerangkatController::class);

    // Maintenance
    Route::resource('maintenance', MaintenanceController::class);

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/checklist', [LaporanController::class, 'checklist'])->name('checklist');
        Route::get('/maintenance', [LaporanController::class, 'maintenance'])->name('maintenance');
        Route::get('/eviden', [LaporanController::class, 'eviden'])->name('eviden');
        Route::get('/cetak/{type}', [LaporanController::class, 'cetak'])->name('cetak');
    });

    // Manajemen User (Admin Only)
    Route::resource('users', UserController::class)->middleware('admin');
});

require __DIR__ . '/auth.php';