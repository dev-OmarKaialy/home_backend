<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HouseController;
use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;


Route::middleware([])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('houses', HouseController::class);
Route::resource('services', ServiceController::class);
Route::resource('categories', CategoryController::class);
