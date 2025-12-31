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

class DashboardController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get statistics for the user
        $profileViews = $user->profile_views ?? 0;
        $commentsCount = NewsComment::where('user_id', $user->id)->count();
        
        // Get latest news (limit to 5)
        $latestNews = News::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('dashboard.index', compact(
            'profileViews',
            'commentsCount',
            'latestNews'
        ));
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

        // Get statistics
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $totalNews = News::count();
        $publishedNews = News::whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->count();

        $totalFaqs = FaqItem::count();
        $faqCategories = \App\Models\FaqCategory::count();

        $totalContacts = Contact::count();
        $unreadContacts = Contact::where('is_read', false)->count();

        // Get recent users (limit to 5)
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get recent contact messages (limit to 5)
        $recentContacts = Contact::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'newUsersThisMonth',
            'totalNews',
            'publishedNews',
            'totalFaqs',
            'faqCategories',
            'totalContacts',
            'unreadContacts',
            'recentUsers',
            'recentContacts'
        ));
    }
}



