<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the specified user's profile.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        
        // Increment profile views if not viewing own profile
        if (Auth::check() && Auth::id() !== $user->id) {
            $user->increment('profile_views');
        }
        
        return view('profile.show', compact('user'));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Validate the request
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
            'birthday' => ['nullable', 'date', 'before:today'],
            'about_me' => ['nullable', 'string', 'max:500'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'current_password' => ['nullable', 'required_with:password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Update basic information
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->birthday = $validated['birthday'] ?? null;
        $user->about_me = $validated['about_me'] ?? null;

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        // Handle password change
        if ($request->filled('current_password')) {
            // Verify current password
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The current password is incorrect.']);
            }

            // Update password
            $user->password = Hash::make($request->password);
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Update user preferences.
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dark_mode' => ['nullable'],
            'autoplay' => ['nullable'],
            'mature_content' => ['nullable'],
        ]);

        // Convert checkboxes to boolean values
        $preferences = [
            'dark_mode' => !empty($validated['dark_mode']),
            'autoplay' => !empty($validated['autoplay']),
            'mature_content' => !empty($validated['mature_content']),
        ];

        $request->user()->update([
            'preferences' => $preferences,
        ]);

        return back()->with('status', 'preferences-updated');
    }

    /**
     * Update user locale settings.
     */
    public function updateLocale(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'language' => ['required', 'string', 'in:en,nl,ja,fr'],
            'timezone' => ['required', 'string'],
        ]);

        $request->user()->update([
            'language' => $validated['language'],
            'timezone' => $validated['timezone'],
        ]);

        return back()->with('status', 'locale-updated');
    }

    /**
     * Update notification preferences.
     */
    public function updateNotifications(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'notify_chapters' => ['nullable'],
            'notify_comments' => ['nullable'],
            'notify_weekly' => ['nullable'],
            'notify_marketing' => ['nullable'],
        ]);

        // Convert checkboxes to boolean values
        $notifications = [
            'notify_chapters' => !empty($validated['notify_chapters']),
            'notify_comments' => !empty($validated['notify_comments']),
            'notify_weekly' => !empty($validated['notify_weekly']),
            'notify_marketing' => !empty($validated['notify_marketing']),
        ];

        $request->user()->update([
            'notifications' => $notifications,
        ]);

        return back()->with('status', 'notifications-updated');
    }

    /**
     * Remove the authenticated user's profile photo.
     */
    public function destroyPhoto()
    {
        $user = Auth::user();

        if ($user->profile_photo_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null;
            $user->save();
        }

        return back()->with('success', 'Profile photo removed successfully!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
