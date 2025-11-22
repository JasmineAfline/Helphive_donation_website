<?php

use App\Http\Controllers\MpesaController;

Route::post('/mpesa/donate', [MpesaController::class, 'donate'])->name('mpesa.donate');
Route::post('/mpesa/callback', [MpesaController::class, 'callback']);
