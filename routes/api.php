<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/diskons', [DiskonController::class, 'index']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('orders', OrderController::class);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::resource('carts', CartController::class);
    Route::resource('products', ProductController::class)->except('index')->middleware('admin');

    Route::resource('diskons', DiskonController::class)->except('index')->middleware('admin');
    Route::post('/products/{product}', [ProductController::class, 'update'])->middleware('admin');
    Route::post('/orders/{order}', [OrderController::class, 'update']);
    Route::post('/diskons/{diskon}', [DiskonController::class, 'update']);
});