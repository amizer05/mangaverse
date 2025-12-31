@extends('layouts.public')

@section('title', $news->title)

@section('content')
<div class="bg-gradient-to-b from-slate-900 to-slate-950 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('news.public.index') }}" class="inline-flex items-center text-slate-400 hover:text-white transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to News
            </a>
        </div>

        <!-- Article -->
        <article class="bg-slate-800/50 border border-slate-700 rounded-2xl overflow-hidden">
            <!-- Hero Image -->
            @if($news->image)
            <div class="relative aspect-video overflow-hidden">
                <img src="{{ asset('storage/' . $news->image) }}" 
                     alt="{{ $news->title }}" 
                     class="w-full h-full object-cover"
                     onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full bg-gradient-to-br from-indigo-600/20 via-purple-600/20 to-rose-600/20 flex items-center justify-center\'><div class=\'text-center\'><svg class=\'w-24 h-24 text-indigo-400/50 mx-auto mb-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z\'/></svg><p class=\'text-sm text-indigo-300/70 font-semibold uppercase tracking-wider\'>News Article</p></div></div>'">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
            </div>
            @else
            <div class="relative aspect-video bg-gradient-to-br from-indigo-600/20 via-purple-600/20 to-rose-600/20 border-b-2 border-indigo-500/30 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-24 h-24 text-indigo-400/50 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    <p class="text-sm text-indigo-300/70 font-semibold uppercase tracking-wider">News Article</p>
                </div>
            </div>
            @endif

            <!-- Content -->
            <div class="p-8 md:p-12">
                <!-- Meta Info -->
                <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-slate-700">
                    <div class="flex items-center text-indigo-400">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm font-medium">
                            {{ $news->published_at ? $news->published_at->format('F d, Y') : 'Draft' }}
                        </span>
                    </div>
                    @if($news->published_at)
                    <div class="flex items-center text-slate-400">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm">{{ $news->published_at->diffForHumans() }}</span>
                    </div>
                    @endif
                    <div class="flex items-center text-slate-400">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <span class="text-sm">1.2K views</span>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
                    {{ $news->title }}
                </h1>

                <!-- Article Content -->
                <div class="prose prose-lg prose-invert prose-slate max-w-none">
                    <div class="text-slate-300 leading-relaxed space-y-4">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                </div>

                <!-- Share Section -->
                <div class="mt-12 pt-8 border-t border-slate-700">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">Share this article</h3>
                            <p class="text-slate-400 text-sm">Help spread the word about this news</p>
                        </div>
                        <div class="flex gap-3">
                            <button onclick="shareOnTwitter()" class="p-3 bg-slate-700 hover:bg-blue-600 rounded-lg text-white transition-colors duration-200" title="Share on Twitter">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </button>
                            <button onclick="shareOnFacebook()" class="p-3 bg-slate-700 hover:bg-blue-800 rounded-lg text-white transition-colors duration-200" title="Share on Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </button>
                            <button onclick="shareOnWhatsApp()" class="p-3 bg-slate-700 hover:bg-green-600 rounded-lg text-white transition-colors duration-200" title="Share on WhatsApp">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </button>
                            <button onclick="copyLink()" class="p-3 bg-slate-700 hover:bg-slate-600 rounded-lg text-white transition-colors duration-200" title="Copy Link">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <!-- Related News -->
        @if(isset($relatedNews) && $relatedNews->count() > 0)
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-white mb-8">Related News</h2>
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($relatedNews as $related)
                <a href="{{ route('news.public.show', $related->id) }}" class="group bg-slate-800 border border-slate-700 rounded-xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300">
                    @if($related->image)
                    <div class="aspect-video overflow-hidden">
                        <img src="{{ asset('storage/' . $related->image) }}" 
                             alt="{{ $related->title }}" 
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    </div>
                    @endif
                    <div class="p-4">
                        <div class="text-xs text-indigo-400 mb-2">
                            {{ $related->published_at->format('M d, Y') }}
                        </div>
                        <h3 class="font-semibold text-white line-clamp-2 group-hover:text-indigo-400 transition-colors duration-200">
                            {{ $related->title }}
                        </h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Comments Section -->
        <div class="mt-16 bg-slate-800/50 border border-slate-700 rounded-2xl p-8">
            <h2 class="text-2xl font-bold text-white mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Comments ({{ $comments->total() }})
            </h2>

            @auth
            <!-- Comment Form -->
            <form method="POST" action="{{ route('news.comments.store', $news) }}" class="mb-8">
                @csrf
                <div class="mb-4">
                    <textarea name="content" rows="3" required
                              class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-3 text-white placeholder-slate-500 focus:border-indigo-500 focus:outline-none transition resize-none"
                              placeholder="Write your comment..."></textarea>
                    @error('content')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-lg text-white font-semibold transition-all">
                    Post Comment
                </button>
            </form>
            @else
            <div class="mb-8 p-4 bg-slate-900/50 rounded-lg text-center">
                <p class="text-slate-400 mb-3">Please <a href="{{ route('login') }}" class="text-indigo-400 hover:text-indigo-300">login</a> to leave a comment</p>
            </div>
            @endauth

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Comments List -->
            <div class="space-y-6">
                @forelse($comments as $comment)
                <div class="bg-slate-900/50 rounded-lg p-4 border border-slate-700">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-indigo-500 to-rose-500 flex items-center justify-center">
                                <span class="text-white font-bold">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-white">{{ $comment->user->name }}</p>
                                <p class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->isAdmin()))
                        <form action="{{ route('news.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Delete this comment?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-300 text-sm">
                                Delete
                            </button>
                        </form>
                        @endif
                    </div>
                    <p class="text-slate-300 whitespace-pre-wrap">{{ $comment->content }}</p>
                </div>
                @empty
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <p class="text-slate-400">No comments yet. Be the first to comment!</p>
                </div>
                @endforelse
            </div>

            @if($comments->hasPages())
            <div class="mt-6">
                {{ $comments->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
// Share functions for news article
function shareOnTwitter() {
    const url = window.location.href;
    const title = '{{ $news->title }}';
    const text = encodeURIComponent(`${title} - ${url}`);
    window.open(`https://twitter.com/intent/tweet?text=${text}`, '_blank', 'width=600,height=400');
}

function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

function shareOnWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent('{{ $news->title }}');
    window.open(`https://wa.me/?text=${text}%20${url}`, '_blank');
}

function copyLink() {
    const url = window.location.href;
    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(() => {
            showMessage('Link copied to clipboard!');
        }).catch(() => {
            fallbackCopy(url);
        });
    } else {
        fallbackCopy(url);
    }
}

function fallbackCopy(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);
    textarea.select();
    try {
        document.execCommand('copy');
        showMessage('Link copied to clipboard!');
    } catch (err) {
        showMessage('Failed to copy link', 'error');
    }
    document.body.removeChild(textarea);
}

function showMessage(message, type = 'success') {
    const messageDiv = document.createElement('div');
    messageDiv.className = `fixed top-4 right-4 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white px-6 py-3 rounded-lg shadow-lg z-50`;
    messageDiv.textContent = message;
    document.body.appendChild(messageDiv);
    setTimeout(() => messageDiv.remove(), 3000);
}
</script>
@endsection






