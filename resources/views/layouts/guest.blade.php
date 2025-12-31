<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'MangaVerse') }} - Auth</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="min-h-screen bg-gradient-to-b from-gray-900 via-purple-900 to-gray-900 flex items-center justify-center p-6">
            <div class="w-full max-w-md relative">
                <!-- Back to Home Button -->
                <div class="absolute -top-16 left-0">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 text-purple-300 hover:text-white transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="m15 18-6-6 6-6"/>
                        </svg>
                        Terug naar Home
                    </a>
                </div>

                <!-- Logo -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl mb-4 shadow-lg shadow-purple-500/50">
                        <span class="text-3xl font-bold text-white">M</span>
                    </div>
                    <h1 class="text-4xl font-bold text-white mb-2">MangaVerse</h1>
                    <p class="text-purple-300">Jouw manga universum</p>
                </div>

                <!-- Form Card -->
                <div class="bg-gray-800/50 backdrop-blur-xl border border-purple-500/30 rounded-2xl shadow-2xl p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
