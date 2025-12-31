<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MangaVerse') }} - FAQ Request Details</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-slate-900 to-gray-900 text-white p-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('admin.faq-requests.index') }}" class="text-purple-400 hover:text-purple-300 mb-4 inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to FAQ Requests
            </a>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
                FAQ Request Details
            </h1>
        </div>

        <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 border border-gray-700/50 mb-6">
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-400">Question</label>
                    <p class="text-white text-lg font-semibold mt-1">{{ $faqRequest->question }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-400">Submitted By</label>
                    <p class="text-white mt-1">{{ $faqRequest->name }} ({{ $faqRequest->email }})</p>
                </div>
                <div>
                    <label class="text-sm text-gray-400">Status</label>
                    <p class="mt-1">
                        @if($faqRequest->status === 'pending')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400">
                                Pending
                            </span>
                        @elseif($faqRequest->status === 'approved')
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400">
                                Approved
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400">
                                Rejected
                            </span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="text-sm text-gray-400">Submitted</label>
                    <p class="text-white mt-1">{{ $faqRequest->created_at->format('F j, Y g:i A') }}</p>
                </div>
                @if($faqRequest->reviewed_at)
                <div>
                    <label class="text-sm text-gray-400">Reviewed</label>
                    <p class="text-white mt-1">{{ $faqRequest->reviewed_at->format('F j, Y g:i A') }} by {{ $faqRequest->reviewer->name ?? 'Admin' }}</p>
                </div>
                @endif
            </div>
        </div>

        @if($faqRequest->status === 'pending')
        <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 border border-gray-700/50">
            <h2 class="text-2xl font-bold mb-6">Approve & Add to FAQ</h2>
            <form method="POST" action="{{ route('admin.faq-requests.approve', $faqRequest) }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Category *</label>
                        <select name="faq_category_id" required
                                class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('faq_category_id')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Answer *</label>
                        <textarea name="answer" rows="5" required
                                  class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors resize-none"
                                  placeholder="Write the answer to this question..."></textarea>
                        @error('answer')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex gap-3">
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg font-semibold hover:from-purple-500 hover:to-pink-500 transition-all">
                            Approve & Add to FAQ
                        </button>
                        <form action="{{ route('admin.faq-requests.reject', $faqRequest) }}" method="POST" onsubmit="return confirm('Reject this FAQ request?')">
                            @csrf
                            <button type="submit" class="px-6 py-3 bg-red-600/20 text-red-400 rounded-lg hover:bg-red-600/30 transition-all font-semibold">
                                Reject
                            </button>
                        </form>
                    </div>
                </div>
            </form>
        </div>
        @endif
    </div>
</div>
</body>
</html>






