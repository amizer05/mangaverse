<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Toggle favorite status for a manga.
     */
    public function toggle(Manga $manga)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to add favorites');
        }
        
        // Check if already favorited
        $isFavorited = $user->favorites()->where('manga_id', $manga->id)->exists();
        
        if ($isFavorited) {
            // Remove from favorites
            $user->favorites()->detach($manga->id);
            $message = 'Removed from favorites';
            $isFavorited = false;
        } else {
            // Add to favorites
            $user->favorites()->attach($manga->id);
            $message = 'Added to favorites';
            $isFavorited = true;
        }
        
        // Return JSON response for AJAX requests
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_favorited' => $isFavorited,
            ]);
        }
        
        // Redirect back for regular requests
        return back()->with('success', $message);
    }
    
    /**
     * Add manga to favorites.
     */
    public function add(Manga $manga)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to add favorites');
        }
        
        // Check if already favorited
        if (!$user->favorites()->where('manga_id', $manga->id)->exists()) {
            $user->favorites()->attach($manga->id);
            $message = 'Added to favorites';
        } else {
            $message = 'Already in favorites';
        }
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ]);
        }
        
        return back()->with('success', $message);
    }
    
    /**
     * Remove manga from favorites.
     */
    public function remove(Manga $manga)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to manage favorites');
        }
        
        $user->favorites()->detach($manga->id);
        
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Removed from favorites',
            ]);
        }
        
        return back()->with('success', 'Removed from favorites');
    }
    
    /**
     * Display user's favorite manga.
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login to view favorites');
        }
        
        $favoriteMangas = $user->favorites()
            ->with(['chapters' => function($q) {
                $q->where('is_published', true);
            }])
            ->orderBy('favorites.created_at', 'desc')
            ->paginate(12);
        
        return view('favorites.index', compact('favoriteMangas'));
    }
}
