<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Chapter {{ $chapter->chapter_number }} - {{ $manga->title }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    <a href="{{ route('admin.mangas.chapters.index', $manga) }}" class="hover:text-indigo-600">← Back to Chapters</a>
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.mangas.chapters.update', [$manga, $chapter]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Chapter Number -->
                        <div class="mb-4">
                            <label for="chapter_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Chapter Number <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="chapter_number" 
                                   name="chapter_number" 
                                   value="{{ old('chapter_number', $chapter->chapter_number) }}"
                                   min="1"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('chapter_number') border-red-500 @enderror">
                            @error('chapter_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Title (Optional)
                            </label>
                            <input type="text" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $chapter->title) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror"
                                   placeholder="e.g., The Beginning">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Language -->
                        <div class="mb-4">
                            <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                                Language <span class="text-red-500">*</span>
                            </label>
                            <select id="language" 
                                    name="language" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('language') border-red-500 @enderror">
                                <option value="">Select Language</option>
                                <option value="VF" {{ old('language', $chapter->language) === 'VF' ? 'selected' : '' }}>VF (Version Française)</option>
                                <option value="VO" {{ old('language', $chapter->language) === 'VO' ? 'selected' : '' }}>VO (Version Originale)</option>
                                <option value="EN" {{ old('language', $chapter->language) === 'EN' ? 'selected' : '' }}>EN (English)</option>
                            </select>
                            @error('language')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Published Status -->
                        <div class="mb-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="is_published" 
                                       name="is_published" 
                                       value="1"
                                       {{ old('is_published', $chapter->is_published) ? 'checked' : '' }}
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                    Published
                                </label>
                            </div>
                        </div>

                        <!-- Published At -->
                        <div class="mb-4" id="published_at_container" style="display: {{ old('is_published', $chapter->is_published) ? 'none' : 'block' }};">
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                                Publish Date
                            </label>
                            <input type="datetime-local" 
                                   id="published_at" 
                                   name="published_at" 
                                   value="{{ old('published_at', $chapter->published_at ? $chapter->published_at->format('Y-m-d\TH:i') : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Current Pages -->
                        @if($chapter->pages->count() > 0)
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-700 mb-3">Current Pages ({{ $chapter->pages->count() }})</h4>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($chapter->pages as $page)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $page->image_path) }}" 
                                         alt="Page {{ $page->page_number }}"
                                         class="w-full h-auto rounded border"
                                         onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'100\' height=\'150\'%3E%3Crect fill=\'%23e5e7eb\' width=\'100\' height=\'150\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-size=\'12\'%3E{{ $page->page_number }}%3C/text%3E%3C/svg%3E'">
                                    <div class="absolute bottom-0 left-0 right-0 bg-black/70 text-white text-xs text-center py-1">
                                        Page {{ $page->page_number }}
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Add New Pages -->
                        <div class="mb-6">
                            <label for="new_pages" class="block text-sm font-medium text-gray-700 mb-2">
                                Add More Pages (Optional)
                            </label>
                            <p class="text-sm text-gray-500 mb-3">
                                Upload additional pages. They will be added to the end. Supported formats: JPEG, PNG, WebP (Max 10MB per image)
                            </p>
                            <input type="file" 
                                   id="new_pages" 
                                   name="new_pages[]" 
                                   multiple
                                   accept="image/jpeg,image/jpg,image/png,image/webp"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('new_pages') border-red-500 @enderror">
                            @error('new_pages')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('new_pages.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div id="file-list" class="mt-2 text-sm text-gray-600"></div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.mangas.chapters.index', $manga) }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Update Chapter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show/hide published_at based on checkbox
        document.getElementById('is_published').addEventListener('change', function() {
            document.getElementById('published_at_container').style.display = this.checked ? 'none' : 'block';
        });

        // Show selected files
        document.getElementById('new_pages').addEventListener('change', function(e) {
            const fileList = document.getElementById('file-list');
            if (this.files.length > 0) {
                let html = '<strong>Selected files (' + this.files.length + '):</strong><ul class="list-disc list-inside mt-1">';
                for (let i = 0; i < this.files.length; i++) {
                    html += '<li>' + this.files[i].name + ' (' + (this.files[i].size / 1024 / 1024).toFixed(2) + ' MB)</li>';
                }
                html += '</ul>';
                fileList.innerHTML = html;
            } else {
                fileList.innerHTML = '';
            }
        });
    </script>
</x-app-layout>









