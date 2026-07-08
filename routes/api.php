<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolTypeController;
use App\Http\Controllers\ReviewController;



// Public Routes
Route::post('/login', [AuthController::class, 'login']);

Route::get('/schools/{school}/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/{review}', [ReviewController::class, 'show']);
Route::get('/schools/filter', [SchoolController::class, 'filter']);

Route::get('/school-types', [SchoolTypeController::class, 'index']);
Route::get('/school-types/{schoolType}', [SchoolTypeController::class, 'show']);


// Protected Routes 
Route::middleware('auth:api')->group(function () {
    
    // Auth Actions
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);

    // Authenticated User Reviews
    Route::post('/schools/{school}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    Route::get('/users/{user}/reviews', [ReviewController::class, 'userReviews']);

    // Admin Only 
    Route::middleware('admin')->group(function () {
        
        // Schools 
        Route::post('/schools', [SchoolController::class, 'store']);
        Route::put('/schools/{id}', [SchoolController::class, 'update']);
        Route::delete('/schools/{id}', [SchoolController::class, 'destroy']);

        // School Types 
        Route::post('/school-types', [SchoolTypeController::class, 'store']);
        Route::put('/school-types/{schoolType}', [SchoolTypeController::class, 'update']);
        Route::delete('/school-types/{schoolType}', [SchoolTypeController::class, 'destroy']);
    });
});












