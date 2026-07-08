<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SchoolTypeController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    // Public
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgetPassword']);
    Route::post('/reset-password/{token}/{email}', [AuthController::class, 'resetPassword']);

    // Protected
    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Schools
Route::get('/schools', [SchoolController::class, 'index']);
Route::get('/schools/compare', [SchoolController::class, 'compare']);
Route::get('/schools/{id}', [SchoolController::class, 'show']);

// School Types
Route::get('/school-types', [SchoolTypeController::class, 'index']);
Route::get('/school-types/{schoolType}', [SchoolTypeController::class, 'show']);

// Reviews
Route::get('/schools/{school}/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/{review}', [ReviewController::class, 'show']);
Route::get('/users/{user}/reviews', [ReviewController::class, 'userReviews']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->group(function () {

    // Favorites
    Route::get('/favorites', [FavoriteController::class, 'index']);
    Route::post('/favorites', [FavoriteController::class, 'store']);
    Route::delete('/favorites/{school}', [FavoriteController::class, 'destroy']);

    // Reviews
    Route::post('/schools/{school}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);

    // User
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::put('/profile/password', [UserController::class, 'changePassword']);

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('admin')->group(function () {

        // Schools
        Route::post('/schools', [SchoolController::class, 'store']);
        Route::put('/schools/{id}', [SchoolController::class, 'update']);
        Route::delete('/schools/{id}', [SchoolController::class, 'destroy']);

        // School Types
        Route::post('/school-types', [SchoolTypeController::class, 'store']);
        Route::put('/school-types/{schoolType}', [SchoolTypeController::class, 'update']);
        Route::delete('/school-types/{schoolType}', [SchoolTypeController::class, 'destroy']);
        
        //Users 
        Route::get('/users', [UserController::class, 'getAllUsers']);
        Route::delete('/users/{id}',[UserController::class,'destroy']);
    });
});