<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;


Route::post('/schools',[SchoolController::class,'store']);
Route::put('/schools/{id}',[SchoolController::class,'update']);
Route::delete('/schools/{id}',[SchoolController::class,'destroy']);

