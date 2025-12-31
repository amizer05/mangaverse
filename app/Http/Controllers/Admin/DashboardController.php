<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Manga;
use App\Models\Chapter;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'user_growth' => $this->calculateGrowth(User::class, 'month'),
            'total_manga' => Manga::count(),
            'manga_growth' => $this->calculateGrowth(Manga::class, 'month'),
            'active_readers' => $this->getActiveReaders(),
            'readers_growth' => 15, // Placeholder
            'reviews_today' => 0, // Placeholder - implement when reviews are added
            'reviews_growth' => 0
        ];
        
        $recentManga = Manga::withCount('chapters')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get()
            ->map(function($manga) {
                return [
                    'id' => $manga->id,
                    'title' => $manga->title,
                    'slug' => $manga->slug,
                    'chapters_count' => $manga->chapters_count,
                    'status' => 'active', // Placeholder
                    'views' => $this->getMangaViews($manga)
                ];
            });
        
        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(4)
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'is_active' => true // Placeholder
                ];
            });
        
        $analytics = [
            'revenue_today' => 0, // Placeholder
            'revenue_growth' => 0,
            'new_subscribers' => User::whereDate('created_at', today())->count(),
            'subscribers_growth' => $this->calculateGrowth(User::class, 'week'),
            'avg_reading_time' => 42, // Placeholder
            'reading_time_growth' => 8
        ];
        
        return view('admin.dashboard', compact('stats', 'recentManga', 'recentUsers', 'analytics'));
    }
    
    private function calculateGrowth($model, $period)
    {
        $now = now();
        $previous = $period === 'day' ? $now->copy()->subDay() : ($period === 'week' ? $now->copy()->subWeek() : $now->copy()->subMonth());
        
        $current = $model::where('created_at', '>=', $previous)->count();
        $old = $model::whereBetween('created_at', [
            $period === 'day' ? $now->copy()->subDays(2) : ($period === 'week' ? $now->copy()->subWeeks(2) : $now->copy()->subMonths(2)),
            $previous
        ])->count();
        
        if ($old === 0) return 0;
        return round((($current - $old) / $old) * 100);
    }
    
    private function getActiveReaders()
    {
        // Placeholder - count users who logged in recently
        return User::where('updated_at', '>=', now()->subDays(7))->count();
    }
    
    private function getMangaViews($manga)
    {
        // Sum of all chapter views
        return Chapter::where('manga_id', $manga->id)
            ->where('is_published', true)
            ->sum('views') ?? 0;
    }
}

