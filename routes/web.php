<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HouseController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\JoinRequestController;
use Illuminate\Support\Facades\Route;


Route::middleware([])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('houses', HouseController::class);
Route::resource('services', ServiceController::class);
Route::resource('categories', CategoryController::class);

// Route::group(function () {
Route::get('/join-requests', [JoinRequestController::class, 'index'])->name('admin.join_requests.index');
Route::post('/join-requests/{id}/accept', [JoinRequestController::class, 'accept'])->name('admin.join_requests.accept');
Route::delete('/join-requests/{id}', [JoinRequestController::class, 'destroy'])->name('admin.join_requests.destroy');
// });
