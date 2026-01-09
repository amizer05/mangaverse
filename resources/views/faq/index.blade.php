@extends('layouts.public')

@section('title', 'Frequently Asked Questions')

@section('content')
<div class="bg-gradient-to-b from-slate-900 to-slate-950 py-12" x-data="faqPage()">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Frequently Asked Questions</h1>
            <p class="text-lg text-slate-400">
                Find answers to common questions about MangaVerse
            </p>
        </div>

        <!-- Search Box -->
        <div class="mb-12">
            <form method="GET" action="{{ route('faq.index') }}" class="relative max-w-2xl mx-auto" 
                  @submit.prevent="handleSearch()"
                  x-data="{ focused: false }">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" 
                       name="q"
                       x-model="searchQuery"
                       value="{{ $query ?? '' }}"
                       placeholder="Search for answers... (Press Enter to search)" 
                       @focus="focused = true"
                       @blur="focused = false"
                       @input="filterFAQs()"
                       @keydown.enter.prevent="handleSearch()"
                       @keydown.escape="clearSearch()"
                       class="w-full pl-12 pr-12 py-4 bg-slate-800 border border-slate-700 rounded-xl text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                       autocomplete="off"
                       aria-label="Search FAQ questions and answers">
                @if($query ?? null)
                <button type="button"
                        @click="clearSearch()"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-white transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded"
                        aria-label="Clear search">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                @endif
                <div x-show="focused" 
                     x-transition
                     class="absolute top-full left-0 right-0 mt-2 bg-slate-800 border border-slate-700 rounded-lg p-2 text-xs text-slate-400 z-10"
                     style="display: none;"
                     x-cloak>
                    <kbd class="px-2 py-1 bg-slate-700 rounded">Enter</kbd> to search, <kbd class="px-2 py-1 bg-slate-700 rounded">Esc</kbd> to clear
                </div>
            </form>
            <div x-show="searchQuery && searchResults.length === 0" 
                 x-transition
                 class="text-center mt-4"
                 style="display: none;"
                 x-cloak>
                <p class="text-slate-400">
                    No results found for "<span class="text-white font-semibold" x-text="searchQuery"></span>"
                </p>
            </div>
            @if($query ?? null)
            <div class="text-center mt-4">
                <p class="text-slate-400">
                    Found <span class="text-indigo-400 font-semibold">{{ $categories->sum(fn($c) => $c->faqItems->count()) }}</span> result(s) for "<span class="text-white font-semibold">{{ $query }}</span>"
                </p>
            </div>
            @endif
        </div>

        @if($categories->count() > 0)
        <!-- Category Filter Tabs -->
        @if(!($query ?? null))
        <div class="mb-8 flex flex-wrap gap-3 justify-center">
            <button @click="activeCategory = null; filterByCategory(null)"
                    :class="activeCategory === null ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'"
                    class="px-4 py-2 rounded-lg font-semibold transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    :aria-pressed="activeCategory === null ? 'true' : 'false'"
                    aria-label="Show all categories">
                All Categories
            </button>
            @foreach($categories as $catIndex => $cat)
            <button @click="activeCategory = {{ $catIndex }}; filterByCategory({{ $catIndex }})"
                    :class="activeCategory === {{ $catIndex }} ? 'bg-indigo-600 text-white' : 'bg-slate-800 text-slate-300 hover:bg-slate-700'"
                    class="px-4 py-2 rounded-lg font-semibold transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    :aria-pressed="activeCategory === {{ $catIndex }} ? 'true' : 'false'"
                    aria-label="Filter by {{ $cat->name }}">
                {{ $cat->name }} ({{ $cat->faqItems->count() }})
            </button>
            @endforeach
        </div>
        @endif

        <!-- FAQ Categories -->
        <div class="space-y-8">
            @foreach($categories as $catIndex => $category)
            <div class="faq-category bg-slate-800/50 border border-slate-700 rounded-xl overflow-hidden hover:border-indigo-500/50 transition-all duration-300"
                 x-show="activeCategory === null || activeCategory === {{ $catIndex }}"
                 x-transition>
                <!-- Category Header -->
                <div class="bg-gradient-to-r from-slate-800 to-slate-900 border-b border-slate-700 p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-white flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-lg flex items-center justify-center mr-4 shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div>{{ $category->name }}</div>
                                @if($category->description)
                                <p class="text-sm text-slate-400 font-normal mt-1">{{ $category->description }}</p>
                                @endif
                            </div>
                        </h2>
                        <div class="text-slate-400 text-sm font-semibold">
                            {{ $category->faqItems->count() }} {{ Str::plural('question', $category->faqItems->count()) }}
                        </div>
                    </div>
                </div>

                <!-- FAQ Items -->
                @if($category->faqItems->count() > 0)
                <div class="divide-y divide-slate-700">
                    @foreach($category->faqItems as $index => $item)
                    @php
                        $itemId = 'faq-' . $category->id . '-' . $item->id;
                    @endphp
                    <div class="faq-item hover:bg-slate-800/30 transition-colors duration-200"
                         x-data="{ 
                             isOpen: false,
                             toggle() {
                                 this.isOpen = !this.isOpen;
                             }
                         }"
                         x-show="shouldShowItem('{{ strtolower($item->question) }}', '{{ strtolower($item->answer) }}')"
                         x-transition>
                        <!-- Question -->
                        <button @click="toggle()"
                                @keydown.enter.prevent="toggle()"
                                @keydown.space.prevent="toggle()"
                                :aria-expanded="isOpen"
                                :aria-controls="'{{ $itemId }}-answer'"
                                :id="'{{ $itemId }}-button'"
                                class="w-full px-6 py-5 text-left flex items-center justify-between group focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-inset rounded"
                                type="button">
                            <div class="flex items-start gap-4 flex-1">
                                <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="font-semibold text-white group-hover:text-indigo-400 transition-colors duration-200 text-lg">
                                    {{ $item->question }}
                                </span>
                            </div>
                            <svg class="w-6 h-6 text-slate-400 group-hover:text-indigo-400 flex-shrink-0 transition-all duration-300 ml-4"
                                 :class="isOpen ? 'rotate-180 text-indigo-400' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <!-- Answer -->
                        <div x-show="isOpen"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 max-h-0"
                             x-transition:enter-end="opacity-100 max-h-96"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 max-h-96"
                             x-transition:leave-end="opacity-0 max-h-0"
                             :id="'{{ $itemId }}-answer'"
                             :aria-labelledby="'{{ $itemId }}-button'"
                             role="region"
                             class="overflow-hidden"
                             style="display: none;">
                            <div class="px-6 pb-6 pl-18">
                                <div class="flex items-start gap-4">
                                    <div class="w-8 h-8 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div class="text-slate-300 leading-relaxed text-base flex-1 prose prose-invert max-w-none">
                                        {!! nl2br(e($item->answer)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="p-6 text-center text-slate-400">
                    No questions in this category yet.
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-20">
            <svg class="w-24 h-24 text-slate-700 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-2xl font-bold text-white mb-2">No FAQ available</h3>
            <p class="text-slate-400">Check back soon for frequently asked questions.</p>
        </div>
        @endif

        <!-- Quick Stats -->
        @if(!($query ?? null))
        <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-indigo-400 mb-2">{{ $categories->count() }}</div>
                <div class="text-slate-400 text-sm">Categories</div>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-rose-400 mb-2">{{ $categories->sum(fn($c) => $c->faqItems->count()) }}</div>
                <div class="text-slate-400 text-sm">Questions Answered</div>
            </div>
            <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6 text-center">
                <div class="text-3xl font-bold text-purple-400 mb-2">24/7</div>
                <div class="text-slate-400 text-sm">Support Available</div>
            </div>
        </div>
        @endif

        <!-- Submit Question Form -->
        <div class="mt-16 bg-gradient-to-br from-slate-800/50 to-slate-900/50 border border-slate-700 rounded-2xl p-8 md:p-12 shadow-xl">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white mb-3">Can't find your question?</h2>
                <p class="text-slate-400 text-lg">
                    Submit a question and we'll review it. If it's helpful for others, we'll add it to the FAQ!
                </p>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-500/20 border border-green-500/50 rounded-lg text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('faq.requests.store') }}">
                @csrf
                <div class="space-y-4">
                    @guest
                    <div>
                        <label for="faq-name" class="block text-sm font-semibold text-gray-300 mb-2">Name *</label>
                        <input type="text" 
                               id="faq-name"
                               name="name" 
                               value="{{ old('name') }}" 
                               required
                               class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors @error('name') border-red-500 @enderror"
                               aria-required="true">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="faq-email" class="block text-sm font-semibold text-gray-300 mb-2">Email *</label>
                        <input type="email" 
                               id="faq-email"
                               name="email" 
                               value="{{ old('email') }}" 
                               required
                               class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors @error('email') border-red-500 @enderror"
                               aria-required="true">
                        @error('email')
                            <p class="text-red-400 text-sm mt-1" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                    @else
                    <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                    <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                    @endguest
                    <div>
                        <label for="faq-question" class="block text-sm font-semibold text-gray-300 mb-2">Your Question *</label>
                        <textarea id="faq-question"
                                  name="question" 
                                  rows="3" 
                                  required
                                  class="w-full bg-slate-900/50 border border-slate-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-indigo-500 transition-colors resize-none @error('question') border-red-500 @enderror"
                                  placeholder="What would you like to know?"
                                  aria-required="true">{{ old('question') }}</textarea>
                        @error('question')
                            <p class="text-red-400 text-sm mt-1" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" 
                            class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-xl text-white font-semibold transition-all transform hover:scale-105 shadow-lg flex items-center justify-center gap-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Submit Question
                    </button>
                </div>
            </form>
        </div>

        <!-- Contact CTA -->
        <div class="mt-12 bg-gradient-to-r from-indigo-600 via-purple-600 to-rose-600 rounded-2xl p-8 md:p-12 text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6 backdrop-blur-sm">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Still need help?</h2>
                <p class="text-lg text-indigo-100 mb-8 max-w-2xl mx-auto">
                    Our support team is here to help you with any questions or issues you might have.
                </p>
                <a href="{{ route('contact.create') }}" 
                   class="inline-flex items-center px-8 py-4 bg-white hover:bg-slate-100 rounded-xl text-indigo-600 font-semibold transition-all duration-200 transform hover:scale-105 shadow-2xl focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function faqPage() {
    return {
        searchQuery: '{{ $query ?? '' }}',
        activeCategory: null,
        searchResults: [],
        
        init() {
            // Initialize from URL query if present
            const urlParams = new URLSearchParams(window.location.search);
            const query = urlParams.get('q');
            if (query) {
                this.searchQuery = query;
                this.filterFAQs();
            }
        },
        
        filterByCategory(categoryIndex) {
            this.activeCategory = categoryIndex;
            // Scroll to first visible category
            this.$nextTick(() => {
                const firstVisible = document.querySelector('.faq-category[x-show]');
                if (firstVisible) {
                    firstVisible.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        },
        
        shouldShowItem(question, answer) {
            if (!this.searchQuery) {
                return true;
            }
            const query = this.searchQuery.toLowerCase();
            return question.includes(query) || answer.includes(query);
        },
        
        filterFAQs() {
            // Real-time filtering is handled by x-show in template
            // This method can be used for additional logic if needed
            this.searchResults = [];
            const items = document.querySelectorAll('.faq-item');
            items.forEach(item => {
                if (item.offsetParent !== null) {
                    this.searchResults.push(item);
                }
            });
        },
        
        handleSearch() {
            if (this.searchQuery.trim()) {
                window.location.href = '{{ route("faq.index") }}?q=' + encodeURIComponent(this.searchQuery);
            } else {
                this.clearSearch();
            }
        },
        
        clearSearch() {
            this.searchQuery = '';
            window.location.href = '{{ route("faq.index") }}';
        }
    }
}
</script>
@endsection
