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
        Schema::create('reviews', function (Blueprint $table) {
            $table->string('review_id')->primary();
            $table->string('user_id');
            $table->string('movie_id');
            $table->unsignedTinyInteger('rating');
            $table->date('review_date');
            $table->enum('device_type', ['Mobile', 'Tablet', 'Laptop', 'Smart TV']);
            $table->boolean('is_verified_watch');
            $table->float('helpful_votes');
            $table->float('total_votes');
            $table->longText('review_text');
            $table->enum('sentiment', ['neutral', 'positive', 'negative']);
            $table->decimal('sentiment_score', 4, 3);

            $table
                ->foreign('movie_id')
                ->references('movie_id')
                ->on('movies')
                ->onDelete('cascade');
            $table
                ->foreign('user_id')
                ->references('user_id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
