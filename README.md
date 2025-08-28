# 🎬 Netflix API (Laravel + Docker)

This is an **API service** built with **Laravel**.

---

## 📌 Contents
- [Overview](#overview)
- [Requirements](#requirements)
- [Environment variables](#environment-variables)
- [Installation & Setup](#installation--setup)
- [Migrations](#migrations)
- [Project Structure](#project-structure)
- [Import Commands](#import-commands)
- [Api Endpoints](#api-endpoints)
- [Jobs](#jobs)
- [Tests](#tests)

## Overview

- This project provides functionality to import Netflix data from files.
- This project provides an API for listing users, movies and reviews with query params.
- This project provides an API for updating specific review by id.
- This project provides an API for creating new review.
- Technologies used:
  - **PHP** (via Docker)
  - **Laravel**
  - **MySQL** (via Docker)
  - **Docker Compose** for container management

---

## Requirements
- **Docker** >= 28.x
- **Docker Compose** >= 2.x

---

## Environment Variables
- Docker mysql (docker/mysql/.env)
    - **MYSQL_DATABASE** - your database name
    - **MYSQL_USER** - your database user
    - **MYSQL_PASSWORD** - your database user password
    - **MYSQL_ROOT_PASSWORD** - your database root user password
- Laravel (src/.env)
    - **DB_CONNECTION** - should be mysql
    - **DB_HOST** - should be as service in docker-compose.yml file. Default: mysql
    - **DB_PORT** - should be as service in docker-compose.yml file. Default: 3306
    - **DB_DATABASE** - should be as in [Environment Variables->Docker mysql->MYSQL_DATABASE](#environment-variables)
    - **DB_USERNAME** - should be as in [Environment Variables->Docker mysql->MYSQL_USER](#environment-variables)
    - **DB_PASSWORD** - should be as in [Environment Variables->Docker mysql->MYSQL_PASSWORD](#environment-variables)

---

## Installation & Setup

### 1. Clone the repository

``` git clone https://github.com/Evgerald/NetflixApi.git```
### 2. Copy .env files
    cp src/.env.example src/.env
    cp docker/mysql/.env.example docker/mysql/.env
### 3. Open .env files and fill required values according [Environment variables](#environment-variables)
### 4. Start Docker containers
    docker compose up -d --build
### 5. Install Laravel dependencies
    docker compose exec php composer install
### 6. Generate the application key
    docker compose exec php php artisan key:generate

---

## Migrations
### Run Migrations
    docker compose exec php php artisan migrate

---

## 📂 Project structure
```
netflixAPI/
├── docker/ # Docker configuration files
│ ├── mysql/ # MySQL service configuration
│ ├── nginx/ # Nginx service configuration
│ └── php/ # PHP service configuration
├── files/ # Project-related files
│ └── CSV/ # CSV files for import
├── src/ # Laravel application source code
│ ├── app/ # Application core (models, controllers, etc.)
│ ├── bootstrap/ # Laravel bootstrap files
│ ├── config/ # Application configuration files
│ ├── database/ # Database migrations and seeders
│ ├── files/ # Custom files for Laravel app
│ ├── public/ # Public files (index.php, assets)
│ ├── resources/ # Blade templates, language files
│ ├── routes/ # Route definitions (web, api)
│ ├── storage/ # Logs, compiled templates, cache
│ ├── tests/ # Unit and feature tests
│ ├── vendor/ # Composer dependencies
│ └── .env # Environment variables (local)
├── docker-compose.yml # Docker Compose configuration
└── README.md # Project documentation
```

---

## Import Commands

> **Note:** For better and simple experience put files in `/files/extension` folder. This folder already included in docker compose.
### You could run command throw console
    docker compose exec php php artisan import:files {path_to_file} {path_to_file_1}
### Example for importing users.csv, movies.csv and reviews.csv
    docker compose exec php php artisan import:files /var/www/netflixAPI/files/CSV/reviews.csv /var/www/netflixAPI/files/CSV/movies.csv /var/www/netflixAPI/files/CSV/users.csv
### If QUEUE_CONNECTION in .env is database you should also run
    docker compose exec php php artisan queue:work --queue=default --daemon

---

## Api Endpoints
### Variables
- {{host}} - your host (Ex. http://localhost/)
- {{user_id}} - user_id from **users** table
- {{movie_id}} - movie_id from **movies** table
- {{review_id}} - review_id from **reviews** table
### Table with end points
### GET REQUEST
<table>
    <thead>
        <tr>
            <th>Endpoint</th>
            <th>Method</th>
            <th>Description</th>
            <th colspan="4">Query params</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="2">{{host}}/api/v1/users/{{user_id}}</td>
            <td rowspan="2">GET</td>
            <td rowspan="2">Get a specific user from **users** table</td>
            <td>Param</td>
            <td>Available values</td>
            <td>Notes</td>
            <td>Example</td>
        </tr>
        <tr>
            <td>include</td>
            <td>You could set available values in <b>src/config/api_v1.php</b> -> <b>user.allowed_includes</b></td>
            <td>Use <b>,</b> as values delimiter</td>
            <td>{{host}}/api/v1/users/{{user_id}}?include=reviews,movies</td>
        </tr>
        <tr>
            <td rowspan="5">{{host}}/api/v1/users</td>
            <td rowspan="5">GET</td>
            <td rowspan="5">Get all users from **users** table with pagination. You could set default(max) pagination value in <b>src/config/api_v1.php</b> -> <b>per_page</b></td>
            <td>Param</td>
            <td>Available values</td>
            <td>Notes</td>
            <td>Example</td>
        </tr>
        <tr>
            <td>include</td>
            <td><pre>You could set available values in <b>src/config/api_v1.php</b> -> <b>user.allowed_includes</b></pre></td>
            <td><pre>Use <b>,</b> as values delimiter</pre></td>
            <td><pre>{{host}}/api/v1/users?include=reviews,movies</pre></td>
        </tr>
        <tr>
            <td>filter[<b>name</b>]</td>
            <td><pre>You could set available values in <b>src/config/api_v1.php</b> -> <b>user.allowed_filters</b></pre></td>
            <td><pre>Use available value instead of <b>name</b>. You could use more than 1 filter</pre></td>
            <td><pre>{{host}}/api/v1/users?filter[gender]=Male&filter[country]=USA</pre></td>
        </tr>
        <tr>
            <td>sort</td>
            <td><pre>You could set available values in <b>src/config/api_v1.php</b> -> <b>user.allowed_sorts</b></pre></td>
            <td><pre>Default ASC sorting. Use <b>-</b> before value to use DESC sorting. Use <b>,</b> as values delimiter</pre></td>
            <td><pre>{{host}}/api/v1/users?sort=-age,monthly_spend</pre></td>
        </tr>
        <tr>
            <td>per_page</td>
            <td><pre>You could set int value</pre></td>
            <td><pre>If value higher than max value -> max value will be applied</pre></td>
            <td><pre>{{host}}/api/v1/users?per_page=2</pre></td>
        </tr>
        <tr>
            <td rowspan="2">{{host}}/api/v1/movies/{{movie_id}}</td>
            <td rowspan="2">GET</td>
            <td rowspan="2">Get a specific movie from **movies** table</td>
            <td>Param</td>
            <td>Available values</td>
            <td>Notes</td>
            <td>Example</td>
        </tr>
        <tr>
            <td>include</td>
            <td><pre>You could set available values in <b>src/config/api_v1.php</b> -> <b>movie.allowed_includes</b></pre></td>
            <td><pre>Use <b>,</b> as values delimiter</pre></td>
            <td><pre>{{host}}/api/v1/movies/{{movie_id}}?include=users</pre></td>
        </tr>
        <tr>
            <td rowspan="5">{{host}}/api/v1/movies</td>
            <td rowspan="5">GET</td>
            <td rowspan="5">Get all movies from **movies** table with pagination. You could set default(max) pagination value in <b>src/config/api_v1.php</b> -> <b>per_page</b></td>
            <td>Param</td>
            <td>Available values</td>
            <td>Notes</td>
            <td>Example</td>
        </tr>
        <tr>
            <td>include</td>
            <td><pre>You could set available values in <b>src/config/api_v1.php</b> -> <b>movie.allowed_includes</b></pre></td>
            <td><pre>Use <b>,</b> as values delimiter</pre></td>
            <td><pre>{{host}}/api/v1/movies?include=reviews</pre></td>
        </tr>
        <tr>
            <td>filter[<b>name</b>]</td>
            <td><pre>You could set available values in <b>src/config/api_v1.php</b> -> <b>movie.allowed_filters</b></pre>/td>
            <td><pre>Use available value instead of <b>name</b>. You could use more than 1 filter></pre></td>
            <td><pre>{{host}}/api/v1/movies?filter[genre_primary]=Action&filter[genre_secondary]=Thriller></pre></td>
        </tr>
        <tr>
            <td>sort</td>
            <td><pre>You could set available values in <b>src/config/api_v1.php</b> -> <b>movie.allowed_sorts</b></pre></td>
            <td><pre>Default ASC sorting. Use <b>-</b> before value to use DESC sorting. Use <b>,</b> as values delimiter</pre></td>
            <td><pre>{{host}}/api/v1/movies?sort=release_year</pre></td>
        </tr>
        <tr>
            <td>per_page</td>
            <td><pre>You could set int value</pre></td>
            <td><pre>If value higher than max value -> max value will be applied</pre></td>
            <td><pre>{{host}}/api/v1/movies?per_page=2</pre></td>
        </tr>
        <tr>
            <td>{{host}}/api/v1/reviews/{{review_id}}</td>
            <td>GET</td>
            <td>Get a specific review from **reviews** table</td>
            <td>Param</td>
            <td>Available values</td>
            <td>Notes</td>
            <td>Example</td>
        </tr>
        <tr>
            <td rowspan="4">{{host}}/api/v1/reviews</td>
            <td rowspan="4">GET</td>
            <td rowspan="4">Get all reviews from **reviews** table with pagination. You could set default(max) pagination value in <b>src/config/api_v1.php</b> -> <b>per_page</b></td>
            <td>Param</td>
            <td>Available values</td>
            <td>Notes</td>
            <td>Example</td>
        </tr>
        <tr>
            <td>filter[<b>name</b>]</td>
            <td><pre>You could set available values in <b>src/config/api_v1.php</b> -> <b>review.allowed_filters</b></pre></td>
            <td><pre>Use available value instead of <b>name</b>. You could use more than 1 filter</pre></td>
            <td><pre>{{host}}/api/v1/reviews?filter[device_type]=Tablet</pre></td>
        </tr>
        <tr>
            <td>sort</td>
            <td><pre>You could set available values in <b>src/config/api_v1.php</b> -> <b>review.allowed_sorts</b></pre></td>
            <td><pre>Default ASC sorting. Use <b>-</b> before value to use DESC sorting. Use <b>,</b> as values delimiter</pre></td>
            <td><pre>{{host}}/api/v1/reviews?sort=rating</pre></td>
        </tr>
        <tr>
            <td>per_page</td>
            <td><pre>You could set int value</pre></td>
            <td><pre>If value higher than max value -> max value will be applied</pre></td>
            <td><pre>{{host}}/api/v1/reviews?per_page=2</pre></td>
        </tr>
    </tbody>
</table>

### PUT/PATCH requests

<table>
    <thead>
        <tr>
            <th>Endpoint</th>
            <th>Method</th>
            <th>Description</th>
            <th>Body params</th>
            <th>Example</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{host}}/api/v1/reviews/{{review_id}}</td>
            <td>PATCH/PUT</td>
            <td>Update or part update specific review from **reviews** table</td>
            <td>
                <pre>
                    rating -> integer, min:0, max:255;
                    device_type -> string, could be: Mobile, Tablet, Laptop, Smart TV;
                    is_verified_watch -> boolean;
                    helpful_votes -> numeric;
                    total_votes -> numeric;
                    sentiment -> string', could be:neutral, positive, negative;
                    sentiment_score -> float;
                    review_date -> date;
                    movie_id -> string, must exist in movies table;
                    user_id -> string, must exist in movies table;
                </pre>
            </td>
            <td>{{host}}/api/v1/reviews/{{review_id}} with json body {"user_id": 123}</td>
        </tr>
    </tbody>
</table>

### POST requests

<table>
    <thead>
        <tr>
            <th>Endpoint</th>
            <th>Method</th>
            <th>Description</th>
            <th>Body params</th>
            <th>Example</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{host}}/api/v1/reviews/{{review_id}}</td>
            <td>POST</td>
            <td>Create new review in **reviews**</td>
            <td>
                <pre>
                    rating -> integer, min:0, max:255;
                    device_type -> required, string, could be: Mobile, Tablet, Laptop, Smart TV;
                    is_verified_watch -> required, boolean;
                    helpful_votes -> required, numeric;
                    total_votes -> required, numeric;
                    sentiment -> required, string, could be:neutral, positive, negative;
                    sentiment_score -> required,float;
                    review_date -> required, date;
                    movie_id -> required, string, must exist in movies table;
                    user_id -> required, string, must exist in movies table;
                </pre>
            </td>
            <td>
                {{host}}/api/v1/reviews with json body 
                <pre>
                    {
                        "user_id": "user_07066",
                        "movie_id": "movie_0415",
                        "rating": 8,
                        "review_date": "2025-08-27",
                        "review_text": "Great movie with amazing visuals!",
                        "device_type": "Laptop",
                        "is_verified_watch": true,
                        "helpful_votes": 12,
                        "total_votes": 15,
                        "sentiment": "positive",
                        "sentiment_score": 0
                    }
                </pre>
            </td>
        </tr>
    </tbody>
</table>

### DELETE requests
<table>
    <thead>
        <tr>
            <th>Endpoint</th>
            <th>Method</th>
            <th>Description</th>
            <th>Example</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{host}}/api/v1/reviews/{{review_id}}</td>
            <td>DELETE</td>
            <td>Delete specific review from **reviews** table</td>
            <td>{{host}}/api/v1/reviews/{{review_id}}</td>
        </tr>
    </tbody>
</table>

---

## Jobs
- Import jobs
  - You could set up jobs priority in import.php config file. Example below will make to execute not mentioned jobs, 
  movies and users first. If movies and users finished without errors than review job will process
  ``` 
  'jobs_priorities' => [
        'reviews' => ['movies', 'users']
  ]
  ```
  
---

## Tests
### To run all test use command
    docker compose exec php php artisan test
### To run only unit tests use command
    docker compose exec php php artisan test --testsuite=Unit