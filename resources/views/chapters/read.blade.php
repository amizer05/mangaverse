@extends('layouts.public')

@section('title', $chapter->full_title . ' - ' . $manga->title)

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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if($chapter->pages->count() > 0)
        <!-- Page Navigation Info -->
        <div class="mb-4 flex items-center justify-between text-sm text-slate-400">
            <span>Page 1 of {{ $chapter->pages->count() }}</span>
            <div class="flex items-center gap-4">
                <button onclick="toggleFullscreen()" class="hover:text-white transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Pages Container -->
        <div id="pages-container" class="space-y-4">
            @foreach($chapter->pages as $page)
            <div class="page-container" data-page="{{ $page->page_number }}">
                <img src="{{ $page->image_url }}" 
                     alt="Page {{ $page->page_number }}" 
                     class="w-full h-auto rounded-lg shadow-2xl mx-auto block cursor-pointer"
                     loading="lazy"
                     onclick="nextPage()"
                     onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'800\' height=\'1200\'%3E%3Crect fill=\'%23f1f5f9\' width=\'800\' height=\'1200\'/%3E%3Ctext x=\'50%25\' y=\'45%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%2394a3b8\' font-family=\'Arial\' font-size=\'32\' font-weight=\'bold\'%3EPage {{ $page->page_number }}%3C/text%3E%3Ctext x=\'50%25\' y=\'55%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%23cbd5e1\' font-family=\'Arial\' font-size=\'18\'%3E{{ $chapter->full_title }}%3C/text%3E%3C/svg%3E'">
            </div>
            @endforeach
        </div>

        <!-- Page Navigation -->
        <div class="mt-8 flex items-center justify-center gap-4">
            @if($previousChapter)
            <a href="{{ route('chapters.read', [$manga->slug, $previousChapter->id]) }}" 
               class="px-6 py-3 bg-slate-800 hover:bg-slate-700 rounded-lg text-white font-medium transition-colors duration-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Previous Chapter
            </a>
            @endif
            
            <a href="{{ route('mangas.public.show', $manga->slug) }}" 
               class="px-6 py-3 bg-slate-800 hover:bg-slate-700 rounded-lg text-white font-medium transition-colors duration-200">
                Back to Manga
            </a>
            
            @if($nextChapter)
            <a href="{{ route('chapters.read', [$manga->slug, $nextChapter->id]) }}" 
               class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-lg text-white font-medium transition-all duration-200 flex items-center">
                Next Chapter
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
            @endif
        </div>
        @else
        <!-- No Pages -->
        <div class="text-center py-20">
            <svg class="w-24 h-24 text-slate-700 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <h3 class="text-2xl font-bold text-white mb-2">No pages available</h3>
            <p class="text-slate-400 mb-6">This chapter doesn't have any pages yet.</p>
            <a href="{{ route('mangas.public.show', $manga->slug) }}" class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-white font-medium transition-colors duration-200">
                Back to Manga
            </a>
        </div>
        @endif
    </div>
</div>

<script>
let currentPage = 1;
const totalPages = {{ $chapter->pages->count() }};

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'ArrowRight' || e.key === ' ') {
        e.preventDefault();
        nextPage();
    } else if (e.key === 'ArrowLeft') {
        e.preventDefault();
        previousPage();
    }
});

function nextPage() {
    if (currentPage < totalPages) {
        currentPage++;
        scrollToPage(currentPage);
    } else if ({{ $nextChapter ? 'true' : 'false' }}) {
        // Go to next chapter
        window.location.href = '{{ $nextChapter ? route("chapters.read", [$manga->slug, $nextChapter->id]) : "#" }}';
    }
}

function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        scrollToPage(currentPage);
    } else if ({{ $previousChapter ? 'true' : 'false' }}) {
        // Go to previous chapter
        window.location.href = '{{ $previousChapter ? route("chapters.read", [$manga->slug, $previousChapter->id]) : "#" }}';
    }
}

function scrollToPage(pageNumber) {
    const pageElement = document.querySelector(`[data-page="${pageNumber}"]`);
    if (pageElement) {
        pageElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        updatePageInfo(pageNumber);
    }
}

function updatePageInfo(page) {
    const pageInfo = document.querySelector('.text-slate-400 span');
    if (pageInfo) {
        pageInfo.textContent = `Page ${page} of ${totalPages}`;
    }
}

function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        document.exitFullscreen();
    }
}

// Scroll to top on load
window.addEventListener('load', () => {
    scrollToPage(1);
});
</script>

<style>
.page-container img {
    max-width: 100%;
    height: auto;
    cursor: pointer;
    transition: transform 0.2s;
}

.page-container img:hover {
    transform: scale(1.01);
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}
</style>
@endsection

