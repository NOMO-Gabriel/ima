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

                <h1 class="text-3xl font-bold text-white mb-4">Rejoignez IMA</h1>
                <p class="text-white/90 text-lg mb-6">Inscription des élèves - Commencez votre parcours éducatif avec nous</p>

                <div class="flex flex-col space-y-4 mt-8">
                    <div class="flex items-center text-white">
                        <div class="bg-white/20 rounded-full p-2 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span>Processus d'inscription simplifié</span>
                    </div>
                    <div class="flex items-center text-white">
                        <div class="bg-white/20 rounded-full p-2 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span>Validation par notre équipe pédagogique</span>
                    </div>
                    <div class="flex items-center text-white">
                        <div class="bg-white/20 rounded-full p-2 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <span>Accès à un enseignement de qualité</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section de droite avec le formulaire -->
        <div class="w-full lg:w-1/2 bg-[#F8FAFC] flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                <!-- En-tête du formulaire -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-[#1E293B]">{{ __('Inscription Élève') }}</h2>
                    <p class="text-[#64748B] mt-2">Créez votre compte élève pour commencer</p>
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
                                <x-text-input id="first_name" class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B] uppercase"
                                              type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" placeholder="TEMGOUA" 
                                              oninput="this.value = this.value.toUpperCase()" />
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
                                <x-text-input id="last_name" class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B] uppercase"
                                              type="text" name="last_name" :value="old('last_name')" required autocomplete="last_name" placeholder="KROS" 
                                              oninput="this.value = this.value.toUpperCase()" />
                            </div>
                            <x-input-error :messages="$errors->get('last_name')" class="mt-1 text-sm text-[#F87171]" />
                        </div>
                    </div>

                    <!-- Genre -->
                    <div>
                        <x-input-label for="gender" :value="__('Genre')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                        <div class="relative rounded-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                            </div>
                            <select id="gender" name="gender" class="block w-full pl-10 pr-10 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B] appearance-none" required>
                                <option value="">{{ __('Sélectionnez votre genre') }}</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('Masculin') }}</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('Féminin') }}</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('gender')" class="mt-1 text-sm text-[#F87171]" />
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

                    <!-- Téléphones -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Téléphone élève -->
                        <div>
                            <x-input-label for="phone_number" :value="__('Votre téléphone')" class="block text-sm font-medium text-[#1E293B] mb-1" />
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

                        <!-- Téléphone parent -->
                        <div>
                            <x-input-label for="parent_phone_number" :value="__('Téléphone parent (optionnel)')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                            <div class="relative rounded-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <x-text-input id="parent_phone_number" class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                              type="tel" name="parent_phone_number" :value="old('parent_phone_number')" placeholder="+237 XXX XXX XXX" />
                            </div>
                            <x-input-error :messages="$errors->get('parent_phone_number')" class="mt-1 text-sm text-[#F87171]" />
                        </div>
                    </div>

                    <!-- Localisation -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Ville -->
                        <div>
                            <x-input-label for="city_id" :value="__('Ville')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                            <div class="relative rounded-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <select id="city_id" name="city_id" class="block w-full pl-10 pr-10 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B] appearance-none" required>
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

                        <!-- Centre -->
                        <div>
                            <x-input-label for="center_id" :value="__('Centre souhaité (optionnel)')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                            <div class="relative rounded-md">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <select id="center_id" name="center_id" class="block w-full pl-10 pr-10 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B] appearance-none">
                                    <option value="">{{ __('Choisissez un centre (optionnel)') }}</option>
                                    @foreach($centers as $center)
                                        <option value="{{ $center->id }}" data-city="{{ $center->city_id }}" {{ old('center_id') == $center->id ? 'selected' : '' }}>
                                            {{ $center->name }} - {{ $center->city->name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('center_id')" class="mt-1 text-sm text-[#F87171]" />
                        </div>
                    </div>

                    <!-- Adresse -->
                    <div>
                        <x-input-label for="address" :value="__('Adresse')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                        <div class="relative rounded-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <x-text-input id="address" class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                          type="text" name="address" :value="old('address', 'Cradat')" required placeholder="Quartier, rue..." />
                        </div>
                        <x-input-error :messages="$errors->get('address')" class="mt-1 text-sm text-[#F87171]" />
                    </div>

                    <!-- Établissement d'origine -->
                    <div>
                        <x-input-label for="establishment" :value="__('Établissement d\'origine')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                        <div class="relative rounded-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <x-text-input id="establishment" class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                          type="text" name="establishment" :value="old('establishment')" required placeholder="Ex: Lycée de Cradat, Université de Yaoundé..." />
                        </div>
                        <x-input-error :messages="$errors->get('establishment')" class="mt-1 text-sm text-[#F87171]" />
                    </div>

                    <!-- Mots de passe -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                    </div>

                    <!-- Information sur le processus -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Processus d'inscription</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <p>Après votre inscription, votre compte sera en attente de validation. La responsable financière de votre centre vous contactera pour compléter votre dossier avec les informations sur vos concours et votre contrat.</p>
                                </div>
                            </div>
                        </div>
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
                            {{ __('Créer mon compte élève') }}
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

   @push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Système de basculement visibilité mot de passe
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        
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

        // Gestion bidirectionnelle ville <-> centre
        const citySelect = document.getElementById('city_id');
        const centerSelect = document.getElementById('center_id');
        
        // Stocker toutes les options de centre initiales
        // Important: cloner les options pour ne pas manipuler les originaux qui pourraient être retirés du DOM
        const allCenterOptions = Array.from(centerSelect.options).map(opt => opt.cloneNode(true));

        // Fonction pour filtrer les centres par ville
        function filterCentersByCity(selectedCityId, preserveSelectedCenterId = null) {
            const previouslySelectedCenter = preserveSelectedCenterId || centerSelect.value;
            
            // Vider le select des centres, en gardant la première option (placeholder)
            while (centerSelect.options.length > 1) {
                centerSelect.remove(1);
            }
            centerSelect.value = ""; // Réinitialiser la sélection

            if (selectedCityId) {
                allCenterOptions.forEach(option => {
                    if (option.value === "") return; // Ne pas rajouter le placeholder
                    if (option.dataset.city === selectedCityId) {
                        centerSelect.appendChild(option.cloneNode(true));
                    }
                });
            } else { // Si aucune ville sélectionnée, afficher tous les centres (sauf le placeholder global)
                allCenterOptions.forEach(option => {
                    if (option.value === "") return;
                    centerSelect.appendChild(option.cloneNode(true));
                });
            }
            
            // Restaurer la sélection du centre si possible
            if (previouslySelectedCenter && centerSelect.querySelector(`option[value="${previouslySelectedCenter}"]`)) {
                 centerSelect.value = previouslySelectedCenter;
            } else if (centerSelect.options.length > 1 && !selectedCityId) {
                // Si aucune ville n'est sélectionnée et qu'il y a des centres,
                // on ne veut pas forcément sélectionner le premier. Laisser le placeholder.
            } else if (centerSelect.options.length > 1 && selectedCityId) {
                // Si une ville est sélectionnée et qu'il y a des centres pour cette ville,
                // mais que le centre précédemment sélectionné n'est pas dans cette ville,
                // on laisse le placeholder.
            }
        }
        
        // Fonction pour mettre à jour la ville en fonction du centre sélectionné
        function updateCityFromCenter(selectedCenterId) {
            if (selectedCenterId) {
                const selectedCenterOption = allCenterOptions.find(option => option.value === selectedCenterId);
                if (selectedCenterOption && selectedCenterOption.dataset.city) {
                    const cityIdForSelectedCenter = selectedCenterOption.dataset.city;
                    
                    // Mettre à jour la ville sans déclencher l'événement 'change' sur citySelect pour éviter une boucle
                    if (citySelect.value !== cityIdForSelectedCenter) {
                        citySelect.value = cityIdForSelectedCenter;
                        // Il faut maintenant re-filtrer les centres pour la ville qui vient d'être mise à jour
                        // et s'assurer que le centre initialement sélectionné reste sélectionné.
                        filterCentersByCity(cityIdForSelectedCenter, selectedCenterId);
                    } else {
                        // La ville est déjà correcte, on s'assure juste que la liste des centres est bien filtrée
                        // et que le centre est sélectionné.
                         filterCentersByCity(cityIdForSelectedCenter, selectedCenterId);
                    }
                    // S'assurer que le centre est bien sélectionné après le filtrage
                    centerSelect.value = selectedCenterId;
                }
            } else {
                // Si aucun centre n'est sélectionné, on ne change pas la ville,
                // mais on s'assure que la liste des centres correspond à la ville actuellement sélectionnée (ou tous si aucune ville)
                filterCentersByCity(citySelect.value);
            }
        }
        
        // Événement quand la ville change
        citySelect.addEventListener('change', function() {
            filterCentersByCity(this.value);
        });
        
        // Événement quand le centre change
        centerSelect.addEventListener('change', function() {
            updateCityFromCenter(this.value);
        });

        // --- Initialisation améliorée au chargement de la page ---
        const initialCityValue = citySelect.value; // Valeur de old('city_id') ou ""
        const initialCenterValue = centerSelect.value; // Valeur de old('center_id') ou ""

        if (initialCenterValue) {
            // Si un centre est pré-sélectionné (ex: old('center_id')),
            // la ville doit correspondre à ce centre, et la liste des centres filtrée.
            updateCityFromCenter(initialCenterValue);
        } else if (initialCityValue) {
            // Si seulement une ville est pré-sélectionnée (ex: old('city_id') sans old('center_id')),
            // filtrer les centres pour cette ville. Le select de centre sera sur son placeholder.
            filterCentersByCity(initialCityValue);
        } else {
            // Aucune ville ou centre pré-sélectionné (nouvelle page).
            // Afficher tous les centres (ou laisser vide selon la logique de filterCentersByCity(null))
            // Par défaut, la fonction filterCentersByCity avec null/"" va afficher tous les centres
            // après le placeholder, ce qui est généralement souhaité.
            filterCentersByCity(null);
        }
        
        // Gestion du modal des conditions d'utilisation
        const termsButton = document.getElementById('terms-button');
        if (termsButton) {
            termsButton.addEventListener('click', function() {
                alert('Ici s\'afficheraient les conditions d\'utilisation dans un modal.');
            });
        }
    });
</script>
@endpush
</x-guest-layout>