@extends('layouts.app')

@section('title', 'Modifier le Département')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5 transition-colors duration-300" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-sm font-medium transition-colors duration-300"
                   :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors duration-300 md:ml-2"
                       :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
                        Gestion des Départements
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium md:ml-2"
                          :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                        Modifier le Département
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="shadow-md rounded-lg p-6 mb-8 transition-colors duration-300"
         :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
        <!-- En-tête avec titre -->
        <div class="flex items-center mb-8">
            <div class="w-10 h-10 rounded-full bg-[#4CA3DD] flex items-center justify-center text-white mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold transition-colors duration-300"
                    :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                    Modifier le Département
                </h1>
                <p class="text-sm transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                    {{ $department->name }} - ID: {{ $department->id }}
                </p>
            </div>
        </div>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div id="alert-errors" class="flex p-4 mb-6 border-l-4 border-red-500 transition-colors duration-300"
                 :class="{ 'bg-gray-800 text-red-400': darkMode, 'bg-red-50 text-red-800': !darkMode }"
                 role="alert">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3">
                    <h3 class="text-lg font-medium mb-2">Veuillez corriger les erreurs suivantes :</h3>
                    <ul class="list-disc pl-5 space-y-1 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 p-1.5 inline-flex h-8 w-8 rounded-lg focus:ring-2 focus:ring-red-400 transition-colors duration-300"
                        :class="{ 'bg-gray-800 text-red-400 hover:bg-gray-700': darkMode, 'bg-red-50 text-red-500': !darkMode }"
                        data-dismiss-target="#alert-errors" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('admin.departments.update', ['locale' => app()->getLocale(), 'department' => $department]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nom du département -->
            <div class="form-group">
                <label for="name" class="block text-sm font-medium mb-2 transition-colors duration-300"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Nom <span class="text-red-500">*</span>
                    </span>
                </label>
                <div class="relative">
                    <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}" required
                           class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                           :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }" />
                </div>
                <p class="mt-1 text-xs transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                    Nom complet du département
                </p>
                @error('name')
                <p class="mt-2 text-sm transition-colors duration-300"
                   :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Code du département -->
            <div class="form-group">
                <label for="code" class="block text-sm font-medium mb-2 transition-colors duration-300"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                        Code
                    </span>
                </label>
                <div class="relative">
                    <input type="text" name="code" id="code" value="{{ old('code', $department->code) }}"
                           class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                           :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }"
                           maxlength="10" />
                </div>
                <p class="mt-1 text-xs transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                    Code court pour identifier le département (optionnel)
                </p>
                @error('code')
                <p class="mt-2 text-sm transition-colors duration-300"
                   :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="block text-sm font-medium mb-2 transition-colors duration-300"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Description
                    </span>
                </label>
                <div class="relative">
                    <textarea name="description" id="description" rows="4"
                              class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm resize-none transition-colors duration-300"
                              :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }"
                              placeholder="Description détaillée du département...">{{ old('description', $department->description) }}</textarea>
                </div>
                <p class="mt-1 text-xs transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                    Description des missions et responsabilités du département
                </p>
                @error('description')
                <p class="mt-2 text-sm transition-colors duration-300"
                   :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Académie -->
            <div class="form-group">
                <label for="academy_id" class="block text-sm font-medium mb-2 transition-colors duration-300"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Académie <span class="text-red-500">*</span>
                    </span>
                </label>
                <div class="relative">
                    <select name="academy_id" id="academy_id" required
                            class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                            :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }">
                        <option value="">Sélectionnez une académie</option>
                        @foreach ($academies as $academy)
                            <option value="{{ $academy->id }}" {{ old('academy_id', $department->academy_id) == $academy->id ? 'selected' : '' }}>
                                {{ $academy->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="mt-1 text-xs transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                    Académie de rattachement du département
                </p>
                @error('academy_id')
                <p class="mt-2 text-sm transition-colors duration-300"
                   :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Chef de département -->
            <div class="form-group">
                <label for="head_id" class="block text-sm font-medium mb-2 transition-colors duration-300"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Chef de département
                    </span>
                </label>
                <div class="relative">
                    <select name="head_id" id="head_id"
                            class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                            :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }">
                        <option value="">Aucun chef assigné</option>
                        @foreach ($heads as $head)
                            <option value="{{ $head->id }}" {{ old('head_id', $department->head_id) == $head->id ? 'selected' : '' }}>
                                {{ $head->first_name }} {{ $head->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="mt-1 text-xs transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                    Responsable en charge du département (optionnel)
                </p>
                @error('head_id')
                <p class="mt-2 text-sm transition-colors duration-300"
                   :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Statut actif -->
            <div class="form-group">
                <div class="flex items-center justify-between p-4 border rounded-lg transition-colors duration-300"
                     :class="{ 'border-gray-600 bg-gray-700': darkMode, 'border-gray-200 bg-gray-50': !darkMode }">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <label for="is_active" class="text-sm font-medium cursor-pointer transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-900': !darkMode }">
                                Département actif
                            </label>
                            <p class="text-xs transition-colors duration-300"
                               :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                                Les départements actifs apparaissent dans les listes et peuvent recevoir des affectations
                            </p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                   {{ old('is_active', $department->is_active) ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4CA3DD]"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t transition-colors duration-300"
                 :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Mettre à jour
                </button>

                <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex justify-center items-center px-6 py-3 border rounded-lg font-medium transition duration-150 ease-in-out"
                   :class="{
                       'bg-gray-700 border-gray-600 text-white hover:bg-gray-600': darkMode,
                       'bg-white border-gray-300 text-gray-700 hover:bg-gray-50': !darkMode
                   }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Information complémentaire (date de création, dernière modification) -->
    <div class="p-4 rounded-lg mb-4 transition-colors duration-300"
         :class="{ 'bg-gray-700 text-gray-300': darkMode, 'bg-gray-100 text-gray-600': !darkMode }">
        <div class="flex flex-wrap items-center text-sm">
            <div class="flex items-center mr-6 mb-2 sm:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Créé le: {{ $department->created_at->format('d/m/Y à H:i') }}
            </div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dernière modification: {{ $department->updated_at->format('d/m/Y à H:i') }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des alertes
            const alerts = document.querySelectorAll('[id^="alert-"]');
            alerts.forEach(alert => {
                // Ajout d'un gestionnaire pour le bouton de fermeture
                const closeBtn = alert.querySelector('[data-dismiss-target]');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]', 'transition-all', 'duration-500');
                        setTimeout(() => {
                            alert.remove();
                        }, 500);
                    });
                }

                // Auto-dismiss après 8 secondes
                setTimeout(() => {
                    if (alert && alert.parentNode) {
                        alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]', 'transition-all', 'duration-500');
                        setTimeout(() => {
                            if (alert && alert.parentNode) {
                                alert.remove();
                            }
                        }, 500);
                    }
                }, 8000);
            });

            // Génération automatique du code à partir du nom
            const nameField = document.getElementById('name');
            const codeField = document.getElementById('code');

            if (nameField && codeField) {
                nameField.addEventListener('input', function() {
                    if (!codeField.value || codeField.hasAttribute('data-auto-generated')) {
                        const code = generateCode(this.value);
                        codeField.value = code;
                        codeField.setAttribute('data-auto-generated', 'true');
                    }
                });

                codeField.addEventListener('input', function() {
                    if (this.value) {
                        this.removeAttribute('data-auto-generated');
                    }
                });
            }

            function generateCode(name) {
                return name
                    .toUpperCase()
                    .replace(/[ÀÁÂÃÄÅ]/g, 'A')
                    .replace(/[ÈÉÊË]/g, 'E')
                    .replace(/[ÌÍÎÏ]/g, 'I')
                    .replace(/[ÒÓÔÕÖ]/g, 'O')
                    .replace(/[ÙÚÛÜ]/g, 'U')
                    .replace(/[^A-Z0-9]/g, '')
                    .substring(0, 6);
            }

            // Détection des changements pour avertir l'utilisateur
            const originalValues = {};
            const formFields = document.querySelectorAll('input, select, textarea');

            // Stocker les valeurs originales
            formFields.forEach(field => {
                if (field.type === 'checkbox') {
                    originalValues[field.name] = field.checked;
                } else {
                    originalValues[field.name] = field.value;
                }
            });

            // Vérifier les changements
            formFields.forEach(field => {
                field.addEventListener('input', function() {
                    checkForChanges();
                });

                field.addEventListener('change', function() {
                    checkForChanges();
                });
            });

            function checkForChanges() {
                let hasChanges = false;
                formFields.forEach(field => {
                    const currentValue = field.type === 'checkbox' ? field.checked : field.value;
                    if (currentValue !== originalValues[field.name]) {
                        hasChanges = true;
                    }
                });

                // Afficher/masquer l'indicateur de changements
                showChangeIndicator(hasChanges);
            }

            function showChangeIndicator(show) {
                let indicator = document.querySelector('.change-indicator');

                if (show && !indicator) {
                    indicator = document.createElement('div');
                    indicator.className = 'change-indicator fixed top-4 left-1/2 transform -translate-x-1/2 bg-yellow-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300';
                    indicator.innerHTML = `
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Modifications détectées
                        </div>
                    `;
                    document.body.appendChild(indicator);
                } else if (!show && indicator) {
                    indicator.remove();
                }
            }

            // Raccourcis clavier
            document.addEventListener('keydown', function(e) {
                // Ctrl+S pour sauvegarder
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    document.querySelector('form').submit();
                }

                // Escape pour annuler
                if (e.key === 'Escape') {
                    const cancelBtn = document.querySelector('a[href*="departments.index"]');
                    if (cancelBtn) {
                        window.location.href = cancelBtn.href;
                    }
                }
            });
        });
    </script>
@endpush
