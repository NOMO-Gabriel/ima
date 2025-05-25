@extends('layouts.app')

@section('title', 'Créer un Département')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
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
                    <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">
                        Gestion des Départements
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Créer un Département</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-4xl mx-auto">
        <!-- En-tête de la page -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8" :class="darkMode ? 'dark:bg-gray-800' : ''">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="bg-[#4CA3DD] bg-opacity-10 p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">Créer un Nouveau Département</h1>
                        <p class="text-sm mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Ajoutez un nouveau département à votre système de gestion</p>
                    </div>
                </div>
                <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium border rounded-lg transition-colors duration-200"
                   :class="darkMode ? 'text-gray-300 border-gray-600 hover:bg-gray-700' : 'text-gray-700 border-gray-300 hover:bg-gray-50'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>

        <!-- Messages d'erreur -->
        @if($errors->any())
            <div id="alert-error" class="flex p-4 mb-6 border-l-4 border-[#F87171] rounded-md fade-in-down"
                 :class="darkMode ? 'bg-red-200/10 text-[#F87171]' : 'bg-[#FEF2F2] text-[#F87171]'" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium mb-2">Erreurs de validation détectées :</h3>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 hover:bg-red-300/20 inline-flex h-8 w-8"
                        :class="darkMode ? 'bg-red-200/10 text-[#F87171]' : 'bg-[#FEF2F2] text-[#F87171]'"
                        data-dismiss-target="#alert-error" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Formulaire de création -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden" :class="darkMode ? 'dark:bg-gray-800' : ''">
            <form method="POST" action="{{ route('admin.departments.store', app()->getLocale()) }}" id="department-form">
                @csrf

                <!-- En-tête du formulaire -->
                <div class="px-6 py-4 border-b" :class="darkMode ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                    <h2 class="text-lg font-semibold flex items-center" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Informations du Département
                    </h2>
                    <p class="text-sm mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Les champs marqués d'un astérisque (*) sont obligatoires</p>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Section : Informations générales -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom du département -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Nom du département <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="name" id="name"
                                       value="{{ old('name') }}"
                                       required
                                       class="w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200 @error('name') border-red-500 @enderror"
                                       :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400' : 'bg-white border-gray-300'"
                                       placeholder="Ex: Informatique, Mathématiques...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="darkMode ? 'text-gray-400' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Code du département -->
                        <div class="space-y-2">
                            <label for="code" class="block text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Code du département
                            </label>
                            <div class="relative">
                                <input type="text" name="code" id="code"
                                       value="{{ old('code') }}"
                                       class="w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200 @error('code') border-red-500 @enderror"
                                       :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400' : 'bg-white border-gray-300'"
                                       placeholder="Ex: INFO, MATH, PHYS..."
                                       maxlength="10">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="darkMode ? 'text-gray-400' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                    </svg>
                                </div>
                            </div>
                            @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Code court pour identifier le département (optionnel)</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200 resize-none @error('description') border-red-500 @enderror"
                                  :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400' : 'bg-white border-gray-300'"
                                  placeholder="Description détaillée du département, ses missions, ses spécialités...">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Décrivez brièvement le rôle et les responsabilités de ce département</p>
                    </div>

                    <!-- Section : Gestion -->
                    <div class="border-t pt-6" :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        <h3 class="text-lg font-medium mb-4 flex items-center" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Gestion et Paramètres
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Académie -->
                            <div class="space-y-2">
                                <label for="academy_id" class="block text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    Académie <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="academy_id" id="academy_id" required
                                            class="w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200 @error('academy_id') border-red-500 @enderror"
                                            :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-200' : 'bg-white border-gray-300'">
                                        <option value="">Sélectionnez une académie</option>
                                        @foreach ($academies as $academy)
                                            <option value="{{ $academy->id }}" {{ old('academy_id') == $academy->id ? 'selected' : '' }}>
                                                {{ $academy->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="darkMode ? 'text-gray-400' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                </div>
                                @error('academy_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Chef de département -->
                            <div class="space-y-2">
                                <label for="head_id" class="block text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    Chef de département
                                </label>
                                <div class="relative">
                                    <select name="head_id" id="head_id"
                                            class="w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200 @error('head_id') border-red-500 @enderror"
                                            :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-200' : 'bg-white border-gray-300'">
                                        <option value="">Aucun chef assigné</option>
                                        @foreach ($heads as $head)
                                            <option value="{{ $head->id }}" {{ old('head_id') == $head->id ? 'selected' : '' }}>
                                                {{ $head->first_name }} {{ $head->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="darkMode ? 'text-gray-400' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                                @error('head_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Vous pourrez modifier ce choix plus tard</p>
                            </div>
                        </div>

                        <!-- Statut actif -->
                        <div class="mt-6">
                            <div class="flex items-center justify-between p-4 border rounded-lg" :class="darkMode ? 'border-gray-600 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <label for="is_active" class="text-sm font-medium cursor-pointer" :class="darkMode ? 'text-gray-300' : 'text-gray-900'">
                                            Département actif
                                        </label>
                                        <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            Les départements actifs apparaissent dans les listes et peuvent recevoir des affectations
                                        </p>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}
                                               class="sr-only peer">
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4CA3DD]"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions du formulaire -->
                <div class="px-6 py-4 border-t flex flex-col sm:flex-row gap-3 sm:gap-0 sm:justify-between" :class="darkMode ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                    <div class="flex items-center text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tous les champs marqués d'un (*) sont obligatoires
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}"
                           class="inline-flex justify-center items-center px-6 py-3 border text-sm font-medium rounded-lg transition-colors duration-200"
                           :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Annuler
                        </a>
                        <button type="submit"
                                class="inline-flex justify-center items-center px-6 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                id="submit-button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span id="submit-text">Créer le département</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Références aux éléments
            const form = document.getElementById('department-form');

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

            // Validation en temps réel
            const requiredFields = ['name', 'academy_id'];
            requiredFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (field) {
                    field.addEventListener('blur', function() {
                        validateField(this);
                    });

                    field.addEventListener('input', function() {
                        if (this.classList.contains('field-error')) {
                            validateField(this);
                        }
                    });
                }
            });

            function validateField(field) {
                const value = field.value.trim();
                const isRequired = field.hasAttribute('required');

                field.classList.remove('field-success', 'field-error');

                if (isRequired && !value) {
                    field.classList.add('field-error');
                    return false;
                } else if (value) {
                    field.classList.add('field-success');
                    return true;
                }
                return true;
            }

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

            // Amélioration de l'expérience utilisateur avec les sélects
            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                select.addEventListener('focus', function() {
                    this.style.transform = 'translateY(-1px)';
                });

                select.addEventListener('blur', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Sauvegarde automatique dans le localStorage (optionnel)
            const formFields = form.querySelectorAll('input, select, textarea');
            formFields.forEach(field => {
                // Restaurer la valeur sauvegardée
                const savedValue = localStorage.getItem(`dept_form_${field.name}`);
                if (savedValue && !field.value) {
                    if (field.type === 'checkbox') {
                        field.checked = savedValue === 'true';
                    } else {
                        field.value = savedValue;
                    }
                }

                // Sauvegarder lors des changements
                field.addEventListener('input', function() {
                    if (this.type === 'checkbox') {
                        localStorage.setItem(`dept_form_${this.name}`, this.checked);
                    } else {
                        localStorage.setItem(`dept_form_${this.name}`, this.value);
                    }
                });
            });

            // Nettoyer le localStorage après soumission réussie
            form.addEventListener('submit', function() {
                setTimeout(() => {
                    formFields.forEach(field => {
                        localStorage.removeItem(`dept_form_${field.name}`);
                    });
                }, 1000);
            });

            // Gestion des raccourcis clavier
            document.addEventListener('keydown', function(e) {
                // Ctrl+S pour sauvegarder
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    form.submit();
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
