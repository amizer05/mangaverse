<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Display the public profile of a user.
     */
    public function show(string $username): View
    {
        $user = User::where('username', $username)->firstOrFail();
        
        // Load favorite mangas
        $favoriteMangas = $user->favorites()->with('chapters')->take(8)->get();

        return view('users.show', compact('user', 'favoriteMangas'));
    }
}
