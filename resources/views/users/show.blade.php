@extends('layouts.public')

@section('title', $user->name . '\'s Profile')

@section('content')
<div class="bg-gradient-to-b from-slate-900 to-slate-950 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-slate-400 hover:text-white transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Left Column - Profile Card -->
            <div class="md:col-span-1">
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl overflow-hidden sticky top-24">
                    <!-- Profile Header -->
                    <div class="relative h-32 bg-gradient-to-r from-indigo-600 to-rose-600">
                        <div class="absolute -bottom-16 left-1/2 transform -translate-x-1/2">
                            <div class="relative">
                                <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=200&background=6366f1&color=fff' }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-32 h-32 rounded-full border-4 border-slate-950 object-cover">
                                @if($user->isAdmin())
                                <div class="absolute bottom-2 right-2 w-8 h-8 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full flex items-center justify-center border-2 border-slate-950" title="Admin">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Profile Info -->
                    <div class="pt-20 px-6 pb-6 text-center">
                        <h1 class="text-2xl font-bold text-white mb-1">{{ $user->name }}</h1>
                        <p class="text-indigo-400 text-sm mb-4">{{ '@' . ($user->username ?? 'user') }}</p>
                        @if($user->birthday)
                        <div class="flex items-center justify-center text-slate-400 text-sm mb-4">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($user->birthday)->format('F j, Y') }}
                        </div>
                        @endif

                        <!-- Member Since -->
                        <div class="flex items-center justify-center text-slate-400 text-sm mb-6">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Member since {{ $user->created_at->format('M Y') }}
                        </div>

                        <!-- Action Buttons -->
                        @auth
                            @if(Auth::id() === $user->id)
                            <a href="{{ route('profile.edit') }}" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-xl text-white font-semibold transition-all duration-200 transform hover:scale-105">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit Profile
                            </a>
                            @else
                            <button class="w-full inline-flex items-center justify-center px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-xl text-white font-semibold transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                Follow
                            </button>
                            @endif
                        @endauth

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-slate-700">
                            <div>
                                <div class="text-2xl font-bold text-white">24</div>
                                <div class="text-xs text-slate-400">Manga Read</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">156</div>
                                <div class="text-xs text-slate-400">Reviews</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">89</div>
                                <div class="text-xs text-slate-400">Followers</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Content -->
            <div class="md:col-span-2 space-y-6">
                <!-- About Me -->
                @if($user->about_me)
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        About Me
                    </h2>
                    <p class="text-slate-300 leading-relaxed whitespace-pre-line">{{ $user->about_me }}</p>
                </div>
                @endif

                <!-- Favorite Manga -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        Favorite Manga
                    </h2>
                    
                    @if($favoriteMangas && $favoriteMangas->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                        @foreach($favoriteMangas as $manga)
                        <a href="{{ route('mangas.public.show', $manga->slug) }}" class="group cursor-pointer">
                            <div class="aspect-[3/4] bg-slate-800 rounded-lg overflow-hidden border border-slate-600 group-hover:border-indigo-500/50 transition-all duration-200 relative">
                                <img src="{{ $manga->cover_image_url }}" 
                                     alt="{{ $manga->title }}" 
                                     class="w-full h-full object-cover"
                                     loading="lazy"
                                     onerror="this.onerror=null; this.src='{{ asset('images/default-manga-cover.svg') }}'">
                            </div>
                            <p class="text-sm text-slate-400 mt-2 line-clamp-1 group-hover:text-indigo-400 transition-colors">{{ $manga->title }}</p>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        <p class="text-slate-400">No favorite manga yet</p>
                    </div>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Recent Activity
                    </h2>
                    <div class="space-y-4">
                        <!-- Activity Items -->
                        <div class="flex items-start p-4 bg-slate-800 rounded-lg border border-slate-700">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-white">
                                    <span class="font-semibold">Added to favorites:</span>
                                    <a href="#" class="text-indigo-400 hover:text-indigo-300">One Piece</a>
                                </p>
                                <p class="text-sm text-slate-400 mt-1">2 days ago</p>
                            </div>
                        </div>
                        <div class="flex items-start p-4 bg-slate-800 rounded-lg border border-slate-700">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-white">
                                    <span class="font-semibold">Commented on:</span>
                                    <a href="#" class="text-indigo-400 hover:text-indigo-300">Attack on Titan</a>
                                </p>
                                <p class="text-sm text-slate-400 mt-1">5 days ago</p>
                            </div>
                        </div>
                        <div class="flex items-start p-4 bg-slate-800 rounded-lg border border-slate-700">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-full flex items-center justify-center flex-shrink-0 mr-4">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-white">
                                    <span class="font-semibold">Rated:</span>
                                    <a href="#" class="text-indigo-400 hover:text-indigo-300">My Hero Academia</a>
                                    <span class="text-yellow-400">★★★★★</span>
                                </p>
                                <p class="text-sm text-slate-400 mt-1">1 week ago</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State if no about_me or activity -->
                @if(!$user->about_me)
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-12 text-center">
                    <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p class="text-slate-400">
                        @if(Auth::check() && Auth::id() === $user->id)
                            Complete your profile to let others know more about you!
                        @else
                            This user hasn't added a bio yet.
                        @endif
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
