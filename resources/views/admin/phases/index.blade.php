@extends('layouts.app')

@section('title', 'Gestion des Phases')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-sm font-medium transition-colors"
                   :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Gestion des Phases</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="shadow-md rounded-lg p-5 mb-8 transition-colors" :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white'">
        <!-- En-tête avec titre et bouton d'ajout -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold flex items-center transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Gestion des Phases
            </h1>
            <a href="{{ route('admin.phases.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouvelle Phase
            </a>
        </div>

        <!-- Messages d'alerte -->
        @if(session('success'))
            <div id="alert-success" class="flex p-4 mb-6 border-l-4 border-[#34D399] rounded-md fade-in-down"
                 :class="darkMode ? 'bg-green-200/10 text-[#34D399]' : 'bg-[#F0FDF4] text-[#34D399]'" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 transition-colors"
                        :class="darkMode ? 'bg-transparent hover:bg-green-200/20 text-[#34D399]' : 'bg-[#F0FDF4] hover:bg-[#ECFDF5] text-[#34D399]'"
                        data-dismiss-target="#alert-success" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="alert-error" class="flex p-4 mb-6 border-l-4 border-[#F87171] rounded-md fade-in-down"
                 :class="darkMode ? 'bg-red-200/10 text-[#F87171]' : 'bg-[#FEF2F2] text-[#F87171]'" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{ session('error') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 rounded-lg p-1.5 inline-flex h-8 w-8 transition-colors"
                        :class="darkMode ? 'bg-transparent hover:bg-red-200/20 text-[#F87171]' : 'bg-[#FEF2F2] hover:bg-[#FEE2E2] text-[#F87171]'"
                        data-dismiss-target="#alert-error" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Section des statistiques adaptées aux dates de création -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Statistique 1: Total des phases -->
            <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#4CA3DD]"
                         :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Total</span>
                </div>
                <div class="mb-3">
                    <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $phases->count() }}</h3>
                    <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">Phases enregistrées</p>
                </div>
                <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                    <div class="h-full bg-[#4CA3DD]" style="width: 100%"></div>
                </div>
            </div>

            <!-- Statistique 2: Phases créées ce mois-ci -->
            <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#34D399]"
                         :class="darkMode ? 'bg-green-900/30' : 'bg-green-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Ce mois</span>
                </div>
                <div class="mb-3">
                    @php
                        $now = \Carbon\Carbon::now();
                        $startOfMonth = $now->startOfMonth();
                        $thisMonthPhases = $phases->filter(function($phase) use ($startOfMonth) {
                            return \Carbon\Carbon::parse($phase->created_at)->gte($startOfMonth);
                        })->count();
                        $thisMonthPercentage = $phases->count() > 0 ? ($thisMonthPhases / $phases->count()) * 100 : 0;
                    @endphp
                    <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $thisMonthPhases }}</h3>
                    <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">Phases créées récemment</p>
                </div>
                <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                    <div class="h-full bg-[#34D399]" style="width: {{ $thisMonthPercentage }}%"></div>
                </div>
            </div>

            <!-- Statistique 3: Phases créées le mois dernier -->
            <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#FBBF24]"
                         :class="darkMode ? 'bg-yellow-900/30' : 'bg-yellow-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Mois dernier</span>
                </div>
                <div class="mb-3">
                    @php
                        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
                        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();
                        $lastMonthPhases = $phases->filter(function($phase) use ($startOfLastMonth, $endOfLastMonth) {
                            $createdAt = \Carbon\Carbon::parse($phase->created_at);
                            return $createdAt->gte($startOfLastMonth) && $createdAt->lte($endOfLastMonth);
                        })->count();
                        $lastMonthPercentage = $phases->count() > 0 ? ($lastMonthPhases / $phases->count()) * 100 : 0;
                    @endphp
                    <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $lastMonthPhases }}</h3>
                    <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">Mois précédent</p>
                </div>
                <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                    <div class="h-full bg-[#FBBF24]" style="width: {{ $lastMonthPercentage }}%"></div>
                </div>
            </div>

            <!-- Statistique 4: Phases plus anciennes -->
            <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#A78BFA]"
                         :class="darkMode ? 'bg-indigo-900/30' : 'bg-indigo-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Anciennes</span>
                </div>
                <div class="mb-3">
                    @php
                        $twoMonthsAgo = $startOfLastMonth->copy()->subMonth();
                        $olderPhases = $phases->filter(function($phase) use ($twoMonthsAgo) {
                            return \Carbon\Carbon::parse($phase->created_at)->lt($twoMonthsAgo);
                        })->count();
                        $olderPercentage = $phases->count() > 0 ? ($olderPhases / $phases->count()) * 100 : 0;
                    @endphp
                    <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $olderPhases }}</h3>
                    <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">Plus de 2 mois</p>
                </div>
                <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                    <div class="h-full bg-[#A78BFA]" style="width: {{ $olderPercentage }}%"></div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="relative w-full lg:w-80">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="search-phases"
                           class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                           :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-gray-50 border-gray-300 text-gray-900'"
                           placeholder="Rechercher une phase...">
                </div>
                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                    <select id="filter-date"
                            class="border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5 transition-colors"
                            :class="darkMode ? 'bg-[#334155] border-[#475569] text-gray-800' : 'bg-gray-50 border-gray-300 text-gray-900'">
                        <option value="">Période de création</option>
                        <option value="this-month">Ce mois-ci</option>
                        <option value="last-month">Mois dernier</option>
                        <option value="older">Plus anciennes</option>
                    </select>
                    <select id="filter-sort"
                            class="border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5 transition-colors"
                            :class="darkMode ? 'bg-[#334155] border-[#475569] text-gray-800' : 'bg-gray-50 border-gray-300 text-gray-900'">
                        <option value="created-desc">Création (récent → ancien)</option>
                        <option value="created-asc">Création (ancien → récent)</option>
                        <option value="start-asc">Date de début (croissant)</option>
                        <option value="start-desc">Date de début (décroissant)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tableau des phases -->
        @if($phases->isEmpty())
            <div class="p-8 text-center rounded-lg border transition-colors"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569] text-white' : 'bg-white border-gray-200'">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-16 w-16 mb-4 transition-colors"
                         :class="darkMode ? 'text-gray-500' : 'text-gray-400'"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-xl font-medium mb-2 transition-colors"
                       :class="darkMode ? 'text-white' : 'text-gray-800'">
                        Aucune phase enregistrée
                    </p>
                    <p class="mb-6 transition-colors"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        Commencez par créer une nouvelle phase pour organiser votre calendrier académique
                    </p>
                    <a href="{{ route('admin.phases.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer une phase
                    </a>
                </div>
            </div>
        @else
            <div class="overflow-x-auto rounded-lg border transition-colors"
                 :class="darkMode ? 'border-[#475569]' : 'border-gray-200'">
                <table class="min-w-full divide-y transition-colors"
                       :class="darkMode ? 'divide-[#475569]' : 'divide-gray-200'">
                    <thead class="transition-colors" :class="darkMode ? 'bg-[#2C3E50]' : 'bg-gray-50'">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Début
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Fin
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Durée
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Date de création
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y transition-colors"
                           :class="darkMode ? 'bg-[#1E293B] divide-[#475569]' : 'bg-white divide-gray-200'">
                    @foreach($phases as $phase)
                        @php
                            $startDate = \Carbon\Carbon::parse($phase->start);
                            $endDate = \Carbon\Carbon::parse($phase->end);
                            $createdDate = \Carbon\Carbon::parse($phase->created_at);

                            // Calculer la durée en jours
                            $duration = $startDate->diffInDays($endDate) + 1; // +1 pour inclure le jour de fin
                        @endphp
                        <tr class="transition-colors duration-150"
                            :class="darkMode ? 'hover:bg-[#2C3E50]' : 'hover:bg-gray-100'">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center text-blue-500 transition-colors"
                                         :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-50'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium transition-colors"
                                             :class="darkMode ? 'text-white' : 'text-gray-900'">
                                            {{ $startDate->format('d M Y') }}
                                        </div>
                                        <div class="text-sm transition-colors"
                                             :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                            {{ $startDate->format('l') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center text-red-500 transition-colors"
                                         :class="darkMode ? 'bg-red-900/30' : 'bg-red-50'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium transition-colors"
                                             :class="darkMode ? 'text-white' : 'text-gray-900'">
                                            {{ $endDate->format('d M Y') }}
                                        </div>
                                        <div class="text-sm transition-colors"
                                             :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                            {{ $endDate->format('l') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium transition-colors"
                                     :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    {{ $duration }} jours
                                </div>
                                <div class="text-sm transition-colors"
                                     :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                    @if($duration < 30)
                                        {{ $duration }} jours
                                    @elseif($duration < 365)
                                        {{ floor($duration / 30) }} mois {{ $duration % 30 }} jours
                                    @else
                                        {{ floor($duration / 365) }} ans {{ floor(($duration % 365) / 30) }} mois
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium transition-colors"
                                     :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    {{ $createdDate->format('d M Y') }}
                                </div>
                                <div class="text-sm transition-colors"
                                     :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                    {{ $createdDate->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                <div class="flex justify-center space-x-3">
                                    <a href="{{ route('admin.phases.edit', ['locale' => app()->getLocale(), 'phase' => $phase->id]) }}"
                                       class="transition-colors duration-150 text-[#4CA3DD]"
                                       :class="darkMode ? 'text-yellow-400 hover:text-yellow-300' : 'text-yellow-600 hover:text-yellow-800'"
                                       title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.phases.destroy', ['locale' => app()->getLocale(), 'phase' => $phase->id]) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette phase ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="transition-colors duration-150 text-red-600"
                                                :class="darkMode ? 'text-red-400 hover:text-red-300' : 'text-red-600 hover:text-red-800'"
                                                title="Supprimer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <!-- Pagination (si disponible) -->
        @if(isset($phases) && method_exists($phases, 'links') && $phases->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 px-6 py-4 border-t transition-colors"
                 :class="darkMode ? 'bg-[#1E293B] border-[#475569]' : 'bg-white border-gray-200'">
                <div class="pagination-info mb-4 sm:mb-0 transition-colors"
                     :class="darkMode ? 'text-gray-400' : 'text-[#64748B]'">
                    Affichage de <span :class="darkMode ? 'text-white' : 'text-[#1E293B]'">{{ $phases->firstItem() ?? 0 }}</span>
                    à <span :class="darkMode ? 'text-white' : 'text-[#1E293B]'">{{ $phases->lastItem() ?? 0 }}</span>
                    sur <span :class="darkMode ? 'text-white' : 'text-[#1E293B]'">{{ $phases->total() }}</span> phases
                </div>
                <div class="pagination-controls">
                    {{ $phases->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        @endif
    </div>
@endsection

@push('styles')
    <style>
        /* Style pour l'info de pagination */
        .pagination-info {
            font-size: 0.875rem;
            color: #64748B;
        }

        .pagination-info span {
            font-weight: 600;
            color: #1E293B;
        }

        /* Style pour les contrôles de pagination */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 2px;
        }

        .pagination li.disabled span,
        .pagination li.disabled a {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            text-decoration: none;
            transition: all 200ms;
        }

        /* Animation */
        .fade-in-down {
            animation: fadeInDown 0.5s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-dismiss pour les alertes
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

            // Filtrage des phases
            const searchInput = document.getElementById('search-phases');
            const dateFilter = document.getElementById('filter-date');
            const sortFilter = document.getElementById('filter-sort');

            // Exemple de traitement des filtres
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    console.log('Recherche:', this.value);
                    // Logique de filtrage à implémenter
                });
            }

            if (dateFilter) {
                dateFilter.addEventListener('change', function() {
                    console.log('Filtre date:', this.value);
                    // Logique de filtrage à implémenter
                });
            }

            if (sortFilter) {
                sortFilter.addEventListener('change', function() {
                    console.log('Tri:', this.value);
                    // Logique de tri à implémenter
                });
            }
        });
    </script>
@endpush
