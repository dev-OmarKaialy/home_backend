<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('categories', CategoryController::class);
Route::apiResource('services', ServiceController::class);
Route::get('categories/{categoryId}/services', [ServiceController::class, 'index']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login',[ \App\Http\Controllers\CustomAuthController::class,'login']);
    Route::post('register',[ \App\Http\Controllers\CustomAuthController::class,'register']);
});
