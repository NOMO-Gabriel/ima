@extends('layouts.app')

@section('title', 'Créer un nouveau concours')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-sm font-medium transition-all duration-200"
                   :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
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
                    <a href="{{ route('admin.entrance-exams.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-all duration-200 md:ml-2"
                       :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
                        Gestion des Concours
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium md:ml-2"
                          :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        Créer un nouveau concours
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="shadow-md rounded-lg p-6 mb-8" :class="darkMode ? 'bg-[#334155]' : 'bg-white'">
        <!-- En-tête avec titre -->
        <div class="flex items-center mb-8">
            <div class="w-10 h-10 rounded-full bg-[#4CA3DD] flex items-center justify-center text-white mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold" :class="darkMode ? 'text-[#F1F5F9]' : 'text-gray-800'">
                    Créer un nouveau concours
                </h1>
                <p class="text-sm mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Ajoutez un nouveau concours d'entrée à votre système
                </p>
            </div>
        </div>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div id="alert-errors" class="flex p-4 mb-6 border-l-4 border-red-500"
                 :class="darkMode ? 'bg-gray-800 text-red-400' : 'bg-red-50 text-red-800'" role="alert">
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
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 inline-flex h-8 w-8"
                        :class="darkMode ? 'bg-gray-800 text-red-400 hover:bg-gray-700' : 'bg-red-50 text-red-500'"
                        data-dismiss-target="#alert-errors" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="{{ route('admin.entrance-exams.store', app()->getLocale()) }}" class="space-y-8">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Code du concours -->
                <div class="form-group">
                    <label for="code" class="block text-sm font-medium mb-2"
                           :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                            Code du concours <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" required
                               placeholder="Ex: CONC2024-001"
                               class="block w-full pl-10 pr-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition duration-150 ease-in-out"
                               :class="darkMode ? 'bg-[#2C3E50] text-gray-300 border-gray-600 placeholder-gray-500' : 'bg-white text-gray-700 border-gray-300 placeholder-gray-400'" />
                    </div>
                    <p class="mt-1 text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        Code unique pour identifier le concours
                    </p>
                    @error('code')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom du concours -->
                <div class="form-group">
                    <label for="name" class="block text-sm font-medium mb-2"
                           :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Nom du concours <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               placeholder="Ex: Concours d'entrée Ingénierie 2024"
                               class="block w-full pl-10 pr-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition duration-150 ease-in-out"
                               :class="darkMode ? 'bg-[#2C3E50] text-gray-300 border-gray-600 placeholder-gray-500' : 'bg-white text-gray-700 border-gray-300 placeholder-gray-400'" />
                    </div>
                    <p class="mt-1 text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        Nom complet et descriptif du concours
                    </p>
                    @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Zone d'information -->
            <div class="border-l-4 border-[#4CA3DD] p-4 rounded"
                 :class="darkMode ? 'bg-blue-900/20' : 'bg-blue-50'">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-[#4CA3DD]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm" :class="darkMode ? 'text-blue-300' : 'text-blue-700'">
                            <strong>Conseils :</strong> Utilisez un code unique et facilement identifiable. Le nom doit être clair et inclure l'année pour faciliter la gestion. Une fois créé, vous pourrez configurer les détails supplémentaires comme les dates, critères et matières.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t"
                 :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Créer le concours
                </button>

                <a href="{{ route('admin.entrance-exams.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-6 py-3 border rounded-lg font-medium transition-all duration-200"
                   :class="darkMode ? 'border-gray-600 text-gray-300 bg-[#334155] hover:bg-[#475569]' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Annuler
                </a>
            </div>
        </form>
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

            // Auto-génération de code basé sur le nom (optionnel)
            let autoGenerateCode = true;

            codeInput.addEventListener('input', function() {
                if (this.value.trim()) {
                    autoGenerateCode = false;
                }
            });

            nameInput.addEventListener('input', function() {
                if (autoGenerateCode && this.value.trim()) {
                    const name = this.value.trim();
                    const year = new Date().getFullYear();
                    const words = name.split(' ').filter(word => word.length > 2);

                    if (words.length > 0) {
                        const initials = words.slice(0, 3).map(word => word.charAt(0).toUpperCase()).join('');
                        const suggestedCode = `${initials}${year}-001`;
                        codeInput.value = suggestedCode;
                        updatePreview();
                    }
                }
            });
        });
    </script>
@endpush
