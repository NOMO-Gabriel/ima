@extends('layouts.app')

@section('page_title', 'Modifier le centre')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">Tableau de bord</a>
    </div>
    <div class="breadcrumb-item">
        <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}">Centres</a>
    </div>
    <div class="breadcrumb-item active">Modifier {{ $center->name }}</div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }">
        <!-- En-tête de la page -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Modifier le centre
                    </h1>
                    <p class="mt-2 text-lg transition-colors"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        {{ $center->name }}
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.centers.show', ['locale' => app()->getLocale(), 'center' => $center]) }}"
                       class="inline-flex items-center px-4 py-2 border rounded-lg text-sm font-medium transition-all duration-200"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700 hover:text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                        <i class="fas fa-eye mr-2"></i>
                        Voir
                    </a>
                    <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center px-4 py-2 border rounded-lg text-sm font-medium transition-all duration-200"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700 hover:text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour
                    </a>
                </div>
            </div>
        </div>

        <!-- Gestion des erreurs -->
        @if ($errors->any())
            <div class="mb-6 rounded-lg border-l-4 border-red-500 p-4 shadow-sm transition-colors"
                 :class="darkMode ? 'bg-red-900/20 text-red-300' : 'bg-red-50 text-red-700'">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium">
                            {{ $errors->count() > 1 ? 'Plusieurs erreurs ont été détectées :' : 'Une erreur a été détectée :' }}
                        </h3>
                        <div class="mt-2 text-sm">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire principal -->
        @can('gestion.center.update')
        <form action="{{ route('admin.centers.update', ['locale' => app()->getLocale(), 'center' => $center]) }}"
              method="POST"
              class="space-y-8"
              x-data="{
              isSubmitting: false,
              submitForm() {
                  this.isSubmitting = true;
                  this.$el.submit();
              }
          }">
            @csrf
            @method('PUT')

            <!-- Section Informations générales -->
            <div class="rounded-xl shadow-sm transition-colors border"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="px-6 py-4 border-b transition-colors"
                     :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                    <h3 class="text-lg font-semibold flex items-center transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                        Informations générales
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Nom du centre <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $center->name) }}"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                   :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'"
                                   placeholder="Entrez le nom du centre">
                        </div>

                        <!-- Code -->
                        <div class="space-y-2">
                            <label for="code" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Code <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="code"
                                   id="code"
                                   value="{{ old('code', $center->code) }}"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                   :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'"
                                   placeholder="Code unique du centre">
                        </div>

                        <!-- Adresse -->
                        <div class="space-y-2 md:col-span-2">
                            <label for="address" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Adresse <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="address"
                                   id="address"
                                   value="{{ old('address', $center->address) }}"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                   :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'"
                                   placeholder="Adresse complète du centre">
                        </div>

                        <!-- Description -->
                        <div class="space-y-2 md:col-span-2">
                            <label for="description" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Description
                            </label>
                            <textarea name="description"
                                      id="description"
                                      rows="4"
                                      class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent resize-none"
                                      :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'"
                                      placeholder="Description du centre (optionnel)">{{ old('description', $center->description) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Contact -->
            <div class="rounded-xl shadow-sm transition-colors border"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="px-6 py-4 border-b transition-colors"
                     :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                    <h3 class="text-lg font-semibold flex items-center transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fas fa-address-card text-green-500 mr-3"></i>
                        Informations de contact
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="contact_email" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Email de contact
                            </label>
                            <input type="email"
                                   name="contact_email"
                                   id="contact_email"
                                   value="{{ old('contact_email', $center->contact_email) }}"
                                   class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                   :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'"
                                   placeholder="contact@centre.com">
                        </div>

                        <!-- Téléphone -->
                        <div class="space-y-2">
                            <label for="contact_phone" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Téléphone de contact
                            </label>
                            <input type="tel"
                                   name="contact_phone"
                                   id="contact_phone"
                                   value="{{ old('contact_phone', $center->contact_phone) }}"
                                   class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                   :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'"
                                   placeholder="+237 6XX XXX XXX">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Organisation -->
            <div class="rounded-xl shadow-sm transition-colors border"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="px-6 py-4 border-b transition-colors"
                     :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                    <h3 class="text-lg font-semibold flex items-center transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fas fa-sitemap text-purple-500 mr-3"></i>
                        Organisation et hiérarchie
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Ville -->
                        <div class="space-y-2">
                            <label for="city_id" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Ville
                            </label>
                            <select name="city_id"
                                    id="city_id"
                                    class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">-- Sélectionner une ville --</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id', $center->city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Académie -->
                        <div class="space-y-2">
                            <label for="academy_id" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Académie
                            </label>
                            <select name="academy_id"
                                    id="academy_id"
                                    class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">-- Sélectionner une académie --</option>
                                @foreach ($academies as $academy)
                                    <option value="{{ $academy->id }}" {{ old('academy_id', $center->academy_id) == $academy->id ? 'selected' : '' }}>
                                        {{ $academy->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Directeur général -->
                        <div class="space-y-2">
                            <label for="director_id" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Directeur général
                            </label>
                            <select name="director_id"
                                    id="director_id"
                                    class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">-- Sélectionner un directeur --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('director_id', $center->director_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Directeur logistique -->
                        <div class="space-y-2">
                            <label for="logistics_director_id" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Directeur logistique
                            </label>
                            <select name="logistics_director_id"
                                    id="logistics_director_id"
                                    class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">-- Sélectionner un directeur logistique --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('logistics_director_id', $center->logistics_director_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Directeur financier -->
                        <div class="space-y-2 md:col-span-2">
                            <label for="finance_director_id" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Directeur financier
                            </label>
                            <select name="finance_director_id"
                                    id="finance_director_id"
                                    class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">-- Sélectionner un directeur financier --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('finance_director_id', $center->finance_director_id) == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Statut -->
            <div class="rounded-xl shadow-sm transition-colors border"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="px-6 py-4 border-b transition-colors"
                     :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                    <h3 class="text-lg font-semibold flex items-center transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fas fa-toggle-on text-orange-500 mr-3"></i>
                        Statut d'activation
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $center->is_active) ? 'checked' : '' }}
                                   class="w-5 h-5 text-[#4CA3DD] border-2 rounded focus:ring-[#4CA3DD] focus:ring-2 transition-colors"
                                   :class="darkMode ? 'border-gray-600 bg-gray-700' : 'border-gray-300 bg-white'">
                            <span class="text-sm font-medium transition-colors"
                                  :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Centre actif
                        </span>
                        </label>
                        <p class="text-sm transition-colors"
                           :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Un centre inactif ne sera pas visible pour les nouvelles inscriptions et opérations.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t transition-colors"
                 :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex justify-center items-center px-6 py-3 border rounded-lg text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                   :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700 focus:ring-gray-500' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-[#4CA3DD]'">
                    <i class="fas fa-times mr-2"></i>
                    Annuler
                </a>

                @can('gestion.center.update')
                    <button type="button"
                            @click="submitForm()"
                            :disabled="isSubmitting"
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#4CA3DD] hover:bg-[#3A8BC8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                            :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }">
                        <i class="fas fa-save mr-2" x-show="!isSubmitting"></i>
                        <i class="fas fa-spinner fa-spin mr-2" x-show="isSubmitting"></i>
                        <span x-text="isSubmitting ? 'Mise à jour...' : 'Mettre à jour'"></span>
                    </button>
                @endcan
            </div>
        </form>
        @else
            <!-- Message d'accès refusé -->
            <div class="p-8 text-center rounded-lg border transition-colors"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569] text-white' : 'bg-white border-gray-200'">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-16 w-16 mb-4 transition-colors"
                         :class="darkMode ? 'text-red-500' : 'text-red-400'"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <p class="text-xl font-medium mb-2 transition-colors"
                       :class="darkMode ? 'text-white' : 'text-gray-800'">
                        Accès refusé
                    </p>
                    <p class="mb-6 transition-colors"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        Vous n'avez pas les permissions nécessaires pour accéder à la gestion des phases.
                    </p>
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour au tableau de bord
                    </a>
                </div>
            </div>
        @endcan
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@push('styles')
    <style>
        /* Animations personnalisées */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Style pour les sélecteurs */
        select option {
            background-color: inherit;
            color: inherit;
        }

        /* Amélioration du focus */
        input:focus, textarea:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(76, 163, 221, 0.1);
        }

        /* Style pour les labels requis */
        .required::after {
            content: ' *';
            color: #ef4444;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation d'entrée pour les sections
            const sections = document.querySelectorAll('.rounded-xl');
            sections.forEach((section, index) => {
                setTimeout(() => {
                    section.classList.add('fade-in');
                }, index * 100);
            });

            // Validation côté client
            const form = document.querySelector('form');
            const requiredFields = form.querySelectorAll('input[required], select[required]');

            requiredFields.forEach(field => {
                field.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.classList.add('border-red-500', 'ring-red-200');
                        this.classList.remove('border-gray-300', 'border-gray-600');
                    } else {
                        this.classList.remove('border-red-500', 'ring-red-200');
                        this.classList.add('border-green-500', 'ring-green-200');
                    }
                });
            });

            // Auto-validation du code (format)
            const codeField = document.getElementById('code');
            if (codeField) {
                codeField.addEventListener('input', function() {
                    // Convertir en majuscules et supprimer les espaces
                    this.value = this.value.toUpperCase().replace(/\s/g, '');
                });
            }

            // Validation de l'email
            const emailField = document.getElementById('contact_email');
            if (emailField) {
                emailField.addEventListener('blur', function() {
                    if (this.value && !this.validity.valid) {
                        this.classList.add('border-red-500');
                    } else if (this.value) {
                        this.classList.add('border-green-500');
                    }
                });
            }

            // Confirmation avant soumission
            form.addEventListener('submit', function(e) {
                const isValid = Array.from(requiredFields).every(field => field.value.trim());

                if (!isValid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires.');
                    return false;
                }
            });
        });
    </script>
@endpush
