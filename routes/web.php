<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/sales', function () {
    return view('sales');
})->name('sales');

Route::get('/rentals', function () {
    return view('rentals');
})->name('rentals');

Route::get('/projects', function () {
    return view('projects');
})->name('projects');

Route::get('/loans', function () {
    return view('loans');
})->name('loans');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
