@extends('layouts.app')

@section('title', 'FAQ Item Details')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.faq-items.index') }}" class="text-purple-400 hover:text-purple-300 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to FAQ Items
            </a>
        </div>

        <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 border border-gray-700/50">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-white mb-2">{{ $faqItem->question }}</h1>
                <p class="text-gray-400">Category: <span class="text-purple-400">{{ $faqItem->faqCategory->name }}</span></p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-white mb-3">Answer</h3>
                <p class="text-gray-300 whitespace-pre-wrap leading-relaxed">{{ $faqItem->answer }}</p>
            </div>

            <div class="mt-6 flex gap-4 pt-6 border-t border-gray-700">
                <a href="{{ route('admin.faq-items.edit', $faqItem) }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-500 text-white font-semibold rounded-lg transition-all">
                    Edit
                </a>
                <form action="{{ route('admin.faq-items.destroy', $faqItem) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg transition-all" onclick="return confirm('Delete this FAQ item?')">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
