@extends('layouts.app')

@section('title', 'Modifier la Salle')

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
                    <a href="{{ route('admin.rooms.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors duration-300 md:ml-2"
                       :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
                        Gestion des Salles
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
                        Modifier la Salle
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    @can('gestion.class.update')
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
                    Modifier la Salle
                </h1>
                <p class="text-sm transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                    {{ $room->name }} - ID: {{ $room->id }}
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
        <form action="{{ route('admin.rooms.update', ['locale' => app()->getLocale(), 'room' => $room->id]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nom de la salle -->
            <div class="form-group">
                <label for="name" class="block text-sm font-medium mb-2 transition-colors duration-300"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Nom <span class="text-red-500">*</span>
                    </span>
                </label>
                <div class="relative">
                    <input type="text" name="name" id="name" value="{{ old('name', $room->name) }}" required
                           class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                           :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }" />
                </div>
                <p class="mt-1 text-xs transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                    Nom ou numéro de la salle
                </p>
                @error('name')
                <p class="mt-2 text-sm transition-colors duration-300"
                   :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Capacité de la salle -->
            <div class="form-group">
                <label for="capacity" class="block text-sm font-medium mb-2 transition-colors duration-300"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Capacité
                    </span>
                </label>
                <div class="relative mt-1 rounded-md shadow-sm">
                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $room->capacity) }}" min="0"
                           class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                           :class="{ 'bg-gray-700 border-gray-600 text-white': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }" />
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 transition-colors duration-300"
                         :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                        <span class="sm:text-sm">personnes</span>
                    </div>
                </div>
                <p class="mt-1 text-xs transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                    Nombre maximum de personnes pouvant être accueillies
                </p>
                @error('capacity')
                <p class="mt-2 text-sm transition-colors duration-300"
                   :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <label for="formation_id">Formation affectée</label>
            <select name="formation_id" id="formation_id">
                <option value="">-- Aucune --</option>
                @foreach ($formations as $formation)
                    <option value="{{ $formation->id }}" {{ old('formation_id', $room->formation_id) == $formation->id ? 'selected' : '' }}>
                        {{ $formation->name }}
                    </option>
                @endforeach
            </select>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t transition-colors duration-300"
                 :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                <button type="submit" class="inline-flex justify-center items-center px-6 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Mettre à jour
                </button>

                <a href="{{ route('admin.rooms.index', ['locale' => app()->getLocale()]) }}"
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
                Créé le: {{ $room->created_at->format('d/m/Y à H:i') }}
            </div>
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Dernière modification: {{ $room->updated_at->format('d/m/Y à H:i') }}
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
