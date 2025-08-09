<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Genres;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('genres')->insert([
            'name' => 'Action',
        ]);
        DB::table('genres')->insert([
            'name' => 'Adventure',
        ]);
        DB::table('genres')->insert([
            'name' => 'Comedy',
        ]);
        DB::table('genres')->insert([
            'name' => 'Drama',
        ]);
        DB::table('genres')->insert([
            'name' => 'Fantasy',
        ]);
        DB::table('genres')->insert([
            'name' => 'Horror',
        ]);
        DB::table('genres')->insert([
            'name' => 'Mystery',
        ]);
        DB::table('genres')->insert([
            'name' => 'Romance',
        ]);
        DB::table('genres')->insert([
            'name' => 'Sci-Fi',
        ]);
        DB::table('genres')->insert([
            'name' => 'Thriller',
        ]);
        DB::table('genres')->insert([
            'name' => 'War',
        ]);
        DB::table('genres')->insert([
            'name' => 'Western',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::dropIfExists('genres');
    }
};
