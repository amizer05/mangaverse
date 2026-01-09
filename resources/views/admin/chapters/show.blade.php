<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Chapter {{ $chapter->chapter_number }} - {{ $manga->title }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    <a href="{{ route('admin.mangas.chapters.index', $manga) }}" class="hover:text-indigo-600">← Back to Chapters</a>
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.mangas.chapters.edit', [$manga, $chapter]) }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                    Edit
                </a>
                <form action="{{ route('admin.mangas.chapters.destroy', [$manga, $chapter]) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('Are you sure? This will delete all pages.')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Chapter Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Chapter Information</h3>
                            
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Chapter Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900">#{{ $chapter->chapter_number }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Title</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $chapter->title ?? 'No title' }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Language</dt>
                                    <dd class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $chapter->language === 'VF' ? 'bg-blue-100 text-blue-800' : ($chapter->language === 'VO' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                            {{ $chapter->language }}
                                        </span>
                                    </dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Pages</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $chapter->page_count }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Views</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ number_format($chapter->views) }}</dd>
                                </div>
                                
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        @if($chapter->is_published)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Published
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Draft
                                            </span>
                                        @endif
                                    </dd>
                                </div>
                                
                                @if($chapter->published_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Published At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $chapter->published_at->format('M d, Y H:i') }}</dd>
                                </div>
                                @endif
                            </dl>

                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <a href="{{ route('chapters.read', [$manga->slug, $chapter->id]) }}" 
                                   target="_blank"
                                   class="block w-full text-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-indigo-700">
                                    View Chapter
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pages -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Pages ({{ $chapter->pages->count() }})</h3>
                            </div>

                            @if($chapter->pages->count() > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                                @foreach($chapter->pages as $page)
                                <div class="relative group">
                                    <div class="aspect-[3/4] bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $page->image_path) }}" 
                                             alt="Page {{ $page->page_number }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'600\'%3E%3Crect fill=\'%23e5e7eb\' width=\'400\' height=\'600\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-family=\'Arial\' font-size=\'24\'%3EPage {{ $page->page_number }}%3C/text%3E%3C/svg%3E'">
                                    </div>
                                    <div class="absolute top-2 left-2 bg-black/70 text-white text-xs px-2 py-1 rounded">
                                        Page {{ $page->page_number }}
                                    </div>
                                    <form action="{{ route('admin.chapters.pages.destroy', [$chapter, $page]) }}" 
                                          method="POST" 
                                          class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Delete this page?')"
                                                class="bg-red-600 text-white p-1 rounded hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No pages</h3>
                                <p class="mt-1 text-sm text-gray-500">This chapter has no pages yet.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>














