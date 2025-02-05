<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);
Route::get('/products', [ProductController::class, 'index']);
