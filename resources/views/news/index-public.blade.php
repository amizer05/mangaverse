@extends('layouts.public')

@section('title', 'Latest News')

@section('content')
<div class="bg-gradient-to-b from-slate-900 to-slate-950 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-12 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Latest News</h1>
            <p class="text-lg text-slate-400 max-w-2xl mx-auto">
                Stay up to date with the latest manga releases, industry news, and community updates
            </p>
        </div>

        @if($news->count() > 0)
        <!-- Featured News (First Item) -->
        @if($news->first())
        <div class="mb-12">
            <a href="{{ route('news.public.show', $news->first()->id) }}" class="group block bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300 transform hover:shadow-2xl hover:shadow-indigo-500/10">
                <div class="grid md:grid-cols-2 gap-0">
                    <!-- Image -->
                    @if($news->first()->image)
                    <div class="relative h-64 md:h-auto overflow-hidden">
                        <img src="{{ asset('storage/' . $news->first()->image) }}" 
                             alt="{{ $news->first()->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                             loading="lazy">
                        <div class="absolute top-4 left-4 px-3 py-1 bg-gradient-to-r from-indigo-500 to-rose-500 rounded-full text-xs font-bold text-white shadow-lg">
                            FEATURED
                        </div>
                    </div>
                    @endif
                    <!-- Content -->
                    <div class="p-8 md:p-12 flex flex-col justify-center">
                        <div class="flex items-center text-sm text-indigo-400 mb-4">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $news->first()->published_at ? $news->first()->published_at->format('F d, Y') : 'Draft' }}
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 group-hover:text-indigo-400 transition-colors duration-200">
                            {{ $news->first()->title }}
                        </h2>
                        <p class="text-slate-300 text-lg mb-6 line-clamp-3">
                            {{ Str::limit(strip_tags($news->first()->content), 200) }}
                        </p>
                        <div class="inline-flex items-center text-indigo-400 font-semibold group-hover:text-indigo-300">
                            Read Full Article
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif

        <!-- News Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($news->skip(1) as $newsItem)
            <article class="group bg-slate-800 border border-slate-700 rounded-xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl hover:shadow-indigo-500/10">
                <!-- Image -->
                @if($newsItem->image)
                <a href="{{ route('news.public.show', $newsItem->id) }}" class="block relative aspect-video overflow-hidden">
                    <img src="{{ asset('storage/' . $newsItem->image) }}" 
                         alt="{{ $newsItem->title }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                         loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                </a>
                @else
                <a href="{{ route('news.public.show', $newsItem->id) }}" class="block relative aspect-video bg-gradient-to-br from-indigo-600/20 via-purple-600/20 to-rose-600/20 border-b-2 border-indigo-500/30">
                    <div class="absolute inset-0 flex flex-col items-center justify-center p-4">
                        <svg class="w-20 h-20 text-indigo-400/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <p class="text-xs text-indigo-300/70 font-semibold uppercase tracking-wider">News Article</p>
                    </div>
                </a>
                @endif
                <!-- Content -->
                <div class="p-6">
                    <!-- Date -->
                    <div class="flex items-center text-xs text-indigo-400 mb-3">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ $newsItem->published_at ? $newsItem->published_at->format('M d, Y') : 'Draft' }}
                    </div>
                    <!-- Title -->
                    <a href="{{ route('news.public.show', $newsItem->id) }}">
                        <h3 class="text-xl font-bold text-white mb-3 line-clamp-2 group-hover:text-indigo-400 transition-colors duration-200">
                            {{ $newsItem->title }}
                        </h3>
                    </a>
                    <!-- Excerpt -->
                    <p class="text-slate-400 text-sm line-clamp-3 mb-4">
                        {{ Str::limit(strip_tags($newsItem->content), 120) }}
                    </p>
                    <!-- Read More Link -->
                    <a href="{{ route('news.public.show', $newsItem->id) }}" class="inline-flex items-center text-sm text-indigo-400 font-medium group-hover:text-indigo-300">
                        Read More
                        <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($news->hasPages())
        <div class="flex justify-center">
            {{ $news->links('pagination::tailwind') }}
        </div>
        @endif
        @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <svg class="w-24 h-24 text-slate-700 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
            <h3 class="text-2xl font-bold text-white mb-2">No news yet</h3>
            <p class="text-slate-400">Check back soon for the latest updates!</p>
        </div>
        @endif
    </div>
</div>

<!-- Newsletter Section -->
<div class="bg-slate-900 border-t border-slate-800 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Never Miss an Update</h2>
        <p class="text-slate-400 mb-8">
            Subscribe to our newsletter and get the latest manga news delivered to your inbox.
        </p>

        @if(session('status') === 'newsletter-subscribed')
            <p class="mb-4 text-sm text-emerald-400">
                Thanks for subscribing! You are now on our newsletter list.
            </p>
        @endif

        <form method="POST" action="{{ route('newsletter.subscribe') }}" class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
            @csrf
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                   placeholder="Enter your email" 
                class="flex-1 px-6 py-4 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-rose-500 focus:ring-rose-500 @enderror">
            <button type="submit" class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-xl text-white font-semibold transition-all duration-200 transform hover:scale-105">
                Subscribe
            </button>
        </form>

        @error('email')
            <p class="mt-3 text-sm text-rose-400">{{ $message }}</p>
        @enderror
    </div>
</div>
@endsection






