<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::post('/users', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/carts', [CartController::class, 'find']);
Route::post('/carts/products', [CartController::class, 'store']);
Route::delete('/carts/products/{productId}', [CartController::class, 'destroy']);

Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders', [OrderController::class, 'index']);