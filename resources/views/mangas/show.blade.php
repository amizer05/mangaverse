<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manga Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('admin.mangas.index') }}" class="text-indigo-600 hover:underline">
                            ← Back to Mangas
                        </a>
                    </div>

                    <div class="mb-6">
                        <h1 class="text-3xl font-bold">{{ $manga->title }}</h1>
                        <p class="text-gray-500 mt-1">Slug: {{ $manga->slug }}</p>
                    </div>

                    @if($manga->cover_image)
                        <div class="mb-6">
                            <img src="{{ $manga->cover_image }}" alt="{{ $manga->title }}" class="max-w-xs rounded-lg shadow-md">
                        </div>
                    @endif

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ __('Description') }}</h3>
                        <p class="text-gray-700">{{ $manga->description ?? __('No description available.') }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold mb-2">{{ __('Release Date') }}</h3>
                        <p class="text-gray-700">{{ $manga->release_date ? \Carbon\Carbon::parse($manga->release_date)->format('F j, Y') : __('Not specified') }}</p>
                    </div>

                    <div class="mt-6 flex gap-4 flex-wrap">
                        <a href="{{ route('admin.mangas.chapters.index', $manga) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                            Manage Chapters ({{ $manga->chapters()->count() }})
                        </a>
                        <a href="{{ route('admin.mangas.edit', $manga) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            {{ __('Edit') }}
                        </a>
                        <form action="{{ route('admin.mangas.destroy', $manga) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700" onclick="return confirm('Delete this manga?')">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





