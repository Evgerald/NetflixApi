<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Review Model
 *
 * @version 1.0
 */
class Review extends Model
{
    public $incrementing = false;

    protected $primaryKey = 'review_id';

    protected $keyType = 'string';


    public $timestamps = false;

    /**
     * @var list<string>
     */
    protected $guarded = ['id'];

    protected $casts = [
        'review_date' => 'date:Y-m-d',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }

    /**
     * @TODO probably better to implement another logic
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::creating(function ($model) {
            $lastId = static::max('review_id');
            $number = $lastId ? intval(str_replace('review_', '', $lastId)) + 1 : 1;
            $model->review_id = 'review_' . str_pad($number, 6, '0', STR_PAD_LEFT);
        });
    }
}
