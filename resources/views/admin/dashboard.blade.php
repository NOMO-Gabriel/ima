@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
    @php
        use Carbon\Carbon;

        // Dates pour les comparaisons
        $now = Carbon::now();
        $startOfThisMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();
        $startOfThisWeek = $now->copy()->startOfWeek();

        // Calcul des statistiques des élèves
        $studentsThisMonth = \App\Models\User::role('eleve')
            ->where('created_at', '>=', $startOfThisMonth)
            ->count();

        $studentsLastMonth = \App\Models\User::role('eleve')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        $studentsGrowthPercentage = $studentsLastMonth > 0
            ? round((($studentsThisMonth - $studentsLastMonth) / $studentsLastMonth) * 100, 1)
            : ($studentsThisMonth > 0 ? 100 : 0);

        // Calcul des statistiques des enseignants
        $teachersThisMonth = \App\Models\User::role('enseignant')
            ->where('created_at', '>=', $startOfThisMonth)
            ->count();

        $teachersLastMonth = \App\Models\User::role('enseignant')
            ->whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])
            ->count();

        $teachersGrowthPercentage = $teachersLastMonth > 0
            ? round((($teachersThisMonth - $teachersLastMonth) / $teachersLastMonth) * 100, 1)
            : ($teachersThisMonth > 0 ? 100 : 0);

        // Calcul des cours cette semaine
        $coursesThisWeek = \App\Models\Slot::whereHas('timetable', function($query) use ($startOfThisWeek) {
            $query->whereBetween('week_start_date', [
                $startOfThisWeek->toDateString(),
                $startOfThisWeek->copy()->addWeek()->toDateString()
            ]);
        })->count();

        // Calcul de croissance des revenus (simulation)
        $revenueGrowthPercentage = 15; // Peut être calculé en fonction des paiements réels
    @endphp

        <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <span class="inline-flex items-center text-sm font-medium text-[#4CA3DD]">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Tableau de bord
                </span>
            </li>
        </ol>
    </nav>

    <div class="space-y-8">
        <!-- Section de bienvenue améliorée -->
        <div class="welcome-section bg-gradient-to-r from-[#4CA3DD] to-[#2A7AB8] rounded-xl shadow-lg p-8"
             :class="darkMode ? 'from-[#2A7AB8] to-[#1E293B]' : 'from-[#4CA3DD] to-[#2A7AB8]'">
            <div class="flex flex-col lg:flex-row justify-between items-center">
                <div class="welcome-text mb-6 lg:mb-0 text-center lg:text-left">
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-600 mb-3">
                        Bienvenue, {{ Auth::user()->first_name }} 👋
                    </h1>
                    <p class="text-gray-400 text-lg max-w-2xl">
                        Gérez efficacement votre personnel et vos services éducatifs. Suivez vos indicateurs en temps réel
                        et optimisez le fonctionnement de votre institution.
                    </p>
                    <div class="mt-4 flex items-center text-gray-400 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                    </div>
                </div>
                <div class="welcome-actions flex flex-col sm:flex-row gap-3">
                    @can('course.create')
                        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-white text-[#4CA3DD] font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-1 hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Planifier un cours
                        </a>
                    @endcan

                    @can('user.create')
                        <a href="{{ route('admin.users.create', ['locale' => app()->getLocale()]) }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-[#4CA3DD] text-white/90 border border-white/20 font-medium rounded-lg hover:bg-[#4CA3DD] transition-all duration-200 transform hover:-translate-y-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                            Ajouter un utilisateur
                        </a>
                    @endcan
                </div>
            </div>
        </div>

        <!-- Statistiques principales -->
        <div class="stats-container">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold flex items-center transition-colors duration-150"
                    :class="darkMode ? 'text-white' : 'text-gray-800'">
                    <svg class="w-7 h-7 mr-3 text-[#4CA3DD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Vue d'ensemble
                </h2>
                <div class="flex items-center space-x-2 text-sm transition-colors duration-150"
                     :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
                    </svg>
                    Mis à jour il y a quelques minutes
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @can('user.view.any')
                    <!-- Élèves inscrits -->
                    <div class="stats-card rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-200 border group hover:-translate-y-1 relative"
                         :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stats-icon p-3 rounded-xl group-hover:scale-110 transition-transform duration-200"
                                 :class="darkMode ? 'bg-blue-900 text-[#4CA3DD]' : 'bg-blue-100 text-[#4CA3DD]'">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium transition-colors duration-150"
                                  :class="darkMode ? 'text-gray-400' : 'text-gray-500'">ÉLÈVES</span>
                        </div>
                        <div class="stats-content">
                            <h3 class="text-3xl font-bold mb-1 transition-colors duration-150"
                                :class="darkMode ? 'text-white' : 'text-gray-800'">{{ number_format($stats['students_count'] ?? 0) }}</h3>
                            <p class="text-sm transition-colors duration-150"
                               :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Élèves inscrits</p>
                            <div class="mt-3 flex items-center">
                                <div class="flex items-center text-xs {{ $studentsGrowthPercentage >= 0 ? 'text-[#34D399]' : 'text-[#F87171]' }}">
                                    @if($studentsGrowthPercentage >= 0)
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        +{{ $studentsGrowthPercentage }}%
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $studentsGrowthPercentage }}%
                                    @endif
                                </div>
                                <span class="text-xs ml-2 transition-colors duration-150"
                                      :class="darkMode ? 'text-gray-400' : 'text-gray-500'">ce mois</span>
                            </div>
                        </div>
                        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="absolute inset-0 rounded-xl"></a>
                    </div>

                    <!-- Enseignants actifs -->
                    <div class="stats-card rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-200 border group hover:-translate-y-1 relative"
                         :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stats-icon p-3 rounded-xl group-hover:scale-110 transition-transform duration-200"
                                 :class="darkMode ? 'bg-green-900 text-[#34D399]' : 'bg-green-100 text-[#34D399]'">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium transition-colors duration-150"
                                  :class="darkMode ? 'text-gray-400' : 'text-gray-500'">ENSEIGNANTS</span>
                        </div>
                        <div class="stats-content">
                            <h3 class="text-3xl font-bold mb-1 transition-colors duration-150"
                                :class="darkMode ? 'text-white' : 'text-gray-800'">{{ number_format($stats['teachers_count'] ?? 0) }}</h3>
                            <p class="text-sm transition-colors duration-150"
                               :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Enseignants actifs</p>
                            <div class="mt-3 flex items-center">
                                <div class="flex items-center text-xs {{ $teachersGrowthPercentage >= 0 ? 'text-[#34D399]' : 'text-[#F87171]' }}">
                                    @if($teachersGrowthPercentage >= 0)
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        +{{ $teachersGrowthPercentage }}%
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $teachersGrowthPercentage }}%
                                    @endif
                                </div>
                                <span class="text-xs ml-2 transition-colors duration-150"
                                      :class="darkMode ? 'text-gray-400' : 'text-gray-500'">ce mois</span>
                            </div>
                        </div>
                        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="absolute inset-0 rounded-xl"></a>
                    </div>
                @endcan

                @can('course.view')
                    <!-- Cours planifiés -->
                    <div class="stats-card rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-200 border group hover:-translate-y-1 relative"
                         :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stats-icon p-3 rounded-xl group-hover:scale-110 transition-transform duration-200"
                                 :class="darkMode ? 'bg-yellow-900 text-[#FBBF24]' : 'bg-yellow-100 text-[#FBBF24]'">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium transition-colors duration-150"
                                  :class="darkMode ? 'text-gray-400' : 'text-gray-500'">COURS</span>
                        </div>
                        <div class="stats-content">
                            <h3 class="text-3xl font-bold mb-1 transition-colors duration-150"
                                :class="darkMode ? 'text-white' : 'text-gray-800'">{{ number_format($stats['courses_count'] ?? 0) }}</h3>
                            <p class="text-sm transition-colors duration-150"
                               :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Cours aujourd'hui</p>
                            <div class="mt-3 flex items-center">
                                <div class="flex items-center text-xs text-[#FBBF24]">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $coursesThisWeek }} cette semaine
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.courses.index', ['locale' => app()->getLocale()]) }}" class="absolute inset-0 rounded-xl"></a>
                    </div>
                @endcan

                @can('finance.transaction.view')
                    <!-- Revenus -->
                    <div class="stats-card rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-200 border group hover:-translate-y-1 relative"
                         :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stats-icon p-3 rounded-xl group-hover:scale-110 transition-transform duration-200"
                                 :class="darkMode ? 'bg-red-900 text-[#F87171]' : 'bg-red-100 text-[#F87171]'">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium transition-colors duration-150"
                                  :class="darkMode ? 'text-gray-400' : 'text-gray-500'">REVENUS</span>
                        </div>
                        <div class="stats-content">
                            <h3 class="text-3xl font-bold mb-1 transition-colors duration-150"
                                :class="darkMode ? 'text-white' : 'text-gray-800'">{{ number_format($stats['revenue'] ?? 0, 1) }}M</h3>
                            <p class="text-sm transition-colors duration-150"
                               :class="darkMode ? 'text-gray-400' : 'text-gray-600'">FCFA ce mois</p>
                            <div class="mt-3 flex items-center">
                                <div class="flex items-center text-xs {{ $revenueGrowthPercentage >= 0 ? 'text-[#34D399]' : 'text-[#F87171]' }}">
                                    @if($revenueGrowthPercentage >= 0)
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        +{{ $revenueGrowthPercentage }}%
                                    @else
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l4.293-4.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $revenueGrowthPercentage }}%
                                    @endif
                                </div>
                                <span class="text-xs ml-2 transition-colors duration-150"
                                      :class="darkMode ? 'text-gray-400' : 'text-gray-500'">vs mois dernier</span>
                            </div>
                        </div>
                        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="absolute inset-0 rounded-xl"></a>
                    </div>
                @endcan
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="actions-section">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold flex items-center transition-colors duration-150"
                    :class="darkMode ? 'text-white' : 'text-gray-800'">
                    <svg class="w-7 h-7 mr-3 text-[#4CA3DD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Actions rapides
                </h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @can('user.create')
                    <!-- Ajouter un élève -->
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                       class="action-card p-6 rounded-xl shadow-md hover:shadow-lg border text-center transition-all duration-200 group hover:-translate-y-2"
                       :class="darkMode ? 'bg-gray-800 border-gray-700 hover:bg-gray-700' : 'bg-white border-gray-200 hover:bg-gray-50'">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-[#4CA3DD] text-xl mx-auto mb-4 group-hover:scale-110 transition-transform duration-200"
                             :class="darkMode ? 'bg-blue-900' : 'bg-blue-100'">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2 transition-colors duration-150"
                            :class="darkMode ? 'text-white' : 'text-gray-900'">Ajouter un élève</h4>
                        <p class="text-sm transition-colors duration-150"
                           :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Enregistrer un nouvel élève dans le système</p>
                    </a>

                    <!-- Ajouter un enseignant -->
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                       class="action-card p-6 rounded-xl shadow-md hover:shadow-lg border text-center transition-all duration-200 group hover:-translate-y-2"
                       :class="darkMode ? 'bg-gray-800 border-gray-700 hover:bg-gray-700' : 'bg-white border-gray-200 hover:bg-gray-50'">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-[#34D399] text-xl mx-auto mb-4 group-hover:scale-110 transition-transform duration-200"
                             :class="darkMode ? 'bg-green-900' : 'bg-green-100'">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2 transition-colors duration-150"
                            :class="darkMode ? 'text-white' : 'text-gray-900'">Ajouter un enseignant</h4>
                        <p class="text-sm transition-colors duration-150"
                           :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Enregistrer un nouvel enseignant</p>
                    </a>
                @endcan

                @can('course.create')
                    <!-- Planifier un cours -->
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                       class="action-card p-6 rounded-xl shadow-md hover:shadow-lg border text-center transition-all duration-200 group hover:-translate-y-2"
                       :class="darkMode ? 'bg-gray-800 border-gray-700 hover:bg-gray-700' : 'bg-white border-gray-200 hover:bg-gray-50'">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-[#FBBF24] text-xl mx-auto mb-4 group-hover:scale-110 transition-transform duration-200"
                             :class="darkMode ? 'bg-yellow-900' : 'bg-yellow-100'">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2 transition-colors duration-150"
                            :class="darkMode ? 'text-white' : 'text-gray-900'">Planifier un cours</h4>
                        <p class="text-sm transition-colors duration-150"
                           :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Programmer un nouveau cours</p>
                    </a>
                @endcan

                @can('finance.report.generate')
                    <!-- Générer un rapport -->
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                       class="action-card p-6 rounded-xl shadow-md hover:shadow-lg border text-center transition-all duration-200 group hover:-translate-y-2"
                       :class="darkMode ? 'bg-gray-800 border-gray-700 hover:bg-gray-700' : 'bg-white border-gray-200 hover:bg-gray-50'">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center text-[#A78BFA] text-xl mx-auto mb-4 group-hover:scale-110 transition-transform duration-200"
                             :class="darkMode ? 'bg-purple-900' : 'bg-purple-100'">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2 transition-colors duration-150"
                            :class="darkMode ? 'text-white' : 'text-gray-900'">Générer un rapport</h4>
                        <p class="text-sm transition-colors duration-150"
                           :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Créer un rapport personnalisé</p>
                    </a>
                @endcan
            </div>
        </div>

        <!-- Liens de gestion -->
        <div class="management-links">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold flex items-center transition-colors duration-150"
                    :class="darkMode ? 'text-white' : 'text-gray-800'">
                    <svg class="w-7 h-7 mr-3 text-[#4CA3DD]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Modules de gestion
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Académies -->
                <a href="{{ route('admin.academies.index', ['locale' => app()->getLocale()]) }}"
                   class="management-card p-6 rounded-xl shadow-md hover:shadow-lg border transition-all duration-200 group hover:-translate-y-1 relative"
                   :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-[#4CA3DD] group-hover:scale-110 transition-transform duration-200"
                             :class="darkMode ? 'bg-blue-900' : 'bg-blue-100'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 transition-colors duration-200"
                             :class="darkMode ? 'text-gray-400 group-hover:text-[#4CA3DD]' : 'text-gray-400 group-hover:text-[#4CA3DD]'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 transition-colors duration-150"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">Académies</h3>
                    <p class="text-sm mb-3 transition-colors duration-150"
                       :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Gérer les académies et départements</p>
                    <div class="flex items-center text-xs transition-colors duration-150"
                         :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        <span class="w-2 h-2 bg-[#34D399] rounded-full mr-2"></span>
                        {{ count(\App\Models\Academy::all()) }} académies actives
                    </div>
                </a>

                <!-- Formations -->
                <a href="{{ route('admin.formations.index', ['locale' => app()->getLocale()]) }}"
                   class="management-card p-6 rounded-xl shadow-md hover:shadow-lg border transition-all duration-200 group hover:-translate-y-1 relative"
                   :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-[#34D399] group-hover:scale-110 transition-transform duration-200"
                             :class="darkMode ? 'bg-green-900' : 'bg-green-100'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 transition-colors duration-200"
                             :class="darkMode ? 'text-gray-400 group-hover:text-[#4CA3DD]' : 'text-gray-400 group-hover:text-[#4CA3DD]'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 transition-colors duration-150"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">Formations</h3>
                    <p class="text-sm mb-3 transition-colors duration-150"
                       :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Gérer les formations et programmes</p>
                    <div class="flex items-center text-xs transition-colors duration-150"
                         :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        <span class="w-2 h-2 bg-[#34D399] rounded-full mr-2"></span>
                        {{ count(\App\Models\Formation::all()) }} formations disponibles
                    </div>
                </a>

                <!-- Centres -->
                <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}"
                   class="management-card p-6 rounded-xl shadow-md hover:shadow-lg border transition-all duration-200 group hover:-translate-y-1 relative"
                   :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-[#FBBF24] group-hover:scale-110 transition-transform duration-200"
                             :class="darkMode ? 'bg-yellow-900' : 'bg-yellow-100'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 transition-colors duration-200"
                             :class="darkMode ? 'text-gray-400 group-hover:text-[#4CA3DD]' : 'text-gray-400 group-hover:text-[#4CA3DD]'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 transition-colors duration-150"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">Centres</h3>
                    <p class="text-sm mb-3 transition-colors duration-150"
                       :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Gérer les centres de formation</p>
                    <div class="flex items-center text-xs transition-colors duration-150"
                         :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        <span class="w-2 h-2 bg-[#34D399] rounded-full mr-2"></span>
                        {{ count(\App\Models\Center::all()) }} centres en activité
                    </div>
                </a>

                <!-- Cours -->
                <a href="{{ route('admin.courses.index', ['locale' => app()->getLocale()]) }}"
                   class="management-card p-6 rounded-xl shadow-md hover:shadow-lg border transition-all duration-200 group hover:-translate-y-1 relative"
                   :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-[#A78BFA] group-hover:scale-110 transition-transform duration-200"
                             :class="darkMode ? 'bg-purple-900' : 'bg-purple-100'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 transition-colors duration-200"
                             :class="darkMode ? 'text-gray-400 group-hover:text-[#4CA3DD]' : 'text-gray-400 group-hover:text-[#4CA3DD]'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 transition-colors duration-150"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">Cours</h3>
                    <p class="text-sm mb-3 transition-colors duration-150"
                       :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Gérer les cours et matières</p>
                    <div class="flex items-center text-xs transition-colors duration-150"
                         :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        <span class="w-2 h-2 bg-[#34D399] rounded-full mr-2"></span>
                        {{ count(\App\Models\Course::all()) }} cours programmés
                    </div>
                </a>

                <!-- Planning -->
                <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale()]) }}"
                   class="management-card p-6 rounded-xl shadow-md hover:shadow-lg border transition-all duration-200 group hover:-translate-y-1 relative"
                   :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-[#F87171] group-hover:scale-110 transition-transform duration-200"
                             :class="darkMode ? 'bg-red-900' : 'bg-red-100'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 transition-colors duration-200"
                             :class="darkMode ? 'text-gray-400 group-hover:text-[#4CA3DD]' : 'text-gray-400 group-hover:text-[#4CA3DD]'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 transition-colors duration-150"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">Planning</h3>
                    <p class="text-sm mb-3 transition-colors duration-150"
                       :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Gérer les emplois du temps</p>
                    <div class="flex items-center text-xs transition-colors duration-150"
                         :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        <span class="w-2 h-2 bg-[#FBBF24] rounded-full mr-2"></span>
                        Visualiser les plannings
                    </div>
                </a>

                <!-- Utilisateurs -->
                <a href="{{ route('admin.users.index', ['locale' => app()->getLocale()]) }}"
                   class="management-card p-6 rounded-xl shadow-md hover:shadow-lg border transition-all duration-200 group hover:-translate-y-1 relative"
                   :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform duration-200"
                             :class="darkMode ? 'bg-indigo-900' : 'bg-indigo-100'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <svg class="w-5 h-5 transition-colors duration-200"
                             :class="darkMode ? 'text-gray-400 group-hover:text-[#4CA3DD]' : 'text-gray-400 group-hover:text-[#4CA3DD]'"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 transition-colors duration-150"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">Utilisateurs</h3>
                    <p class="text-sm mb-3 transition-colors duration-150"
                       :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Gérer les utilisateurs et rôles</p>
                    <div class="flex items-center text-xs transition-colors duration-150"
                         :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        <span class="w-2 h-2 bg-[#34D399] rounded-full mr-2"></span>
                        {{ \App\Models\User::count() }} utilisateurs
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .stats-card {
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4CA3DD, #2A7AB8);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .stats-card:hover::before {
            transform: scaleX(1);
        }

        .management-card {
            position: relative;
            overflow: hidden;
        }

        .management-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #4CA3DD, #34D399);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .management-card:hover::before {
            transform: scaleX(1);
        }

        .welcome-section {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);
        }

        /* Animations */
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stats-container > div > div {
            animation: slideInUp 0.6s ease-out;
        }

        .stats-container > div > div:nth-child(1) { animation-delay: 0.1s; }
        .stats-container > div > div:nth-child(2) { animation-delay: 0.2s; }
        .stats-container > div > div:nth-child(3) { animation-delay: 0.3s; }
        .stats-container > div > div:nth-child(4) { animation-delay: 0.4s; }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des statistiques au chargement
            const statsCards = document.querySelectorAll('.stats-card');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            statsCards.forEach((card) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(card);
            });

            // Animation des compteurs
            function animateCounter(element, target) {
                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = target.toLocaleString();
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current).toLocaleString();
                    }
                }, 20);
            }

            // Démarrer l'animation des compteurs quand ils sont visibles
            const counters = document.querySelectorAll('.stats-value');
            counters.forEach(counter => {
                const targetValue = parseInt(counter.textContent.replace(/\D/g, ''));
                if (targetValue > 0) {
                    observer.observe(counter);
                    counter.addEventListener('animationstart', () => {
                        animateCounter(counter, targetValue);
                    });
                }
            });
        });
    </script>
@endpush
