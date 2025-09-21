<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\MoviesController;


Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest')->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Movies
    Route::get('movies', [MoviesController::class, 'index'])->name('movies.index');
    Route::get('movies/create', [MoviesController::class, 'create'])->name('movies.create');
    Route::post('movies', [MoviesController::class, 'store'])->name('movies.store');
    Route::get('movies/{id}/edit', [MoviesController::class, 'edit'])->name('movies.edit');
    Route::put('movies/{id}', [MoviesController::class, 'update'])->name('movies.update');
    Route::delete('movies/{id}', [MoviesController::class, 'destroy'])->name('movies.destroy');

    Route::get('movies/download', [MoviesController::class, 'donwloadXlsx'])->name('movies.download');

    Route::get('movies/suggestions', [MoviesController::class, 'suggestions'])->name('movies.suggestions');
    Route::post('movies/save-log-gemini', [MoviesController::class, 'saveLogGemini'])->name('movies.save-log-gemini');
    
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
