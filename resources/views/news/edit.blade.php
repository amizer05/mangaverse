@extends('layouts.app')

@section('title', 'Edit News')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
                Edit News Article
            </h1>
            <p class="text-gray-400">Update news article information</p>
        </div>

        <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 border border-gray-700/50">
            <form method="POST" action="{{ route('admin.news.update', $news) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-300 mb-2">Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" required
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors @error('title') border-red-500 @enderror"
                               placeholder="Enter news title">
                        @error('title')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-semibold text-gray-300 mb-2">Cover Image</label>
                        @if($news->image)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $news->image) }}" 
                                 alt="{{ $news->title }}" 
                                 class="max-w-xs rounded-lg shadow-lg mb-2"
                                 onerror="this.style.display='none'">
                            <p class="text-xs text-gray-400">Current image</p>
                        </div>
                        @endif
                        <input type="file" id="image" name="image" accept="image/jpeg,image/jpg,image/png,image/webp"
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-500 transition-colors @error('image') border-red-500 @enderror">
                        <p class="mt-2 text-xs text-gray-400">Upload a new image to replace the current one. Supported formats: JPEG, PNG, WebP (Max 5MB)</p>
                        @error('image')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="image_url" class="block text-sm font-semibold text-gray-300 mb-2">Or Image URL</label>
                        <input type="url" id="image_url" name="image_url" value="{{ old('image_url') }}"
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors @error('image_url') border-red-500 @enderror"
                               placeholder="https://example.com/image.jpg">
                        <p class="mt-2 text-xs text-gray-400">Alternative: Provide an image URL to download</p>
                        @error('image_url')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="p-4 bg-purple-500/10 border border-purple-500/30 rounded-lg">
                        <label for="manga_cover" class="block text-sm font-semibold text-gray-300 mb-2">Or Use Manga Cover</label>
                        <select id="manga_cover" name="manga_cover"
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors">
                            <option value="">-- Select a manga cover --</option>
                            @foreach(\App\Models\Manga::whereNotNull('cover_image')->where('cover_image', '!=', '')->orderBy('title')->get() as $manga)
                                <option value="{{ $manga->id }}">{{ $manga->title }}</option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-xs text-gray-400">Select a manga to use its cover image for this news item</p>
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-semibold text-gray-300 mb-2">Content *</label>
                        <textarea id="content" name="content" rows="10" required
                                  class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors resize-none @error('content') border-red-500 @enderror"
                                  placeholder="Enter news content">{{ old('content', $news->content) }}</textarea>
                        @error('content')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="published_at" class="block text-sm font-semibold text-gray-300 mb-2">Published At</label>
                        <input type="date" id="published_at" name="published_at" value="{{ old('published_at', $news->published_at) }}"
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors @error('published_at') border-red-500 @enderror">
                        <p class="mt-2 text-xs text-gray-400">Leave empty to publish immediately</p>
                        @error('published_at')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4 pt-4">
                        <a href="{{ route('admin.news.index') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-semibold rounded-lg transition-all">
                            Update News Article
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
