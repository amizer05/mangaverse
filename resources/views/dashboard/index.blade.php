@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-900 via-purple-900 to-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Welcome back, {{ auth()->user()->username ?? auth()->user()->name }}!</h1>
            <p class="text-gray-400">Manage your profile and stay updated with the latest manga news</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm">Profile Views</p>
                        <p class="text-white text-3xl font-bold mt-1">{{ $profileViews ?? 0 }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm">Comments</p>
                        <p class="text-white text-3xl font-bold mt-1">{{ $commentsCount ?? 0 }}</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-600 to-teal-600 rounded-xl p-6 shadow-xl">
                <div>
                    <p class="text-green-100 text-sm">Member Since</p>
                    <p class="text-white text-xl font-bold mt-1">{{ auth()->user()->created_at->format('M Y') }}</p>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-600 to-red-600 rounded-xl p-6 shadow-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm">Account Type</p>
                        <p class="text-white text-xl font-bold mt-1">
                            @if(auth()->user()->is_admin)
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Admin
                                </span>
                            @else
                                User
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-xl border border-gray-700/50 overflow-hidden">
                    <div class="h-32 bg-gradient-to-r from-purple-600 via-pink-600 to-blue-600"></div>
                    <div class="px-6 pb-6">
                        <div class="flex justify-center -mt-16 mb-4">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo_path) }}" alt="Profile" class="w-32 h-32 rounded-full border-4 border-gray-800 object-cover shadow-xl">
                            @else
                                <div class="w-32 h-32 rounded-full border-4 border-gray-800 bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center shadow-xl">
                                    <span class="text-white text-4xl font-bold">{{ substr(auth()->user()->username ?? auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-white mb-1">{{ auth()->user()->username ?? auth()->user()->name }}</h2>
                            <p class="text-gray-400 text-sm mb-4">{{ auth()->user()->email }}</p>
                            
                            @if(auth()->user()->birthday)
                                <div class="flex items-center justify-center text-gray-300 mb-2">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm">{{ \Carbon\Carbon::parse(auth()->user()->birthday)->format('F d, Y') }}</span>
                                </div>
                            @endif
                            
                            @if(auth()->user()->about_me)
                                <div class="mt-4 p-4 bg-gray-900/50 rounded-lg">
                                    <p class="text-gray-300 text-sm">{{ auth()->user()->about_me }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 space-y-3">
                            <a href="{{ route('profile.edit') }}" class="block w-full text-center bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Edit Profile
                            </a>
                            <a href="{{ route('profile.show', auth()->user()->id) }}" class="block w-full text-center bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200">
                                View Public Profile
                            </a>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->is_admin)
                    <div class="mt-6 bg-gradient-to-br from-yellow-600 to-orange-600 rounded-xl shadow-xl p-6 border border-yellow-500/50">
                        <div class="flex items-center mb-4">
                            <svg class="w-6 h-6 text-white mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <h3 class="text-xl font-bold text-white">Admin Panel</h3>
                        </div>
                        <p class="text-yellow-100 text-sm mb-4">Quick access to admin features</p>
                        <a href="{{ route('admin.dashboard') }}" class="block w-full text-center bg-white text-orange-600 font-semibold py-3 px-4 rounded-lg hover:bg-gray-100 transition-all duration-200 shadow-lg">
                            Go to Admin Dashboard
                        </a>
                    </div>
                @endif
            </div>

            <!-- Activity Feed -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Latest News -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-xl border border-gray-700/50 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-white flex items-center">
                            <svg class="w-7 h-7 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            Latest News
                        </h3>
                        <a href="{{ route('news.public.index') }}" class="text-purple-400 hover:text-purple-300 text-sm font-semibold flex items-center">
                            View All
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    @if($latestNews && $latestNews->count() > 0)
                        <div class="space-y-4">
                            @foreach($latestNews as $news)
                                <div class="flex bg-gray-900/50 rounded-lg overflow-hidden hover:bg-gray-900/70 transition-all duration-200 border border-gray-700/30">
                                    @if($news->image)
                                        <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-32 h-32 object-cover">
                                    @else
                                        <div class="w-32 h-32 bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 p-4">
                                        <h4 class="text-white font-semibold text-lg mb-2 hover:text-purple-400 transition-colors">
                                            <a href="{{ route('news.public.show', $news->id) }}">{{ $news->title }}</a>
                                        </h4>
                                        <p class="text-gray-400 text-sm mb-2 line-clamp-2">{{ Str::limit(strip_tags($news->content), 100) }}</p>
                                        <div class="flex items-center text-gray-500 text-xs">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $news->published_at->format('M d, Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            <p class="text-gray-400">No news articles available yet</p>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-xl shadow-xl border border-gray-700/50 p-6">
                    <h3 class="text-2xl font-bold text-white mb-6 flex items-center">
                        <svg class="w-7 h-7 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Quick Actions
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('news.public.index') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-blue-600/20 to-blue-800/20 hover:from-blue-600/30 hover:to-blue-800/30 rounded-xl border border-blue-500/30 transition-all duration-200 group">
                            <svg class="w-10 h-10 text-blue-400 mb-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                            <span class="text-white font-semibold text-sm">Browse News</span>
                        </a>

                        <a href="{{ route('faq.index') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-green-600/20 to-green-800/20 hover:from-green-600/30 hover:to-green-800/30 rounded-xl border border-green-500/30 transition-all duration-200 group">
                            <svg class="w-10 h-10 text-green-400 mb-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-white font-semibold text-sm">FAQ</span>
                        </a>

                        <a href="{{ route('contact.create') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-purple-600/20 to-purple-800/20 hover:from-purple-600/30 hover:to-purple-800/30 rounded-xl border border-purple-500/30 transition-all duration-200 group">
                            <svg class="w-10 h-10 text-purple-400 mb-3 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-white font-semibold text-sm">Contact</span>
                        </a>

                        <a href="{{ route('favorites.index') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-pink-600/20 to-rose-800/20 hover:from-pink-600/30 hover:to-rose-800/30 rounded-xl border border-pink-500/30 transition-all duration-200 group">
                            <svg class="w-10 h-10 text-pink-400 mb-3 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            <span class="text-white font-semibold text-sm">My Favorites</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

