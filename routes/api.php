<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\ReviewController;


Route::get('/schools/{school}/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/{review}', [ReviewController::class, 'show']);
Route::get('/users/{user}/reviews', [ReviewController::class, 'userReviews']);


Route::middleware('auth:api')->group(function () {
    // Reviews
    Route::post('/schools/{school}/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
    //Schools -- for admin only
    Route::middleware('isAdmin')->group(function () {
        Route::post('/schools', [SchoolController::class, 'store']);
        Route::put('/schools/{id}',[SchoolController::class, 'update']);
        Route::delete('/schools/{id}',[SchoolController::class, 'destroy']);
    });
});



