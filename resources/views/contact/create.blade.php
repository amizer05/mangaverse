@extends('layouts.public')

@section('title', 'Contact Us')

@section('content')
<div class="bg-gradient-to-b from-slate-900 to-slate-950 py-12" x-data="contactForm()">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Get in Touch</h1>
            <p class="text-lg text-slate-400 max-w-2xl mx-auto mb-4">
                Have a question or feedback? We'd love to hear from you. Send us a message and we'll respond as soon as possible.
            </p>
            <div class="flex items-center justify-center gap-4 text-sm text-slate-500">
                <a href="{{ route('faq.index') }}" 
                   class="flex items-center gap-2 text-indigo-400 hover:text-indigo-300 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded"
                   aria-label="Check our FAQ page">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Check our FAQ first
                </a>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Contact Info Sidebar -->
            <div class="md:col-span-1 space-y-6">
                <!-- Contact Cards -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Email</h3>
                    <p class="text-slate-400 text-sm mb-3">Our friendly team is here to help.</p>
                    <a href="mailto:support@mangaverse.com" 
                       class="text-indigo-400 hover:text-indigo-300 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded"
                       aria-label="Send email to support@mangaverse.com">
                        support@mangaverse.com
                    </a>
                </div>

                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Office</h3>
                    <p class="text-slate-400 text-sm mb-3">Come say hello at our HQ.</p>
                    <address class="text-slate-400 text-sm not-italic">
                        <a href="https://www.google.com/maps/search/?api=1&query=123+Manga+Street+Tokyo+Japan+100-0001" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="hover:text-indigo-400 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded"
                           aria-label="Open address in Google Maps">
                            123 Manga Street<br>
                            Tokyo, Japan 100-0001
                        </a>
                    </address>
                </div>

                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-rose-500 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white mb-2">Phone</h3>
                    <p class="text-slate-400 text-sm mb-3">Mon-Fri from 8am to 5pm.</p>
                    <a href="tel:+81312345678" 
                       class="text-indigo-400 hover:text-indigo-300 text-sm font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded"
                       aria-label="Call +81 (3) 1234-5678">
                        +81 (3) 1234-5678
                    </a>
                </div>

                <!-- Social Links -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Follow Us</h3>
                    <div class="flex gap-3">
                        <a href="https://twitter.com/mangaverse" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="w-10 h-10 bg-slate-700 hover:bg-indigo-600 rounded-lg flex items-center justify-center transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           aria-label="Follow us on Twitter">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="https://facebook.com/mangaverse" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="w-10 h-10 bg-slate-700 hover:bg-blue-800 rounded-lg flex items-center justify-center transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           aria-label="Follow us on Facebook">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://discord.gg/mangaverse" 
                           target="_blank" 
                           rel="noopener noreferrer"
                           class="w-10 h-10 bg-slate-700 hover:bg-purple-600 rounded-lg flex items-center justify-center transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           aria-label="Join our Discord server">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20.317 4.37a19.791 19.791 0 0 0-4.885-1.515a.074.074 0 0 0-.079.037c-.21.375-.444.864-.608 1.25a18.27 18.27 0 0 0-5.487 0a12.64 12.64 0 0 0-.617-1.25a.077.077 0 0 0-.079-.037A19.736 19.736 0 0 0 3.677 4.37a.07.07 0 0 0-.032.027C.533 9.046-.32 13.58.099 18.057a.082.082 0 0 0 .031.057a19.9 19.9 0 0 0 5.993 3.03a.078.078 0 0 0 .084-.028a14.09 14.09 0 0 0 1.226-1.994a.076.076 0 0 0-.041-.106a13.107 13.107 0 0 1-1.872-.892a.077.077 0 0 1-.008-.128a10.2 10.2 0 0 0 .372-.292a.074.074 0 0 1 .077-.01c3.928 1.793 8.18 1.793 12.062 0a.074.074 0 0 1 .078.01c.12.098.246.198.373.292a.077.077 0 0 1-.006.127a12.299 12.299 0 0 1-1.873.892a.077.077 0 0 0-.041.107c.36.698.772 1.362 1.225 1.993a.076.076 0 0 0 .084.028a19.839 19.839 0 0 0 6.002-3.03a.077.077 0 0 0 .032-.054c.5-5.177-.838-9.674-3.549-13.66a.061.061 0 0 0-.031-.03zM8.02 15.33c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.956-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.956 2.418-2.157 2.418zm7.975 0c-1.183 0-2.157-1.085-2.157-2.419c0-1.333.955-2.419 2.157-2.419c1.21 0 2.176 1.096 2.157 2.42c0 1.333-.946 2.418-2.157 2.418z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="md:col-span-2">
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-8">
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/50 rounded-lg flex items-start" role="alert">
                        <svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h4 class="font-semibold text-green-500 mb-1">Message Sent!</h4>
                            <p class="text-green-400 text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('contact.store') }}" 
                          method="POST" 
                          class="space-y-6" 
                          @submit="handleSubmit($event)"
                          novalidate>
                        @csrf

                        <!-- Honeypot field (hidden from users, visible to bots) -->
                        <input type="text" 
                               name="website" 
                               tabindex="-1" 
                               autocomplete="off" 
                               style="position: absolute; left: -9999px;"
                               aria-hidden="true">

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-300 mb-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Your Name <span class="text-rose-400" aria-label="required">*</span>
                                </div>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $prefilledData['name'] ?? '') }}"
                                   x-model="formData.name"
                                   @blur="validateField('name')"
                                   @input="clearError('name')"
                                   :class="errors.name ? 'border-rose-500' : (validatedFields.name ? 'border-green-500' : 'border-slate-700')"
                                   class="w-full px-4 py-3 bg-slate-800 border rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="John Doe"
                                   required
                                   minlength="2"
                                   maxlength="255"
                                   aria-required="true"
                                   :aria-invalid="errors.name ? 'true' : 'false'"
                                   :aria-describedby="errors.name ? 'name-error' : null">
                            <div x-show="errors.name" 
                                 x-transition
                                 id="name-error"
                                 class="mt-2 text-sm text-rose-400 flex items-center gap-1"
                                 role="alert"
                                 style="display: none;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span x-text="errors.name"></span>
                            </div>
                            @error('name')
                            <p class="mt-2 text-sm text-rose-400 flex items-center gap-1" id="name-error" role="alert">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-300 mb-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Email Address <span class="text-rose-400" aria-label="required">*</span>
                                </div>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $prefilledData['email'] ?? '') }}"
                                   x-model="formData.email"
                                   @blur="validateField('email')"
                                   @input="clearError('email')"
                                   :class="errors.email ? 'border-rose-500' : (validatedFields.email ? 'border-green-500' : 'border-slate-700')"
                                   class="w-full px-4 py-3 bg-slate-800 border rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                                   placeholder="john@example.com"
                                   required
                                   maxlength="255"
                                   aria-required="true"
                                   :aria-invalid="errors.email ? 'true' : 'false'"
                                   :aria-describedby="errors.email ? 'email-error' : null">
                            <div x-show="errors.email" 
                                 x-transition
                                 id="email-error"
                                 class="mt-2 text-sm text-rose-400 flex items-center gap-1"
                                 role="alert"
                                 style="display: none;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span x-text="errors.email"></span>
                            </div>
                            @error('email')
                            <p class="mt-2 text-sm text-rose-400 flex items-center gap-1" id="email-error" role="alert">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-slate-300 mb-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    Subject <span class="text-rose-400" aria-label="required">*</span>
                                </div>
                            </label>
                            <div x-data="{ 
                                showCustom: false,
                                selectedValue: '{{ old('subject', '') }}',
                                init() {
                                    const predefinedOptions = ['General Inquiry', 'Technical Support', 'Account Issue', 'Bug Report', 'Feature Request', 'Other'];
                                    if (this.selectedValue && !predefinedOptions.includes(this.selectedValue)) {
                                        this.showCustom = true;
                                    } else if (this.selectedValue === 'Other') {
                                        this.showCustom = true;
                                        this.selectedValue = '';
                                    }
                                }
                            }">
                                <div class="relative" x-show="!showCustom">
                                    <select id="subject" 
                                            name="subject" 
                                            x-model="selectedValue"
                                            @change="showCustom = $event.target.value === 'Other'; if (showCustom) { selectedValue = ''; } $dispatch('update-subject', selectedValue)"
                                            :required="!showCustom"
                                            :disabled="showCustom"
                                            class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('subject') border-rose-500 @enderror appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                            aria-required="true"
                                            aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}"
                                            aria-describedby="{{ $errors->has('subject') ? 'subject-error' : null }}">
                                        <option value="" disabled>Select a subject...</option>
                                        <option value="General Inquiry" {{ old('subject') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="Technical Support" {{ old('subject') == 'Technical Support' ? 'selected' : '' }}>Technical Support</option>
                                        <option value="Account Issue" {{ old('subject') == 'Account Issue' ? 'selected' : '' }}>Account Issue</option>
                                        <option value="Bug Report" {{ old('subject') == 'Bug Report' ? 'selected' : '' }}>Bug Report</option>
                                        <option value="Feature Request" {{ old('subject') == 'Feature Request' ? 'selected' : '' }}>Feature Request</option>
                                        <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                                <div x-show="showCustom" 
                                     x-transition
                                     style="display: none;">
                                    <input type="text" 
                                           id="subject_custom" 
                                           name="subject" 
                                           x-model="selectedValue"
                                           value="{{ old('subject') }}"
                                           required
                                           minlength="3"
                                           maxlength="255"
                                           placeholder="Enter custom subject..."
                                           class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 @error('subject') border-rose-500 @enderror"
                                           aria-required="true"
                                           aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}"
                                           aria-describedby="{{ $errors->has('subject') ? 'subject-error' : null }}">
                                </div>
                            </div>
                            @error('subject')
                            <p class="mt-2 text-sm text-rose-400 flex items-center gap-1" id="subject-error" role="alert">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-slate-300 mb-2">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Message <span class="text-rose-400" aria-label="required">*</span>
                                    </div>
                                    <span class="text-xs text-slate-500" 
                                          :class="messageLength > maxLength * 0.9 ? 'text-yellow-400' : (messageLength >= maxLength ? 'text-rose-400' : '')">
                                        <span x-text="messageLength"></span> / <span x-text="maxLength"></span> characters
                                    </span>
                                </div>
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="6"
                                      x-model="formData.message"
                                      @input="updateLength(); clearError('message')"
                                      @blur="validateField('message')"
                                      maxlength="2000"
                                      :class="errors.message ? 'border-rose-500' : (validatedFields.message ? 'border-green-500' : 'border-slate-700')"
                                      class="w-full px-4 py-3 bg-slate-800 border rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 resize-none"
                                      placeholder="Tell us what's on your mind... (min 10, max 2000 characters)"
                                      required
                                      minlength="10"
                                      aria-required="true"
                                      :aria-invalid="errors.message ? 'true' : 'false'"
                                      :aria-describedby="errors.message ? 'message-error' : 'message-counter'">{{ old('message') }}</textarea>
                            <div class="flex items-center justify-between mt-1">
                                <div x-show="errors.message" 
                                     x-transition
                                     id="message-error"
                                     class="text-sm text-rose-400 flex items-center gap-1"
                                     role="alert"
                                     style="display: none;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span x-text="errors.message"></span>
                                </div>
                                <span id="message-counter" class="text-xs text-slate-500" aria-live="polite"></span>
                            </div>
                            @error('message')
                            <p class="mt-2 text-sm text-rose-400 flex items-center gap-1" id="message-error" role="alert">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between pt-4">
                            <p class="text-sm text-slate-400">
                                <span class="text-rose-400" aria-label="required">*</span> Required fields
                            </p>
                            <button type="submit" 
                                    :disabled="loading || submitting"
                                    class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-rose-600 hover:from-indigo-500 hover:to-rose-500 disabled:opacity-50 disabled:cursor-not-allowed rounded-xl text-white font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg flex items-center gap-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-slate-800 min-h-[44px]"
                                    aria-busy="loading || submitting">
                                <svg x-show="!loading && !submitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                </svg>
                                <svg x-show="loading || submitting" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span x-text="(loading || submitting) ? 'Sending...' : 'Send Message'"></span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Additional Info -->
                <div class="mt-6 space-y-4">
                    <div class="p-4 bg-indigo-500/10 border border-indigo-500/30 rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-indigo-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-indigo-300 mb-1">Response Time</p>
                                <p class="text-xs text-indigo-400">We typically respond within 24-48 hours during business days.</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-green-500/10 border border-green-500/30 rounded-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <div>
                                <p class="text-sm font-semibold text-green-300 mb-1">Secure & Private</p>
                                <p class="text-xs text-green-400">Your information is encrypted and kept confidential.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function contactForm() {
    return {
        loading: false,
        submitting: false,
        messageLength: {{ old('message', '') ? strlen(old('message')) : 0 }},
        maxLength: 2000,
        formData: {
            name: '{{ old('name', $prefilledData['name'] ?? '') }}',
            email: '{{ old('email', $prefilledData['email'] ?? '') }}',
            subject: '{{ old('subject', '') }}',
            message: '{{ old('message', '') }}',
        },
        errors: {},
        validatedFields: {},
        
        init() {
            // Initialize message length
            this.updateLength();
        },
        
        updateLength() {
            const messageEl = document.getElementById('message');
            if (messageEl) {
                this.messageLength = messageEl.value.length;
            }
        },
        
        validateField(field) {
            const fieldMap = {
                'name': { min: 2, max: 255, required: true },
                'email': { type: 'email', max: 255, required: true },
                'subject': { min: 3, max: 255, required: true },
                'message': { min: 10, max: 2000, required: true },
            };
            
            const rules = fieldMap[field];
            if (!rules) return;
            
            const value = this.formData[field] || document.getElementById(field)?.value || '';
            delete this.errors[field];
            delete this.validatedFields[field];
            
            if (rules.required && !value.trim()) {
                this.errors[field] = `${field.charAt(0).toUpperCase() + field.slice(1)} is required.`;
                return false;
            }
            
            if (rules.min && value.length < rules.min) {
                this.errors[field] = `${field.charAt(0).toUpperCase() + field.slice(1)} must be at least ${rules.min} characters.`;
                return false;
            }
            
            if (rules.max && value.length > rules.max) {
                this.errors[field] = `${field.charAt(0).toUpperCase() + field.slice(1)} cannot exceed ${rules.max} characters.`;
                return false;
            }
            
            if (rules.type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    this.errors[field] = 'Please enter a valid email address.';
                    return false;
                }
            }
            
            this.validatedFields[field] = true;
            return true;
        },
        
        clearError(field) {
            delete this.errors[field];
        },
        
        handleSubmit(event) {
            // Validate all fields first
            const fields = ['name', 'email', 'subject', 'message'];
            let isValid = true;
            
            fields.forEach(field => {
                if (!this.validateField(field)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                // Focus first error field
                const firstErrorField = fields.find(f => this.errors[f]);
                if (firstErrorField) {
                    document.getElementById(firstErrorField)?.focus();
                }
                event.preventDefault();
                return false;
            }
            
            // Prevent double submission
            if (this.submitting) {
                event.preventDefault();
                return false;
            }
            
            // Set loading state
            this.submitting = true;
            this.loading = true;
            
            // Allow normal form submission - this ensures CSRF token is properly sent
            // The form will submit normally, maintaining the session
            // We just prevent default if validation fails
            return true;
        }
    }
}
</script>
@endsection
