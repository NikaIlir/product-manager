<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::post('/sanctum/token', LoginController::class)->name('login');

Route::put('/products/{id}', [ProductController::class, 'update'])
    ->middleware('auth:sanctum');
