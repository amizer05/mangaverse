@extends('layouts.public')

@section('title', $manga->title)

@section('content')
<div class="bg-gradient-to-b from-slate-900 to-slate-950">
    <!-- Back Button -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <a href="{{ route('mangas.public.index') }}" class="inline-flex items-center text-slate-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Manga List
        </a>
    </div>

    <!-- Manga Details -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div class="grid md:grid-cols-3 gap-6 md:gap-8">
            <!-- Left Column - Cover -->
            <div class="md:col-span-1">
                <div class="sticky top-24 md:top-28">
                    <!-- Cover Image -->
                    <div class="relative overflow-hidden rounded-2xl bg-slate-800 border border-slate-700 shadow-2xl">
                        <div class="aspect-[3/4]">
                    @if($manga->cover_image)
                        <img src="{{ asset('storage/' . $manga->cover_image) }}" 
                             alt="{{ $manga->title }}" 
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'300\' height=\'400\'%3E%3Crect fill=\'%231e293b\' width=\'300\' height=\'400\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%2394a3b8\' font-family=\'Arial\' font-size=\'24\' font-weight=\'bold\'%3E{{ urlencode($manga->title) }}%3C/text%3E%3C/svg%3E'">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-slate-700 to-slate-800 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-32 h-32 text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <p class="text-slate-500 text-sm">{{ $manga->title }}</p>
                            </div>
                        </div>
                    @endif
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 space-y-3">
                        @php
                            $firstChapter = $chapters->flatten()->sortBy('chapter_number')->first();
                        @endphp
                        @if($firstChapter)
                        <a href="{{ route('chapters.read', [$manga->slug, $firstChapter->id]) }}" class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-xl text-white font-semibold transition-all duration-200 transform hover:scale-105 hover:shadow-lg hover:shadow-indigo-500/25 flex items-center justify-center group">
                            <svg class="w-5 h-5 mr-2 transform group-hover:rotate-12 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Read Now
                        </a>
                        @else
                        <button disabled class="w-full px-6 py-3 bg-slate-700 rounded-xl text-slate-400 font-semibold cursor-not-allowed flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            No Chapters Available
                        </button>
                        @endif
                        @auth
                        <form action="{{ route('mangas.favorite.toggle', $manga->slug) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" id="favoriteBtn" class="w-full px-6 py-3 {{ $isFavorited ? 'bg-indigo-600 hover:bg-indigo-500 border-indigo-500' : 'bg-slate-800 hover:bg-slate-700 border-slate-700 hover:border-indigo-500/50' }} border rounded-xl text-white font-semibold transition-all duration-200 flex items-center justify-center group">
                                <svg class="w-5 h-5 mr-2 group-hover:text-white transition-colors duration-200 {{ $isFavorited ? 'fill-current' : '' }}" fill="{{ $isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                                <span id="favoriteText">{{ $isFavorited ? 'Remove from Favorites' : 'Add to Favorites' }}</span>
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="w-full px-6 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 hover:border-indigo-500/50 rounded-xl text-white font-semibold transition-all duration-200 flex items-center justify-center group">
                            <svg class="w-5 h-5 mr-2 group-hover:text-indigo-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                            </svg>
                            Login to Add Favorites
                        </a>
                        @endauth
                        <button onclick="shareManga()" class="w-full px-6 py-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 hover:border-indigo-500/50 rounded-xl text-white font-semibold transition-all duration-200 flex items-center justify-center group">
                            <svg class="w-5 h-5 mr-2 group-hover:text-indigo-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            Share
                        </button>
                    </div>

                    <!-- Stats -->
                    <div class="mt-6 p-4 bg-slate-800/50 border border-slate-700 rounded-xl">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-sm">Rating</span>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-yellow-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-white font-semibold">4.8</span>
                                    <span class="text-slate-400 text-sm ml-1">(234)</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-sm">Views</span>
                                <span class="text-white font-semibold">12.5K</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-400 text-sm">Bookmarks</span>
                                <span class="text-white font-semibold">3.2K</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Info -->
            <div class="md:col-span-2 space-y-6">
                <!-- Title and Basic Info -->
                <div>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">{{ $manga->title }}</h1>
                    
                    <!-- Meta Info -->
                    <div class="flex flex-wrap gap-3 mb-6">
                        @if($manga->release_date)
                        <div class="flex items-center px-3 py-2 bg-slate-800 rounded-lg border border-slate-700 hover:border-indigo-500/50 transition-colors duration-200">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-white text-xs md:text-sm font-medium">{{ \Carbon\Carbon::parse($manga->release_date)->format('Y') }}</span>
                        </div>
                        @endif
                        <div class="flex items-center px-3 py-2 bg-slate-800 rounded-lg border border-slate-700 hover:border-indigo-500/50 transition-colors duration-200">
                            <svg class="w-4 h-4 md:w-5 md:h-5 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span class="text-white text-xs md:text-sm font-medium">Status: Ongoing</span>
                        </div>
                    </div>

                    <!-- Genre Tags -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="px-3 py-1 bg-indigo-500/20 text-indigo-400 rounded-full text-xs md:text-sm font-medium hover:bg-indigo-500/30 transition-colors duration-200 cursor-default">Action</span>
                        <span class="px-3 py-1 bg-rose-500/20 text-rose-400 rounded-full text-xs md:text-sm font-medium hover:bg-rose-500/30 transition-colors duration-200 cursor-default">Adventure</span>
                        <span class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-xs md:text-sm font-medium hover:bg-purple-500/30 transition-colors duration-200 cursor-default">Fantasy</span>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 hover:border-indigo-500/30 transition-colors duration-200">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Synopsis
                    </h2>
                    @if($manga->description)
                    <div class="prose prose-invert prose-slate max-w-none">
                        <p class="text-slate-300 leading-relaxed text-base">
                            {!! nl2br(e($manga->description)) !!}
                        </p>
                    </div>
                    @else
                    <p class="text-slate-400 italic">No description available.</p>
                    @endif
                </div>

                <!-- Chapters Section -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 hover:border-indigo-500/30 transition-colors duration-200">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center justify-between">
                        <span class="flex items-center">
                            <svg class="w-6 h-6 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            Chapters
                        </span>
                        @if($chapters->isNotEmpty())
                        <span class="text-sm text-slate-400 font-normal">{{ $chapters->flatten()->count() }} chapters available</span>
                        @endif
                    </h2>

                    @if($chapters->isNotEmpty())
                    <!-- Language Tabs -->
                    <div class="flex gap-2 mb-4 flex-wrap">
                        @foreach($chapters as $language => $languageChapters)
                        <button onclick="showLanguage('{{ $language }}')" 
                                class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 language-tab {{ $loop->first ? 'active' : '' }}"
                                data-language="{{ $language }}">
                            {{ $language }}
                            <span class="ml-2 px-2 py-0.5 bg-slate-700 rounded text-xs">{{ $languageChapters->count() }}</span>
                        </button>
                        @endforeach
                    </div>

                    <!-- Chapter Lists by Language -->
                    @foreach($chapters as $language => $languageChapters)
                    <div class="language-chapters {{ $loop->first ? '' : 'hidden' }}" data-language="{{ $language }}">
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            @foreach($languageChapters as $chapter)
                            <a href="{{ route('chapters.read', [$manga->slug, $chapter->id]) }}" 
                               class="block p-4 bg-slate-800 hover:bg-slate-700 border border-slate-700 hover:border-indigo-500/50 rounded-lg transition-all duration-200 group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-slate-700 rounded-lg flex items-center justify-center text-slate-400 font-bold group-hover:bg-indigo-500 group-hover:text-white transition-all duration-200">
                                            {{ $chapter->chapter_number }}
                                        </div>
                                        <div>
                                            <h3 class="text-white font-medium group-hover:text-indigo-400 transition-colors duration-200">
                                                @if($chapter->title)
                                                    Chapter {{ $chapter->chapter_number }}: {{ $chapter->title }}
                                                @else
                                                    Chapter {{ $chapter->chapter_number }}
                                                @endif
                                            </h3>
                                            <div class="flex items-center gap-3 mt-1">
                                                <span class="text-xs px-2 py-0.5 bg-indigo-500/20 text-indigo-400 rounded">{{ $chapter->language }}</span>
                                                <span class="text-xs text-slate-400">{{ $chapter->page_count }} pages</span>
                                                @if($chapter->views > 0)
                                                <span class="text-xs text-slate-500">{{ number_format($chapter->views) }} views</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-500 group-hover:text-indigo-400 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-12 border-2 border-dashed border-slate-700 rounded-lg">
                        <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <p class="text-slate-400 mb-2">No chapters available yet</p>
                        <p class="text-sm text-slate-500">Chapters will be added soon!</p>
                    </div>
                    @endif
                </div>

                <script>
                function showLanguage(language) {
                    // Hide all language chapters
                    document.querySelectorAll('.language-chapters').forEach(el => {
                        el.classList.add('hidden');
                    });
                    
                    // Remove active class from all tabs
                    document.querySelectorAll('.language-tab').forEach(el => {
                        el.classList.remove('active');
                    });
                    
                    // Show selected language chapters
                    document.querySelector(`.language-chapters[data-language="${language}"]`).classList.remove('hidden');
                    
                    // Add active class to clicked tab
                    document.querySelector(`.language-tab[data-language="${language}"]`).classList.add('active');
                }
                
                // Share manga functionality
                function shareManga() {
                    const url = window.location.href;
                    const title = '{{ $manga->title }}';
                    const text = `Check out this manga: ${title}`;
                    
                    if (navigator.share) {
                        navigator.share({
                            title: title,
                            text: text,
                            url: url
                        }).catch(err => console.log('Error sharing', err));
                    } else {
                        // Fallback: copy to clipboard
                        navigator.clipboard.writeText(url).then(() => {
                            alert('Link copied to clipboard!');
                        }).catch(() => {
                            // Fallback for older browsers
                            const textarea = document.createElement('textarea');
                            textarea.value = url;
                            document.body.appendChild(textarea);
                            textarea.select();
                            document.execCommand('copy');
                            document.body.removeChild(textarea);
                            alert('Link copied to clipboard!');
                        });
                    }
                }
                
                // Handle favorite form submission with AJAX
                @auth
                document.addEventListener('DOMContentLoaded', function() {
                    const favoriteForm = document.querySelector('form[action*="favorite"]');
                    if (favoriteForm) {
                        favoriteForm.addEventListener('submit', function(e) {
                            e.preventDefault();
                            
                            const formData = new FormData(this);
                            const button = this.querySelector('button[type="submit"]');
                            const buttonText = document.getElementById('favoriteText');
                            const svg = button.querySelector('svg');
                            
                            fetch(this.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Update button appearance
                                    if (data.is_favorited) {
                                        button.classList.remove('bg-slate-800', 'border-slate-700');
                                        button.classList.add('bg-indigo-600', 'border-indigo-500');
                                        svg.classList.add('fill-current');
                                        buttonText.textContent = 'Remove from Favorites';
                                    } else {
                                        button.classList.remove('bg-indigo-600', 'border-indigo-500');
                                        button.classList.add('bg-slate-800', 'border-slate-700');
                                        svg.classList.remove('fill-current');
                                        buttonText.textContent = 'Add to Favorites';
                                    }
                                    
                                    // Show success message
                                    const message = document.createElement('div');
                                    message.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                                    message.textContent = data.message;
                                    document.body.appendChild(message);
                                    setTimeout(() => message.remove(), 3000);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred. Please try again.');
                            });
                        });
                    }
                });
                @endauth
                </script>
                
                <style>
                .language-tab {
                    @apply bg-slate-700 text-slate-300 hover:bg-slate-600;
                }
                .language-tab.active {
                    @apply bg-indigo-600 text-white;
                }
                </style>

                <!-- Comments Section Placeholder -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                    <h2 class="text-xl font-bold text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Comments
                    </h2>
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-slate-400 mb-4">Be the first to comment on this manga!</p>
                        @auth
                        <a href="{{ route('news.public.index') }}" class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-white font-medium transition-colors duration-200">
                            View News Comments
                        </a>
                        @else
                        <a href="{{ route('login') }}" class="inline-block px-6 py-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white font-medium transition-colors duration-200">
                            Login to Comment
                        </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
