<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/products', ProductController::class);
Route::apiResource('/customers', CustomerController::class);
Route::apiResource('/sales', SaleController::class);