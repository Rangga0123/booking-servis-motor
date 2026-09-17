<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Redirect halaman depan langsung ke dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// 1. Rute Pelanggan (Dashboard & Booking)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [BookingController::class, 'index'])->name('dashboard');
    Route::get('/home', [BookingController::class, 'index'])->name('home');

    // CRUD Booking Pelanggan
    Route::prefix('booking')->name('booking.')->group(function () {
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BookingController::class, 'update'])->name('update');
        Route::delete('/{id}', [BookingController::class, 'destroy'])->name('destroy');
    });
});

// 2. Rute Khusus Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::patch('/booking/{id}/status', [AdminController::class, 'updateStatus'])->name('booking.status');
});

// 3. Rute Profil User
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';