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
        Schema::create('movies', function (Blueprint $table) {
            $table->string('movie_id')->primary();
            $table->string('title');
            $table->enum(
                'content_type',
                ['Movie', 'TV Series', 'Documentary', 'Stand-up Comedy', 'Limited Series']
            );
            $table->enum(
                'genre_primary',
                ['Adventure', 'War', 'Sci-Fi', 'Comedy', 'Action']
            );
            $table->enum(
                'genre_secondary',
                ['Drama', 'Adventure', 'Thriller', 'Sci-Fi', 'Family']
            )->nullable();
            $table->unsignedSmallInteger('release_year');
            $table->float('duration_minutes')->unsigned();
            $table->enum('rating', ['TV-Y', 'NC-17', 'TV-MA', 'TV-Y7', 'TV-14']);
            $table->string('language');
            $table->string('country_of_origin');
            $table->decimal('imdb_rating', 3, 1)->nullable();
            $table->decimal('production_budget', 12,1)->nullable();
            $table->decimal('box_office_revenue', 12,1)->nullable();
            $table->float('number_of_seasons')->nullable();
            $table->float('number_of_episodes')->nullable();
            $table->boolean('is_netflix_original')->default(false);
            $table->date('added_to_platform');
            $table->boolean('content_warning')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
