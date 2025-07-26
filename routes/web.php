<?php

use App\Http\Controllers\Admin\HouseController;
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
