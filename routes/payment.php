<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VnpayController;

Route::prefix('payment')->group(function () {
    Route::get('/vnpay/return', [VnpayController::class, 'paymentReturn']);
});
