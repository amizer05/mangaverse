@extends('layouts.app')

@section('title', 'News Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.news.index') }}" class="text-purple-400 hover:text-purple-300 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to News
            </a>
        </div>

        <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 border border-gray-700/50">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-white mb-2">{{ $news->title }}</h1>
                @if($news->published_at)
                    <p class="text-gray-400">Published: {{ \Carbon\Carbon::parse($news->published_at)->format('F j, Y') }}</p>
                @else
                    <p class="text-gray-400">Not published yet</p>
                @endif
            </div>

            @if($news->image)
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="max-w-xs rounded-lg shadow-lg" onerror="this.style.display='none'">
                </div>
            @endif

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-white mb-3">Content</h3>
                <div class="text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $news->content }}</div>
            </div>

            <div class="mt-6 flex gap-4 pt-6 border-t border-gray-700">
                <a href="{{ route('admin.news.edit', $news) }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-lg transition-all">
                    Edit
                </a>
                <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg transition-all" onclick="return confirm('Delete this news item?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
