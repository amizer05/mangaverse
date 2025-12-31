@extends('layouts.public')

@section('title', 'My Favorites')

@section('content')
<div class="bg-gradient-to-b from-slate-900 to-slate-950 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-white mb-2 flex items-center">
                        <svg class="w-10 h-10 mr-3 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                        My Favorites
                    </h1>
                    <p class="text-slate-400">Your favorite manga collection</p>
                </div>
                <a href="{{ route('mangas.public.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-lg text-white transition-colors duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Browse Manga
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-500/20 border border-green-500/50 text-green-400 px-6 py-4 rounded-xl flex items-center">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if($favoriteMangas->count() > 0)
        <!-- Favorites Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4 md:gap-6">
            @foreach($favoriteMangas as $manga)
            <div class="group cursor-pointer">
                <a href="{{ route('mangas.public.show', $manga->slug) }}" class="block">
                    <div class="relative aspect-[3/4] bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl overflow-hidden border border-slate-600 group-hover:border-indigo-500/50 transition-all duration-200 shadow-lg group-hover:shadow-indigo-500/20 group-hover:scale-105">
                        @if($manga->cover_image)
                            <img src="{{ asset('storage/' . $manga->cover_image) }}" 
                                 alt="{{ $manga->title }}" 
                                 class="w-full h-full object-cover"
                                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'400\'%3E%3Crect fill=\'%231e293b\' width=\'300\' height=\'400\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%2394a3b8\' font-family=\'Arial\' font-size=\'24\' font-weight=\'bold\'%3E{{ urlencode($manga->title) }}%3C/text%3E%3C/svg%3E'">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-16 h-16 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Favorite Badge -->
                        <div class="absolute top-2 right-2 bg-indigo-600 rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                        </div>
                        
                        <!-- Chapter Count Badge -->
                        @if($manga->chapters && $manga->chapters->count() > 0)
                        <div class="absolute bottom-2 left-2 bg-slate-900/80 backdrop-blur-sm rounded-lg px-2 py-1">
                            <span class="text-xs font-semibold text-white">{{ $manga->chapters->count() }} chapters</span>
                        </div>
                        @endif
                    </div>
                    <h3 class="text-white font-semibold mt-3 mb-1 line-clamp-2 group-hover:text-indigo-400 transition-colors duration-200 text-sm md:text-base">
                        {{ $manga->title }}
                    </h3>
                </a>
                
                <!-- Remove from Favorites Button -->
                <form action="{{ route('mangas.favorite.remove', $manga->slug) }}" method="POST" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to remove this from favorites?')" class="w-full px-3 py-2 bg-slate-800 hover:bg-red-600 border border-slate-700 hover:border-red-500 rounded-lg text-slate-300 hover:text-white text-xs font-medium transition-all duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Remove
                    </button>
                </form>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($favoriteMangas->hasPages())
        <div class="mt-8">
            {{ $favoriteMangas->links() }}
        </div>
        @endif

        @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="max-w-md mx-auto">
                <svg class="w-24 h-24 text-slate-700 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                </svg>
                <h2 class="text-2xl font-bold text-white mb-3">No favorites yet</h2>
                <p class="text-slate-400 mb-6">Start adding manga to your favorites to see them here!</p>
                <a href="{{ route('mangas.public.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-xl text-white font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-indigo-500/25">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Browse Manga
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

