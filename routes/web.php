<?php

use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqCategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FaqItemController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicChapterController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\NewsletterSubscriptionController;
use Illuminate\Support\Facades\Route;

use App\Models\Manga;
use App\Models\News;
use App\Models\User;

Route::get('/app', function () {
    return view('mangaverse-app');
});

Route::get('/', function () {
    // Only show mangas with cover images
    $mangaQuery = Manga::whereNotNull('cover_image')
                       ->where('cover_image', '!=', '');

    // Featured manga (mix of popular and latest)
    $featuredMangas = (clone $mangaQuery)
        ->with(['chapters' => function($q) {
            $q->where('is_published', true);
        }])
        ->whereHas('chapters', function($q) {
            $q->where('is_published', true);
        })
        ->get()
        ->sortByDesc(function($manga) {
            return $manga->chapters->where('is_published', true)->count();
        })
        ->take(3)
        ->merge(
            (clone $mangaQuery)->latest()->take(3)->get()
        )
        ->unique('id')
        ->take(6);

    // Popular manga (by chapter count)
    $popularMangas = (clone $mangaQuery)
        ->with(['chapters' => function($q) {
            $q->where('is_published', true);
        }])
        ->whereHas('chapters', function($q) {
            $q->where('is_published', true);
        })
        ->get()
        ->sortByDesc(function($manga) {
            return $manga->chapters->where('is_published', true)->count();
        })
        ->take(6);

    // Latest manga
    $latestMangas = (clone $mangaQuery)->latest()->take(6)->get();

    // Recent chapter updates
    $recentChapters = \App\Models\Chapter::with('manga')
        ->where('is_published', true)
        ->latest('created_at')
        ->take(6)
        ->get();

    // Get unique genres (only from mangas with covers)
    $genres = (clone $mangaQuery)
        ->whereNotNull('genre')
        ->distinct()
        ->pluck('genre')
        ->filter()
        ->take(8);

    return view('home', [
        'featuredMangas' => $featuredMangas,
        'popularMangas' => $popularMangas,
        'latestMangas' => $latestMangas,
        'recentChapters' => $recentChapters,
        'genres' => $genres,
        'latestNews' => News::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->take(3)
            ->get(),
        'totalMangas' => Manga::count(),
        'totalUsers' => User::count(),
        'totalChapters' => \App\Models\Chapter::where('is_published', true)->count(),
    ]);
})->name('home');

// Public contact form
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:3,60') // 3 requests per 60 minutes
    ->name('contact.store');

// Public user profiles
Route::get('/users/{username}', [UserProfileController::class, 'show'])->name('users.show');

// Public FAQ
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Public Manga viewing (read-only)
Route::get('/mangas', [MangaController::class, 'indexPublic'])->name('mangas.public.index');
Route::get('/mangas/{manga}', [MangaController::class, 'showPublic'])->name('mangas.public.show');

// Public Chapter reading
Route::get('/mangas/{manga}/chapters/{chapter}', [PublicChapterController::class, 'show'])->name('chapters.read')->where('chapter', '[0-9]+');
Route::get('/mangas/{manga}/chapters/{chapter}/page/{pageNumber}', [PublicChapterController::class, 'showPage'])->name('chapters.read-page')->where(['chapter' => '[0-9]+', 'pageNumber' => '[0-9]+']);

// Public News viewing (read-only)
Route::get('/news', [NewsController::class, 'indexPublic'])->name('news.public.index');
Route::get('/news/{news}', [NewsController::class, 'showPublic'])->name('news.public.show');

// News Comments
Route::middleware('auth')->group(function () {
    Route::post('/news/{news}/comments', [\App\Http\Controllers\NewsCommentController::class, 'store'])->name('news.comments.store');
    Route::delete('/news/comments/{comment}', [\App\Http\Controllers\NewsCommentController::class, 'destroy'])->name('news.comments.destroy');
    
    // Favorites
    Route::get('/favorites', [\App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/mangas/{manga}/favorite', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('mangas.favorite.toggle');
    Route::post('/mangas/{manga}/favorite/add', [\App\Http\Controllers\FavoriteController::class, 'add'])->name('mangas.favorite.add');
    Route::delete('/mangas/{manga}/favorite', [\App\Http\Controllers\FavoriteController::class, 'remove'])->name('mangas.favorite.remove');
});

// FAQ Requests
Route::post('/faq/requests', [\App\Http\Controllers\FaqRequestController::class, 'store'])->name('faq.requests.store');

// Newsletter subscription
Route::post('/newsletter-subscribe', [NewsletterSubscriptionController::class, 'store'])
    ->name('newsletter.subscribe');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::post('/profile/preferences', [ProfileController::class, 'updatePreferences'])->name('profile.preferences');
    Route::post('/profile/locale', [ProfileController::class, 'updateLocale'])->name('profile.locale');
    Route::post('/profile/notifications', [ProfileController::class, 'updateNotifications'])->name('profile.notifications');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin-only routes (Manga, News, FAQ, Contacts)
    Route::middleware('admin')->group(function () {
        // Admin routes with prefix
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'admin'])->name('dashboard');
            Route::resource('mangas', MangaController::class);
            Route::post('mangas/search-api', [MangaController::class, 'searchApi'])->name('mangas.search-api');
            Route::post('mangas/sync-api', [MangaController::class, 'syncFromApi'])->name('mangas.sync-api');
            Route::resource('news', NewsController::class);
            Route::resource('faq-categories', FaqCategoryController::class);
            Route::resource('faq-items', FaqItemController::class);
            Route::resource('faq-requests', \App\Http\Controllers\Admin\FaqRequestController::class)->only(['index', 'show', 'destroy']);
            Route::post('faq-requests/{faqRequest}/approve', [\App\Http\Controllers\Admin\FaqRequestController::class, 'approve'])->name('faq-requests.approve');
            Route::post('faq-requests/{faqRequest}/reject', [\App\Http\Controllers\Admin\FaqRequestController::class, 'reject'])->name('faq-requests.reject');
            Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
            Route::post('users/{user}/toggle-admin', [\App\Http\Controllers\Admin\UserController::class, 'toggleAdmin'])->name('users.toggle-admin');
            
            // Chapter management
            Route::resource('mangas.chapters', ChapterController::class)->shallow();
            Route::delete('chapters/{chapter}/pages/{page}', [ChapterController::class, 'deletePage'])->name('chapters.pages.destroy');
            
            // Contact management
            Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
            Route::get('contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
            Route::patch('contacts/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.update-status');
            Route::post('contacts/{contact}/reply', [AdminContactController::class, 'reply'])->name('contacts.reply');
            Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
        });
    });
});

require __DIR__.'/auth.php';
