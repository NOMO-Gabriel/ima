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

                <form class="space-y-6" method="POST" action="{{ route('register') }}" id="registrationForm">
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
                        
                        <!-- Type de compte -->
                        <div>
                            <x-input-label for="account_type" :value="__('Type de compte')" class="block text-sm font-medium text-gray-700" />
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user-tag text-gray-400"></i>
                                </div>
                                <select id="account_type" name="account_type" class="block w-full pl-10 pr-3 py-2 rounded-md border border-gray-300 focus:ring-blue-500 focus:border-blue-500" required>
                                    <option value="">-- Sélectionnez un type de compte --</option>
                                    <option value="Eleve" {{ old('account_type') == 'Eleve' ? 'selected' : '' }}>Élève</option>
                                    <option value="Enseignant" {{ old('account_type') == 'Enseignant' ? 'selected' : '' }}>Enseignant</option>
                                    <option value="Parent" {{ old('account_type') == 'Parent' ? 'selected' : '' }}>Parent</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('account_type')" class="mt-2 text-sm text-red-600" />
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
                            {{ __('J\'accepte les') }}
                            <button type="button" id="terms-button" class="font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:underline">
                                {{ __('conditions d\'utilisation') }}
                            </button>
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
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Conditions d'Utilisation
                                </h3>
                                <button id="close-terms-modal" type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="mt-2 max-h-[60vh] overflow-y-auto pr-4">
                                <h4 class="font-semibold mb-2">1. Acceptation des Conditions</h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    En créant un compte sur la plateforme IMA-ICORP, vous acceptez pleinement et sans réserve l'ensemble des conditions décrites ci-dessous.
                                </p>

                                <h4 class="font-semibold mb-2">2. Utilisation de la Plateforme</h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    La plateforme IMA-ICORP est destinée uniquement à la gestion académique et administrative. Tout usage frauduleux ou contraire à son objet sera passible de sanctions.
                                </p>

                                <h4 class="font-semibold mb-2">3. Protection des Données Personnelles</h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    Vos données personnelles sont protégées conformément à la législation en vigueur. Vous disposez d'un droit d'accès, de modification et de suppression de vos informations.
                                </p>

                                <h4 class="font-semibold mb-2">4. Confidentialité</h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    Les informations partagées sur la plateforme sont strictement confidentielles. Toute divulgation non autorisée est interdite et passible de poursuites.
                                </p>

                                <h4 class="font-semibold mb-2">5. Responsabilité</h4>
                                <p class="text-sm text-gray-600 mb-4">
                                    IMA-ICORP ne peut être tenu responsable des utilisations abusives de la plateforme par un utilisateur.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button id="accept-terms" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        J'accepte
                    </button>
                    <button id="close-terms-modal-bottom" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            const termsButton = document.getElementById('terms-button');
            const termsModal = document.getElementById('terms-modal');
            const termsCheckbox = document.getElementById('terms');
            const closeModalButtons = document.querySelectorAll('#close-terms-modal, #close-terms-modal-bottom');
            const acceptTermsButton = document.getElementById('accept-terms');
            const registrationForm = document.getElementById('registrationForm');

            // Ouvrir la modale des conditions
            termsButton.addEventListener('click', function(e) {
                e.preventDefault();
                termsModal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            });

            // Boutons de fermeture
            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    termsModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    // Décocher la case si l'utilisateur ferme sans accepter
                    termsCheckbox.checked = false;
                });
            });

            // Bouton d'acceptation
            acceptTermsButton.addEventListener('click', function() {
                termsCheckbox.checked = true;
                termsModal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            });

            // Empêcher la soumission si les conditions ne sont pas acceptées
            registrationForm.addEventListener('submit', function(e) {
                if (!termsCheckbox.checked) {
                    e.preventDefault();
                    alert('Veuillez accepter les conditions d\'utilisation avant de continuer.');
                    termsModal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                }
            });

            // Fermer la modale en cliquant à l'extérieur
            termsModal.addEventListener('click', function(e) {
                if (e.target === termsModal) {
                    termsModal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    termsCheckbox.checked = false;
                }
            });
        });
    </script>
    @endpush
</x-guest-layout>