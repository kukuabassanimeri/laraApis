<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

# Get all products route
Route::get('/products', [ProductController::class, 'index']);

# Get Single product route
Route::get('/products/{id}', [ProductController::class, 'show']);

# Search for a product route
Route::get('/products/search/{name}', [ProductController::class, 'search']);

# Register user route
Route::post('/register', [AuthController::class, 'register']);

# Login user route
Route::post('/login', [AuthController::class, 'login']);

# Use resource controller to implement all the crud routing.
# Route::resource('products', ProductController::class);

# Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    # Create product route
    Route::post('/products', [ProductController::class, 'store']);

    # Delete the product route
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    # Update the product and return it
    Route::put('/products/{id}', [ProductController::class, 'update']);

    # Logged out route
    Route::post('/logout', [AuthController::class, 'logout']);
});
