<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Movie Model
 *
 * @version 1.0
 */
class Movie extends Model
{
    /**
     * @var list<string>
     */
    protected $guarded = ['id'];

    protected $casts = [
        'added_to_platform' => 'date:Y-m-d',
    ];

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'movie_id', 'movie_id');
    }

    /**
     * @return Movie|HasManyThrough
     */
    public function users(): Movie|HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            Review::class,
            'movie_id',
            'user_id',
            'movie_id',
            'user_id'

        );
    }
}
