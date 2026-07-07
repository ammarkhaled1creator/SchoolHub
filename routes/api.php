<?php
use App\Http\Controllers\SchoolTypeController;
use Illuminate\Support\Facades\Route;

Route::get('/school-types', [SchoolTypeController::class, 'index']);
Route::get('/school-types/{schoolType}', [SchoolTypeController::class, 'show']);

Route::middleware('auth:api')->group(function () {
    Route::post('/school-types', [SchoolTypeController::class, 'store']);
    Route::put('/school-types/{schoolType}', [SchoolTypeController::class, 'update']);
    Route::delete('/school-types/{schoolType}', [SchoolTypeController::class, 'destroy']);
});

