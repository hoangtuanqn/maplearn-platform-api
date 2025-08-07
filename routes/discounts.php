<?php

use App\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\Route;

// Route::apiResource('discounts', DiscountController::class)->middleware('auth.jwt');
Route::prefix('discounts')->middleware('auth.jwt')->group(function () {
    Route::post('/check-coupon', [DiscountController::class, 'checkCoupon']);
});
