<?php

use App\Http\Controllers\Api\V1\MovieApiController;
use App\Http\Controllers\Api\V1\ReviewApiController;
use App\Http\Controllers\Api\V1\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')
    ->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/{id}', [UserApiController::class, 'show']);
            Route::get('', [UserApiController::class, 'index']);
        });

        Route::prefix('movies')->group(function () {
            Route::get('/{id}', [MovieApiController::class, 'show']);
            Route::get('', [MovieApiController::class, 'index']);
        });

        Route::prefix('reviews')->group(function () {
            Route::get('/{id}', [ReviewApiController::class, 'show']);
            Route::get('', [ReviewApiController::class, 'index']);
            Route::post('', [ReviewApiController::class, 'store']);
            Route::put('/{id}', [ReviewApiController::class, 'update']);
            Route::patch('/{id}', [ReviewApiController::class, 'update']);
            Route::delete('/{id}', [ReviewApiController::class, 'destroy']);
        });
});

