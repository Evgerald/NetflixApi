<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Movie\MovieCollection;
use App\Http\Resources\Review\ReviewCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * User Resource
 *
 * @version 1.0
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user_id,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'age' => isset($this->age) ? (float) $this->age : null,
            'gender' => $this->gender ?? null,
            'country' => $this->country,
            'state_province' => $this->state_province,
            'city' => $this->city,
            'subscription_plan' => $this->subscription_plan,
            'subscription_start_date' => $this->subscription_start_date->toDateString(),
            'is_active' => (bool) $this->is_active,
            'monthly_spend' => isset($this->monthly_spend) ? (float) $this->monthly_spend : null,
            'primary_device' => $this->primary_device,
            'household_size' => isset($this->household_size) ? (float) $this->household_size : null,
            'movies' => new MovieCollection($this->whenLoaded('movies')),
            'reviews'=> new ReviewCollection($this->whenLoaded('reviews')),
        ];
    }
}
