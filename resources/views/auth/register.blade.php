<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="max-h-[70vh] overflow-y-auto pr-2">
        @csrf

        <h2 class="text-2xl font-bold text-white mb-6">Registreren</h2>

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-purple-300 text-sm mb-2">Naam *</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    class="w-full bg-gray-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white placeholder-gray-500 focus:border-purple-500 focus:outline-none transition"
                    placeholder="Jouw naam"
                />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Username (optional) -->
        <div class="mb-4">
            <label for="username" class="block text-purple-300 text-sm mb-2">Gebruikersnaam (optioneel)</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <input
                    id="username"
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    autocomplete="username"
                    class="w-full bg-gray-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white placeholder-gray-500 focus:border-purple-500 focus:outline-none transition"
                    placeholder="gebruikersnaam"
                />
            </div>
            <p class="text-purple-400 text-xs mt-1">Voor je publieke profiel URL</p>
            <x-input-error :messages="$errors->get('username')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="block text-purple-300 text-sm mb-2">Email *</label>
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
                    autocomplete="username"
                    class="w-full bg-gray-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white placeholder-gray-500 focus:border-purple-500 focus:outline-none transition"
                    placeholder="jouw@email.com"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Birthday -->
        <div class="mb-4">
            <label for="birthday" class="block text-purple-300 text-sm mb-2">Geboortedatum</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <input
                    id="birthday"
                    type="date"
                    name="birthday"
                    value="{{ old('birthday') }}"
                    class="w-full bg-gray-900/50 border border-purple-500/30 rounded-lg pl-11 pr-4 py-3 text-white placeholder-gray-500 focus:border-purple-500 focus:outline-none transition"
                />
            </div>
            <x-input-error :messages="$errors->get('birthday')" class="mt-1" />
        </div>

        <!-- About Me -->
        <div class="mb-4">
            <label for="about_me" class="block text-purple-300 text-sm mb-2">Over Mij</label>
            <textarea
                id="about_me"
                name="about_me"
                rows="3"
                maxlength="500"
                class="w-full bg-gray-900/50 border border-purple-500/30 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:border-purple-500 focus:outline-none transition resize-none"
                placeholder="Vertel iets over jezelf..."
            >{{ old('about_me') }}</textarea>
            <div class="flex justify-between items-center mt-1">
                <x-input-error :messages="$errors->get('about_me')" />
                <span class="text-purple-400 text-xs" id="aboutMeCounter">0/500</span>
            </div>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-purple-300 text-sm mb-2">Wachtwoord *</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
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

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="block text-purple-300 text-sm mb-2">Bevestig Wachtwoord *</label>
            <div class="relative">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full bg-gray-900/50 border border-purple-500/30 rounded-lg pl-11 pr-11 py-3 text-white placeholder-gray-500 focus:border-purple-500 focus:outline-none transition"
                    placeholder="••••••••"
                />
                <button
                    type="button"
                    onclick="togglePassword('password_confirmation', 'passwordConfirmationToggle')"
                    id="passwordConfirmationToggle"
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-purple-400 hover:text-purple-300 transition"
                >
                    <svg id="passwordConfirmationEye" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="passwordConfirmationEyeOff" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            id="registerButton"
            class="w-full bg-gradient-to-r from-purple-500 to-pink-500 text-white font-semibold py-3 rounded-lg hover:from-purple-600 hover:to-pink-600 transition transform hover:scale-105 shadow-lg shadow-purple-500/50 disabled:opacity-50 disabled:cursor-not-allowed"
        >
            Registreren
        </button>

        <!-- Login Link -->
        <p class="text-center text-purple-300 mt-6">
            Al een account?{' '}
            <a href="{{ route('login') }}" class="text-purple-400 font-semibold hover:text-purple-300 transition">
                Log hier in
            </a>
        </p>
    </form>

    <script>
        function togglePassword(inputId, buttonId) {
            const input = document.getElementById(inputId);
            if (!input) return;
            
            let eye, eyeOff;
            
            if (inputId === 'password') {
                eye = document.getElementById('passwordEye');
                eyeOff = document.getElementById('passwordEyeOff');
            } else if (inputId === 'password_confirmation') {
                eye = document.getElementById('passwordConfirmationEye');
                eyeOff = document.getElementById('passwordConfirmationEyeOff');
            } else {
                return;
            }
            
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
        
        // Form validation and loading state
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="{{ route('register') }}"]');
            const submitButton = document.getElementById('registerButton');
            const aboutMeTextarea = document.getElementById('about_me');
            const aboutMeCounter = document.getElementById('aboutMeCounter');
            
            // Character counter for about_me
            if (aboutMeTextarea && aboutMeCounter) {
                function updateCounter() {
                    const length = aboutMeTextarea.value.length;
                    aboutMeCounter.textContent = length + '/500';
                    if (length > 450) {
                        aboutMeCounter.classList.add('text-yellow-400');
                        aboutMeCounter.classList.remove('text-purple-400');
                    } else {
                        aboutMeCounter.classList.remove('text-yellow-400');
                        aboutMeCounter.classList.add('text-purple-400');
                    }
                }
                aboutMeTextarea.addEventListener('input', updateCounter);
                updateCounter(); // Initial count
            }
            
            if (form) {
                form.addEventListener('submit', function(e) {
                    const password = document.getElementById('password');
                    const passwordConfirmation = document.getElementById('password_confirmation');
                    const email = document.getElementById('email');
                    
                    // Client-side validation
                    if (password && passwordConfirmation) {
                        if (password.value !== passwordConfirmation.value) {
                            e.preventDefault();
                            // Show error message
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'mb-4 bg-red-500/20 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg text-sm';
                            errorDiv.textContent = 'Wachtwoorden komen niet overeen!';
                            form.insertBefore(errorDiv, form.firstChild);
                            passwordConfirmation.focus();
                            setTimeout(() => errorDiv.remove(), 5000);
                            return false;
                        }
                        
                        if (password.value.length < 8) {
                            e.preventDefault();
                            // Show error message
                            const errorDiv = document.createElement('div');
                            errorDiv.className = 'mb-4 bg-red-500/20 border border-red-500/50 text-red-400 px-4 py-3 rounded-lg text-sm';
                            errorDiv.textContent = 'Wachtwoord moet minimaal 8 tekens lang zijn!';
                            form.insertBefore(errorDiv, form.firstChild);
                            password.focus();
                            setTimeout(() => errorDiv.remove(), 5000);
                            return false;
                        }
                    }
                    
                    // Email lowercase
                    if (email && email.value) {
                        email.value = email.value.toLowerCase().trim();
                    }
                    
                    // Disable button and show loading
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Registreren...';
                    }
                });
            }
        });
    </script>
</x-guest-layout>
