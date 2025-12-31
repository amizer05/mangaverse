<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MangaController as ApiMangaController;
use App\Http\Controllers\Api\NewsController as ApiNewsController;
use App\Http\Controllers\Api\ChapterController as ApiChapterController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\Api\FaqController as ApiFaqController;
use App\Http\Controllers\Api\ContactController as ApiContactController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API Routes
Route::prefix('v1')->group(function () {
    // Authentication
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Public Manga
    Route::get('/mangas', [ApiMangaController::class, 'index']);
    Route::get('/mangas/{manga}', [ApiMangaController::class, 'show']);
    
    // External Manga API Integration
    Route::get('/manga-api/search', [\App\Http\Controllers\Api\MangaApiController::class, 'search']);
    Route::get('/manga-api/top', [\App\Http\Controllers\Api\MangaApiController::class, 'getTop']);
    Route::get('/manga-api/details', [\App\Http\Controllers\Api\MangaApiController::class, 'getDetails']);
    Route::get('/manga-api/stats', [\App\Http\Controllers\Api\MangaApiController::class, 'getStats']);
    
    // Public News
    Route::get('/news', [ApiNewsController::class, 'index']);
    Route::get('/news/{news}', [ApiNewsController::class, 'show']);
    
    // Public Chapters
    Route::get('/mangas/{manga}/chapters', [ApiChapterController::class, 'index']);
    Route::get('/mangas/{manga}/chapters/{chapter}', [ApiChapterController::class, 'show']);
    
    // Public FAQ
    Route::get('/faq', [ApiFaqController::class, 'index']);
    
    // Public User Profiles
    Route::get('/users/{username}', [ApiUserController::class, 'show']);
    
    // Contact Form
    Route::post('/contact', [ApiContactController::class, 'store']);
    
    // Newsletter
    Route::post('/newsletter/subscribe', [\App\Http\Controllers\NewsletterSubscriptionController::class, 'store']);
    
    // Protected Routes (require authentication)
    Route::middleware('auth:sanctum')->group(function () {
        // User Profile
        Route::get('/user', [ApiUserController::class, 'me']);
        Route::put('/user', [ApiUserController::class, 'update']);
        Route::put('/user/password', [ApiUserController::class, 'updatePassword']);
        Route::get('/user/favorites', [ApiUserController::class, 'favorites']);
        
        // User Favorites
        Route::get('/user/favorites', [ApiUserController::class, 'favorites']);
        Route::post('/mangas/{manga}/favorite', [ApiMangaController::class, 'favorite']);
        Route::delete('/mangas/{manga}/favorite', [ApiMangaController::class, 'unfavorite']);
        
        // News Comments
        Route::post('/news/{news}/comments', [ApiNewsController::class, 'storeComment']);
        Route::delete('/news/comments/{comment}', [ApiNewsController::class, 'deleteComment']);
        
        // FAQ Requests
        Route::post('/faq/requests', [\App\Http\Controllers\FaqRequestController::class, 'store']);
        
        // Sync Manga from External API (Admin only)
        Route::post('/manga-api/sync', [\App\Http\Controllers\Api\MangaApiController::class, 'sync']);
        
        // Logout
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    
    // Admin Routes
    Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
        // Manga Management
        Route::apiResource('mangas', \App\Http\Controllers\Api\Admin\MangaController::class);
        
        // News Management
        Route::apiResource('news', \App\Http\Controllers\Api\Admin\NewsController::class);
        
        // FAQ Management
        Route::apiResource('faq-categories', \App\Http\Controllers\Api\Admin\FaqCategoryController::class);
        Route::apiResource('faq-items', \App\Http\Controllers\Api\Admin\FaqItemController::class);
        Route::get('faq-requests', [\App\Http\Controllers\Api\Admin\FaqRequestController::class, 'index']);
        Route::post('faq-requests/{faqRequest}/approve', [\App\Http\Controllers\Api\Admin\FaqRequestController::class, 'approve']);
        
        // User Management
        Route::apiResource('users', \App\Http\Controllers\Api\Admin\UserController::class);
        Route::post('users/{user}/toggle-admin', [\App\Http\Controllers\Api\Admin\UserController::class, 'toggleAdmin']);
        
        // Contact Management
        Route::get('contacts', [\App\Http\Controllers\Api\Admin\ContactController::class, 'index']);
        Route::get('contacts/{contact}', [\App\Http\Controllers\Api\Admin\ContactController::class, 'show']);
        Route::post('contacts/{contact}/reply', [\App\Http\Controllers\Api\Admin\ContactController::class, 'reply']);
    });
});

