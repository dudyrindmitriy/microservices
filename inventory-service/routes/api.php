<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::post('/v1/items', [ItemController::class, 'store']);
Route::get('/v1/items/{sku}', [ItemController::class, 'show']);
