<?php

return [
    'allowed_formats' => [
        'csv'
    ],

    'allowed_files_sorted_by_priority' => [
        'users',
        'movies',
        'reviews',
    ],

    'jobs' => [
        'users'   => \App\Jobs\Import\ImportUsersJob::class,
        'movies'  => \App\Jobs\Import\ImportMoviesJob::class,
        'reviews' => \App\Jobs\Import\ImportReviewsJob::class,
    ],

    'jobs_priorities' => [
        'reviews' => ['movies', 'users']
    ]
];
