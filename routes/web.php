<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 1. Halaman utama pelanggan setelah login (menggantikan dashboard bawaan)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [BookingController::class, 'index'])->name('dashboard');
    Route::get('/home', [BookingController::class, 'index'])->name('home');

    // Fitur CRUD Booking untuk Pelanggan
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
});

// 2. Rute Khusus Admin (Dilindungi Middleware Admin)
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