<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;


Route::apiResource('invoices', InvoiceController::class)->middleware('auth.jwt');
Route::middleware('auth.jwt')->group(function () {
    Route::prefix('invoices')->group(function () {
        Route::post('/{invoice}/cancel', [InvoiceController::class, 'cancel']);
    });
});
// Cancel Invoice
