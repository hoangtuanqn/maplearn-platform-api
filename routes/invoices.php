<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;


Route::apiResource('invoices', InvoiceController::class)->middleware('auth.jwt');
Route::middleware('auth.jwt')->group(function () {
    Route::prefix('invoices')->group(function () {
        Route::post('/{invoice}/pay-with-card', [InvoiceController::class, 'payWithCard']);
        // Route::post('/{invoice}/confirm', [InvoiceController::class, 'confirm']);
        Route::post('/{invoice}/cancel', [InvoiceController::class, 'cancel']);

        // Get card đã nạp trong invoice này
        Route::get('/{invoice}/cards', [InvoiceController::class, 'getCards']);
        // Thanh toán bằng thẻ cào
    });
});
// Cancel Invoice
