@extends('layouts.app')

@section('page_title', 'Modifier le département')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">Tableau de bord</a>
    </div>
    <div class="breadcrumb-item">
        <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}">Départements</a>
    </div>
    <div class="breadcrumb-item active">Modifier {{ $department->name }}</div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark',
    isSubmitting: false,
    formChanged: false,
    originalData: {},
    currentData: {},

    initForm() {
        const form = this.$refs.departmentForm;
        this.originalData = new FormData(form);
        this.trackChanges();
    },

    trackChanges() {
        const form = this.$refs.departmentForm;
        const inputs = form.querySelectorAll('input, select, textarea');

        inputs.forEach(input => {
            input.addEventListener('input', () => {
                this.formChanged = true;
            });
        });
    },

    submitForm() {
        if (this.validateForm()) {
            this.isSubmitting = true;
            this.$refs.departmentForm.submit();
        }
    },

    validateForm() {
        const name = this.$refs.nameInput.value.trim();
        if (!name) {
            alert('Le nom du département est obligatoire.');
            this.$refs.nameInput.focus();
            return false;
        }
        return true;
    },

    confirmNavigation() {
        if (this.formChanged) {
            return confirm('Vous avez des modifications non sauvegardées. Êtes-vous sûr de vouloir quitter cette page ?');
        }
        return true;
    }
}" x-init="initForm()">

        <!-- En-tête de la page -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Modifier le département
                    </h1>
                    <p class="mt-2 text-lg transition-colors"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        {{ $department->name }}
                    </p>
                    @if($department->academy)
                        <p class="mt-1 text-sm transition-colors"
                           :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            <i class="fas fa-university mr-1"></i>
                            {{ $department->academy->name }}
                        </p>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-4 py-2 border rounded-lg text-sm font-medium transition-all duration-200"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700 hover:text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50'"
                       @click="if (!confirmNavigation()) event.preventDefault()">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>

        @canany([ 'department.view', 'department.update' ])
            <!-- Indicateur de modifications -->
            <div x-show="formChanged"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 class="mb-6">
                <div class="rounded-lg border-l-4 border-yellow-500 p-4 shadow-sm transition-colors"
                     :class="darkMode ? 'bg-yellow-900/20 text-yellow-300' : 'bg-yellow-50 text-yellow-700'">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-yellow-500 mr-3"></i>
                        <p class="text-sm font-medium">
                            Vous avez des modifications non sauvegardées
                        </p>
                    </div>
                </div>
            </div>

            <!-- Formulaire principal -->
            <form x-ref="departmentForm"
                  action="{{ route('admin.departments.update', ['locale' => app()->getLocale(), 'department' => $department]) }}"
                  method="POST"
                  class="space-y-8"
                  @beforeunload.window="if (formChanged) return 'Vous avez des modifications non sauvegardées.'">
                @csrf
                @method('PUT')

                <!-- Section Informations de base -->
                <div class="rounded-xl shadow-sm transition-colors border"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="px-6 py-4 border-b transition-colors"
                         :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        <h3 class="text-lg font-semibold flex items-center transition-colors"
                            :class="darkMode ? 'text-white' : 'text-gray-900'">
                            <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                            Informations de base
                        </h3>
                        <p class="mt-1 text-sm transition-colors"
                           :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Informations générales du département
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nom du département -->
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-medium transition-colors"
                                       :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    Nom du département <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       x-ref="nameInput"
                                       value="{{ old('name', $department->name) }}"
                                       required
                                       class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                       :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'"
                                       placeholder="Entrez le nom du département"
                                       maxlength="255">
                                @error('name')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>

                            <!-- Code du département -->
                            <div class="space-y-2">
                                <label for="code" class="block text-sm font-medium transition-colors"
                                       :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    Code du département
                                </label>
                                <input type="text"
                                       name="code"
                                       id="code"
                                       value="{{ old('code', $department->code) }}"
                                       class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                       :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'"
                                       placeholder="Code unique (ex: DEPT001)"
                                       maxlength="50"
                                       pattern="[A-Z0-9-_]*"
                                       title="Utilisez uniquement des lettres majuscules, chiffres, tirets et underscores">
                                @error('code')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                                <p class="text-xs transition-colors"
                                   :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    Code unique pour identifier le département (optionnel)
                                </p>
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
                                          placeholder="Description détaillée du département et de ses missions"
                                          maxlength="1000">{{ old('description', $department->description) }}</textarea>
                                @error('description')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                                <div class="flex justify-between text-xs transition-colors"
                                     :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    <span>Description optionnelle du département</span>
                                    <span x-text="1000 - ($refs.description?.value.length || 0) + ' caractères restants'"></span>
                                </div>
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
                        <p class="mt-1 text-sm transition-colors"
                           :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Rattachement organisationnel et responsabilités
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Académie -->
                            <div class="space-y-2">
                                <label for="academy_id" class="block text-sm font-medium transition-colors"
                                       :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    Académie de rattachement
                                </label>
                                <select name="academy_id"
                                        id="academy_id"
                                        class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                        :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                    <option value="">-- Aucune académie --</option>
                                    @foreach($academies as $academy)
                                        <option value="{{ $academy->id }}"
                                                {{ old('academy_id', $department->academy_id) == $academy->id ? 'selected' : '' }}
                                                data-description="{{ $academy->description }}">
                                            {{ $academy->name }}
                                            @if($academy->code)
                                                ({{ $academy->code }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('academy_id')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                                <p class="text-xs transition-colors"
                                   :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    Académie à laquelle appartient ce département
                                </p>
                            </div>

                            <!-- Responsable -->
                            <div class="space-y-2">
                                <label for="head_id" class="block text-sm font-medium transition-colors"
                                       :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    Responsable du département
                                </label>
                                <select name="head_id"
                                        id="head_id"
                                        class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                        :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                    <option value="">-- Aucun responsable --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                                {{ old('head_id', $department->head_id) == $user->id ? 'selected' : '' }}
                                                data-email="{{ $user->email }}"
                                                data-phone="{{ $user->phone_number }}">
                                            {{ $user->first_name }} {{ $user->last_name }}
                                            @if($user->email)
                                                ({{ $user->email }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('head_id')
                                <p class="text-sm text-red-600 flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                                @enderror
                                <p class="text-xs transition-colors"
                                   :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    Personne responsable de la gestion du département
                                </p>
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
                            <i class="fas fa-toggle-on text-green-500 mr-3"></i>
                            Statut d'activation
                        </h3>
                        <p class="mt-1 text-sm transition-colors"
                           :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Contrôle de la visibilité et de l'utilisation du département
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox"
                                       name="is_active"
                                       id="is_active"
                                       value="1"
                                       {{ old('is_active', $department->is_active) ? 'checked' : '' }}
                                       class="mt-1 w-5 h-5 text-[#4CA3DD] border-2 rounded focus:ring-[#4CA3DD] focus:ring-2 transition-colors"
                                       :class="darkMode ? 'border-gray-600 bg-gray-700' : 'border-gray-300 bg-white'">
                                <div>
                                    <label for="is_active" class="text-sm font-medium cursor-pointer transition-colors"
                                           :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        Département actif
                                    </label>
                                    <p class="text-sm transition-colors"
                                       :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        Un département inactif ne sera pas visible dans les sélections et ne pourra pas être utilisé pour de nouvelles affectations.
                                    </p>
                                </div>
                            </div>
                            @error('is_active')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Métadonnées (si nécessaire) -->
                @if($department->created_at || $department->updated_at)
                    <div class="rounded-xl shadow-sm transition-colors border"
                         :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                        <div class="px-6 py-4 border-b transition-colors"
                             :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                            <h3 class="text-lg font-semibold flex items-center transition-colors"
                                :class="darkMode ? 'text-white' : 'text-gray-900'">
                                <i class="fas fa-info text-gray-500 mr-3"></i>
                                Informations système
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                                @if($department->created_at)
                                    <div>
                                    <span class="font-medium transition-colors"
                                          :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        Créé le :
                                    </span>
                                        <span class="transition-colors"
                                              :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        {{ $department->created_at->format('d/m/Y à H:i') }}
                                    </span>
                                    </div>
                                @endif
                                @if($department->updated_at)
                                    <div>
                                    <span class="font-medium transition-colors"
                                          :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        Modifié le :
                                    </span>
                                        <span class="transition-colors"
                                              :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        {{ $department->updated_at->format('d/m/Y à H:i') }}
                                    </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Boutons d'action -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t transition-colors"
                     :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                    <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex justify-center items-center px-6 py-3 border rounded-lg text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700 focus:ring-gray-500' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-[#4CA3DD]'"
                       @click="if (!confirmNavigation()) event.preventDefault()">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>

                    @can('department.update')
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
        @endcanany
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

        /* Style pour les sélecteurs avec options enrichies */
        select option[data-description]:not([data-description=""]):after {
            content: " - " attr(data-description);
            font-style: italic;
            color: #6b7280;
        }

        /* Amélioration du focus */
        input:focus, textarea:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(76, 163, 221, 0.1);
        }

        /* Style pour les champs invalides */
        input:invalid:not(:focus):not(:placeholder-shown),
        textarea:invalid:not(:focus):not(:placeholder-shown) {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        /* Style pour les champs valides */
        input:valid:not(:focus):not(:placeholder-shown),
        textarea:valid:not(:focus):not(:placeholder-shown) {
            border-color: #10b981;
        }

        /* Animation pour le compteur de caractères */
        .char-counter {
            transition: color 0.2s ease;
        }

        .char-counter.warning {
            color: #f59e0b;
        }

        .char-counter.danger {
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

            // Auto-formatage du code
            const codeField = document.getElementById('code');
            if (codeField) {
                codeField.addEventListener('input', function() {
                    // Convertir en majuscules et supprimer les caractères non autorisés
                    this.value = this.value.toUpperCase().replace(/[^A-Z0-9\-_]/g, '');
                });
            }

            // Validation en temps réel du nom
            const nameField = document.getElementById('name');
            if (nameField) {
                nameField.addEventListener('input', function() {
                    const value = this.value.trim();
                    if (value.length < 2) {
                        this.setCustomValidity('Le nom doit contenir au moins 2 caractères');
                    } else if (value.length > 255) {
                        this.setCustomValidity('Le nom ne peut pas dépasser 255 caractères');
                    } else {
                        this.setCustomValidity('');
                    }
                });
            }

            // Compteur de caractères pour la description
            const descriptionField = document.getElementById('description');
            if (descriptionField) {
                const updateCharCounter = () => {
                    const remaining = 1000 - descriptionField.value.length;
                    const counter = document.querySelector('[x-text*="caractères restants"]');

                    if (counter) {
                        if (remaining < 100) {
                            counter.classList.add('char-counter', 'warning');
                        }
                        if (remaining < 50) {
                            counter.classList.add('danger');
                            counter.classList.remove('warning');
                        }
                        if (remaining >= 100) {
                            counter.classList.remove('char-counter', 'warning', 'danger');
                        }
                    }
                };

                descriptionField.addEventListener('input', updateCharCounter);
            }

            // Amélioration des sélecteurs avec recherche
            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];

                    // Afficher des informations supplémentaires si disponibles
                    if (selectedOption.dataset.email || selectedOption.dataset.phone) {
                        console.log('Sélection:', {
                            value: selectedOption.value,
                            text: selectedOption.text,
                            email: selectedOption.dataset.email,
                            phone: selectedOption.dataset.phone
                        });
                    }
                });
            });

            // Sauvegarde automatique en brouillon (localStorage)
            const form = document.querySelector('form');
            const draftKey = `department-edit-draft-${window.location.pathname}`;

            // Charger le brouillon
            const loadDraft = () => {
                const draft = localStorage.getItem(draftKey);
                if (draft) {
                    const data = JSON.parse(draft);
                    Object.keys(data).forEach(name => {
                        const field = form.querySelector(`[name="${name}"]`);
                        if (field) {
                            if (field.type === 'checkbox') {
                                field.checked = data[name];
                            } else {
                                field.value = data[name];
                            }
                        }
                    });
                }
            };

            // Sauvegarder le brouillon
            const saveDraft = () => {
                const formData = new FormData(form);
                const data = {};
                for (let [name, value] of formData.entries()) {
                    data[name] = value;
                }
                localStorage.setItem(draftKey, JSON.stringify(data));
            };

            // Sauvegarder toutes les 30 secondes
            setInterval(saveDraft, 30000);

            // Sauvegarder à chaque changement
            form.addEventListener('input', saveDraft);
            form.addEventListener('change', saveDraft);

            // Nettoyer le brouillon après soumission réussie
            form.addEventListener('submit', () => {
                localStorage.removeItem(draftKey);
            });

            // Raccourcis clavier
            document.addEventListener('keydown', function(e) {
                // Ctrl/Cmd + S pour sauvegarder
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    const submitBtn = document.querySelector('button[type="button"][x-text]');
                    if (submitBtn) {
                        submitBtn.click();
                    }
                }

                // Ctrl/Cmd + Échap pour annuler
                if ((e.ctrlKey || e.metaKey) && e.key === 'Escape') {
                    e.preventDefault();
                    const cancelBtn = document.querySelector('a[href*="departments.index"]');
                    if (cancelBtn) {
                        cancelBtn.click();
                    }
                }
            });

            // Validation avancée côté client
            const validateField = (field, rules) => {
                const value = field.value.trim();
                let isValid = true;
                let message = '';

                rules.forEach(rule => {
                    if (!isValid) return;

                    switch (rule.type) {
                        case 'required':
                            if (!value) {
                                isValid = false;
                                message = rule.message || 'Ce champ est obligatoire';
                            }
                            break;
                        case 'minLength':
                            if (value && value.length < rule.value) {
                                isValid = false;
                                message = rule.message || `Minimum ${rule.value} caractères`;
                            }
                            break;
                        case 'maxLength':
                            if (value && value.length > rule.value) {
                                isValid = false;
                                message = rule.message || `Maximum ${rule.value} caractères`;
                            }
                            break;
                        case 'pattern':
                            if (value && !rule.value.test(value)) {
                                isValid = false;
                                message = rule.message || 'Format invalide';
                            }
                            break;
                    }
                });

                return { isValid, message };
            };

            // Règles de validation
            const validationRules = {
                name: [
                    { type: 'required', message: 'Le nom du département est obligatoire' },
                    { type: 'minLength', value: 2, message: 'Le nom doit contenir au moins 2 caractères' },
                    { type: 'maxLength', value: 255, message: 'Le nom ne peut pas dépasser 255 caractères' }
                ],
                code: [
                    { type: 'pattern', value: /^[A-Z0-9\-_]*$/, message: 'Utilisez uniquement des lettres majuscules, chiffres, tirets et underscores' },
                    { type: 'maxLength', value: 50, message: 'Le code ne peut pas dépasser 50 caractères' }
                ],
                description: [
                    { type: 'maxLength', value: 1000, message: 'La description ne peut pas dépasser 1000 caractères' }
                ]
            };

            // Appliquer la validation en temps réel
            Object.keys(validationRules).forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (field) {
                    const rules = validationRules[fieldName];

                    field.addEventListener('blur', function() {
                        const validation = validateField(this, rules);

                        // Supprimer les anciens messages d'erreur
                        const existingError = this.parentNode.querySelector('.field-error');
                        if (existingError) {
                            existingError.remove();
                        }

                        if (!validation.isValid) {
                            // Ajouter le style d'erreur
                            this.classList.add('border-red-500', 'ring-red-200');
                            this.classList.remove('border-green-500', 'ring-green-200');

                            // Ajouter le message d'erreur
                            const errorDiv = document.createElement('p');
                            errorDiv.className = 'text-sm text-red-600 flex items-center mt-1 field-error';
                            errorDiv.innerHTML = `<i class="fas fa-exclamation-circle mr-1"></i>${validation.message}`;
                            this.parentNode.appendChild(errorDiv);
                        } else if (this.value.trim()) {
                            // Ajouter le style de succès
                            this.classList.add('border-green-500', 'ring-green-200');
                            this.classList.remove('border-red-500', 'ring-red-200');
                        }
                    });

                    field.addEventListener('input', function() {
                        // Supprimer les styles d'erreur pendant la frappe
                        this.classList.remove('border-red-500', 'ring-red-200', 'border-green-500', 'ring-green-200');
                    });
                }
            });

            // Vérification de connectivité pour la sauvegarde automatique
            let isOnline = navigator.onLine;

            window.addEventListener('online', () => {
                isOnline = true;
                console.log('Connexion rétablie - sauvegarde disponible');
            });

            window.addEventListener('offline', () => {
                isOnline = false;
                console.log('Connexion perdue - sauvegarde locale uniquement');
            });

            // Amélioration de l'UX pour les sélecteurs
            const enhanceSelect = (selectElement) => {
                selectElement.addEventListener('focus', function() {
                    this.setAttribute('data-original-value', this.value);
                });

                selectElement.addEventListener('change', function() {
                    const originalValue = this.getAttribute('data-original-value');
                    if (originalValue !== this.value) {
                        // Animer le changement
                        this.style.backgroundColor = '#dcfce7';
                        setTimeout(() => {
                            this.style.backgroundColor = '';
                        }, 1000);
                    }
                });
            };

            document.querySelectorAll('select').forEach(enhanceSelect);

            // Indicateur de progression de saisie
            const updateProgressIndicator = () => {
                const requiredFields = document.querySelectorAll('[required]');
                const filledFields = Array.from(requiredFields).filter(field => {
                    if (field.type === 'checkbox') {
                        return field.checked;
                    }
                    return field.value.trim() !== '';
                });

                const progress = (filledFields.length / requiredFields.length) * 100;

                // Vous pouvez ajouter ici un indicateur visuel de progression
                console.log(`Progression du formulaire: ${Math.round(progress)}%`);
            };

            // Surveiller les changements pour la progression
            form.addEventListener('input', updateProgressIndicator);
            form.addEventListener('change', updateProgressIndicator);

            // Initialiser la progression
            updateProgressIndicator();

            // Fonction de nettoyage au déchargement de la page
            window.addEventListener('beforeunload', (e) => {
                // Vérifier s'il y a des modifications non sauvegardées
                const formData = new FormData(form);
                const hasChanges = Array.from(formData.entries()).some(([name, value]) => {
                    const originalField = form.querySelector(`[name="${name}"]`);
                    if (originalField) {
                        const originalValue = originalField.getAttribute('data-original-value') ||
                            originalField.defaultValue ||
                            (originalField.defaultChecked ? 'on' : '');
                        return value !== originalValue;
                    }
                    return false;
                });

                if (hasChanges) {
                    const message = 'Vous avez des modifications non sauvegardées. Êtes-vous sûr de vouloir quitter ?';
                    e.returnValue = message;
                    return message;
                }
            });

            // Amélioration de l'accessibilité
            const improveAccessibility = () => {
                // Ajouter des descriptions ARIA pour les champs requis
                document.querySelectorAll('[required]').forEach(field => {
                    if (!field.getAttribute('aria-describedby')) {
                        field.setAttribute('aria-required', 'true');
                    }
                });

                // Améliorer les labels des checkboxes
                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.setAttribute('role', 'switch');
                    checkbox.setAttribute('aria-checked', checkbox.checked);

                    checkbox.addEventListener('change', function() {
                        this.setAttribute('aria-checked', this.checked);
                    });
                });
            };

            improveAccessibility();

            // Fonction de debug pour le développement
            window.debugForm = () => {
                const formData = new FormData(form);
                const data = {};
                for (let [name, value] of formData.entries()) {
                    data[name] = value;
                }
                console.table(data);
            };

            // Message de confirmation après sauvegarde réussie
            if (window.location.search.includes('updated=1')) {
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                notification.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Département mis à jour avec succès !';
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }
        });

        // Fonction globale pour réinitialiser le formulaire
        window.resetForm = () => {
            if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ? Toutes les modifications seront perdues.')) {
                document.querySelector('form').reset();

                // Supprimer le brouillon
                const draftKey = `department-edit-draft-${window.location.pathname}`;
                localStorage.removeItem(draftKey);

                // Supprimer les styles de validation
                document.querySelectorAll('.border-red-500, .border-green-500').forEach(field => {
                    field.classList.remove('border-red-500', 'ring-red-200', 'border-green-500', 'ring-green-200');
                });

                // Supprimer les messages d'erreur personnalisés
                document.querySelectorAll('.field-error').forEach(error => error.remove());
            }
        };
    </script>
@endpush
