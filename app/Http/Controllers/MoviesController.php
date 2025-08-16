<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movies;
use Inertia\Inertia;
use App\Models\Genres;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\MoviesGenres;

class MoviesController extends Controller
{
    public function index()
    {
        $id_user = Auth::user()->id;    
        
        // Buscar filmes com seus gêneros
        $movies_raw = DB::select("select m.*, mg.id_genre, g.name as genre_name, g.id as genre_id from movies m
            left join movies_genres mg on m.id = mg.id_movie
            left join genres g on mg.id_genre = g.id
            where m.id_user = ?", [$id_user]);

        // Agrupar os dados por filme
        $movies = [];
        foreach ($movies_raw as $movie_raw) {
            $movie_id = $movie_raw->id;
            
            if (!isset($movies[$movie_id])) {
                $movies[$movie_id] = [
                    'id' => $movie_raw->id,
                    'name' => $movie_raw->name,
                    'id_user' => $movie_raw->id_user,
                    'created_at' => $movie_raw->created_at,
                    'updated_at' => $movie_raw->updated_at,
                    'id_genres' => [],
                    'genres_names' => []
                ];
            }
            
            // Adicionar gênero se existir
            if ($movie_raw->id_genre) {
                $movies[$movie_id]['id_genres'][] = $movie_raw->id_genre;
                $movies[$movie_id]['genres_names'][] = $movie_raw->genre_name;
            }
        }
        
        // Converter para array indexado
        $movies = array_values($movies);
     
        return Inertia::render('movies/index', ['movies' => $movies]);
    }

    public function create()
    {
        $genres = Genres::getGenres();
        return Inertia::render('movies/create', ['genres' => $genres]);
    }

    public function store(Request $request)
    {
        $reg = $this->loadRequest($request);
        $res = $reg->save();
        
        // Vou salvar os generos do filme.
        $id_movie = $reg->id;
        $id_genres = $request->id_genre;
        foreach ($id_genres as $id_genre) {
            $id_genre = (object) $id_genre;

            $reg_genre = new MoviesGenres();
            $reg_genre->id_movie = $id_movie;
            $reg_genre->id_genre = $id_genre->id;
            $reg_genre->id_user = Auth::user()->id;
            $reg_genre->save();
        }

        if ($res) {
            return redirect()->route('movies.index');
        } else {
            return redirect()->back()->with('error', 'Error saving movie');
        }
    }

    private function loadRequest(Request $request) : Movies
     {
        $reg = new Movies();
        if (isset($request->id)) {
            $reg = Movies::find($request->id);
        }
        $reg->name = $request->name;
        $reg->id_user = Auth::user()->id;
        return $reg;
     }

    public function edit($id)
    {
        $user = Auth::user();
        $movie = Movies::find($id);

        if (!$movie || $movie->id_user != $user->id) {
            abort(404, 'Movie not found');
        }

        // Buscar gêneros do filme
        $movieGenres = MoviesGenres::where('id_movie', $id)->pluck('id_genre')->toArray();
        
        // Buscar todos os gêneros disponíveis
        $genres = Genres::getGenres();

        return Inertia::render('movies/edit', [
            'movie' => [
                'id' => $movie->id,
                'name' => $movie->name,
                'id_genres' => $movieGenres
            ],
            'genres' => $genres
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $movie = Movies::find($id);

        if (!$movie || $movie->id_user != $user->id) {
            return response()->json(['success' => false, 'message' => 'Movie not found'], 404);
        }

        // Atualizar nome do filme
        $movie->name = $request->name;
        $movie->save();

        // Remover gêneros antigos
        MoviesGenres::where('id_movie', $id)->delete();

        // Adicionar novos gêneros
        $id_genres = $request->id_genre;
        if ($id_genres && !empty($id_genres)) {
            foreach ($id_genres as $id_genre) {
                $id_genre = (object) $id_genre;

                $reg_genre = new MoviesGenres();
                $reg_genre->id_movie = $id;
                $reg_genre->id_genre = $id_genre->id;
                $reg_genre->id_user = $user->id;
                $reg_genre->save();
            }
        }

        return response()->json(['success' => true, 'message' => 'Movie updated successfully']);
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $movie = Movies::find($id);

        if ($movie->id_user != $user->id) {
            return response()->json(['success' => false, 'message' => 'You are not authorized to delete this movie'], 403);
        }
        
        $movie->delete();
        MoviesGenres::where('id_movie', $id)->delete();

        return response()->json(['success' => true]);
    }

}
