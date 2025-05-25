@extends('layouts.app')

@section('title', 'Sélection du Centre - Gestion des Absences')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-sm font-medium transition-colors duration-150"
                   :class="darkMode ? 'text-gray-300 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1" :class="darkMode ? 'text-gray-500' : 'text-gray-400'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">Gestion des absences</span>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1" :class="darkMode ? 'text-gray-500' : 'text-gray-400'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Sélection du centre</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Conteneur principal avec animation -->
    <div class="min-h-[60vh] flex items-center justify-center">
        <div class="max-w-2xl w-full mx-auto fade-in-up">
            <!-- Carte principale -->
            <div class="rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl"
                 :class="darkMode ? 'bg-[#334155] border border-gray-600' : 'bg-white border border-gray-200'">

                <!-- En-tête avec icône -->
                <div class="text-center pt-8 pb-6 px-6">
                    <div class="mx-auto w-20 h-20 rounded-full flex items-center justify-center mb-6 transition-all duration-300"
                         :class="darkMode ? 'bg-[#F87171]/20' : 'bg-[#F87171]/10'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#F87171]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold mb-3 transition-colors duration-150"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Gestion des Absences
                    </h1>
                    <p class="text-lg transition-colors duration-150"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        Sélectionnez un centre pour gérer les absences des étudiants
                    </p>
                </div>

                <!-- Informations contextuelles -->
                <div class="px-6 pb-6">
                    <div class="rounded-lg p-4 mb-6 transition-colors duration-150"
                         :class="darkMode ? 'bg-[#2C3E50]/50 border border-gray-600' : 'bg-blue-50 border border-blue-200'">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4CA3DD] mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium" :class="darkMode ? 'text-blue-200' : 'text-blue-800'">
                                    À propos de la gestion des absences
                                </h3>
                                <div class="mt-2 text-sm" :class="darkMode ? 'text-blue-300' : 'text-blue-700'">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Enregistrement et suivi des absences par étudiant</li>
                                        <li>Justification des absences avec documents</li>
                                        <li>Statistiques et rapports d'assiduité</li>
                                        <li>Notifications automatiques aux parents</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Formulaire -->
                <form method="GET" action="{{ route('admin.absences.index', app()->getLocale()) }}" class="px-6 pb-8">
                    <!-- Sélecteur de centre -->
                    <div class="mb-8">
                        <label for="center_id" class="block text-sm font-semibold mb-3 transition-colors duration-150"
                               :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            Centre d'enseignement
                        </label>

                        <div class="relative">
                            <select name="center_id" id="center_id" required
                                    class="w-full pl-12 pr-10 py-4 text-base font-medium rounded-lg border-2 transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2 appearance-none cursor-pointer"
                                    :class="darkMode ?
                                        'bg-[#2C3E50] border-gray-600 text-white focus:border-[#4CA3DD] focus:ring-offset-[#334155]' :
                                        'bg-white border-gray-300 text-gray-900 focus:border-[#4CA3DD] focus:ring-offset-white hover:border-gray-400'">
                                <option value="" class="py-2">-- Choisir un centre --</option>
                                @foreach ($centers as $center)
                                    <option value="{{ $center->id }}" class="py-2">{{ $center->name }}</option>
                                @endforeach
                            </select>

                            <!-- Icône dans le champ -->
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="darkMode ? 'text-gray-400' : 'text-gray-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>

                            <!-- Flèche dropdown -->
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="h-5 w-5" :class="darkMode ? 'text-gray-400' : 'text-gray-500'" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques des centres -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        <div class="p-4 rounded-lg transition-colors duration-150"
                             :class="darkMode ? 'bg-[#2C3E50]/50 border border-gray-600' : 'bg-gray-50 border border-gray-200'">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3"
                                     :class="darkMode ? 'bg-[#4CA3DD]/20' : 'bg-[#4CA3DD]/10'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        {{ count($centers) }}
                                    </p>
                                    <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        Centre{{ count($centers) > 1 ? 's' : '' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 rounded-lg transition-colors duration-150"
                             :class="darkMode ? 'bg-[#2C3E50]/50 border border-gray-600' : 'bg-gray-50 border border-gray-200'">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3"
                                     :class="darkMode ? 'bg-[#34D399]/20' : 'bg-[#34D399]/10'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#34D399]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        Étudiants
                                    </p>
                                    <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        Tous niveaux
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 rounded-lg transition-colors duration-150"
                             :class="darkMode ? 'bg-[#2C3E50]/50 border border-gray-600' : 'bg-gray-50 border border-gray-200'">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3"
                                     :class="darkMode ? 'bg-[#F87171]/20' : 'bg-[#F87171]/10'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#F87171]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-semibold" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        Suivi
                                    </p>
                                    <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        Temps réel
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="text-center">
                        <button type="submit"
                                class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 bg-[#F87171] hover:bg-[#EF4444] text-white font-semibold rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 focus:ring-2 focus:ring-[#F87171] focus:ring-offset-2"
                                :class="darkMode ? 'focus:ring-offset-[#334155]' : 'focus:ring-offset-white'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Gérer les absences
                        </button>
                    </div>
                </form>
            </div>

            <!-- Cartes d'aperçu des centres -->
            @if(count($centers) > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4 transition-colors duration-150"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Centres disponibles
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($centers->take(6) as $center)
                            <div class="center-card cursor-pointer rounded-lg p-4 transition-all duration-200 hover:shadow-md border"
                                 :class="darkMode ? 'bg-[#2C3E50] border-gray-600 hover:border-[#F87171]' : 'bg-white border-gray-200 hover:border-[#F87171] hover:shadow-lg'"
                                 onclick="selectCenter({{ $center->id }}, '{{ $center->name }}')">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3"
                                             :class="darkMode ? 'bg-[#4CA3DD]/20' : 'bg-[#4CA3DD]/10'">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium transition-colors duration-150"
                                                :class="darkMode ? 'text-white' : 'text-gray-900'">
                                                {{ $center->name }}
                                            </h4>
                                            <p class="text-sm transition-colors duration-150"
                                               :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                {{ $center->academy->name ?? 'Académie' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-colors duration-150"
                                             :class="darkMode ? 'text-gray-400' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Animation pour l'entrée de la page */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Style personnalisé pour le select */
        select {
            background-image: none;
        }

        /* Amélioration du focus pour l'accessibilité */
        select:focus,
        button:focus {
            outline: none;
        }

        /* Animation au survol des cartes de centres */
        .center-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .center-card:hover {
            transform: translateY(-2px);
        }

        /* Style pour les options du select en mode sombre */
        select option {
            padding: 8px;
        }

        /* Animation de pulsation pour les erreurs */
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .animate-pulse {
            animation: pulse 0.6s ease-in-out;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fonction pour sélectionner un centre depuis les cartes
            window.selectCenter = function(centerId, centerName) {
                const select = document.getElementById('center_id');
                select.value = centerId;

                // Effet visuel pour indiquer la sélection
                const selectedCard = event.currentTarget;
                const allCards = document.querySelectorAll('.center-card');

                allCards.forEach(card => {
                    card.classList.remove('ring-2', 'ring-[#F87171]');
                });

                selectedCard.classList.add('ring-2', 'ring-[#F87171]');

                // Animation subtile
                selectedCard.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    selectedCard.style.transform = '';
                }, 200);
            };

            // Validation du formulaire avec feedback visuel
            const form = document.querySelector('form');
            const select = document.getElementById('center_id');
            const submitBtn = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function(e) {
                if (!select.value) {
                    e.preventDefault();

                    // Animation d'erreur
                    select.classList.add('border-red-500', 'ring-red-500');
                    select.parentElement.classList.add('animate-pulse');

                    setTimeout(() => {
                        select.parentElement.classList.remove('animate-pulse');
                    }, 600);

                    // Message d'erreur temporaire
                    const errorMsg = document.createElement('p');
                    errorMsg.className = 'text-red-500 text-sm mt-2';
                    errorMsg.textContent = 'Veuillez sélectionner un centre.';
                    select.parentElement.appendChild(errorMsg);

                    setTimeout(() => {
                        errorMsg.remove();
                        select.classList.remove('border-red-500', 'ring-red-500');
                    }, 3000);
                } else {
                    // Animation de chargement
                    submitBtn.innerHTML = `
                        <svg class="animate-spin h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Chargement...
                    `;
                    submitBtn.disabled = true;
                }
            });

            // Réinitialiser les styles d'erreur quand l'utilisateur sélectionne une option
            select.addEventListener('change', function() {
                this.classList.remove('border-red-500', 'ring-red-500');
                const errorMsg = this.parentElement.querySelector('p.text-red-500');
                if (errorMsg) {
                    errorMsg.remove();
                }
            });
        });
    </script>
@endpush
