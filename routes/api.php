<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\TaxonomyController;

/**
 * CMS REST API v1
 * 
 * Base URL: /api/v1
 * All responses use JSON format
 * 
 * Authentication: Bearer tokens (Sanctum)
 * Rate Limiting: Standard Laravel rate limits apply
 */

Route::prefix('v1')->group(function () {
    // ============================================================================
    // PUBLIC ENDPOINTS - No authentication required
    // ============================================================================
    
    /**
     * Posts API
     * 
     * GET /posts - List all published posts with pagination
     *   Query parameters:
     *   - page: int (default: 1)
     *   - per_page: int (default: 15, max: 100)
     *   - search: string (search in title and content)
     *   - category: string (filter by category slug)
     *   - sort: string ('published_at' [default] or 'popular')
     * 
     * GET /posts/{slug} - Get a single post by slug
     */
    Route::get('posts', [PostController::class, 'index']);
    Route::get('posts/{slug}', [PostController::class, 'show']);

    /**
     * Pages API
     * 
     * GET /pages - List all pages with pagination
     *   Query parameters:
     *   - page: int (default: 1)
     *   - per_page: int (default: 20, max: 100)
     *   - search: string (search in title and content)
     * 
     * GET /pages/{slug} - Get a single page by slug
     */
    Route::get('pages', [PageController::class, 'index']);
    Route::get('pages/{slug}', [PageController::class, 'show']);

    /**
     * Taxonomies API (Categories & Tags)
     * 
     * GET /taxonomies - List all taxonomies
     * GET /taxonomies/{slug} - Get a single taxonomy with related posts
     */
    Route::get('taxonomies', [TaxonomyController::class, 'index']);
    Route::get('taxonomies/{slug}', [TaxonomyController::class, 'show']);

    /**
     * Media API - Read Only
     * 
     * GET /media - List all public media files
     * GET /media/{id} - Get a single media file
     */
    Route::get('media', [MediaController::class, 'index']);
    Route::get('media/{id}', [MediaController::class, 'show']);

    // ============================================================================
    // AUTHENTICATED ENDPOINTS - Require Sanctum token
    // ============================================================================
    
    Route::middleware(['auth:sanctum'])->group(function () {
        /**
         * Media API - Write operations
         * Requires 'media.upload' or 'media.delete' permissions
         * 
         * POST /media - Upload new media file
         * DELETE /media/{id} - Delete a media file
         */
        Route::post('media', [MediaController::class, 'store']);
        Route::delete('media/{id}', [MediaController::class, 'destroy']);
    });
});
