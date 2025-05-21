@extends('layouts.app')

@section('title', 'Ajouter un Cours')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#4CA3DD] dark:text-gray-400 dark:hover:text-white">
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
                    <a href="{{ route('admin.courses.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-[#4CA3DD] md:ml-2 dark:text-gray-400 dark:hover:text-white">Gestion des Cours</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Ajouter un Cours</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <!-- En-tête avec titre -->
        <div class="flex items-center mb-8">
            <div class="w-10 h-10 rounded-full bg-[#4CA3DD] flex items-center justify-center text-white mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Ajouter un Cours</h1>
        </div>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div id="alert-errors" class="flex p-4 mb-6 text-red-800 border-l-4 border-red-500 bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
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
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 inline-flex h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-errors" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('admin.courses.store', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-8">
            @csrf

            <div class="grid md:grid-cols-2 gap-6">
                <!-- Code du cours -->
                <div class="form-group">
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                            Code <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">#</span>
                        </div>
                        <input type="text" name="code" id="code" value="{{ old('code') }}" required placeholder="ex: MATH101"
                               class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition duration-150 ease-in-out" />
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Code unique d'identification du cours</p>
                </div>

                <!-- Titre du cours -->
                <div class="form-group">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                            </svg>
                            Titre <span class="text-red-500">*</span>
                        </span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="ex: Mathématiques fondamentales"
                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition duration-150 ease-in-out" />
                    <p class="mt-1 text-xs text-gray-500">Titre complet du cours</p>
                </div>
            </div>

            <!-- Description du cours -->
            <div class="form-group">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                        Description
                    </span>
                </label>
                <textarea name="description" id="description" rows="5" placeholder="Description détaillée du cours..."
                          class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition duration-150 ease-in-out">{{ old('description') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Détaillez le programme et les objectifs du cours</p>
            </div>

            <!-- Formations associées -->
            <div class="form-group">
                <label for="formations" class="block text-sm font-medium text-gray-700 mb-2">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Formations associées
                    </span>
                </label>
                <div class="formations-select-container border border-gray-300 rounded-lg shadow-sm p-4 max-h-60 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach ($formations as $formation)
                            <div class="flex items-center px-3 py-2 hover:bg-gray-50 rounded-md transition">
                                <input type="checkbox" name="formations[]" id="formation_{{ $formation->id }}"
                                       value="{{ $formation->id }}"
                                       {{ in_array($formation->id, old('formations', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 text-[#4CA3DD] focus:ring-[#4CA3DD] rounded">
                                <label for="formation_{{ $formation->id }}" class="ml-3 text-sm text-gray-700 cursor-pointer">
                                    {{ $formation->name ?? $formation->title }}
                                </label>
                            </div>
                        @endforeach
                        @if(count($formations) == 0)
                            <div class="col-span-full text-center py-4 text-gray-500">
                                Aucune formation disponible
                            </div>
                        @endif
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-500">Sélectionnez les formations dans lesquelles ce cours sera enseigné</p>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Créer le cours
                </button>

                <a href="{{ route('admin.courses.index', ['locale' => app()->getLocale()]) }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 font-medium transition duration-150 ease-in-out">
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
        });
    </script>
@endpush
