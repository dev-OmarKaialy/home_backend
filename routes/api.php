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
Route::get('get-addresses',[\App\Http\Controllers\AddressController::class,'index'])->middleware('auth:api');
Route::post('create-address',[\App\Http\Controllers\AddressController::class,'store'])->middleware('auth:api');
Route::post('top-up',[\App\Http\Controllers\WalletController::class,'topUp'])->middleware('auth:api');
Route::post('withdraw',[\App\Http\Controllers\WalletController::class,'withdraw'])->middleware('auth:api');
Route::get('get-balance',[\App\Http\Controllers\WalletController::class,'getBalance'])->middleware('auth:api');
Route::group(['prefix' => 'auth'], function () {
    Route::post('login',[ \App\Http\Controllers\CustomAuthController::class,'login']);
    Route::post('validate',[ \App\Http\Controllers\CustomAuthController::class,'validate']);
    Route::post('register',[ \App\Http\Controllers\CustomAuthController::class,'register']);
});
