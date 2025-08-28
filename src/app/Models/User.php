<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model
 *
 * @version 1.0
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * @var list<string>
     */
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'subscription_start_date' => 'date:Y-m-d',
    ];

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id', 'user_id');
    }

    /**
     * @return User|HasManyThrough
     */
    public function movies(): HasManyThrough|User
    {
        return $this->hasManyThrough(
            Movie::class,
            Review::class,
            'user_id',
            'movie_id',
            'user_id',
            'movie_id'
        );
    }
}
