@extends('layouts.app')

@section('title', 'Modifier un Cours')

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
            <li class="inline-flex items-center">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.courses.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-[#4CA3DD] md:ml-2 dark:text-gray-400 dark:hover:text-white">Gestion des Cours</a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.courses.show', ['locale' => app()->getLocale(), 'course' => $course->id]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-[#4CA3DD] md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ $course->title }}</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm text-[#4CA3DD] font-medium md:ml-2 dark:text-gray-400">Modifier</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-5 mb-8">
        <!-- En-tête avec titre et icône -->
        <div class="flex items-center mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <h1 class="text-2xl font-bold text-gray-700">Modifier le cours</h1>
        </div>

        <!-- Messages d'erreurs -->
        @if ($errors->any())
            <div id="alert-error" class="flex p-4 mb-6 text-red-800 border-l-4 border-red-500 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3 text-sm">
                    <h3 class="font-medium mb-1">Veuillez corriger les erreurs suivantes :</h3>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-error" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Formulaire de modification -->
        <form action="{{ route('admin.courses.update', ['locale' => app()->getLocale(), 'course' => $course->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Colonne gauche -->
                <div class="space-y-6">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Informations de base
                            </h2>
                        </div>
                        <div class="p-4 space-y-4">
                            <!-- Code du cours -->
                            <div class="relative">
                                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                                    Code du cours <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="code" id="code" value="{{ old('code', $course->code) }}" required
                                           class="pl-10 w-full border border-gray-300 rounded-lg px-6 py-2 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent shadow-sm" />
                                </div>
                                @error('code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Titre du cours -->
                            <div class="relative">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                                    Titre du cours <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" required
                                           class="pl-10 w-full border border-gray-300 rounded-lg px-6 py-2 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent shadow-sm" />
                                </div>
                                @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Description du cours -->
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Description du cours
                            </h2>
                        </div>
                        <div class="p-4">
                            <div class="relative">
                                <textarea name="description" id="description" rows="11"
                                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent shadow-sm">{{ old('description', $course->description) }}</textarea>
                                @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne droite - Sélecteur de formations amélioré -->
                <div class="space-y-6">
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm" x-data="multiSelect()">
                        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Formations associées
                            </h2>
                        </div>
                        <div class="p-4">
                            <!-- Input de recherche pour filtrer les formations -->
                            <div class="relative mb-4">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input type="text" x-model="searchTerm" placeholder="Rechercher une formation..."
                                       class="pl-10 w-full border border-gray-300 rounded-lg px-6 py-2 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent shadow-sm" />
                            </div>

                            <!-- Formations sélectionnées -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Formations sélectionnées</label>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 min-h-[80px]">
                                    <template x-if="selectedFormations.length === 0">
                                        <p class="text-gray-500 text-sm italic">Aucune formation sélectionnée</p>
                                    </template>
                                    <div class="flex flex-wrap gap-2">
                                        <template x-for="formation in selectedFormations" :key="formation.id">
                                            <div class="flex items-center bg-[#EBF5FF] text-[#2A7AB8] rounded-full px-3 py-1 text-sm">
                                                <span x-text="formation.name"></span>
                                                <button type="button" @click="removeFormation(formation.id)" class="ml-2 text-gray-400 hover:text-red-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Liste des formations disponibles -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Formations disponibles</label>
                                <div class="bg-white border border-gray-200 rounded-lg h-[300px] overflow-y-auto">
                                    <template x-if="filteredFormations.length === 0">
                                        <div class="p-4 text-center text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                            Aucune formation trouvée
                                        </div>
                                    </template>
                                    <div class="divide-y divide-gray-200">
                                        <template x-for="formation in filteredFormations" :key="formation.id">
                                            <div class="p-3 hover:bg-gray-50 cursor-pointer flex items-center" @click="toggleFormation(formation)">
                                                <div class="flex-shrink-0 mr-3">
                                                    <div :class="isSelected(formation.id) ? 'bg-[#4CA3DD] border-[#4CA3DD]' : 'bg-white border-gray-300'"
                                                         class="w-5 h-5 rounded-md border flex items-center justify-center">
                                                        <svg x-show="isSelected(formation.id)" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <span class="block font-medium text-gray-800" x-text="formation.name"></span>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                <!-- Champ caché pour stocker les IDs des formations sélectionnées -->
                                <template x-for="formation in selectedFormations" :key="formation.id">
                                    <input type="hidden" name="formations[]" :value="formation.id">
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-wrap justify-end space-x-2 pt-6">
                <a href="{{ route('admin.courses.index', ['locale' => app()->getLocale()]) }}"
                   class="px-6 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 shadow-sm flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Annuler
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-dismiss pour les alertes
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[id^="alert-"]');

            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]', 'transition-all', 'duration-500');
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 8000); // Durée plus longue pour les erreurs
            });
        });

        // Fonction Alpine.js pour gérer la sélection multiple des formations
        function multiSelect() {
            return {
                searchTerm: '',
                allFormations: @json($formations->map(function($formation) {
                    return [
                        'id' => $formation->id,
                        'name' => $formation->name ?? $formation->title
                    ];
                })),
                selectedIds: @json(old('formations', $course->formations->pluck('id')->toArray())),

                get selectedFormations() {
                    return this.allFormations.filter(f => this.selectedIds.includes(f.id));
                },

                get filteredFormations() {
                    return this.allFormations.filter(f =>
                        f.name.toLowerCase().includes(this.searchTerm.toLowerCase())
                    );
                },

                isSelected(id) {
                    return this.selectedIds.includes(id);
                },

                toggleFormation(formation) {
                    if (this.isSelected(formation.id)) {
                        this.removeFormation(formation.id);
                    } else {
                        this.selectedIds.push(formation.id);
                    }
                },

                removeFormation(id) {
                    this.selectedIds = this.selectedIds.filter(fId => fId !== id);
                }
            }
        }
    </script>
@endpush
