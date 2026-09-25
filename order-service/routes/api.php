<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::post('/v1/orders', [OrderController::class, 'store']);
Route::get('/v1/orders/{id}', [OrderController::class, 'show']);
