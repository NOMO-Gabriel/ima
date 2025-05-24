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
                                <x-text-input id="first_name" class="block w-full pl-10 pr-3 py-2.5 rounded-lg border border-[#E2E8F0] focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                              type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" placeholder="TEMGOUA" />
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
                                              type="text" name="last_name" :value="old('last_name')" required autocomplete="last_name" placeholder="KROS" />
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

                    <!-- Ville -->
                    <div>
                        <x-input-label for="city_id" :value="__('Ville')" class="block text-sm font-medium text-[#1E293B] mb-1" />
                        <div class="relative rounded-md">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
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
                                    <p>Après votre inscription, votre compte sera en attente de validation. Notre équipe financière vous contactera pour compléter votre dossier avec les informations sur vos concours et votre contrat.</p>
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

    <!-- Modal Conditions d'utilisation (identique à l'original) -->
    <!-- ... (le modal reste le même) ... -->

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
            });
        </script>
    @endpush
</x-guest-layout>