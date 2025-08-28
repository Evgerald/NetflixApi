<?php

namespace App\Http\Resources\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Review Resource
 *
 * @version 1.0
 */
class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->review_id,
            'user_id' => $this->user_id,
            'movie_id' => $this->movie_id,
            'rating' => (int) $this->rating,
            'review_date' => $this->review_date->toDateString(),
            'device_type' => $this->device_type,
            'is_verified_watch' => (bool) $this->is_verified_watch,
            'helpful_votes' => (float) $this->helpful_votes,
            'total_votes' => (float) $this->total_votes,
            'review_text' => $this->review_text,
            'sentiment' => $this->sentiment,
            'sentiment_score' => (float) $this->sentiment_score
        ];
    }
}
