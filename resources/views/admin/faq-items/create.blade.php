@extends('layouts.app')

@section('title', 'Create FAQ Item')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
                Create FAQ Item
            </h1>
            <p class="text-gray-400">Add a new FAQ question and answer</p>
        </div>

        <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 border border-gray-700/50">
            <form method="POST" action="{{ route('admin.faq-items.store') }}">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="faq_category_id" class="block text-sm font-semibold text-gray-300 mb-2">Category *</label>
                        <select id="faq_category_id" name="faq_category_id" required
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors @error('faq_category_id') border-red-500 @enderror">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('faq_category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('faq_category_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="question" class="block text-sm font-semibold text-gray-300 mb-2">Question *</label>
                        <input type="text" id="question" name="question" value="{{ old('question') }}" required
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors @error('question') border-red-500 @enderror"
                               placeholder="Enter the question">
                        @error('question')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="answer" class="block text-sm font-semibold text-gray-300 mb-2">Answer *</label>
                        <textarea id="answer" name="answer" rows="6" required
                                  class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors resize-none @error('answer') border-red-500 @enderror"
                                  placeholder="Enter the answer">{{ old('answer') }}</textarea>
                        @error('answer')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4 pt-4">
                        <a href="{{ route('admin.faq-items.index') }}" class="px-6 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-500 hover:to-pink-500 text-white font-semibold rounded-lg transition-all">
                            Save FAQ Item
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
