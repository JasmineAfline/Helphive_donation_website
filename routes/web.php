<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;

// --------------------
// Authentication Routes
// --------------------
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// --------------------
// Public Routes
// --------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');
Route::get('/about', function () { return view('about'); })->name('about');

// Donation Routes
Route::get('/donate', [DonationController::class, 'general'])->name('donate.general');
Route::get('/donate/{campaign}', [DonationController::class, 'create'])->name('donate.campaign');
Route::post('/donate', [DonationController::class, 'store'])->name('donate.submit');

// --------------------
// Admin Routes
// --------------------
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('/campaigns', CampaignController::class);
});
