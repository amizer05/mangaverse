<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create Chapter - {{ $manga->title }}
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
                    <form action="{{ route('admin.mangas.chapters.store', $manga) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Chapter Number -->
                        <div class="mb-4">
                            <label for="chapter_number" class="block text-sm font-medium text-gray-700 mb-2">
                                Chapter Number <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   id="chapter_number" 
                                   name="chapter_number" 
                                   value="{{ old('chapter_number') }}"
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
                                   value="{{ old('title') }}"
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
                                <option value="VF" {{ old('language') === 'VF' ? 'selected' : '' }}>VF (Version Française)</option>
                                <option value="VO" {{ old('language') === 'VO' ? 'selected' : '' }}>VO (Version Originale)</option>
                                <option value="EN" {{ old('language') === 'EN' ? 'selected' : '' }}>EN (English)</option>
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
                                       {{ old('is_published', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="is_published" class="ml-2 block text-sm text-gray-900">
                                    Publish immediately
                                </label>
                            </div>
                        </div>

                        <!-- Published At -->
                        <div class="mb-4" id="published_at_container" style="display: none;">
                            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-2">
                                Publish Date
                            </label>
                            <input type="datetime-local" 
                                   id="published_at" 
                                   name="published_at" 
                                   value="{{ old('published_at') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Upload Method Tabs -->
                        <div class="mb-4">
                            <div class="border-b border-gray-200">
                                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                                    <button type="button" 
                                            onclick="switchUploadMethod('file')"
                                            id="tab-file"
                                            class="upload-tab active border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        Upload Files
                                    </button>
                                    <button type="button" 
                                            onclick="switchUploadMethod('url')"
                                            id="tab-url"
                                            class="upload-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                        From URLs
                                    </button>
                                </nav>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <div id="upload-file-section" class="mb-6">
                            <label for="pages" class="block text-sm font-medium text-gray-700 mb-2">
                                Chapter Pages <span class="text-red-500">*</span>
                            </label>
                            <p class="text-sm text-gray-500 mb-3">
                                Upload images for each page. Images will be ordered by filename. Supported formats: JPEG, PNG, WebP (Max 10MB per image)
                            </p>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors" 
                                 id="drop-zone"
                                 ondrop="handleDrop(event)" 
                                 ondragover="handleDragOver(event)" 
                                 ondragleave="handleDragLeave(event)">
                                <input type="file" 
                                       id="pages" 
                                       name="pages[]" 
                                       multiple
                                       accept="image/jpeg,image/jpg,image/png,image/webp"
                                       class="hidden"
                                       onchange="handleFileSelect(event)">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 8M7 8h21" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="mt-4">
                                    <label for="pages" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        Select Files
                                    </label>
                                    <p class="mt-2 text-sm text-gray-600">or drag and drop</p>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">PNG, JPG, WebP up to 10MB each</p>
                            </div>
                            @error('pages')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('pages.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div id="file-list" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                        </div>

                        <!-- URL Upload Section -->
                        <div id="upload-url-section" class="mb-6" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Chapter Page URLs <span class="text-red-500">*</span>
                            </label>
                            <p class="text-sm text-gray-500 mb-3">
                                Enter image URLs (one per line). Images will be downloaded and stored. Make sure you have permission to use these images.
                            </p>
                            <textarea id="page_urls_textarea" 
                                      name="page_urls_textarea"
                                      rows="10"
                                      placeholder="https://example.com/page1.jpg&#10;https://example.com/page2.jpg&#10;https://example.com/page3.jpg"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm"></textarea>
                            <input type="hidden" id="page_urls" name="page_urls[]" value="">
                            <p class="mt-2 text-xs text-gray-500">Enter one URL per line. URLs will be processed in order.</p>
                            @error('page_urls')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @error('page_urls.*')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('admin.mangas.chapters.index', $manga) }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                Create Chapter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedFiles = [];
        let currentUploadMethod = 'file';

        // Show/hide published_at based on checkbox
        document.getElementById('is_published').addEventListener('change', function() {
            document.getElementById('published_at_container').style.display = this.checked ? 'none' : 'block';
        });

        // Switch upload method
        function switchUploadMethod(method) {
            currentUploadMethod = method;
            const fileSection = document.getElementById('upload-file-section');
            const urlSection = document.getElementById('upload-url-section');
            const fileTab = document.getElementById('tab-file');
            const urlTab = document.getElementById('tab-url');
            const pagesInput = document.getElementById('pages');
            const urlsTextarea = document.getElementById('page_urls_textarea');

            if (method === 'file') {
                fileSection.style.display = 'block';
                urlSection.style.display = 'none';
                fileTab.classList.add('active', 'border-indigo-500', 'text-indigo-600');
                fileTab.classList.remove('border-transparent', 'text-gray-500');
                urlTab.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
                urlTab.classList.add('border-transparent', 'text-gray-500');
                pagesInput.required = true;
                urlsTextarea.required = false;
            } else {
                fileSection.style.display = 'none';
                urlSection.style.display = 'block';
                urlTab.classList.add('active', 'border-indigo-500', 'text-indigo-600');
                urlTab.classList.remove('border-transparent', 'text-gray-500');
                fileTab.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
                fileTab.classList.add('border-transparent', 'text-gray-500');
                pagesInput.required = false;
                urlsTextarea.required = true;
            }
        }

        // Drag and drop handlers
        function handleDragOver(e) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.add('border-indigo-500', 'bg-indigo-50');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.remove('border-indigo-500', 'bg-indigo-50');
        }

        function handleDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.remove('border-indigo-500', 'bg-indigo-50');
            
            const files = Array.from(e.dataTransfer.files).filter(file => 
                file.type.startsWith('image/')
            );
            
            if (files.length > 0) {
                const input = document.getElementById('pages');
                const dataTransfer = new DataTransfer();
                [...selectedFiles, ...files].forEach(file => dataTransfer.items.add(file));
                input.files = dataTransfer.files;
                selectedFiles = Array.from(input.files);
                displayFiles();
            }
        }

        function handleFileSelect(e) {
            selectedFiles = Array.from(e.target.files);
            displayFiles();
        }

        function displayFiles() {
            const fileList = document.getElementById('file-list');
            if (selectedFiles.length > 0) {
                let html = '<div class="col-span-full mb-2"><strong class="text-sm text-gray-700">Selected files (' + selectedFiles.length + '):</strong></div>';
                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.getElementById('preview-' + index);
                        if (img) img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                    
                    html += `
                        <div class="border border-gray-200 rounded-lg p-2">
                            <img id="preview-${index}" src="" alt="${file.name}" class="w-full h-32 object-cover rounded mb-2 bg-gray-100">
                            <p class="text-xs text-gray-600 truncate" title="${file.name}">${file.name}</p>
                            <p class="text-xs text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                        </div>
                    `;
                });
                fileList.innerHTML = html;
            } else {
                fileList.innerHTML = '';
            }
        }

        // Handle URL textarea
        document.getElementById('page_urls_textarea').addEventListener('input', function() {
            const urls = this.value.split('\n').filter(url => url.trim().length > 0);
            const hiddenInput = document.getElementById('page_urls');
            hiddenInput.value = '';
            urls.forEach(url => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'page_urls[]';
                input.value = url.trim();
                hiddenInput.parentNode.insertBefore(input, hiddenInput);
            });
        });

        // Form submission validation
        document.querySelector('form').addEventListener('submit', function(e) {
            if (currentUploadMethod === 'file' && selectedFiles.length === 0) {
                e.preventDefault();
                alert('Please select at least one file to upload.');
                return false;
            }
            if (currentUploadMethod === 'url') {
                const urls = document.getElementById('page_urls_textarea').value.split('\n').filter(url => url.trim().length > 0);
                if (urls.length === 0) {
                    e.preventDefault();
                    alert('Please enter at least one image URL.');
                    return false;
                }
            }
        });
    </script>
</x-app-layout>




