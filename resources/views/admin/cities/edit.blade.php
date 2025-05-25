@extends('layouts.app')

@section('title', 'Modifier la Ville')

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
                    <a href="{{ route('admin.cities.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors duration-300 md:ml-2"
                       :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
                        Gestion des Villes
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
                        Modifier "{{ $city->name }}"
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="shadow-md rounded-lg p-6 mb-8 transition-colors duration-300"
         :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
        <!-- En-tête avec titre -->
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-[#4CA3DD] flex items-center justify-center text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold transition-colors duration-300"
                        :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                        Modifier la Ville
                    </h1>
                    <p class="text-sm transition-colors duration-300"
                       :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                        {{ $city->name }} - Code: {{ $city->code }}
                    </p>
                </div>
            </div>
            <a href="{{ route('admin.cities.index', ['locale' => app()->getLocale()]) }}"
               class="inline-flex items-center px-4 py-2 text-sm font-medium border rounded-lg transition-colors duration-200"
               :class="{ 'text-gray-300 border-gray-600 hover:bg-gray-700': darkMode, 'text-gray-700 border-gray-300 hover:bg-gray-50': !darkMode }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <!-- Informations rapides -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 rounded-lg transition-colors duration-300"
             :class="{ 'bg-gray-700': darkMode, 'bg-gray-50': !darkMode }">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs transition-colors duration-300"
                       :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">Créé le</p>
                    <p class="text-sm font-medium transition-colors duration-300"
                       :class="{ 'text-gray-200': darkMode, 'text-gray-900': !darkMode }">{{ $city->created_at->format('d/m/Y à H:i') }}</p>
                </div>
            </div>
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-xs transition-colors duration-300"
                       :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">Dernière modification</p>
                    <p class="text-sm font-medium transition-colors duration-300"
                       :class="{ 'text-gray-200': darkMode, 'text-gray-900': !darkMode }">{{ $city->updated_at->format('d/m/Y à H:i') }}</p>
                </div>
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
        <form action="{{ route('admin.cities.update', [app()->getLocale(), $city]) }}" method="POST" class="space-y-6" id="city-form">
            @csrf
            @method('PUT')

            <!-- Code de la ville -->
            <div class="form-group">
                <label for="code" class="block text-sm font-medium mb-2 transition-colors duration-300"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                        Code <span class="text-red-500">*</span>
                    </span>
                </label>
                <div class="relative">
                    <input type="text" name="code" id="code" value="{{ old('code', $city->code) }}" required
                           placeholder="ex: YDE, DLA, BAF..."
                           class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300 uppercase"
                           :class="{ 'bg-gray-700 border-gray-600 text-gray-700': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }"
                           maxlength="10" />
                </div>
                <p class="mt-1 text-xs transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                    Code unique pour identifier la ville (ex: YDE pour Yaoundé)
                </p>
                @error('code')
                <p class="mt-2 text-sm transition-colors duration-300"
                   :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Nom de la ville -->
            <div class="form-group">
                <label for="name" class="block text-sm font-medium mb-2 transition-colors duration-300"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                    <span class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Nom <span class="text-red-500">*</span>
                    </span>
                </label>
                <div class="relative">
                    <input type="text" name="name" id="name" value="{{ old('name', $city->name) }}" required
                           placeholder="ex: Yaoundé, Douala, Bafoussam..."
                           class="block w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD] sm:text-sm transition-colors duration-300"
                           :class="{ 'bg-white border-gray-600 text-gray-700': darkMode, 'bg-white border-gray-300 text-gray-700': !darkMode }" />
                </div>
                <p class="mt-1 text-xs transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                    Nom complet de la ville
                </p>
                @error('name')
                <p class="mt-2 text-sm transition-colors duration-300"
                   :class="{ 'text-red-400': darkMode, 'text-red-600': !darkMode }">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <!-- Alerte de changement important -->
            <div class="mt-6 p-4 border rounded-lg transition-colors duration-300"
                 :class="{ 'border-yellow-600 bg-yellow-200/10': darkMode, 'border-yellow-300 bg-yellow-50': !darkMode }">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.349 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-600">Attention</h3>
                        <p class="text-sm text-yellow-700 mt-1 transition-colors duration-300"
                           :class="{ 'text-yellow-400': darkMode, 'text-yellow-700': !darkMode }">
                            Les modifications apportées à cette ville affecteront tous les éléments qui lui sont associés (centres, utilisateurs, etc.).
                        </p>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t transition-colors duration-300"
                 :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                <button type="submit" id="submit-btn"
                        class="inline-flex justify-center items-center px-6 py-3 bg-yellow-600 hover:bg-yellow-700 text-white font-medium rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span id="submit-text">Mettre à jour</span>
                </button>

                <button type="button" id="reset-button"
                        class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg transition duration-150 ease-in-out hover:bg-gray-50"
                        :class="{ 'border-gray-600 text-gray-300 hover:bg-gray-700': darkMode, 'border-gray-300 text-gray-700 hover:bg-gray-50': !darkMode }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Réinitialiser
                </button>

                <a href="{{ route('admin.cities.index', ['locale' => app()->getLocale()]) }}"
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
