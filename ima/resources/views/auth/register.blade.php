<!-- resources/views/auth/register.blade.php -->
<x-guest-layout>
    <div class="flex min-h-screen">
        <!-- Section de gauche avec image et texte de bienvenue -->
        <div class="hidden lg:flex lg:w-1/2 bg-[#4CA3DD] flex-col justify-center items-center px-12 relative overflow-hidden">
            <!-- Forme décorative -->
            <div class="absolute top-0 right-0 transform translate-x-1/4 -translate-y-1/4 w-96 h-96 rounded-full bg-[#2A7AB8] opacity-30"></div>
            <div class="absolute bottom-0 left-0 transform -translate-x-1/4 translate-y-1/4 w-96 h-96 rounded-full bg-[#2A7AB8] opacity-30"></div>

            <div class="relative z-10 max-w-md text-center">
                <!-- Logo -->
                <img class="mx-auto h-32 w-auto mb-6" src="{{ asset('logo-icorp-white.png') }}" alt="IMA-ICORP"
                     onerror="this.src='https://via.placeholder.com/150x150?text=IMA-ICORP';this.classList.add('border','border-white','rounded-full','p-2')">

                <h1 class="text-3xl font-bold text-white mb-4">Bienvenue sur IMA</h1>
                <p class="text-white/90 text-lg mb-6">Rejoignez notre communauté éducative et accédez à une gestion optimisée de votre parcours.</p>

                <div class="flex flex-col space-y-4 mt-8">
                    <div class="flex items-center text-white">
                        <div class="bg-white/20 rounded-full p-2 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span>Interface intuitive et adaptée</span>
                    </div>
                    <div class="flex items-center text-white">
                        <div class="bg-white/20 rounded-full p-2 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span>Communication simplifiée entre tous les acteurs</span>
                    </div>
                    <div class="flex items-center text-white">
                        <div class="bg-white/20 rounded-full p-2 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span>Suivi personnalisé de votre parcours</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section de droite avec le formulaire -->
        <div class="w-full lg:w-1/2 bg-[#F8FAFC] flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <!-- Notification de succès (cachée par défaut) -->
                <div id="success-notification" class="hidden mb-6 bg-[#34D399]/10 border border-[#34D399] text-[#1E293B] rounded-lg p-4 flex items-start">
                    <div class="flex-shrink-0 mr-3">
                        <svg class="h-5 w-5 text-[#34D399]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">Inscription réussie!</p>
                        <p class="text-sm">Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.</p>
                    </div>
                    <button type="button" class="ml-auto" onclick="document.getElementById('success-notification').classList.add('hidden')">
                        <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <!-- En-tête du formulaire -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-[#1E293B]">{{ __('Créer un compte') }}</h2>
                    <p class="text-[#64748B] mt-2">Rejoignez-nous pour accéder à tous nos services</p>
                </div>

                <form class="space-y-5" method="POST" action="{{ route('register', ['locale' => app()->getLocale()]) }}" id="registrationForm">
                    @csrf

                    <!-- Informations personnelles -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Prénom -->
                        <div>
                            <x-input-label for="first_name" :value="__('Prénom')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                            <div class="relative rounded-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <x-text-input id="first_name" class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                              type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" placeholder="John" />
                            </div>
                            <x-input-error :messages="$errors->get('first_name')" class="mt-1 text-sm text-[#F87171]" />
                        </div>

                        <!-- Nom -->
                        <div>
                            <x-input-label for="last_name" :value="__('Nom')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                            <div class="relative rounded-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <x-text-input id="last_name" class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                              type="text" name="last_name" :value="old('last_name')" required autocomplete="last_name" placeholder="Doe" />
                            </div>
                            <x-input-error :messages="$errors->get('last_name')" class="mt-1 text-sm text-[#F87171]" />
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                        <div class="relative rounded-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <x-text-input id="email" class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                          type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="exemple@email.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-[#F87171]" />
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <x-input-label for="phone_number" :value="__('Téléphone')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                        <div class="relative rounded-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <x-text-input id="phone_number" class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                          type="tel" name="phone_number" :value="old('phone_number')" required placeholder="+237 XXX XXX XXX" />
                        </div>
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-1 text-sm text-[#F87171]" />
                    </div>

                    <!-- Double sélection: Ville et Type de compte -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Ville -->
                        <div>
                            <x-input-label for="city_id" :value="__('Ville')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                            <div class="relative rounded-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <select id="city_id" name="city_id" class="block w-full pl-10 pr-10 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B] appearance-none">
                                    <option value="">{{ __('Sélectionnez une ville') }}</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('city_id')" class="mt-1 text-sm text-[#F87171]" />
                        </div>

                        <!-- Type de compte -->
                        <div>
                            <x-input-label for="account_type" :value="__('Type de compte')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                            <div class="relative rounded-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                </div>
                                <select id="account_type" name="account_type" class="block w-full pl-10 pr-10 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B] appearance-none" required>
                                    <option value="">{{ __('Type de compte') }}</option>
                                    <option value="eleve" {{ old('account_type') == 'eleve' ? 'selected' : '' }}>{{ __('Élève') }}</option>
                                    <option value="enseignant" {{ old('account_type') == 'enseignant' ? 'selected' : '' }}>{{ __('Enseignant') }}</option>
                                    <option value="parent" {{ old('account_type') == 'parent' ? 'selected' : '' }}>{{ __('Parent') }}</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('account_type')" class="mt-1 text-sm text-[#F87171]" />
                        </div>
                    </div>

                    <!-- Mot de passe -->
                    <div>
                        <x-input-label for="password" :value="__('Mot de passe')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                        <div class="relative rounded-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <x-text-input id="password" class="block w-full pl-10 pr-12 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                          type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none toggle-password" data-target="password">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B] show-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B] hide-icon hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-[#F87171]" />
                        <p class="text-xs text-[#64748B] mt-1">8 caractères minimum, incluant majuscules, minuscules et chiffres</p>
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                        <div class="relative rounded-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <x-text-input id="password_confirmation" class="block w-full pl-10 pr-12 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                          type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none toggle-password" data-target="password_confirmation">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B] show-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B] hide-icon hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-sm text-[#F87171]" />
                    </div>

                    <!-- Conditions d'utilisation -->
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" class="h-4 w-4 rounded border-[#E2E8F0] text-[#4CA3DD] focus:ring-[#4CA3DD]" required>
                        <label for="terms" class="ml-2 block text-sm text-[#64748B]">
                            {{ __('J\'accepte les') }}
                            <button type="button" id="terms-button" class="font-medium text-[#2A7AB8] hover:underline focus:outline-none cursor-pointer">
                                {{ __('conditions d\'utilisation') }}
                            </button>
                        </label>
                    </div>

                    <!-- Bouton d'inscription -->
                    <div>
                        <button type="submit" class="w-full flex justify-center items-center px-4 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] rounded-lg font-semibold text-white transition duration-150 ease-in-out shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            {{ __('S\'inscrire') }}
                        </button>
                    </div>

                    <!-- Lien vers connexion -->
                    <div class="text-center mt-6">
                        <p class="text-sm text-[#64748B]">
                            {{ __('Déjà inscrit?') }}
                            <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="font-medium text-[#2A7AB8] hover:underline">
                                {{ __('Se connecter') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Conditions d'utilisation -->
    <div id="terms-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-modal="true" role="dialog">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Espace pour centrer le modal -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal Content -->
            <div id="terms-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-modal="true" role="dialog" style="display: none; background-color: rgba(0,0,0,0.5);">
                <div class="bg-white dark:bg-[#1E293B] px-6 pt-5 pb-4 sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg leading-6 font-medium text-[#1E293B] dark:text-[#F1F5F9]" id="modal-title">
                                    Conditions d'Utilisation
                                </h3>
                                <button id="close-terms-modal" type="button" class="text-[#64748B] hover:text-[#1E293B] dark:hover:text-white focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-2 max-h-[60vh] overflow-y-auto pr-4 text-[#1E293B] dark:text-[#F1F5F9]">
                                <h4 class="font-semibold mb-2">1. Acceptation des Conditions</h4>
                                <p class="text-sm text-[#64748B] dark:text-[#94A3B8] mb-4">
                                    En créant un compte sur la plateforme IMA-ICORP, vous acceptez pleinement et sans réserve l'ensemble des conditions décrites ci-dessous.
                                </p>

                                <h4 class="font-semibold mb-2">2. Utilisation de la Plateforme</h4>
                                <p class="text-sm text-[#64748B] dark:text-[#94A3B8] mb-4">
                                    La plateforme IMA-ICORP est destinée uniquement à la gestion académique et administrative. Tout usage frauduleux ou contraire à son objet sera passible de sanctions.
                                </p>

                                <h4 class="font-semibold mb-2">3. Protection des Données Personnelles</h4>
                                <p class="text-sm text-[#64748B] dark:text-[#94A3B8] mb-4">
                                    Vos données personnelles sont protégées conformément à la législation en vigueur. Vous disposez d'un droit d'accès, de modification et de suppression de vos informations.
                                </p>

                                <h4 class="font-semibold mb-2">4. Confidentialité</h4>
                                <p class="text-sm text-[#64748B] dark:text-[#94A3B8] mb-4">
                                    Les informations partagées sur la plateforme sont strictement confidentielles. Toute divulgation non autorisée est interdite et passible de poursuites.
                                </p>

                                <h4 class="font-semibold mb-2">5. Responsabilité</h4>
                                <p class="text-sm text-[#64748B] dark:text-[#94A3B8] mb-4">
                                    IMA-ICORP ne peut être tenu responsable des utilisations abusives de la plateforme par un utilisateur.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-[#EEF2F7] dark:bg-[#2C3E50] px-6 py-4 sm:flex sm:flex-row-reverse">
                    <button id="accept-terms" type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-[#4CA3DD] text-base font-medium text-white hover:bg-[#2A7AB8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] sm:ml-3 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
                        J'accepte
                    </button>
                    <button id="close-terms-modal-bottom" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-[#E2E8F0] dark:border-[#475569] shadow-sm px-4 py-2 bg-white dark:bg-[#2C3E50] text-base font-medium text-[#1E293B] dark:text-[#F1F5F9] hover:bg-[#EEF2F7] dark:hover:bg-[#334155] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] sm:mt-0 sm:w-auto sm:text-sm transition duration-150 ease-in-out">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Récupérer tous les éléments nécessaires
                const termsButton = document.getElementById('terms-button');
                const termsModal = document.getElementById('terms-modal');
                const termsCheckbox = document.getElementById('terms');
                const closeModalButtons = document.querySelectorAll('#close-terms-modal, #close-terms-modal-bottom');
                const acceptTermsButton = document.getElementById('accept-terms');
                const registrationForm = document.getElementById('registrationForm');
                const togglePasswordButtons = document.querySelectorAll('.toggle-password');

                // Vérifier que les éléments existent
                if (!termsButton || !termsModal) {
                    console.error('Éléments du modal introuvables');
                    return;
                }

                console.log('Modal et bouton trouvés:', termsModal, termsButton); // Debug

                // Système de basculement visibilité mot de passe
                togglePasswordButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const targetId = this.getAttribute('data-target');
                        const passwordInput = document.getElementById(targetId);
                        const showIcon = this.querySelector('.show-icon');
                        const hideIcon = this.querySelector('.hide-icon');

                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            showIcon.classList.add('hidden');
                            hideIcon.classList.remove('hidden');
                        } else {
                            passwordInput.type = 'password';
                            showIcon.classList.remove('hidden');
                            hideIcon.classList.add('hidden');
                        }
                    });
                });

                // Ouvrir la modale des conditions - ajout d'un événement plus direct
                termsButton.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Bouton terms cliqué, ouverture du modal'); // Debug
                    termsModal.style.display = 'block'; // Utilisation de style.display en plus de la classe
                    termsModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                    return false;
                };

                // Boutons de fermeture
                closeModalButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        console.log('Fermeture du modal'); // Debug
                        termsModal.style.display = 'none'; // Utilisation de style.display en plus de la classe
                        termsModal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    });
                });

                // Bouton d'acceptation
                acceptTermsButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    termsCheckbox.checked = true;
                    termsModal.style.display = 'none'; // Utilisation de style.display en plus de la classe
                    termsModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                });

                // Empêcher la soumission si les conditions ne sont pas acceptées
                registrationForm.addEventListener('submit', function(e) {
                    if (!termsCheckbox.checked) {
                        e.preventDefault();
                        // Notification d'erreur plus élégante
                        const errorNotification = document.createElement('div');
                        errorNotification.className = 'mb-6 bg-[#F87171]/10 border border-[#F87171] text-[#1E293B] rounded-lg p-4 flex items-start';
                        errorNotification.innerHTML = `
                    <div class="flex-shrink-0 mr-3">
                        <svg class="h-5 w-5 text-[#F87171]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium">Vous devez accepter les conditions d'utilisation</p>
                    </div>
                    <button type="button" class="ml-auto" onclick="this.parentElement.remove()">
                        <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;

                        if (!document.querySelector(".bg-[#F87171]")) {
                            registrationForm.insertBefore(errorNotification, registrationForm.firstChild);
                        }

                        // Ouvrir la modale des conditions
                        console.log('Ouverture forcée du modal depuis la validation'); // Debug
                        termsModal.style.display = 'block'; // Utilisation de style.display en plus de la classe
                        termsModal.classList.remove('hidden');
                        document.body.classList.add('overflow-hidden');
                    }
                });

                // Fermer la modale en cliquant à l'extérieur
                window.addEventListener('click', function(e) {
                    if (e.target === termsModal) {
                        termsModal.style.display = 'none'; // Utilisation de style.display en plus de la classe
                        termsModal.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }
                });

                // Support du thème sombre selon les préférences du système
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.classList.add('dark');
                }

                // Écouter les changements de thème du système
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                    if (e.matches) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                });

                // Assurer que le modal puisse être ouvert via une fonction globale
                window.openTermsModal = function() {
                    console.log('Ouverture du modal via fonction globale'); // Debug
                    termsModal.style.display = 'block';
                    termsModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                };

                // Extra: assurer que le bouton est vraiment cliquable
                termsButton.style.cursor = 'pointer';
            });
        </script>
    @endpush
</x-guest-layout>
