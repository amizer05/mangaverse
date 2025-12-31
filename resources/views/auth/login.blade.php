<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <h2 class="text-2xl font-bold text-white mb-6">Inloggen</h2>

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
                    autocomplete="username"
                    class="w-full bg-gray-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white placeholder-gray-500 focus:border-purple-500 focus:outline-none transition"
                    placeholder="jouw@email.com"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-purple-300 text-sm mb-2">Wachtwoord</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="w-full bg-gray-900/50 border border-purple-500/30 rounded-lg pl-11 pr-11 py-3 text-white placeholder-gray-500 focus:border-purple-500 focus:outline-none transition"
                    placeholder="••••••••"
                />
                <button
                    type="button"
                    onclick="togglePassword('password', 'passwordToggle')"
                    id="passwordToggle"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-purple-400 hover:text-purple-300 transition"
                >
                    <svg id="passwordEye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="passwordEyeOff" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="w-4 h-4 rounded border-purple-500/30 bg-gray-900/50 text-purple-500 focus:ring-purple-500"
                />
                <span class="text-purple-300 text-sm">Onthoud mij</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-purple-400 text-sm hover:text-purple-300 transition">
                    Wachtwoord vergeten?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            id="loginButton"
            class="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold py-3 rounded-lg hover:from-purple-600 hover:to-pink-600 transition transform hover:scale-105 shadow-lg shadow-purple-500/50 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Inloggen
        </button>

        <!-- Register Link -->
        <p class="text-center text-purple-300 mt-6">
            Nog geen account?{' '}
            <a href="{{ route('register') }}" class="text-purple-400 font-semibold hover:text-purple-300 transition">
                Registreer nu
            </a>
        </p>
    </form>

    <script>
        function togglePassword(inputId, buttonId) {
            const input = document.getElementById(inputId);
            if (!input) return;
            
            const eye = document.getElementById('passwordEye');
            const eyeOff = document.getElementById('passwordEyeOff');
            
            if (!eye || !eyeOff) return;
            
            if (input.type === 'password') {
                input.type = 'text';
                eye.classList.add('hidden');
                eyeOff.classList.remove('hidden');
            } else {
                input.type = 'password';
                eye.classList.remove('hidden');
                eyeOff.classList.add('hidden');
            }
        }
        
        // Add loading state and email lowercase
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Convert email to lowercase
                    if (emailInput && emailInput.value) {
                        emailInput.value = emailInput.value.toLowerCase().trim();
                    }
                    
                    const submitButton = document.getElementById('loginButton');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Inloggen...';
                    }
                });
            }
        });
    </script>
</x-guest-layout>
