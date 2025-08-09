<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Inertia\Inertia;

class MoviesController extends Controller
{
    public function index()
    {
        return Inertia::render('movies/index', []);
    }

    public function create()
    {
        return Inertia::render('movies/create', []);
    }

    public function store(Request $request)
    {

    }

    // public function show(Movie $movie)
    // {

    // }

    // public function edit(Movie $movie)
    // {

    // }

    // public function update(Request $request, Movie $movie)
    // {

    // }

    // public function destroy(Movie $movie)
    // {

    // }

}
