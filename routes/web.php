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

// --------------------
// Donation Routes
// --------------------
// Redirect /donate to first campaign
Route::get('/donate', function () {
    $campaign = \App\Models\Campaign::first();
    if (!$campaign) {
        abort(404, 'No campaigns available.');
    }
    return redirect()->route('mpesa.checkout', ['campaign' => $campaign->id]);
})->name('donate.page');

// Show donation page for a specific campaign
Route::get('/donate/{campaign}', [DonationsController::class, 'create'])->name('donate.campaign');

// Submit donation via form
Route::post('/donate', [DonationsController::class, 'store'])->name('donate.submit');

// --------------------
// M-Pesa Routes
// --------------------
// Show checkout page for M-Pesa donation
Route::get('/checkout/{campaign}', [MpesaController::class, 'checkout'])->name('mpesa.checkout');

// Submit M-Pesa donation (STK Push)
Route::post('/mpesa/donate', [MpesaController::class, 'donate'])->name('mpesa.donate');

// M-Pesa callback (no CSRF)
Route::post('/mpesa/callback', [MpesaController::class, 'callback'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
    ->name('mpesa.callback');

// Success page after donation
Route::get('/donation/success', [MpesaController::class, 'success'])->name('mpesa.success');

// --------------------
// User Dashboard Routes
// --------------------
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
});

// --------------------
// Admin Routes
// --------------------
Route::middleware(['web', 'auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('/campaigns', CampaignController::class);
});
