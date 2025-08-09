<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MoviesController;


Route::get('/', function () {
    return Inertia::render('Welcome');
})->middleware('guest')->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('movies', [MoviesController::class, 'index'])->name('movies.index');
    Route::get('movies/create', [MoviesController::class, 'create'])->name('movies.create');
    Route::post('movies', [MoviesController::class, 'store'])->name('movies.store');
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
