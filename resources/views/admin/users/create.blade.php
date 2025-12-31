<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MangaVerse') }} - Create User</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-slate-900 to-gray-900 text-white p-6">
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
                Create New User
            </h1>
            <p class="text-gray-400">Manually create a new user account</p>
        </div>

        <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 border border-gray-700/50">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Username (optional)</label>
                        <input type="text" name="username" value="{{ old('username') }}"
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors @error('username') border-red-500 @enderror">
                        @error('username')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Password *</label>
                        <input type="password" name="password" required
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Confirm Password *</label>
                        <input type="password" name="password_confirmation" required
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">Birthday (optional)</label>
                        <input type="date" name="birthday" value="{{ old('birthday') }}"
                               class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-300 mb-2">About Me (optional)</label>
                        <textarea name="about_me" rows="3"
                                  class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-3 text-white focus:outline-none focus:border-purple-500 transition-colors resize-none">{{ old('about_me') }}</textarea>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_admin" id="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-purple-500/30 bg-gray-900/50 text-purple-500 focus:ring-purple-500">
                        <label for="is_admin" class="ml-2 text-sm text-gray-300">
                            Make this user an admin
                        </label>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('admin.users.index') }}" class="px-6 py-3 bg-gray-700 rounded-lg font-semibold hover:bg-gray-600 transition-all text-center">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg font-semibold hover:from-purple-500 hover:to-pink-500 transition-all">
                            Create User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>






