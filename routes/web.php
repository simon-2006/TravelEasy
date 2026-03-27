<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\FactuurController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagementDashboardController;
use App\Http\Controllers\AccommodatieController;
use App\Http\Controllers\TransportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReisController;
use App\Http\Controllers\KlantController;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});




Route::get('/reizen', [ReisController::class, 'index'])->name('reizen.index');
Route::get('/reizen/toevoegen', [ReisController::class, 'create'])->name('reizen.create');
Route::post('/reizen', [ReisController::class, 'store'])->name('reizen.store');
Route::get('/reizen/{id}', [ReisController::class, 'show'])->name('reizen.show');

Route::get('/accommodaties', [AccommodatieController::class, 'index'])->name('accommodaties.index');
Route::get('/accommodaties/toevoegen', [AccommodatieController::class, 'create'])->name('accommodaties.create');
Route::post('/accommodaties', [AccommodatieController::class, 'store'])->name('accommodaties.store');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'can:view-account-overview'])
    ->prefix('accounts')
    ->name('accounts.')
    ->group(function (): void {
        Route::get('/', [AccountController::class, 'index'])->name('index');

        Route::get('/nieuw', [AccountController::class, 'create'])
            ->middleware('can:manage-dashboard')
            ->name('create');

        Route::post('/', [AccountController::class, 'store'])
            ->middleware('can:manage-dashboard')
            ->name('store');
    });

Route::post('/accounts', [AccountController::class, 'store'])
    ->middleware(['auth', 'can:manage-dashboard'])
    ->name('accounts.store');

Route::middleware(['auth', 'can:manage-dashboard'])
    ->prefix('management')
    ->name('management.')
    ->group(function (): void {
        Route::get('/dashboard', [ManagementDashboardController::class, 'index'])
            ->name('index');
        Route::get('/boekingen', [ManagementDashboardController::class, 'bookings'])
            ->name('bookings');
        Route::get('/omzet', [ManagementDashboardController::class, 'revenue'])
            ->name('revenue');
    });


Route::middleware(['auth'])->group(function () {
    Route::get('/klanten/create', [KlantController::class, 'create']);
    Route::get('/klanten', [KlantController::class, 'index'])->name('klanten.index');
    // Route::get('/klanten/{id}/edit', [KlantController::class, 'edit']);
    Route::put('/klanten/{id}', [KlantController::class, 'update']);
    Route::delete('/klanten/{id}', [KlantController::class, 'destroy']);
    Route::post('/klanten', [KlantController::class, 'store']);
});
