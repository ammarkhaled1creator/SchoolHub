<?php

use App\Http\Controllers\SchoolTypeController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ReviewController;

// Public routes
Route::get('/schools/{school}/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/{review}', [ReviewController::class, 'show']);
Route::get('/schools/filter', [SchoolController::class, 'filter']);
Route::get('/school-types', [SchoolTypeController::class, 'index']);
Route::get('/school-types/{schoolType}', [SchoolTypeController::class, 'show']);

Route::middleware('auth:api')->group(function () {
    // Reviews
    Route::post('/schools/{school}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    Route::get('/users/{user}/reviews', [ReviewController::class, 'userReviews']);

    // Admin only
    Route::middleware('isAdmin')->group(function () {
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

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/forgot-password', [AuthController::class, 'forgetPassword']);
    Route::post('/reset-password/{token}/{email}', [AuthController::class, 'resetPassword']);
});

//school type


Route::get('/school-types', [SchoolTypeController::class, 'index']);
Route::get('/school-types/{schoolType}', [SchoolTypeController::class, 'show']);

Route::middleware('auth:api')->group(function () {
    Route::post('/school-types', [SchoolTypeController::class, 'store']);
    Route::put('/school-types/{schoolType}', [SchoolTypeController::class, 'update']);
    Route::delete('/school-types/{schoolType}', [SchoolTypeController::class, 'destroy']);
});


























