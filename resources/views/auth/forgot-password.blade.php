<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-white mb-2">Wachtwoord Vergeten?</h2>
        <p class="text-purple-300 text-sm">
            Geen probleem. Laat ons je e-mailadres weten en we sturen je een link om je wachtwoord opnieuw in te stellen.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-purple-300 text-sm mb-2">Email</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full bg-slate-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white placeholder-slate-500 focus:border-purple-500 focus:outline-none transition @error('email') border-red-500 @enderror"
                    placeholder="jouw@email.com"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-purple-400 text-sm hover:text-purple-300 transition">
                Terug naar inloggen
            </a>
            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg font-semibold hover:from-purple-500 hover:to-pink-500 transition-all text-white">
                Verstuur Reset Link
            </button>
        </div>
    </form>
</x-guest-layout>
