@extends('layouts.public')

@section('title', $chapter->full_title . ' - ' . $manga->title . ' - Page ' . $pageNumber)

@section('content')
<div class="bg-slate-950 min-h-screen">
    <!-- Chapter Header -->
    <div class="sticky top-0 z-50 bg-slate-900/95 backdrop-blur-md border-b border-slate-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <!-- Manga & Chapter Info -->
                <div class="flex-1 min-w-0">
                    <a href="{{ route('mangas.public.show', $manga->slug) }}" class="text-sm text-slate-400 hover:text-indigo-400 transition-colors duration-200 inline-flex items-center mb-1">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        {{ $manga->title }}
                    </a>
                    <h1 class="text-lg md:text-xl font-bold text-white truncate">
                        {{ $chapter->full_title }}
                    </h1>
                    <p class="text-xs text-slate-400 mt-1">
                        Page {{ $page->page_number }} of {{ $allPages->count() }}
                    </p>
                </div>

                <!-- Navigation Controls -->
                <div class="flex items-center gap-2 ml-4">
                    <!-- Language Badge -->
                    <span class="px-3 py-1 bg-indigo-500/20 text-indigo-400 rounded-lg text-sm font-medium">
                        {{ $chapter->language }}
                    </span>
                    
                    <!-- Chapter Navigation -->
                    <div class="flex items-center gap-1">
                        @if($previousChapter)
                        <a href="{{ route('chapters.read', [$manga->slug, $previousChapter->id]) }}" 
                           class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-white transition-colors duration-200"
                           title="Previous Chapter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                        @endif
                        
                        @if($nextChapter)
                        <a href="{{ route('chapters.read', [$manga->slug, $nextChapter->id]) }}" 
                           class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-white transition-colors duration-200"
                           title="Next Chapter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reading Area -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Single Page -->
        <div class="page-container">
            <img src="{{ $page->image_url }}" 
                 alt="Page {{ $page->page_number }}" 
                 class="w-full h-auto rounded-lg shadow-2xl mx-auto block"
                 loading="lazy"
                 onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'800\' height=\'1200\'%3E%3Crect fill=\'%23f1f5f9\' width=\'800\' height=\'1200\'/%3E%3Ctext x=\'50%25\' y=\'45%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%2394a3b8\' font-family=\'Arial\' font-size=\'32\' font-weight=\'bold\'%3EPage {{ $page->page_number }}%3C/text%3E%3Ctext x=\'50%25\' y=\'55%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23cbd5e1\' font-family=\'Arial\' font-size=\'18\'%3E{{ $chapter->full_title }}%3C/text%3E%3C/svg%3E'">
        </div>

        <!-- Page Navigation -->
        <div class="mt-8 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                @if($previousPage)
                <a href="{{ route('chapters.read-page', [$manga->slug, $chapter->id, $previousPage->page_number]) }}" 
                   class="px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-white text-sm font-medium transition-colors duration-200 flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Previous page
                </a>
                @endif

                @if($nextPage)
                <a href="{{ route('chapters.read-page', [$manga->slug, $chapter->id, $nextPage->page_number]) }}" 
                   class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-lg text-white text-sm font-medium transition-all duration-200 flex items-center">
                    Next page
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('chapters.read', [$manga->slug, $chapter->id]) }}" 
                   class="px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-white text-sm font-medium transition-colors duration-200">
                    View all pages
                </a>
                <a href="{{ route('mangas.public.show', $manga->slug) }}" 
                   class="px-4 py-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-white text-sm font-medium transition-colors duration-200">
                    Back to manga
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.page-container img {
    max-width: 100%;
    height: auto;
}
</style>
@endsection








