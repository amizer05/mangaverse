<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Manga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.mangas.update', $manga) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $manga->title)" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="slug" :value="__('Slug')" />
                            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $manga->slug)" required />
                            <x-input-error :messages="$errors->get('slug')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="cover_image" :value="__('Cover Image')" />
                            @if($manga->cover_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $manga->cover_image) }}" 
                                     alt="{{ $manga->title }}" 
                                     class="max-w-xs rounded-lg shadow-md mb-2"
                                     onerror="this.style.display='none'">
                                <p class="text-xs text-gray-500">Current cover image</p>
                            </div>
                            @endif
                            <input id="cover_image" 
                                   name="cover_image" 
                                   type="file" 
                                   accept="image/jpeg,image/jpg,image/png,image/webp"
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            <p class="mt-1 text-xs text-gray-500">Upload a new image to replace the current one. Supported formats: JPEG, PNG, WebP (Max 5MB)</p>
                            <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $manga->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="release_date" :value="__('Release Date')" />
                            <x-text-input id="release_date" name="release_date" type="date" class="mt-1 block w-full" :value="old('release_date', $manga->release_date)" />
                            <x-input-error :messages="$errors->get('release_date')" class="mt-2" />
                        </div>

                        <div class="flex justify-end">
                            <a href="{{ route('admin.mangas.index') }}" class="mr-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-xs font-semibold text-gray-700 uppercase tracking-widest hover:bg-gray-50">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>





