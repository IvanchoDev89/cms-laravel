<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\TaxonomyController;

Route::prefix('v1')->group(function () {
    // Media endpoints - require authentication and permissions for write actions
    Route::get('media', [MediaController::class, 'index']);
    Route::get('media/{id}', [MediaController::class, 'show']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('media', [MediaController::class, 'store']);
        Route::delete('media/{id}', [MediaController::class, 'destroy']);
    });

    // Posts API (public)
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{slug}', [PostController::class, 'show']);

    // Pages API (public)
    Route::get('pages', [PageController::class, 'index']);
    Route::get('pages/{slug}', [PageController::class, 'show']);

    // Taxonomies API (public)
    Route::get('taxonomies', [TaxonomyController::class, 'index']);
    Route::get('taxonomies/{slug}', [TaxonomyController::class, 'show']);
});

