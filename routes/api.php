<?php
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    // Route::post('/schools/{school}/reviews', [ReviewController::class, 'store']);
    // Route::put('/reviews/{review}', [ReviewController::class, 'update']);
    // Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);
});
Route::post('/schools/{school}/reviews', [ReviewController::class, 'store']);
Route::put('/reviews/{review}', [ReviewController::class, 'update']);
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy']);

Route::get('/schools/{school}/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/{review}', [ReviewController::class, 'show']);
Route::get('/users/{user}/reviews', [ReviewController::class, 'userReviews']);