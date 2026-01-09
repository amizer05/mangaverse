<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\News;
use App\Models\NewsComment;
use App\Models\User;
use App\Models\Contact;
use App\Models\FaqItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Cache user statistics for 2 minutes
        $cacheKey = 'user_dashboard_stats_' . $user->id;
        $stats = Cache::remember($cacheKey, 120, function () use ($user) {
            return [
                'profileViews' => $user->profile_views ?? 0,
                'commentsCount' => NewsComment::where('user_id', $user->id)->count(),
                'favoritesCount' => $user->favorites()->count(),
                'memberSince' => $user->created_at,
            ];
        });
        
        // Get latest news (limit to 5)
        $latestNews = News::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get recent favorites (limit to 4)
        $recentFavorites = $user->favorites()
            ->latest('favorites.created_at')
            ->limit(4)
            ->get();
        
        return view('dashboard.index', array_merge($stats, [
            'latestNews' => $latestNews,
            'recentFavorites' => $recentFavorites,
        ]));
    }

    /**
     * Show the admin dashboard.
     */
    public function admin()
    {
        // Check if user is admin
        if (!Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        // Cache statistics for 5 minutes to improve performance
        $cacheKey = 'admin_dashboard_stats';
        $stats = \Cache::remember($cacheKey, 300, function () {
            return [
                'totalUsers' => User::count(),
                'newUsersThisMonth' => User::whereYear('created_at', now()->year)
                    ->whereMonth('created_at', now()->month)
                    ->count(),
                'totalNews' => News::count(),
                'publishedNews' => News::whereNotNull('published_at')
                    ->where('published_at', '<=', now())
                    ->count(),
                'draftNews' => News::whereNull('published_at')
                    ->orWhere('published_at', '>', now())
                    ->count(),
                'totalFaqs' => FaqItem::count(),
                'faqCategories' => \App\Models\FaqCategory::count(),
                'totalContacts' => Contact::count(),
                'unreadContacts' => Contact::where('is_read', false)->count(),
            ];
        });

        // Get recent users (limit to 4 for display)
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        // Get recent contact messages (limit to 5)
        $recentContacts = Contact::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', array_merge($stats, [
            'recentUsers' => $recentUsers,
            'recentContacts' => $recentContacts,
        ]));
    }
}



