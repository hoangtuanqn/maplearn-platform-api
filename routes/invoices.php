<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;

Route::apiResource('invoices', InvoiceController::class)->middleware('auth.jwt');
