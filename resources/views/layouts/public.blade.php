<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MangaVerse') }} - @yield('title', 'Discover Manga')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-950 text-slate-100" x-data="{ mobileMenuOpen: false }">
    <!-- Navigation -->
    <nav class="bg-slate-900/95 backdrop-blur-md border-b border-slate-800 sticky top-0 z-50 shadow-lg shadow-black/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:h-20">
                <!-- Logo -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                        <div class="w-8 h-8 md:w-10 md:h-10 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-lg flex items-center justify-center transform group-hover:scale-110 group-hover:rotate-12 transition-all duration-200 shadow-lg shadow-indigo-500/25">
                            <span class="text-white font-bold text-xl md:text-2xl">M</span>
                        </div>
                        <span class="text-xl md:text-2xl font-bold bg-gradient-to-r from-indigo-400 to-rose-400 bg-clip-text text-transparent">
                            MangaVerse
                        </span>
                    </a>

                    <!-- Primary Navigation -->
                    <div class="hidden md:flex space-x-1">
                        <a href="{{ route('home') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'bg-slate-800 text-indigo-400 shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            Home
                        </a>
                        <a href="{{ route('mangas.public.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('mangas.public.*') ? 'bg-slate-800 text-indigo-400 shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            Manga
                        </a>
                        <a href="{{ route('news.public.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('news.public.*') ? 'bg-slate-800 text-indigo-400 shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            News
                        </a>
                        <a href="{{ route('faq.index') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('faq.*') ? 'bg-slate-800 text-indigo-400 shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            FAQ
                        </a>
                        <a href="{{ route('contact.create') }}" class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('contact.*') ? 'bg-slate-800 text-indigo-400 shadow-lg shadow-indigo-500/10' : 'text-slate-300 hover:text-white hover:bg-slate-800' }}">
                            Contact
                        </a>
                    </div>
                </div>

                <!-- Right Side Navigation -->
                <div class="flex items-center space-x-4">
                    @auth
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-slate-800 transition-colors duration-200">
                                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6366f1&color=fff' }}" 
                                     alt="{{ Auth::user()->name }}" 
                                     class="w-8 h-8 rounded-full">
                                <span class="hidden md:block text-sm font-medium">{{ Auth::user()->name }}</span>
                            </button>

                            <div x-show="open" 
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-slate-800 rounded-lg shadow-lg border border-slate-700 py-1"
                                 style="display: none;">
                                <a href="{{ route('users.show', Auth::user()->username ?? '') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-700">
                                    My Profile
                                </a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-300 hover:bg-slate-700">
                                    Settings
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-indigo-400 hover:bg-slate-700">
                                        Admin Dashboard
                                    </a>
                                @endif
                                <hr class="my-1 border-slate-700">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-slate-300 hover:bg-slate-700">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-slate-300 hover:text-white transition-colors duration-200">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 rounded-lg text-sm font-medium text-white transition-all duration-200 transform hover:scale-105">
                            Register
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg hover:bg-slate-800 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-slate-900 border-t border-slate-800"
             style="display: none;">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('home') ? 'bg-slate-800 text-indigo-400' : 'text-slate-300 hover:bg-slate-800' }}">
                    Home
                </a>
                <a href="{{ route('mangas.public.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('mangas.public.*') ? 'bg-slate-800 text-indigo-400' : 'text-slate-300 hover:bg-slate-800' }}">
                    Manga
                </a>
                <a href="{{ route('news.public.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('news.public.*') ? 'bg-slate-800 text-indigo-400' : 'text-slate-300 hover:bg-slate-800' }}">
                    News
                </a>
                <a href="{{ route('faq.index') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('faq.*') ? 'bg-slate-800 text-indigo-400' : 'text-slate-300 hover:bg-slate-800' }}">
                    FAQ
                </a>
                <a href="{{ route('contact.create') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('contact.*') ? 'bg-slate-800 text-indigo-400' : 'text-slate-300 hover:bg-slate-800' }}">
                    Contact
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xl">M</span>
                        </div>
                        <span class="text-xl font-bold bg-gradient-to-r from-indigo-400 to-rose-400 bg-clip-text text-transparent">
                            MangaVerse
                        </span>
                    </div>
                    <p class="text-slate-400 text-sm mb-4">
                        Your ultimate destination for discovering and reading manga. Join our community and explore thousands of titles.
                    </p>
                    <p class="text-slate-500 text-xs">
                        &copy; {{ date('Y') }} MangaVerse. All rights reserved.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('mangas.public.index') }}" class="text-slate-400 hover:text-indigo-400 text-sm transition-colors duration-200">Browse Manga</a></li>
                        <li><a href="{{ route('news.public.index') }}" class="text-slate-400 hover:text-indigo-400 text-sm transition-colors duration-200">Latest News</a></li>
                        <li><a href="{{ route('faq.index') }}" class="text-slate-400 hover:text-indigo-400 text-sm transition-colors duration-200">FAQ</a></li>
                        <li><a href="{{ route('contact.create') }}" class="text-slate-400 hover:text-indigo-400 text-sm transition-colors duration-200">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Community -->
                <div>
                    <h3 class="text-sm font-semibold text-slate-300 uppercase tracking-wider mb-4">Community</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ config('services.social.discord', '#') }}"
                               @if(config('services.social.discord')) target="_blank" rel="noopener noreferrer" @endif
                               class="text-slate-400 hover:text-indigo-400 text-sm transition-colors duration-200">
                                Discord
                            </a>
                        </li>
                        <li>
                            <a href="{{ config('services.social.twitter', '#') }}"
                               @if(config('services.social.twitter')) target="_blank" rel="noopener noreferrer" @endif
                               class="text-slate-400 hover:text-indigo-400 text-sm transition-colors duration-200">
                                Twitter
                            </a>
                        </li>
                        <li>
                            <a href="{{ config('services.social.github', '#') }}"
                               @if(config('services.social.github')) target="_blank" rel="noopener noreferrer" @endif
                               class="text-slate-400 hover:text-indigo-400 text-sm transition-colors duration-200">
                                GitHub
                            </a>
                        </li>
                        <li>
                            <a href="{{ config('services.social.support', '#') }}"
                               @if(config('services.social.support')) target="_blank" rel="noopener noreferrer" @endif
                               class="text-slate-400 hover:text-indigo-400 text-sm transition-colors duration-200">
                                Support
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Alpine.js for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Smooth scroll and animations -->
    <script>
        // Add fade-in animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);
            
            // Observe all cards and sections
            document.querySelectorAll('.card, article, section > div').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
