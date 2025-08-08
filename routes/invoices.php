<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;


Route::apiResource('invoices', InvoiceController::class)->middleware('auth.jwt');
Route::middleware('auth.jwt')->group(function () {
    Route::post('invoices/{invoice}/confirm', [InvoiceController::class, 'confirm']);
    Route::post('invoices/{invoice}/cancel', [InvoiceController::class, 'cancel']);
});
// Cancel Invoice
