<?php

use App\Http\Resources\Review\ReviewResource;
use App\Http\Resources\Movie\MovieResource;
use App\Http\Resources\User\UserResource;

return [
    'per_page' => 30,
    'user' => [
        'id_field' => 'user_id',
        'model' => App\Models\User::class,
        'allowed_includes' => ['movies', 'reviews'],
        'allowed_sorts' => ['age', 'subscription_start_date', 'monthly_spend'],
        'allowed_filters' => ['gender', 'country', 'city'],
        'resource' => UserResource::class,
        'collection' => \App\Http\Resources\User\UserCollection::class
    ],
    'movie' => [
        'id_field' => 'movie_id',
        'model' => App\Models\Movie::class,
        'allowed_includes' => ['reviews', 'users'],
        'allowed_sorts' => ['release_year', 'number_of_seasons', 'number_of_episodes'],
        'allowed_filters' => ['genre_primary', 'genre_secondary', 'release_year', 'country_of_origin'],
        'resource' => MovieResource::class,
        'collection' => \App\Http\Resources\Movie\MovieCollection::class

    ],
    'review' => [
        'id_field' => 'review_id',
        'model' => App\Models\Review::class,
        'allowed_sorts' => ['rating', 'total_votes', 'sentiment_score'],
        'allowed_filters' => ['device_type', 'is_verified_watch', 'rating'],
        'resource' => ReviewResource::class,
        'collection' => \App\Http\Resources\Review\ReviewCollection::class
    ]
];
