<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movies;
use Inertia\Inertia;
use App\Models\Genres;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MoviesController extends Controller
{
    public function index()
    {
        return Inertia::render('movies/index', []);
    }

    public function create()
    {
        $genres = Genres::getGenres();
        return Inertia::render('movies/create', ['genres' => $genres]);
    }

    public function store(Request $request)
    {
        $reg = $this->loadRequest($request);
        // $reg->save();
        // return redirect()->route('movies.index');
    }

    private function loadRequest(Request $request)
     {

        $reg = new Movies();
        if (isset($request->id)) {
            $reg = Movies::find($request->id);
        }
        $reg->name = $request->name;
        $reg->id_user = Auth::user()->id;
        $reg->save();
        return $reg;
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
