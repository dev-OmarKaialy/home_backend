<?php

use Illuminate\Support\Facades\Route;


Route::middleware([])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware([])->group(function () {
    Route::get('/homes', function () {
        return view('homes');
    })->name('homes');
});
