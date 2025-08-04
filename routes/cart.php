<?php

use App\Http\Controllers\CartItemController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth.jwt')->group(function () {
    Route::delete('/carts/cleanup', [CartItemController::class, 'cleanup']); // Làm sạch giỏ hàng
    
    // Standard CRUD routes
    Route::apiResource('carts', CartItemController::class);


    // Bật/tắt từng item
    Route::patch('/cart-items/{cart}/toggle', [CartItemController::class, 'toggleActive']);

    // Bật/tắt toàn bộ
    Route::patch('/cart-items/toggle-all', [CartItemController::class, 'toggleAll']);
});
