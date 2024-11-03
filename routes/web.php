<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute untuk halaman depan
Route::get('/', [FieldController::class, 'indexForUser'])->name('index');

// Rute untuk halaman dashboard yang hanya bisa diakses oleh pengguna yang terautentikasi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Rute untuk profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk pemesanan, hanya dapat diakses oleh pengguna yang terautentikasi
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/store', [BookingController::class, 'store'])->name('store');
    });
});

// Rute Admin dengan middleware auth dan admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    
    // Rute resource untuk fields, schedules, bookings, dan users
    Route::resource('fields', FieldController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('bookings', BookingController::class);
    Route::resource('users', UserController::class);
});

// Rute untuk autentikasi
require __DIR__.'/auth.php';