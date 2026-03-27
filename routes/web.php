<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\FactuurController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagementDashboardController;
use App\Http\Controllers\AccommodatieController;
use App\Http\Controllers\TransportController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/accounts', [AccountController::class, 'index'])
    ->middleware(['auth', 'can:view-account-overview'])
    ->name('accounts.index');

Route::middleware('auth')->group(function() {
    Route::resource('accommodaties', AccommodatieController::class);
    Route::post('/accommodaties/{accommodatie}/boeken', [AccommodatieController::class, 'boeken'])->name('accommodaties.boeken');
    Route::resource('facturen', FactuurController::class);
    Route::resource('transport', TransportController::class);
});

Route::middleware(['auth', 'can:manage-dashboard'])
    ->prefix('management')
    ->name('management.')
    ->group(function (): void {
        Route::get('/dashboard', [ManagementDashboardController::class, 'index'])
            ->name('index');
        Route::get('/boekingen', [ManagementDashboardController::class, 'bookings'])
            ->name('bookings');
        Route::get('/facturen', [ManagementDashboardController::class, 'facturen'])
            ->name('facturen');
    });
