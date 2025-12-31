@extends('layouts.public')

@section('title', 'Browse Manga')

@section('content')
<div class="bg-gradient-to-b from-slate-900 to-slate-950 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-white mb-2">Browse Manga</h1>
            <p class="text-slate-400">Discover your next favorite series from our extensive collection</p>
        </div>

        <!-- Search and Filters -->
        <div class="mb-8">
            <form action="{{ route('mangas.public.index') }}" method="GET" class="space-y-4">
                <!-- Search Bar -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="Search manga by title..." 
                           class="w-full pl-12 pr-4 py-4 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                    @if(request('q'))
                    <a href="{{ route('mangas.public.index') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </a>
                    @endif
                </div>

                <!-- Filters Row -->
                <div class="flex flex-wrap gap-4 items-end">
                    <!-- Genre Filter (Placeholder) -->
                    <div class="flex-1 min-w-[150px] sm:min-w-[200px]">
                        <label class="block text-sm font-medium text-slate-400 mb-2">Genre</label>
                        <select name="genre" class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 cursor-pointer">
                            <option value="">All Genres</option>
                            <option value="action" {{ request('genre') === 'action' ? 'selected' : '' }}>Action</option>
                            <option value="romance" {{ request('genre') === 'romance' ? 'selected' : '' }}>Romance</option>
                            <option value="comedy" {{ request('genre') === 'comedy' ? 'selected' : '' }}>Comedy</option>
                            <option value="drama" {{ request('genre') === 'drama' ? 'selected' : '' }}>Drama</option>
                            <option value="fantasy" {{ request('genre') === 'fantasy' ? 'selected' : '' }}>Fantasy</option>
                            <option value="horror" {{ request('genre') === 'horror' ? 'selected' : '' }}>Horror</option>
                            <option value="sci-fi" {{ request('genre') === 'sci-fi' ? 'selected' : '' }}>Sci-Fi</option>
                            <option value="slice-of-life" {{ request('genre') === 'slice-of-life' ? 'selected' : '' }}>Slice of Life</option>
                        </select>
                    </div>

                    <!-- Sort Filter -->
                    <div class="flex-1 min-w-[150px] sm:min-w-[200px]">
                        <label class="block text-sm font-medium text-slate-400 mb-2">Sort By</label>
                        <select name="sort" class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 cursor-pointer">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Updates</option>
                            <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title A-Z</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>

                    <!-- Apply Filters Button -->
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-lg text-white font-medium transition-all duration-200 transform hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        @if(request('q') || request('sort') || request('genre'))
        <div class="mb-6 p-4 bg-slate-800/50 border border-slate-700 rounded-lg flex flex-wrap items-center justify-between gap-4">
            <p class="text-slate-300">
                @if(request('q'))
                    Search results for: <span class="text-white font-semibold">"{{ request('q') }}"</span>
                @endif
                <span class="text-slate-400">
                    ({{ $mangas->total() }} {{ Str::plural('result', $mangas->total()) }})
                </span>
            </p>
            @if(request('q') || request('sort') || request('genre'))
            <a href="{{ route('mangas.public.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-white text-sm font-medium transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Clear Filters
            </a>
            @endif
        </div>
        @endif

        <!-- Manga Grid -->
        @if($mangas->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6 mb-12">
            @foreach($mangas as $manga)
            <a href="{{ route('mangas.public.show', $manga->slug) }}" class="group">
                <div class="relative overflow-hidden rounded-xl bg-slate-800 border border-slate-700 transition-all duration-300 transform group-hover:scale-105 group-hover:shadow-2xl group-hover:shadow-indigo-500/25 group-hover:border-indigo-500/50">
                    <!-- Cover Image -->
                    <div class="aspect-[3/4] overflow-hidden relative">
                        @if($manga->cover_image)
                            <img src="{{ asset('storage/' . $manga->cover_image) }}" 
                                 alt="{{ $manga->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'400\'%3E%3Crect fill=\'%231e293b\' width=\'300\' height=\'400\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%2394a3b8\' font-family=\'Arial\' font-size=\'20\'%3E{{ urlencode($manga->title) }}%3C/text%3E%3C/svg%3E'">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center">
                                <div class="text-center p-4">
                                    <svg class="w-16 h-16 text-slate-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <p class="text-slate-500 text-xs line-clamp-2">{{ $manga->title }}</p>
                                </div>
                            </div>
                        @endif
                        <!-- New Badge (if recently added) -->
                        @if($manga->created_at && $manga->created_at->diffInDays(now()) < 7)
                        <div class="absolute top-2 right-2 px-2 py-1 bg-gradient-to-r from-indigo-500 to-rose-500 rounded-md text-xs font-bold text-white shadow-lg z-10">
                            NEW
                        </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="p-3 md:p-4 bg-slate-800/95 backdrop-blur-sm">
                        <h3 class="font-semibold text-white text-sm mb-2 line-clamp-2 group-hover:text-indigo-400 transition-colors duration-200">
                            {{ $manga->title }}
                        </h3>
                        
                        @if($manga->description)
                        <p class="text-xs text-slate-400 line-clamp-2 mb-2 hidden sm:block">
                            {{ Str::limit(strip_tags($manga->description), 80) }}
                        </p>
                        @endif

                        @if($manga->release_date)
                        <div class="flex items-center text-xs text-slate-500">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($manga->release_date)->format('Y') }}
                        </div>
                        @endif
                    </div>

                    <!-- Overlay on hover -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center p-4">
                        <span class="text-sm text-white font-medium flex items-center">
                            View Details
                            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $mangas->links('pagination::tailwind') }}
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <svg class="w-24 h-24 text-slate-700 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-2xl font-bold text-white mb-2">No manga found</h3>
            <p class="text-slate-400 mb-6">
                @if(request('q'))
                    We couldn't find any manga matching "{{ request('q') }}"
                @else
                    There are no manga available yet. Check back soon!
                @endif
            </p>
            @if(request('q'))
            <a href="{{ route('mangas.public.index') }}" class="inline-flex items-center px-6 py-3 bg-slate-800 hover:bg-slate-700 rounded-lg text-white font-medium transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Clear Search
            </a>
            @endif
        </div>
        @endif
    </div>
</div>
@endsection
