<?php

namespace App\Http\Resources\Movie;

use App\Http\Resources\Review\ReviewCollection;
use App\Http\Resources\User\UserCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Movie Resource
 *
 * @version 1.0
 */
class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->movie_id,
            'title' => $this->title,
            'content_type' => $this->content_type,
            'genre_primary' => $this->genre_primary,
            'genre_secondary' => $this->genre_secondary ?? null,
            'release_year' => (int) $this->release_year,
            'duration_minutes' => (float) $this->duration_minutes,
            'rating' => $this->rating,
            'language' => $this->language,
            'country_of_origin' => $this->country_of_origin,
            'imdb_rating' => isset($this->imdb_rating) ? (float) $this->imdb_rating : null,
            'production_budget' => isset($this->production_budget) ? (float) $this->production_budget : null,
            'box_office_revenue' => isset($this->box_office_revenue) ? (float) $this->box_office_revenue : null,
            'number_of_seasons' => isset($this->number_of_seasons) ? (float) $this->number_of_seasons : null,
            'number_of_episodes' => isset($this->number_of_episodes) ? (float) $this->number_of_episodes : null,
            'is_netflix_original' => (bool) $this->is_netflix_original,
            'added_to_platform' => $this->added_to_platform->toDateString(),
            'content_warning' => (bool) $this->content_warning,
            'reviews'=> new ReviewCollection($this->whenLoaded('reviews')),
            'users'=> new UserCollection($this->whenLoaded('users'))
        ];
    }
}
