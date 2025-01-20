<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; 
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

Route::post('/login', [AuthController::class, 'login']);  


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); 
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/categories', [CategoryController::class, 'index']);
});