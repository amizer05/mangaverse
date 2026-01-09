@extends('layouts.public')

@section('title', 'Discover New Manga Every Day')

@section('content')
<!-- Hero Section -->
<div class="relative overflow-hidden bg-gradient-to-b from-slate-900 via-slate-950 to-slate-950">
    <!-- Decorative Background -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-rose-500 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <!-- Hero Content -->
            <div class="space-y-8 animate-fade-in">
                <div class="space-y-4">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                        <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-rose-400 bg-clip-text text-transparent animate-gradient bg-[length:200%_auto]">
                            Discover New Manga
                        </span>
                        <br>
                        <span class="text-white">Every Day</span>
                    </h1>
                    <p class="text-lg md:text-xl text-slate-400 leading-relaxed">
                        Explore thousands of manga titles, stay updated with the latest releases, and join a passionate community of manga enthusiasts.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('mangas.public.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-xl text-white font-semibold text-lg transition-all duration-200 transform hover:scale-105 shadow-lg shadow-indigo-500/25">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Browse Manga
                    </a>
                    <a href="{{ route('news.public.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-slate-800 hover:bg-slate-700 rounded-xl text-white font-semibold text-lg transition-all duration-200 border border-slate-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        Latest News
                    </a>
                </div>
                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 pt-8">
                    <div class="bg-slate-800/30 rounded-lg p-4 border border-slate-700/50 hover:border-indigo-500/50 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl md:text-3xl font-bold text-white">{{ number_format($totalMangas ?? 0) }}</div>
                                <div class="text-xs text-slate-400">Manga Titles</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-800/30 rounded-lg p-4 border border-slate-700/50 hover:border-rose-500/50 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-pink-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl md:text-3xl font-bold text-white">{{ number_format($totalUsers ?? 0) }}</div>
                                <div class="text-xs text-slate-400">Users</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-800/30 rounded-lg p-4 border border-slate-700/50 hover:border-purple-500/50 transition-all">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-2xl md:text-3xl font-bold text-white">{{ number_format($totalChapters ?? 0) }}</div>
                                <div class="text-xs text-slate-400">Chapters</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Hero Image -->
            <div class="hidden md:block">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500/20 to-rose-500/20 rounded-3xl blur-2xl"></div>
                    <div class="relative bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl p-8 border border-slate-700 aspect-square flex items-center justify-center">
                        <svg class="w-full h-full text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 2.18l8 3.86v8.96c0 4.35-2.97 8.43-7 9.77-4.03-1.34-7-5.42-7-9.77V7.86l6-2.9 8 3.86z"/>
                            <path d="M12 6c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6zm0 10c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Featured Manga Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white">Featured Manga</h2>
            </div>
            <p class="text-slate-400 ml-13">Handpicked titles just for you</p>
        </div>
        <a href="{{ route('mangas.public.index') }}" class="hidden md:inline-flex items-center text-indigo-400 hover:text-indigo-300 font-medium transition-all duration-200 group">
            View All
            <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
        @forelse($featuredMangas ?? [] as $manga)
        <a href="{{ route('mangas.public.show', $manga->slug) }}" class="group">
            <div class="relative overflow-hidden rounded-xl bg-slate-800 border border-slate-700 transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-2xl group-hover:shadow-indigo-500/25 group-hover:border-indigo-500/50">
                <!-- Cover Image -->
                <div class="aspect-[3/4] overflow-hidden relative bg-slate-800">
                    <img src="{{ $manga->cover_image_url }}" 
                         alt="{{ $manga->title }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                         loading="lazy"
                         onerror="this.onerror=null; this.src='{{ asset('images/default-manga-cover.svg') }}'">
                    <!-- New Badge -->
                    @if($manga->created_at && $manga->created_at->diffInDays(now()) < 7)
                    <div class="absolute top-2 right-2 px-2 py-1 bg-gradient-to-r from-indigo-500 to-rose-500 rounded-md text-xs font-bold text-white shadow-lg z-10">
                        NEW
                    </div>
                    @endif
                </div>
                <!-- Title -->
                <div class="p-3 bg-slate-800/95 backdrop-blur-sm">
                    <h3 class="font-semibold text-white text-sm line-clamp-2 group-hover:text-indigo-400 transition-colors duration-200">
                        {{ $manga->title }}
                    </h3>
                </div>
                <!-- Overlay on hover -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center p-4">
                    <span class="text-xs text-white font-medium flex items-center">
                        View Details
                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
            </div>
        </a>
        @empty
        <!-- Placeholder cards if no manga available -->
        @for($i = 0; $i < 6; $i++)
        <div class="group cursor-not-allowed">
            <div class="relative overflow-hidden rounded-xl bg-slate-800 border border-slate-700">
                <div class="aspect-[3/4] bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center">
                    <svg class="w-16 h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="p-3">
                    <h3 class="font-semibold text-slate-500 text-sm">Coming Soon</h3>
                </div>
            </div>
        </div>
        @endfor
        @endforelse
    </div>
</div>

<!-- Popular Manga Section -->
@if(isset($popularMangas) && $popularMangas->count() > 0)
<div class="bg-slate-900/50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-rose-500 to-pink-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-white">Popular Manga</h2>
                </div>
                <p class="text-slate-400 ml-13">Most read titles this week</p>
            </div>
            <a href="{{ route('mangas.public.index', ['sort' => 'popular']) }}" class="hidden md:inline-flex items-center text-rose-400 hover:text-rose-300 font-medium transition-all duration-200 group">
                View All
                <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
            @foreach($popularMangas as $manga)
            <a href="{{ route('mangas.public.show', $manga->slug) }}" class="group">
                <div class="relative overflow-hidden rounded-xl bg-slate-800 border border-slate-700 transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-2xl group-hover:shadow-rose-500/25 group-hover:border-rose-500/50">
                    <div class="aspect-[3/4] overflow-hidden relative bg-slate-800">
                        <img src="{{ $manga->cover_image_url }}" 
                             alt="{{ $manga->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-manga-cover.svg') }}'">
                        <div class="absolute top-2 left-2 px-2 py-1 bg-gradient-to-r from-rose-500 to-pink-500 rounded-md text-xs font-bold text-white shadow-lg z-10">
                            🔥 HOT
                        </div>
                    </div>
                    <div class="p-3 bg-slate-800/95 backdrop-blur-sm">
                        <h3 class="font-semibold text-white text-sm line-clamp-2 group-hover:text-rose-400 transition-colors duration-200">
                            {{ $manga->title }}
                        </h3>
                        <p class="text-xs text-slate-400 mt-1">{{ $manga->chapters->where('is_published', true)->count() ?? 0 }} chapters</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Recent Updates Section -->
@if(isset($recentChapters) && $recentChapters->count() > 0)
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white">Recent Updates</h2>
            </div>
            <p class="text-slate-400 ml-13">Newly released chapters</p>
        </div>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
        @foreach($recentChapters as $chapter)
        <a href="{{ route('chapters.read', ['manga' => $chapter->manga->slug, 'chapter' => $chapter->chapter_number]) }}" class="group bg-slate-800 rounded-xl overflow-hidden border border-slate-700 hover:border-purple-500/50 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-purple-500/10">
            <div class="p-4 md:p-6">
                <div class="flex items-start gap-4">
                    <div class="w-16 h-20 flex-shrink-0 rounded-lg overflow-hidden border border-slate-700 bg-slate-800">
                        <img src="{{ $chapter->manga->cover_image_url }}" 
                             alt="{{ $chapter->manga->title }}" 
                             class="w-full h-full object-cover"
                             loading="lazy"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-manga-cover.svg') }}'">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-xs text-purple-400 font-medium mb-1">
                            {{ $chapter->manga->title }}
                        </div>
                        <h3 class="text-base md:text-lg font-bold text-white mb-1 line-clamp-1 group-hover:text-purple-400 transition-colors duration-200">
                            Chapter {{ $chapter->chapter_number }}{!! $chapter->title ? ': ' . $chapter->title : '' !!}
                        </h3>
                        <p class="text-xs text-slate-400">
                            {{ $chapter->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-purple-400 transform group-hover:translate-x-1 transition-all duration-200 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</div>
@endif

<!-- Genres Quick Links -->
@if(isset($genres) && $genres->count() > 0)
<div class="bg-slate-900/50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-3 mb-2">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-cyan-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white">Browse by Genre</h2>
            </div>
            <p class="text-slate-400">Explore manga by your favorite genres</p>
        </div>
        <div class="flex flex-wrap gap-3 justify-center">
            @foreach($genres as $genre)
            <a href="{{ route('mangas.public.index', ['genre' => $genre]) }}" class="px-6 py-3 bg-slate-800 hover:bg-gradient-to-r hover:from-indigo-600 hover:to-cyan-600 rounded-lg text-white font-medium transition-all duration-200 transform hover:scale-105 border border-slate-700 hover:border-transparent">
                {{ $genre }}
            </a>
            @endforeach
            <a href="{{ route('mangas.public.index') }}" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-cyan-600 rounded-lg text-white font-medium transition-all duration-200 transform hover:scale-105">
                View All Genres →
            </a>
        </div>
    </div>
</div>
@endif

<!-- Latest News Section -->
<div class="bg-slate-900/50 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-bold text-white">Latest News</h2>
                </div>
                <p class="text-slate-400 ml-13">Stay updated with the manga world</p>
            </div>
            <a href="{{ route('news.public.index') }}" class="hidden md:inline-flex items-center text-indigo-400 hover:text-indigo-300 font-medium transition-all duration-200 group">
                View All
                <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
            @forelse(($latestNews ?? []) as $newsItem)
            <a href="{{ route('news.public.show', $newsItem->id) }}" class="group bg-slate-800 rounded-xl overflow-hidden border border-slate-700 hover:border-indigo-500/50 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/10">
                @if($newsItem->image)
                <div class="aspect-video overflow-hidden">
                    <img src="{{ asset('storage/' . $newsItem->image) }}" 
                         alt="{{ $newsItem->title }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                         loading="lazy">
                </div>
                @endif
                <div class="p-4 md:p-6">
                    <div class="text-xs text-indigo-400 font-medium mb-2">
                        {{ $newsItem->published_at ? \Carbon\Carbon::parse($newsItem->published_at)->format('M d, Y') : 'Draft' }}
                    </div>
                    <h3 class="text-base md:text-lg font-bold text-white mb-2 line-clamp-2 group-hover:text-indigo-400 transition-colors duration-200">
                        {{ $newsItem->title }}
                    </h3>
                    <p class="text-slate-400 text-sm line-clamp-3">
                        {{ Str::limit(strip_tags($newsItem->content), 120) }}
                    </p>
                </div>
            </a>
            @empty
            <div class="col-span-3 text-center py-12">
                <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
                <p class="text-slate-400">No news articles yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="relative bg-gradient-to-r from-indigo-600 to-rose-600 rounded-2xl p-8 md:p-12 text-center overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/2"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                Join Our Community Today
            </h2>
            <p class="text-lg text-indigo-100 mb-8 max-w-2xl mx-auto">
                Create an account to bookmark your favorite manga, participate in discussions, and get personalized recommendations.
            </p>
            @guest
            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white hover:bg-slate-100 rounded-xl text-indigo-600 font-semibold text-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl group">
                Get Started Free
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            @else
            <a href="{{ route('mangas.public.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 rounded-xl text-white font-semibold text-lg transition-all duration-200 transform hover:scale-105 group">
                Browse Manga
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            @endguest
        </div>
    </div>
</div>
@endsection
