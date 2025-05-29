@extends('layouts.app')

@section('title', 'Sélection de la Formation')

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
                    <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors duration-150"
                       :class="darkMode ? 'text-gray-300 hover:text-white' : 'text-gray-500 hover:text-[#4CA3DD]'">
                        Emplois du temps
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1" :class="darkMode ? 'text-gray-500' : 'text-gray-400'" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Sélection de la formation</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Conteneur principal avec animation -->
    <div class="min-h-[60vh] flex items-center justify-center">
        <div class="max-w-4xl w-full mx-auto">
            <!-- Carte principale -->
            <div class="rounded-xl shadow-lg transition-all duration-300 hover:shadow-xl"
                 :class="darkMode ? 'bg-[#334155] border border-gray-600' : 'bg-white border border-gray-200'">

                <!-- En-tête avec informations du centre -->
                <div class="text-center pt-8 pb-6 px-6">
                    <div class="flex items-center justify-center mb-6">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center mr-4 transition-all duration-300"
                             :class="darkMode ? 'bg-[#4CA3DD]/20' : 'bg-[#4CA3DD]/10'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <div class="px-3 py-1 rounded-full text-xs font-medium mb-2 inline-block"
                                 :class="darkMode ? 'bg-[#4CA3DD]/20 text-[#4CA3DD]' : 'bg-[#4CA3DD]/10 text-[#4CA3DD]'">
                                Centre sélectionné
                            </div>
                            <h2 class="text-xl font-bold transition-colors duration-150"
                                :class="darkMode ? 'text-white' : 'text-gray-900'">
                                {{ $center->name }}
                            </h2>
                        </div>
                    </div>

                    <h1 class="text-3xl font-bold mb-3 transition-colors duration-150"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Sélection de la formation
                    </h1>
                    <p class="text-lg transition-colors duration-150"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        Choisissez une formation pour consulter son emploi du temps
                    </p>
                </div>

                <!-- Bouton retour -->
                <div class="px-6 mb-6">
                    <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center text-sm font-medium transition-colors duration-150 hover:underline"
                       :class="darkMode ? 'text-gray-300 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Changer de centre
                    </a>
                </div>

                @if(count($formations) > 0)
                    <!-- Grille des formations -->
                    <div class="px-6 pb-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($formations as $formation)
                                <div class="group cursor-pointer rounded-xl p-6 transition-all duration-300 border-2 hover:shadow-lg hover:-translate-y-1"
                                     :class="darkMode ? 'bg-[#2C3E50] border-gray-600 hover:border-[#4CA3DD] hover:bg-[#475569]' : 'bg-white border-gray-200 hover:border-[#4CA3DD] hover:shadow-xl'"
                                     onclick="selectFormation({{ $formation->id }})">

                                    <!-- Icône de la formation -->
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300"
                                         :class="darkMode ? 'bg-[#4CA3DD]/20' : 'bg-[#4CA3DD]/10'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>

                                    <!-- Nom de la formation -->
                                    <h3 class="text-xl font-bold mb-2 group-hover:text-[#4CA3DD] transition-colors duration-300"
                                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        {{ $formation->name }}
                                    </h3>

                                    <!-- Informations sur les salles -->
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center text-sm"
                                             :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#34D399]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $formation->rooms->count() }}
                                            salle{{ $formation->rooms->count() > 1 ? 's' : '' }} disponible{{ $formation->rooms->where('center_id', $center->id)->count() > 1 ? 's' : '' }}
                                        </div>

                                        <!-- Liste des salles -->
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($formation->rooms->take(3) as $room)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                                      :class="darkMode ? 'bg-[#475569] text-gray-300' : 'bg-gray-100 text-gray-700'">
                                                    {{ $room->name }}
                                                </span>
                                            @endforeach
                                            @if($formation->rooms->count() > 3)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                                      :class="darkMode ? 'bg-[#475569] text-gray-400' : 'bg-gray-100 text-gray-500'">
                                                    +{{ $formation->rooms->count() - 3 }} autres
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Bouton d'action -->
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                            Cliquez pour voir le planning
                                        </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4CA3DD] group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Message si aucune formation -->
                    <div class="px-6 pb-8">
                        <div class="text-center py-12 rounded-lg transition-colors duration-150"
                             :class="darkMode ? 'bg-[#475569]' : 'bg-gray-50'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 transition-colors duration-150"
                                 :class="darkMode ? 'text-[#64748B]' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <h3 class="text-xl font-semibold mb-2 transition-colors duration-150"
                                :class="darkMode ? 'text-[#F1F5F9]' : 'text-gray-900'">
                                Aucune formation disponible
                            </h3>
                            <p class="transition-colors duration-150"
                               :class="darkMode ? 'text-[#94A3B8]' : 'text-gray-600'">
                                Il n'y a pas de formations configurées avec des salles dans ce centre.
                            </p>
                        </div>
                    </div>
                @endif
            </div>
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

        /* Animation pour les cartes de formation */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .formation-card {
            animation: slideInUp 0.5s ease-out;
        }

        /* Délai d'animation pour chaque carte */
        .formation-card:nth-child(1) { animation-delay: 0.1s; }
        .formation-card:nth-child(2) { animation-delay: 0.2s; }
        .formation-card:nth-child(3) { animation-delay: 0.3s; }
        .formation-card:nth-child(4) { animation-delay: 0.4s; }
        .formation-card:nth-child(5) { animation-delay: 0.5s; }
        .formation-card:nth-child(6) { animation-delay: 0.6s; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter l'animation d'entrée
            document.querySelector('.max-w-4xl').classList.add('fade-in-up');

            // Ajouter l'animation aux cartes de formation
            document.querySelectorAll('.group').forEach(card => {
                card.classList.add('formation-card');
            });

            // Fonction pour sélectionner une formation
            window.selectFormation = function(formationId) {
                // Animation de chargement
                const card = event.currentTarget;
                const originalContent = card.innerHTML;

                card.innerHTML = `
                    <div class="flex items-center justify-center py-8">
                        <svg class="animate-spin h-8 w-8 text-[#4CA3DD]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="ml-2 text-[#4CA3DD] font-medium">Chargement...</span>
                    </div>
                `;

                // Redirection vers l'emploi du temps de la formation
                setTimeout(() => {
                    window.location.href = `{{ route('admin.planning.index', ['locale' => app()->getLocale()]) }}?center_id={{ $center->id }}&formation_id=${formationId}`;
                }, 500);
            };

            // Animation au survol
            document.querySelectorAll('.group').forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px) scale(1.02)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = '';
                });
            });
        });
    </script>
@endpush
