<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->index('id_user', 'movies_id_user_index');
        });

        Schema::table("movies_genres", function (Blueprint $table) {
            $table->index('id_movie', 'movies_genres_id_movie_index');
            $table->index('id_genre', 'movies_genres_id_genre_index');
            $table->index('id_user', 'movies_genres_id_user_index');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropIndex('movies_id_user_index');
        });
        Schema::table("movies_genres", function (Blueprint $table) {
            $table->dropIndex('movies_genres_id_movie_index');
            $table->dropIndex('movies_genres_id_genre_index');
            $table->dropIndex('movies_genres_id_user_index');
        });
    }
};
