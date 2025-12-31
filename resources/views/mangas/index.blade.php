<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mangas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 text-sm text-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Sync from MyAnimeList API</h3>
                    <p class="text-sm text-gray-600">Search and import manga with covers and descriptions</p>
                </div>
                <div class="flex gap-2">
                    <button onclick="openSyncModal()" 
                            class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Sync from API
                    </button>
                    <a href="{{ route('admin.mangas.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        {{ __('Create Manga') }}
                    </a>
                </div>
            </div>

            <!-- Sync Modal -->
            <div id="syncModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Sync Manga from MyAnimeList</h3>
                            <button onclick="closeSyncModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Search Manga</label>
                            <div class="flex gap-2">
                                <input type="text" 
                                       id="searchQuery" 
                                       placeholder="Enter manga title..."
                                       class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <button onclick="searchManga()" 
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    Search
                                </button>
                            </div>
                        </div>

                        <div id="searchResults" class="max-h-96 overflow-y-auto space-y-2 mb-4"></div>

                        <div class="flex justify-end gap-2">
                            <button onclick="closeSyncModal()" 
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
            function openSyncModal() {
                document.getElementById('syncModal').classList.remove('hidden');
            }

            function closeSyncModal() {
                document.getElementById('syncModal').classList.add('hidden');
                document.getElementById('searchResults').innerHTML = '';
                document.getElementById('searchQuery').value = '';
            }

            function searchManga() {
                const query = document.getElementById('searchQuery').value.trim();
                if (query.length < 2) {
                    alert('Please enter at least 2 characters');
                    return;
                }

                const resultsDiv = document.getElementById('searchResults');
                resultsDiv.innerHTML = '<div class="text-center py-4">Searching...</div>';

                fetch('{{ route("admin.mangas.search-api") }}?q=' + encodeURIComponent(query), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.data && data.data.length > 0) {
                        resultsDiv.innerHTML = data.data.map(manga => `
                            <div class="border rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex gap-4">
                                    <img src="${manga.images?.jpg?.small_image_url || manga.images?.jpg?.image_url || ''}" 
                                         alt="${manga.title}" 
                                         class="w-16 h-24 object-cover rounded">
                                    <div class="flex-1">
                                        <h4 class="font-semibold">${manga.title}</h4>
                                        ${manga.title_english ? `<p class="text-sm text-gray-600">${manga.title_english}</p>` : ''}
                                        <p class="text-xs text-gray-500 mt-1">${manga.synopsis ? manga.synopsis.substring(0, 100) + '...' : 'No description'}</p>
                                        <button onclick="syncManga(${manga.mal_id})" 
                                                class="mt-2 px-3 py-1 bg-purple-600 text-white text-xs rounded hover:bg-purple-700">
                                            Sync to Database
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `).join('');
                    } else {
                        resultsDiv.innerHTML = '<div class="text-center py-4 text-gray-500">No results found</div>';
                    }
                })
                .catch(error => {
                    resultsDiv.innerHTML = '<div class="text-center py-4 text-red-500">Error searching manga</div>';
                    console.error('Error:', error);
                });
            }

            function syncManga(malId) {
                if (!confirm('Sync this manga to the database? This will download the cover image and update the information.')) {
                    return;
                }

                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.mangas.sync-api") }}';
                
                const csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                const malIdInput = document.createElement('input');
                malIdInput.type = 'hidden';
                malIdInput.name = 'mal_id';
                malIdInput.value = malId;
                form.appendChild(malIdInput);

                document.body.appendChild(form);
                form.submit();
            }

            // Close modal on outside click
            document.getElementById('syncModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeSyncModal();
                }
            });
            </script>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Release Date</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($mangas as $manga)
                                <tr>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('admin.mangas.show', $manga) }}" class="text-indigo-600 hover:underline">
                                            {{ $manga->title }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-2">{{ $manga->slug }}</td>
                                    <td class="px-4 py-2">{{ $manga->release_date }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('admin.mangas.edit', $manga) }}" class="text-sm text-blue-600 hover:underline mr-2">
                                            {{ __('Edit') }}
                                        </a>
                                        <form action="{{ route('admin.mangas.destroy', $manga) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:underline" onclick="return confirm('Delete this manga?')">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                        {{ __('No mangas found.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $mangas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>






