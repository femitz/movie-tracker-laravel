<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoviesGenres extends Model
{
    public $timestamps = true;
    protected $table = 'movies_genres';
    protected $fillable = ['id_movie', 'id_genre', 'id_user'];
}
