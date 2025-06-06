<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleItemController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/products', ProductController::class);
Route::apiResource('/customers', CustomerController::class);
Route::apiResource('/sales', SaleController::class);
