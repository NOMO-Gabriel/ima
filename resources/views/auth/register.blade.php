<!-- resources/views/auth/register.blade.php -->
<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-lg">
            <!-- Logo avec arrière-plan bleu -->
            <div class="bg-blue-600 py-6 px-4 rounded-t-lg text-center">
                <img class="mx-auto h-24 w-auto" src="{{ asset('logo-icorp-white.png') }}" alt="IMA-ICORP" 
                     onerror="this.src='https://via.placeholder.com/150x80?text=IMA-ICORP';this.classList.add('border','border-white','rounded')">
                <h2 class="mt-4 text-xl font-bold text-white">
                    ICORP MANAGEMENT APPLICATION
                </h2>
            </div>
            
            <!-- Titre du formulaire -->
            <div class="bg-white px-6 py-6 rounded-b-lg border-x border-b border-gray-200 shadow-lg">
                <h2 class="text-center text-2xl font-bold text-gray-900 mb-6">
                    {{ __('Créer un compte') }}
                </h2>

                <form class="space-y-6" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Informations personnelles -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Prénom -->
                        <div>
                            <x-input-label for="first_name" :value="__('Prénom')" class="block text-sm font-medium text-gray-700" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <x-text-input id="first_name" class="block w-full pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
                                    type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                            </div>
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <!-- Nom -->
                        <div>
                            <x-input-label for="last_name" :value="__('Nom')" class="block text-sm font-medium text-gray-700" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <x-text-input id="last_name" class="block w-full pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
                                    type="text" name="last_name" :value="old('last_name')" required autocomplete="last_name" />
                            </div>
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2 text-sm text-red-600" />
                        </div>
                    </div>

                    <!-- Coordonnées -->
                    <div class="space-y-4">
                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <x-text-input id="email" class="block w-full pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
                                    type="email" name="email" :value="old('email')" required autocomplete="username" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <x-input-label for="phone_number" :value="__('Téléphone')" class="block text-sm font-medium text-gray-700" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-gray-400"></i>
                                </div>
                                <x-text-input id="phone_number" class="block w-full pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
                                    type="tel" name="phone_number" :value="old('phone_number')" required />
                            </div>
                            <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <!-- Ville -->
                        <div>
                            <x-input-label for="city" :value="__('Ville')" class="block text-sm font-medium text-gray-700" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-city text-gray-400"></i>
                                </div>
                                <x-text-input id="city" class="block w-full pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500" 
                                    type="text" name="city" :value="old('city')" />
                            </div>
                            <x-input-error :messages="$errors->get('city')" class="mt-2 text-sm text-red-600" />
                        </div>
                    </div>

                    <!-- Sécurité -->
                    <div class="space-y-4">
                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Mot de passe')" class="block text-sm font-medium text-gray-700" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <x-text-input id="password" class="block w-full pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                          type="password"
                                          name="password"
                                          required autocomplete="new-password" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="block text-sm font-medium text-gray-700" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <x-text-input id="password_confirmation" class="block w-full pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                          type="password"
                                          name="password_confirmation" required autocomplete="new-password" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
                        </div>
                    </div>

                    <!-- Conditions d'utilisation -->
                    <div class="flex items-center">
                        <input id="terms" name="terms" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" required>
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            {{ __('J\'accepte les') }} <a href="#" class="font-medium text-blue-600 hover:text-blue-500">{{ __('conditions d\'utilisation') }}</a>
                        </label>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            <i class="fas fa-user-plus mr-2"></i>
                            {{ __('S\'inscrire') }}
                        </button>
                    </div>
                </form>

                <p class="mt-6 text-center text-sm text-gray-600">
                    {{ __('Déjà inscrit?') }}
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                        {{ __('Se connecter') }}
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>