@extends('layouts.app')

@section('page_title', 'Nouveau département')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">Tableau de bord</a>
    </div>
    <div class="breadcrumb-item">
        <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}">Départements</a>
    </div>
    <div class="breadcrumb-item active">Nouveau département</div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark',
    isSubmitting: false,
    formData: {
        name: '{{ old('name') }}',
        code: '{{ old('code') }}',
        description: '{{ old('description') }}',
        is_active: {{ old('is_active', true) ? 'true' : 'false' }},
        academy_id: '{{ old('academy_id') }}',
        head_id: '{{ old('head_id') }}'
    },
    progressStep: 1,
    totalSteps: 3,

    nextStep() {
        if (this.validateCurrentStep()) {
            this.progressStep = Math.min(this.progressStep + 1, this.totalSteps);
        }
    },

    prevStep() {
        this.progressStep = Math.max(this.progressStep - 1, 1);
    },

    validateCurrentStep() {
        switch (this.progressStep) {
            case 1:
                return this.formData.name.trim().length >= 2;
            case 2:
                return true; // Organisation est optionnelle
            case 3:
                return true; // Révision
            default:
                return true;
        }
    },

    submitForm() {
        if (this.validateForm()) {
            this.isSubmitting = true;
            this.$refs.departmentForm.submit();
        }
    },

    validateForm() {
        const name = this.formData.name.trim();
        if (!name) {
            alert('Le nom du département est obligatoire.');
            this.progressStep = 1;
            this.$nextTick(() => this.$refs.nameInput.focus());
            return false;
        }
        if (name.length < 2) {
            alert('Le nom doit contenir au moins 2 caractères.');
            this.progressStep = 1;
            this.$nextTick(() => this.$refs.nameInput.focus());
            return false;
        }
        return true;
    },

    getProgressPercentage() {
        return (this.progressStep / this.totalSteps) * 100;
    },

    isStepCompleted(step) {
        return this.progressStep > step;
    },

    isStepCurrent(step) {
        return this.progressStep === step;
    }
}" x-init="$watch('formData', () => {}, { deep: true })">

        <!-- En-tête de la page -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Créer un nouveau département
                    </h1>
                    <p class="mt-2 text-lg transition-colors"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        Ajoutez un département à votre organisation
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-4 py-2 border rounded-lg text-sm font-medium transition-all duration-200"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700 hover:text-white' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour à la liste
                    </a>
                </div>
            </div>
        </div>

        <!-- Indicateur de progression -->
        @can('gestion.department.create')
        <div class="mb-8">
            <div class="rounded-xl shadow-sm p-6 transition-colors border"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Progression de la création
                    </h3>
                    <span class="text-sm font-medium transition-colors"
                          :class="darkMode ? 'text-gray-300' : 'text-gray-600'"
                          x-text="`Étape ${progressStep} sur ${totalSteps}`"></span>
                </div>

                <!-- Barre de progression -->
                <div class="w-full bg-gray-200 rounded-full h-2 mb-4 transition-colors"
                     :class="darkMode ? 'bg-gray-700' : 'bg-gray-200'">
                    <div class="bg-[#4CA3DD] h-2 rounded-full transition-all duration-300"
                         :style="`width: ${getProgressPercentage()}%`"></div>
                </div>

                <!-- Étapes -->
                <div class="flex justify-between">
                    <div class="flex flex-col items-center"
                         :class="isStepCompleted(1) || isStepCurrent(1) ? (darkMode ? 'text-white' : 'text-gray-900') : (darkMode ? 'text-gray-500' : 'text-gray-400')">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium mb-2 transition-colors"
                             :class="isStepCompleted(1) ? 'bg-green-500 text-white' : (isStepCurrent(1) ? 'bg-[#4CA3DD] text-white' : (darkMode ? 'bg-gray-700 text-gray-400' : 'bg-gray-200 text-gray-500'))">
                            <i class="fas" :class="isStepCompleted(1) ? 'fa-check' : 'fa-info'"></i>
                        </div>
                        <span class="text-xs font-medium text-center">Informations<br>de base</span>
                    </div>

                    <div class="flex flex-col items-center"
                         :class="isStepCompleted(2) || isStepCurrent(2) ? (darkMode ? 'text-white' : 'text-gray-900') : (darkMode ? 'text-gray-500' : 'text-gray-400')">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium mb-2 transition-colors"
                             :class="isStepCompleted(2) ? 'bg-green-500 text-white' : (isStepCurrent(2) ? 'bg-[#4CA3DD] text-white' : (darkMode ? 'bg-gray-700 text-gray-400' : 'bg-gray-200 text-gray-500'))">
                            <i class="fas" :class="isStepCompleted(2) ? 'fa-check' : 'fa-sitemap'"></i>
                        </div>
                        <span class="text-xs font-medium text-center">Organisation<br>& hiérarchie</span>
                    </div>

                    <div class="flex flex-col items-center"
                         :class="isStepCompleted(3) || isStepCurrent(3) ? (darkMode ? 'text-white' : 'text-gray-900') : (darkMode ? 'text-gray-500' : 'text-gray-400')">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium mb-2 transition-colors"
                             :class="isStepCompleted(3) ? 'bg-green-500 text-white' : (isStepCurrent(3) ? 'bg-[#4CA3DD] text-white' : (darkMode ? 'bg-gray-700 text-gray-400' : 'bg-gray-200 text-gray-500'))">
                            <i class="fas" :class="isStepCompleted(3) ? 'fa-check' : 'fa-eye'"></i>
                        </div>
                        <span class="text-xs font-medium text-center">Révision<br>& validation</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire principal -->
        <form x-ref="departmentForm"
              action="{{ route('admin.departments.store', ['locale' => app()->getLocale()]) }}"
              method="POST"
              class="space-y-8">
            @csrf

            <!-- Étape 1: Informations de base -->
            <div x-show="progressStep === 1"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="rounded-xl shadow-sm transition-colors border"
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
                        Renseignez les informations essentielles du département
                    </p>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
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
                                   x-model="formData.name"
                                   required
                                   class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                   :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'"
                                   placeholder="Entrez le nom du département"
                                   maxlength="255"
                                   autofocus>
                            @error('name')
                            <p class="text-sm text-red-600 flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                            <p class="text-xs transition-colors"
                               :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Nom officiel du département (minimum 2 caractères)
                            </p>
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
                                   x-model="formData.code"
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
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Description
                            </label>
                            <textarea name="description"
                                      id="description"
                                      x-model="formData.description"
                                      rows="4"
                                      class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent resize-none"
                                      :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'"
                                      placeholder="Description détaillée du département et de ses missions"
                                      maxlength="1000"></textarea>
                            @error('description')
                            <p class="text-sm text-red-600 flex items-center mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                            @enderror
                            <div class="flex justify-between text-xs transition-colors"
                                 :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                <span>Description optionnelle du département</span>
                                <span x-text="1000 - (formData.description?.length || 0) + ' caractères restants'"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Étape 2: Organisation et hiérarchie -->
            <div x-show="progressStep === 2"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="rounded-xl shadow-sm transition-colors border"
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
                        Définissez le rattachement organisationnel et les responsabilités
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
                                    x-model="formData.academy_id"
                                    class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">-- Sélectionner une académie --</option>
                                @foreach($academies as $academy)
                                    <option value="{{ $academy->id }}"
                                            {{ old('academy_id') == $academy->id ? 'selected' : '' }}
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
                                    x-model="formData.head_id"
                                    class="w-full px-4 py-3 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">-- Sélectionner un responsable --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                            {{ old('head_id') == $user->id ? 'selected' : '' }}
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

                        <!-- Statut d'activation -->
                        <div class="space-y-2 md:col-span-2">
                            <div class="flex items-start space-x-3">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox"
                                       name="is_active"
                                       id="is_active"
                                       value="1"
                                       x-model="formData.is_active"
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="mt-1 w-5 h-5 text-[#4CA3DD] border-2 rounded focus:ring-[#4CA3DD] focus:ring-2 transition-colors"
                                       :class="darkMode ? 'border-gray-600 bg-gray-700' : 'border-gray-300 bg-white'">
                                <div>
                                    <label for="is_active" class="text-sm font-medium cursor-pointer transition-colors"
                                           :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        Département actif
                                    </label>
                                    <p class="text-sm transition-colors"
                                       :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        Un département actif sera visible dans les sélections et pourra être utilisé immédiatement.
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
            </div>

            <!-- Étape 3: Révision et validation -->
            <div x-show="progressStep === 3"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-x-4"
                 x-transition:enter-end="opacity-100 transform translate-x-0"
                 class="rounded-xl shadow-sm transition-colors border"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="px-6 py-4 border-b transition-colors"
                     :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                    <h3 class="text-lg font-semibold flex items-center transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fas fa-eye text-green-500 mr-3"></i>
                        Révision et validation
                    </h3>
                    <p class="mt-1 text-sm transition-colors"
                       :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        Vérifiez les informations avant de créer le département
                    </p>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Résumé des informations -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <h4 class="font-medium transition-colors"
                                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    Informations de base
                                </h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                    <span class="font-medium transition-colors"
                                          :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        Nom :
                                    </span>
                                        <span class="transition-colors"
                                              :class="darkMode ? 'text-gray-400' : 'text-gray-500'"
                                              x-text="formData.name || 'Non défini'"></span>
                                    </div>
                                    <div class="flex justify-between">
                                    <span class="font-medium transition-colors"
                                          :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        Code :
                                    </span>
                                        <span class="transition-colors"
                                              :class="darkMode ? 'text-gray-400' : 'text-gray-500'"
                                              x-text="formData.code || 'Aucun'"></span>
                                    </div>
                                    <div class="flex justify-between">
                                    <span class="font-medium transition-colors"
                                          :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        Statut :
                                    </span>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                              :class="formData.is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                                              x-text="formData.is_active ? 'Actif' : 'Inactif'"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h4 class="font-medium transition-colors"
                                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    Organisation
                                </h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                    <span class="font-medium transition-colors"
                                          :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        Académie :
                                    </span>
                                        <span class="transition-colors"
                                              :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        <span x-show="formData.academy_id">
                                            {{ collect($academies)->where('id', old('academy_id'))->first()->name ?? 'Sélectionnée' }}
                                        </span>
                                        <span x-show="!formData.academy_id">Aucune</span>
                                    </span>
                                    </div>
                                    <div class="flex justify-between">
                                    <span class="font-medium transition-colors"
                                          :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        Responsable :
                                    </span>
                                        <span class="transition-colors"
                                              :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        <span x-show="formData.head_id">
                                            {{ collect($users)->where('id', old('head_id'))->first()->first_name ?? 'Sélectionné' }}
                                        </span>
                                        <span x-show="!formData.head_id">Aucun</span>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div x-show="formData.description" class="space-y-2">
                            <h4 class="font-medium transition-colors"
                                :class="darkMode ? 'text-white' : 'text-gray-900'">
                                Description
                            </h4>
                            <p class="text-sm p-3 rounded-lg transition-colors"
                               :class="darkMode ? 'bg-gray-700 text-gray-300' : 'bg-gray-50 text-gray-700'"
                               x-text="formData.description"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation entre les étapes -->
            <div class="flex flex-col sm:flex-row justify-between space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t transition-colors"
                 :class="darkMode ? 'border-gray-700' : 'border-gray-200'">

                <!-- Bouton Précédent -->
                <button type="button"
                        x-show="progressStep > 1"
                        @click="prevStep()"
                        class="inline-flex justify-center items-center px-6 py-3 border rounded-lg text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700 focus:ring-gray-500' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-[#4CA3DD]'">
                    <i class="fas fa-chevron-left mr-2"></i>
                    Précédent
                </button>

                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 sm:ml-auto">
                    <!-- Bouton Annuler -->
                    <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex justify-center items-center px-6 py-3 border rounded-lg text-sm font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700 focus:ring-gray-500' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-[#4CA3DD]'">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>

                    <!-- Bouton Suivant / Créer -->
                    @can('gestion.department.create')
                        <button type="button"
                                x-show="progressStep < totalSteps"
                                @click="nextStep()"
                                :disabled="!validateCurrentStep()"
                                class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#4CA3DD] hover:bg-[#3A8BC8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                                :class="{ 'opacity-50 cursor-not-allowed': !validateCurrentStep() }">
                            <span>Suivant</span>
                            <i class="fas fa-chevron-right ml-2"></i>
                        </button>

                        <button type="button"
                                x-show="progressStep === totalSteps"
                                @click="submitForm()"
                                :disabled="isSubmitting"
                                class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                                :class="{ 'opacity-50 cursor-not-allowed': isSubmitting }">
                            <i class="fas fa-save mr-2" x-show="!isSubmitting"></i>
                            <i class="fas fa-spinner fa-spin mr-2" x-show="isSubmitting"></i>
                            <span x-text="isSubmitting ? 'Création...' : 'Créer le département'"></span>
                        </button>
                    @endcan
                </div>
            </div>
        </form>

        <!-- Guide d'aide (optionnel) -->
        <div class="mt-8 rounded-xl shadow-sm p-6 transition-colors border"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-blue-50 border-blue-200'">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-blue-500 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium transition-colors"
                        :class="darkMode ? 'text-white' : 'text-blue-900'">
                        Conseils pour la création d'un département
                    </h3>
                    <div class="mt-2 text-sm transition-colors"
                         :class="darkMode ? 'text-gray-300' : 'text-blue-700'">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Choisissez un nom clair et descriptif pour le département</li>
                            <li>Le code permet une identification unique (optionnel mais recommandé)</li>
                            <li>Rattachez le département à une académie pour une meilleure organisation</li>
                            <li>Assignez un responsable pour faciliter la gestion</li>
                            <li>Un département inactif ne sera pas visible dans les sélections</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
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

        /* Animations pour les transitions d'étapes */
        .step-transition {
            transition: all 0.3s ease-in-out;
        }

        /* Style pour les étapes complétées */
        .step-completed {
            background: linear-gradient(135deg, #10b981, #059669);
        }

        /* Style pour l'étape courante */
        .step-current {
            background: linear-gradient(135deg, #4CA3DD, #3A8BC8);
            box-shadow: 0 0 0 4px rgba(76, 163, 221, 0.2);
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

        /* Animation pour la barre de progression */
        .progress-bar {
            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Amélioration des boutons */
        .btn-enhanced {
            position: relative;
            overflow: hidden;
        }

        .btn-enhanced::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            transition: width 0.3s, height 0.3s;
            transform: translate(-50%, -50%);
        }

        .btn-enhanced:hover::before {
            width: 300px;
            height: 300px;
        }

        /* Style pour le compteur de caractères */
        .char-counter {
            transition: color 0.2s ease;
        }

        .char-counter.warning {
            color: #f59e0b;
        }

        .char-counter.danger {
            color: #ef4444;
        }

        /* Style pour les tooltips des étapes */
        .step-tooltip {
            position: relative;
        }

        .step-tooltip:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 0.5rem;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 10;
        }

        /* Responsive amélioré */
        @media (max-width: 640px) {
            .step-container {
                flex-direction: column;
                gap: 1rem;
            }

            .step-item {
                flex-direction: row;
                align-items: center;
                text-align: left;
            }

            .step-number {
                margin-right: 0.75rem;
                margin-bottom: 0;
            }
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
                }, index * 150);
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
                    const feedback = this.parentNode.querySelector('.field-feedback');

                    if (feedback) feedback.remove();

                    if (value.length === 0) {
                        this.classList.remove('border-green-500', 'border-red-500');
                    } else if (value.length < 2) {
                        this.classList.add('border-red-500');
                        this.classList.remove('border-green-500');

                        const feedbackDiv = document.createElement('p');
                        feedbackDiv.className = 'text-sm text-red-600 flex items-center mt-1 field-feedback';
                        feedbackDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Le nom doit contenir au moins 2 caractères';
                        this.parentNode.appendChild(feedbackDiv);
                    } else {
                        this.classList.add('border-green-500');
                        this.classList.remove('border-red-500');
                    }
                });
            }

            // Compteur de caractères pour la description avec warnings
            const descriptionField = document.getElementById('description');
            if (descriptionField) {
                const updateCharCounter = () => {
                    const remaining = 1000 - descriptionField.value.length;
                    const counterElements = document.querySelectorAll('[x-text*="caractères restants"]');

                    counterElements.forEach(counter => {
                        counter.classList.remove('char-counter', 'warning', 'danger');

                        if (remaining < 100) {
                            counter.classList.add('char-counter', 'warning');
                        }
                        if (remaining < 50) {
                            counter.classList.add('danger');
                            counter.classList.remove('warning');
                        }
                    });
                };

                descriptionField.addEventListener('input', updateCharCounter);
            }

            // Sauvegarde automatique en brouillon
            const form = document.querySelector('form');
            const draftKey = 'department-create-draft';

            // Charger le brouillon si disponible
            const loadDraft = () => {
                const draft = localStorage.getItem(draftKey);
                if (draft) {
                    try {
                        const data = JSON.parse(draft);
                        Object.keys(data).forEach(name => {
                            const field = form.querySelector(`[name="${name}"]`);
                            if (field) {
                                if (field.type === 'checkbox') {
                                    field.checked = data[name];
                                } else {
                                    field.value = data[name];
                                }

                                // Déclencher l'événement input pour Alpine.js
                                field.dispatchEvent(new Event('input', { bubbles: true }));
                            }
                        });

                        console.log('Brouillon chargé');
                    } catch (e) {
                        console.error('Erreur lors du chargement du brouillon:', e);
                    }
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

            // Charger le brouillon au démarrage
            setTimeout(loadDraft, 500);

            // Sauvegarder automatiquement
            let saveTimeout;
            const debouncedSave = () => {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(saveDraft, 1000);
            };

            form.addEventListener('input', debouncedSave);
            form.addEventListener('change', debouncedSave);

            // Nettoyer le brouillon après soumission réussie
            form.addEventListener('submit', () => {
                localStorage.removeItem(draftKey);
            });

            // Amélioration des sélecteurs avec informations supplémentaires
            const enhanceSelect = (selectElement) => {
                selectElement.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];

                    // Afficher des informations supplémentaires
                    if (selectedOption.dataset.email || selectedOption.dataset.phone || selectedOption.dataset.description) {
                        console.log('Sélection:', {
                            value: selectedOption.value,
                            text: selectedOption.text,
                            email: selectedOption.dataset.email,
                            phone: selectedOption.dataset.phone,
                            description: selectedOption.dataset.description
                        });
                    }

                    // Animation de feedback
                    this.style.backgroundColor = '#dcfce7';
                    setTimeout(() => {
                        this.style.backgroundColor = '';
                    }, 1000);
                });
            };

            document.querySelectorAll('select').forEach(enhanceSelect);

            // Validation de l'unicité du code (simulation)
            const validateCodeUniqueness = async (code) => {
                if (!code) return true;

                // Ici vous pouvez implémenter une vérification AJAX
                // pour vérifier l'unicité du code côté serveur
                console.log('Vérification de l\'unicité du code:', code);

                // Simulation d'une vérification
                return new Promise(resolve => {
                    setTimeout(() => {
                        resolve(true); // Toujours valide pour la démo
                    }, 500);
                });
            };

            if (codeField) {
                let validationTimeout;
                codeField.addEventListener('input', function() {
                    clearTimeout(validationTimeout);
                    const code = this.value.trim();

                    if (code) {
                        validationTimeout = setTimeout(async () => {
                            const isUnique = await validateCodeUniqueness(code);

                            const feedback = this.parentNode.querySelector('.uniqueness-feedback');
                            if (feedback) feedback.remove();

                            if (!isUnique) {
                                const feedbackDiv = document.createElement('p');
                                feedbackDiv.className = 'text-sm text-red-600 flex items-center mt-1 uniqueness-feedback';
                                feedbackDiv.innerHTML = '<i class="fas fa-exclamation-circle mr-1"></i>Ce code existe déjà';
                                this.parentNode.appendChild(feedbackDiv);
                                this.classList.add('border-red-500');
                            } else {
                                this.classList.remove('border-red-500');
                            }
                        }, 1000);
                    }
                });
            }

            // Amélioration de l'accessibilité
            const improveAccessibility = () => {
                // Ajouter des labels ARIA pour les étapes
                document.querySelectorAll('[x-show*="progressStep"]').forEach((element, index) => {
                    element.setAttribute('aria-label', `Étape ${index + 1} du formulaire`);
                    element.setAttribute('role', 'tabpanel');
                });

                // Améliorer les checkboxes
                document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                    checkbox.setAttribute('role', 'switch');
                    checkbox.setAttribute('aria-checked', checkbox.checked);

                    checkbox.addEventListener('change', function() {
                        this.setAttribute('aria-checked', this.checked);
                    });
                });
            };

            improveAccessibility();

            // Gestion des erreurs de validation côté serveur
            @if($errors->any())
            // Si des erreurs existent, aller à la première étape avec erreur
            const errorFields = @json($errors->keys());
            let targetStep = 1;

            if (errorFields.some(field => ['academy_id', 'head_id', 'is_active'].includes(field))) {
                targetStep = 2;
            }

            // Utiliser Alpine.js pour changer l'étape
            setTimeout(() => {
                window.Alpine && window.Alpine.store && window.Alpine.store('form', { progressStep: targetStep });
            }, 100);
            @endif

            // Indicateur de progression de saisie
            const updateFormProgress = () => {
                const requiredFields = ['name'];
                const filledRequired = requiredFields.filter(fieldName => {
                    const field = document.getElementById(fieldName);
                    return field && field.value.trim() !== '';
                });

                const optionalFields = ['code', 'description', 'academy_id', 'head_id'];
                const filledOptional = optionalFields.filter(fieldName => {
                    const field = document.getElementById(fieldName);
                    if (field.type === 'checkbox') {
                        return field.checked;
                    }
                    return field && field.value.trim() !== '';
                });

                const totalProgress = ((filledRequired.length / requiredFields.length) * 70) +
                    ((filledOptional.length / optionalFields.length) * 30);

                console.log(`Progression du formulaire: ${Math.round(totalProgress)}%`);
            };

            // Surveiller la progression
            form.addEventListener('input', updateFormProgress);
            form.addEventListener('change', updateFormProgress);

            // Animation au focus des champs
            document.querySelectorAll('input, textarea, select').forEach(field => {
                field.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                    this.parentElement.style.transition = 'transform 0.2s ease';
                });

                field.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
                });
            });

            // Message de bienvenue pour les nouveaux utilisateurs
            if (!localStorage.getItem('department-create-visited')) {
                setTimeout(() => {
                    const welcome = document.createElement('div');
                    welcome.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-sm';
                    welcome.innerHTML = `
                    <div class="flex items-start">
                        <i class="fas fa-info-circle mr-3 mt-0.5"></i>
                        <div>
                            <h4 class="font-medium">Créer un département</h4>
                            <p class="text-sm mt-1">Suivez les étapes pour créer un nouveau département. Vos données sont sauvegardées automatiquement.</p>
                            <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-blue-200 hover:text-white mt-2 text-sm">
                                Fermer
                            </button>
                        </div>
                    </div>
                `;
                    document.body.appendChild(welcome);

                    setTimeout(() => {
                        welcome.style.opacity = '0';
                        setTimeout(() => welcome.remove(), 300);
                    }, 8000);

                    localStorage.setItem('department-create-visited', 'true');
                }, 1000);
            }
        });

        // Fonction globale pour réinitialiser le formulaire
        window.resetForm = () => {
            if (confirm('Êtes-vous sûr de vouloir réinitialiser le formulaire ? Toutes les données seront perdues.')) {
                document.querySelector('form').reset();
                localStorage.removeItem('department-create-draft');
                location.reload();
            }
        };

        // Fonction pour forcer la validation
        window.validateAllFields = () => {
            const form = document.querySelector('form');
            const formData = new FormData(form);

            console.table(Object.fromEntries(formData.entries()));

            const isValid = form.checkValidity();
            if (!isValid) {
                form.reportValidity();
            }

            return isValid;
        };
    </script>
@endpush
