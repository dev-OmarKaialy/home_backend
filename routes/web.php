<?php

use App\Http\Controllers\Admin\HouseController;
use App\Http\Controllers\Admin\ServiceController;
use Illuminate\Support\Facades\Route;


Route::middleware([])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('houses')->middleware([])->group(function () {
    Route::get('/', [HouseController::class, 'index'])->name('houses');
    Route::get('/create', [HouseController::class, 'create'])->name('houses.create');
    Route::post('/store', [HouseController::class, 'store'])->name('houses.store');
    Route::get('/{id}', [HouseController::class, 'show'])->name('houses.show');
    Route::get('/edit/{id}', [HouseController::class, 'edit'])->name('houses.edit');
    Route::put('/update/{id}', [HouseController::class, 'update'])->name('houses.update');
    Route::delete('/delete/{id}', [HouseController::class, 'delete'])->name('houses.delete');
});

Route::prefix('services')->middleware([])->group(function () {
    Route::get('/', [ServiceController::class, 'index'])->name('services');
    Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/store', [ServiceController::class, 'store'])->name('services.store');
    Route::get('/{id}', [ServiceController::class, 'show'])->name('services.show');
    Route::get('/edit/{id}', [ServiceController::class, 'edit'])->name('services.edit');
    Route::put('/update/{id}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/delete/{id}', [ServiceController::class, 'delete'])->name('services.delete');
});
