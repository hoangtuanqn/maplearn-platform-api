<?php

use App\Http\Controllers\CartItemController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.jwt')->group(function () {
    Route::apiResource('carts', CartItemController::class);
    // Standard CRUD routes

    // Additional cart management routes
    Route::delete('carts', [CartItemController::class, 'clear']); // Xóa toàn bộ giỏ hàng
    Route::post('carts/cleanup', [CartItemController::class, 'cleanup']); // Làm sạch giỏ hàng
});
