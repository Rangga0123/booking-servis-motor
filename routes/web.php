<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\InformasiBengkelController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::match(['get', 'post'], '/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard pelanggan
    Route::get('/dashboard', [BookingController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/home', [BookingController::class, 'dashboard'])
        ->name('home');

    // Booking servis pelanggan
    Route::prefix('booking')->name('booking.')->group(function () {

        Route::get('/', [BookingController::class, 'index'])
            ->name('index');

        Route::get('/create', [BookingController::class, 'create'])
            ->name('create');

        Route::post('/', [BookingController::class, 'store'])
            ->name('store');

        Route::get('/{id}/edit', [BookingController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [BookingController::class, 'update'])
            ->name('update');

        Route::delete('/{id}/cancel', [BookingController::class, 'cancel'])
            ->name('cancel');
    });
});

// Admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [BookingController::class, 'indexAdmin'])
            ->name('dashboard');

        // Pelanggan dan pesanan
        Route::get('/pelanggan-pesanan', [AdminController::class, 'pelangganPesanan'])
            ->name('pelanggan-pesanan');

        Route::put('/booking/{id}', [BookingController::class, 'updateStatus'])
            ->name('booking.update');

        // Data mekanik
        Route::get('/mekanik', [AdminController::class, 'indexMekanik'])
            ->name('mekanik.index');

        Route::get('/mekanik/tambah', [AdminController::class, 'createMekanik'])
            ->name('mekanik.create');

        Route::post('/mekanik', [AdminController::class, 'storeMekanik'])
            ->name('mekanik.store');

        Route::get('/mekanik/{id}/edit', [AdminController::class, 'editMekanik'])
            ->name('mekanik.edit');

        Route::put('/mekanik/{id}', [AdminController::class, 'updateMekanik'])
            ->name('mekanik.update');

        Route::delete('/mekanik/{id}', [AdminController::class, 'destroyMekanik'])
            ->name('mekanik.destroy');

        // Pengaturan informasi bengkel
        Route::get('/informasi-bengkel', [InformasiBengkelController::class, 'index'])
            ->name('informasi-bengkel.index');

        Route::put('/informasi-bengkel', [InformasiBengkelController::class, 'update'])
            ->name('informasi-bengkel.update');

        // Pengelolaan pengumuman
        Route::post('/pengumuman', [InformasiBengkelController::class, 'storePengumuman'])
            ->name('pengumuman.store');

        Route::put('/pengumuman/{id}', [InformasiBengkelController::class, 'updatePengumuman'])
            ->name('pengumuman.update');

        Route::delete('/pengumuman/{id}', [InformasiBengkelController::class, 'destroyPengumuman'])
            ->name('pengumuman.destroy');
    });

// Profil
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])
        ->name('profile.photo.update');

    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])
        ->name('profile.photo.destroy');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::put('/password', [PasswordController::class, 'update'])
        ->name('password.update');
});

// Login dan register
Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});