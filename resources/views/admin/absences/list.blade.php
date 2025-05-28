@extends('layouts.app')

@section('title', 'Gestion des Présences')

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
                    <span class="ml-1 text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Présences</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- En-tête avec informations du créneau -->
    <div class="mb-8">
        <div class="rounded-xl shadow-lg transition-all duration-300"
             :class="darkMode ? 'bg-[#334155] border border-gray-600' : 'bg-white border border-gray-200'">
            <div class="p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4"
                             :class="darkMode ? 'bg-[#4CA3DD]/20' : 'bg-[#4CA3DD]/10'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold transition-colors duration-150"
                                :class="darkMode ? 'text-white' : 'text-gray-900'">
                                Présences du créneau
                            </h1>
                            <p class="text-lg transition-colors duration-150"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                                {{ ucfirst(\Carbon\Carbon::parse($slot->week_day)->locale('fr')->dayName) }} ·
                                {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Statistiques rapides -->
                    <div class="flex space-x-4">
                        @php
                            $presentCount = $students->count() - count($absentStudentIds);
                            $absentCount = count($absentStudentIds);
                            $totalCount = $students->count();
                            $attendanceRate = $totalCount > 0 ? round(($presentCount / $totalCount) * 100) : 0;
                        @endphp

                        <div class="text-center">
                            <div class="text-2xl font-bold text-[#34D399]">{{ $presentCount }}</div>
                            <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Présents</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-[#F87171]">{{ $absentCount }}</div>
                            <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Absents</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold" :class="attendanceRate >= 80 ? 'text-[#34D399]' : (attendanceRate >= 60 ? 'text-[#FBBF24]' : 'text-[#F87171]')">
                                {{ $attendanceRate }}%
                            </div>
                            <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Taux</div>
                        </div>
                    </div>
                </div>

                <!-- Barre de progression -->
                <div class="mt-4">
                    <div class="flex justify-between text-sm mb-2" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                        <span>Taux de présence</span>
                        <span>{{ $attendanceRate }}% ({{ $presentCount }}/{{ $totalCount }})</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2" :class="darkMode ? 'bg-gray-700' : 'bg-gray-200'">
                        <div class="h-2 rounded-full transition-all duration-500"
                             :class="attendanceRate >= 80 ? 'bg-[#34D399]' : (attendanceRate >= 60 ? 'bg-[#FBBF24]' : 'bg-[#F87171]')"
                             style="width: {{ $attendanceRate }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    @if ($students->isEmpty())
        <!-- État vide -->
        <div class="text-center py-12">
            <div class="rounded-xl shadow-lg transition-all duration-300"
                 :class="darkMode ? 'bg-[#334155] border border-gray-600' : 'bg-white border border-gray-200'">
                <div class="p-8">
                    <div class="mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-4"
                         :class="darkMode ? 'bg-gray-600' : 'bg-gray-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" :class="darkMode ? 'text-gray-400' : 'text-gray-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2" :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Aucun étudiant inscrit
                    </h3>
                    <p class="text-base" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        Il n'y a aucun étudiant inscrit à ce créneau horaire.
                    </p>
                </div>
            </div>
        </div>
    @else
        <!-- Actions rapides -->
        <div class="mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-3 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <button type="button" id="markAllPresent"
                            class="inline-flex items-center px-4 py-2 bg-[#34D399] hover:bg-[#10B981] text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Marquer tous présents
                    </button>
                    <button type="button" id="markAllAbsent"
                            class="inline-flex items-center px-4 py-2 bg-[#F87171] hover:bg-[#EF4444] text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Marquer tous absents
                    </button>
                </div>

                <!-- Recherche -->
                <div class="relative">
                    <input type="text" id="searchStudent" placeholder="Rechercher un étudiant..."
                           class="pl-10 pr-4 py-2 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2"
                           :class="darkMode ?
                               'bg-[#2C3E50] border-gray-600 text-white placeholder-gray-400 focus:border-[#4CA3DD] focus:ring-offset-[#334155]' :
                               'bg-white border-gray-300 text-gray-900 placeholder-gray-500 focus:border-[#4CA3DD] focus:ring-offset-white'">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des étudiants -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="studentsContainer">
            @foreach ($students as $student)
                @php
                    $isAbsent = in_array($student->id, $absentStudentIds);
                @endphp
                <div class="student-card rounded-xl shadow-md transition-all duration-300 hover:shadow-lg"
                     :class="darkMode ? 'bg-[#334155] border border-gray-600' : 'bg-white border border-gray-200'"
                     data-student-name="{{ strtolower($student->first_name . ' ' . $student->last_name) }}">
                    <div class="p-6">
                        <!-- En-tête de la carte -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3 transition-all duration-200"
                                     :class="'{{ $isAbsent ? 'bg-[#F87171]/20' : 'bg-[#34D399]/20' }}'">
                                    @if($isAbsent)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#F87171]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#34D399]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-semibold transition-colors duration-150"
                                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </h3>
                                    <p class="text-sm transition-colors duration-150"
                                       :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        ID: #{{ $student->id }}
                                    </p>
                                </div>
                            </div>

                            <!-- Badge de statut -->
                            <span class="px-3 py-1 rounded-full text-sm font-medium transition-all duration-200 {{ $isAbsent ? 'bg-[#F87171] text-white' : 'bg-[#34D399] text-white' }}">
                                {{ $isAbsent ? 'Absent' : 'Présent' }}
                            </span>
                        </div>

                        <!-- Actions -->
                        <form method="POST" action="{{ route('admin.absences.toggle', ['locale' => app()->getLocale()]) }}" class="attendance-form">
                            @csrf
                            <input type="hidden" name="slot_id" value="{{ $slot->id }}">
                            <input type="hidden" name="student_id" value="{{ $student->id }}">

                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-3 font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 focus:ring-2 focus:ring-offset-2 {{ $isAbsent ? 'bg-[#34D399] hover:bg-[#10B981] text-white focus:ring-[#34D399]' : 'bg-[#F87171] hover:bg-[#EF4444] text-white focus:ring-[#F87171]' }}"
                                    :class="darkMode ? 'focus:ring-offset-[#334155]' : 'focus:ring-offset-white'">
                                @if($isAbsent)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Marquer présent
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Marquer absent
                                @endif
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Bouton retour -->
        <div class="mt-8 text-center">
            <a href="{{ route('admin.absences.index', ['locale' => app()->getLocale()]) }}"
               class="inline-flex items-center px-6 py-3 border-2 border-[#4CA3DD] text-[#4CA3DD] font-medium rounded-lg hover:bg-[#4CA3DD] hover:text-white transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2"
               :class="darkMode ? 'focus:ring-offset-[#1E293B]' : 'focus:ring-offset-white'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste des créneaux
            </a>
        </div>
    @endif
@endsection

@push('styles')
    <style>
        /* Animation pour l'entrée des cartes */
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

        .student-card {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Animation décalée pour les cartes */
        .student-card:nth-child(1) { animation-delay: 0.1s; }
        .student-card:nth-child(2) { animation-delay: 0.2s; }
        .student-card:nth-child(3) { animation-delay: 0.3s; }
        .student-card:nth-child(4) { animation-delay: 0.4s; }
        .student-card:nth-child(5) { animation-delay: 0.5s; }
        .student-card:nth-child(6) { animation-delay: 0.6s; }

        /* Effet de survol pour les cartes */
        .student-card:hover {
            transform: translateY(-4px);
        }

        /* Animation de chargement pour les boutons */
        .loading-btn {
            position: relative;
            overflow: hidden;
        }

        .loading-btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Style pour la recherche */
        .highlight {
            background-color: #FBBF24;
            padding: 2px 4px;
            border-radius: 4px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la recherche
            const searchInput = document.getElementById('searchStudent');
            const studentCards = document.querySelectorAll('.student-card');

            searchInput?.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                studentCards.forEach(card => {
                    const studentName = card.getAttribute('data-student-name');
                    if (studentName.includes(searchTerm)) {
                        card.style.display = 'block';
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(-20px)';
                        setTimeout(() => {
                            if (!studentName.includes(searchInput.value.toLowerCase())) {
                                card.style.display = 'none';
                            }
                        }, 200);
                    }
                });
            });

            // Actions groupées
            const markAllPresentBtn = document.getElementById('markAllPresent');
            const markAllAbsentBtn = document.getElementById('markAllAbsent');

            markAllPresentBtn?.addEventListener('click', function() {
                const absentButtons = document.querySelectorAll('button[type="submit"]:contains("Marquer présent")');
                if (confirm('Êtes-vous sûr de vouloir marquer tous les étudiants comme présents ?')) {
                    absentButtons.forEach(btn => btn.click());
                }
            });

            markAllAbsentBtn?.addEventListener('click', function() {
                const presentButtons = document.querySelectorAll('button[type="submit"]:contains("Marquer absent")');
                if (confirm('Êtes-vous sûr de vouloir marquer tous les étudiants comme absents ?')) {
                    presentButtons.forEach(btn => btn.click());
                }
            });

            // Animation de chargement pour les formulaires
            const forms = document.querySelectorAll('.attendance-form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const button = this.querySelector('button[type="submit"]');
                    button.classList.add('loading-btn');
                    button.disabled = true;

                    // Remplacer le contenu du bouton
                    const originalContent = button.innerHTML;
                    button.innerHTML = `
                        <svg class="animate-spin h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mise à jour...
                    `;
                });
            });

            // Helper pour la sélection de texte
            if (!String.prototype.includes) {
                String.prototype.includes = function(search, start) {
                    if (typeof start !== 'number') {
                        start = 0;
                    }
                    if (start + search.length > this.length) {
                        return false;
                    } else {
                        return this.indexOf(search, start) !== -1;
                    }
                };
            }
        });
    </script>
@endpush
