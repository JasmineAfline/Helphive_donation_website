<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MpesaController;

// --------------------
// Authentication
// --------------------
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// --------------------
// Public Pages
// --------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');

Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');

// Donations
Route::get('/donate/{campaign}', [DonationsController::class, 'create'])->name('donate.campaign');
Route::post('/donate', [DonationsController::class, 'store'])->name('donate.submit');

// M-Pesa
Route::get('/checkout/{campaign}', [MpesaController::class, 'checkout'])->name('mpesa.checkout');
Route::post('/mpesa/donate', [MpesaController::class, 'donate'])->name('mpesa.donate');
Route::post('/mpesa/callback', [MpesaController::class, 'callback'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('mpesa.callback');

Route::get('/donation/success', [MpesaController::class, 'success'])->name('mpesa.success');

// ------------------------
// User Dashboard
// ------------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// ------------------------
// Admin Routes (Role = admin)
// ------------------------
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/campaigns', [AdminController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/create', [AdminController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [AdminController::class, 'store'])->name('campaigns.store');

    Route::get('/campaigns/{id}/edit', [AdminController::class, 'edit'])->name('campaigns.edit');
    Route::put('/campaigns/{id}', [AdminController::class, 'update'])->name('campaigns.update');

    Route::delete('/campaigns/{id}', [AdminController::class, 'destroy'])->name('campaigns.destroy');

     // REPORTS PAGE
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
});
