<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\AdminController;

// Home
Route::get('/', [CampaignController::class, 'index'])->name('campaigns.index');

// Campaigns
Route::get('/campaigns/{id}', [CampaignController::class, 'show'])->name('campaigns.show');

// Donations
Route::post('/donate', [DonationController::class, 'store'])->name('donate');

// Admin
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::resource('/admin/campaigns', CampaignController::class);
});
