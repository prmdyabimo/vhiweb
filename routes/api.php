<?php

use App\Presentation\Controllers\AuthController;
use App\Presentation\Controllers\ProductController;
use App\Presentation\Controllers\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api.key')->group(function () {
    Route::prefix('v1')->group(function () {

        // Auth
        Route::prefix('auth')->group(function () {
            Route::post('login', [AuthController::class, 'login']);
            Route::post('register', [AuthController::class, 'register']);

            Route::middleware('jwt.auth.custom')->group(function () {
                Route::post('logout', [AuthController::class, 'logout']);
                Route::post('refresh', [AuthController::class, 'refresh']);
                Route::get('profile', [AuthController::class, 'profile']);
            });
        });

        Route::middleware('jwt.auth.custom')->group(function () {
            // Vendor
            Route::prefix('vendor')->group(function () {
                Route::post('/', [VendorController::class, 'store']);
                Route::get('/', [VendorController::class, 'getVendor']);
            });

            // Product
            Route::prefix('product')->group(function () {
                Route::post('/', [ProductController::class, 'store']);
                Route::get('/', [ProductController::class, 'getProduct']);
                Route::get('/{id}', [ProductController::class, 'getProductById']);
                Route::get('/vendor/{vendorId}', [ProductController::class, 'getProductByVendorId']);
                Route::put('/{id}', [ProductController::class, 'update']);
                Route::delete('/{id}', [ProductController::class, 'delete']);
            });
        });
    });
});