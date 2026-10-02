<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
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

    Route::get('/dashboard', [BookingController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/home', [BookingController::class, 'dashboard'])
        ->name('home');

    Route::prefix('booking')->name('booking.')->group(function () {

        Route::get('/create', [BookingController::class, 'create'])
            ->name('create');

        Route::post('/', [BookingController::class, 'store'])
            ->name('store');

        Route::get('/{id}/edit', [BookingController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [BookingController::class, 'update'])
            ->name('update');

        Route::match(
            ['get', 'post', 'patch'],
            '/{id}/cancel',
            [BookingController::class, 'cancel']
        )->name('cancel');
    });
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [BookingController::class, 'indexAdmin'])
            ->name('dashboard');

        Route::put('/booking/{id}', [BookingController::class, 'updateStatus'])
            ->name('booking.update');
    });

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});