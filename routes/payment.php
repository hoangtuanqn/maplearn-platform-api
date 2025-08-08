<?php
// routes/web.php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VnpayController;

Route::prefix('payment')->middleware('auth.jwt')->group(function () {
    // Tạo payment
    Route::post('/', [PaymentController::class, 'store']);

    Route::get('/vnpay/create/{transaction_code}', [VnpayController::class, 'createPayment']);

    Route::get('/vnpay/return', [VnpayController::class, 'paymentReturn']);
});
