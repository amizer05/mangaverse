<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MangaVerse') }} - User Details</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<div class="min-h-screen bg-gradient-to-br from-gray-900 via-slate-900 to-gray-900 text-white p-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('admin.users.index') }}" class="text-purple-400 hover:text-purple-300 mb-4 inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Users
            </a>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
                User Details
            </h1>
        </div>

        <div class="bg-gray-800/50 backdrop-blur rounded-xl p-6 border border-gray-700/50">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-bold mb-4">Profile Information</h2>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm text-gray-400">Name</label>
                            <p class="text-white font-semibold">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-400">Username</label>
                            <p class="text-white">@{{ $user->username ?? 'No username' }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-400">Email</label>
                            <p class="text-white">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-gray-400">Role</label>
                            <p>
                                @if($user->is_admin)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-purple-600 to-pink-600 text-white">
                                        Admin
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-700 text-gray-300">
                                        User
                                    </span>
                                @endif
                            </p>
                        </div>
                        @if($user->birthday)
                        <div>
                            <label class="text-sm text-gray-400">Birthday</label>
                            <p class="text-white">{{ $user->birthday->format('F j, Y') }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="text-sm text-gray-400">Member Since</label>
                            <p class="text-white">{{ $user->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-bold mb-4">About</h2>
                    @if($user->about_me)
                        <p class="text-gray-300 whitespace-pre-line">{{ $user->about_me }}</p>
                    @else
                        <p class="text-gray-500">No bio provided</p>
                    @endif
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-700 flex gap-3">
                <a href="{{ route('admin.users.edit', $user) }}" class="px-6 py-3 bg-purple-600/20 text-purple-400 rounded-lg hover:bg-purple-600/30 transition-all font-semibold">
                    Edit User
                </a>
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-yellow-600/20 text-yellow-400 rounded-lg hover:bg-yellow-600/30 transition-all font-semibold">
                            {{ $user->is_admin ? 'Remove Admin Rights' : 'Promote to Admin' }}
                        </button>
                    </form>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-600/20 text-red-400 rounded-lg hover:bg-red-600/30 transition-all font-semibold">
                            Delete User
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
</body>
</html>






