<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\InformasiBengkelController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ==========================================
// HALAMAN UTAMA
// ==========================================
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ==========================================
// LOGOUT
// ==========================================
Route::match(['get', 'post'], '/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

// ==========================================
// DASHBOARD DAN BOOKING PELANGGAN
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [BookingController::class, 'dashboard'])
        ->name('dashboard');

    Route::get('/home', [BookingController::class, 'dashboard'])
        ->name('home');

    Route::prefix('booking')->name('booking.')->group(function () {

        Route::get('/', [BookingController::class, 'index'])
            ->name('index');

        Route::get('/create', [BookingController::class, 'create'])
            ->name('create');

        Route::post('/', [BookingController::class, 'store'])
            ->name('store');

        Route::get('/{id}', [BookingController::class, 'show'])
            ->whereNumber('id')
            ->name('show');

        Route::get('/{id}/edit', [BookingController::class, 'edit'])
            ->whereNumber('id')
            ->name('edit');

        Route::put('/{id}', [BookingController::class, 'update'])
            ->whereNumber('id')
            ->name('update');

        Route::delete('/{id}/cancel', [BookingController::class, 'cancel'])
            ->name('cancel');
    });
});

// ==========================================
// ADMIN
// ==========================================
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

        // Jadwal servis
        Route::get('/jadwal-servis', [BookingController::class, 'jadwal'])
            ->name('jadwal-servis');

        // Update status booking
        Route::put('/booking/{id}', [BookingController::class, 'updateStatus'])
            ->name('booking.update');

        // ==========================================
        // DATA MEKANIK
        // ==========================================
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

        // ==========================================
        // INFORMASI BENGKEL
        // ==========================================
        Route::get('/informasi-bengkel', [InformasiBengkelController::class, 'index'])
            ->name('informasi-bengkel.index');

        Route::put('/informasi-bengkel', [InformasiBengkelController::class, 'update'])
            ->name('informasi-bengkel.update');

        // Pengumuman
        Route::post('/pengumuman', [InformasiBengkelController::class, 'storePengumuman'])
            ->name('pengumuman.store');

        Route::put('/pengumuman/{id}', [InformasiBengkelController::class, 'updatePengumuman'])
            ->name('pengumuman.update');

        Route::delete('/pengumuman/{id}', [InformasiBengkelController::class, 'destroyPengumuman'])
            ->name('pengumuman.destroy');

        // ==========================================
        // KELOLA LAYANAN & HARGA
        // ==========================================
        Route::get('/layanan', [ServiceController::class, 'index'])
            ->name('layanan.index');

        Route::get('/layanan/tambah', [ServiceController::class, 'create'])
            ->name('layanan.create');

        Route::post('/layanan', [ServiceController::class, 'store'])
            ->name('layanan.store');

        // Detail layanan
        Route::get('/layanan/{id}', [ServiceController::class, 'show'])
            ->whereNumber('id')
            ->name('layanan.show');

        // Edit layanan
        Route::get('/layanan/{id}/edit', [ServiceController::class, 'edit'])
            ->whereNumber('id')
            ->name('layanan.edit');

        // Update layanan
        Route::put('/layanan/{id}', [ServiceController::class, 'update'])
            ->whereNumber('id')
            ->name('layanan.update');

        // Hapus layanan
        Route::delete('/layanan/{id}', [ServiceController::class, 'destroy'])
            ->whereNumber('id')
            ->name('layanan.destroy');
    });

// ==========================================
// PROFIL
// ==========================================
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

// ==========================================
// LOGIN & REGISTER
// ==========================================
Route::middleware('guest')->group(function () {

    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});