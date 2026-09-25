<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseController;

Route::post('/v1/purchases', [PurchaseController::class, 'store']);
Route::get('/v1/purchases/{id}', [PurchaseController::class, 'show']);
