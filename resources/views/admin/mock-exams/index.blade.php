@extends('layouts.app')

@section('title', 'Gestion des Concours Blancs')

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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Gestion des Concours Blancs</span>
                </div>
            </li>
        </ol>
    </nav>

    @can('gestion.exam.read')
        <div class="shadow-md rounded-lg p-5 mb-8 transition-colors" :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white'">
            <!-- En-tête avec titre et bouton d'ajout -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold flex items-center transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Gestion des Concours Blancs
                </h1>
                @can('gestion.exam.create')
                    <a href="{{ route('admin.mock-exams.create', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Nouveau Concours Blanc
                    </a>
                @endcan
            </div>

            <!-- Messages d'alerte -->
            <x-flash-message />

            <!-- Section des statistiques -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Statistique 1: Total des concours -->
                <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                     :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#4CA3DD]"
                             :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Total</span>
                    </div>
                    <div class="mb-3">
                        <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $mockExams->count() }}</h3>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">Concours blancs</p>
                    </div>
                    <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                        <div class="h-full bg-[#4CA3DD]" style="width: 100%"></div>
                    </div>
                </div>

                <!-- Statistique 2: Par type QCM -->
                @php
                    $qcmCount = $mockExams->where('type', 'QCM')->count();
                    $qcmPercentage = $mockExams->count() > 0 ? ($qcmCount / $mockExams->count()) * 100 : 0;
                @endphp
                <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                     :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#34D399]"
                             :class="darkMode ? 'bg-green-900/30' : 'bg-green-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">QCM</span>
                    </div>
                    <div class="mb-3">
                        <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $qcmCount }}</h3>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">QCM uniquement</p>
                    </div>
                    <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                        <div class="h-full bg-[#34D399]" style="width: {{ $qcmPercentage }}%"></div>
                    </div>
                </div>

                <!-- Statistique 3: Par type REDACTION -->
                @php
                    $redactionCount = $mockExams->where('type', 'REDACTION')->count();
                    $redactionPercentage = $mockExams->count() > 0 ? ($redactionCount / $mockExams->count()) * 100 : 0;
                @endphp
                <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                     :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#FBBF24]"
                             :class="darkMode ? 'bg-yellow-900/30' : 'bg-yellow-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Rédaction</span>
                    </div>
                    <div class="mb-3">
                        <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $redactionCount }}</h3>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">Rédaction pure</p>
                    </div>
                    <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                        <div class="h-full bg-[#FBBF24]" style="width: {{ $redactionPercentage }}%"></div>
                    </div>
                </div>

                <!-- Statistique 4: Par type MIX -->
                @php
                    $mixCount = $mockExams->where('type', 'MIX')->count();
                    $mixPercentage = $mockExams->count() > 0 ? ($mixCount / $mockExams->count()) * 100 : 0;
                @endphp
                <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                     :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#A78BFA]"
                             :class="darkMode ? 'bg-indigo-900/30' : 'bg-indigo-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.871 4A17.926 17.926 0 003 12c0 2.874.673 5.59 1.871 8m14.13 0a17.926 17.926 0 001.87-8c0-2.874-.673-5.59-1.87-8M9 9h1.246a1 1 0 01.961 1.243l-1.4 6C9.612 17.001 10.763 18 12.054 18h4.657a1 1 0 01.961 1.243l-1.687 7.5" />
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-gray-500">Mixte</span>
                    </div>
                    <div class="mb-3">
                        <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $mixCount }}</h3>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">QCM + Rédaction</p>
                    </div>
                    <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                        <div class="h-full bg-[#A78BFA]" style="width: {{ $mixPercentage }}%"></div>
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
                        <input type="search" id="search-mock-exams"
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                               :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-gray-50 border-gray-300 text-gray-900'"
                               placeholder="Rechercher un concours blanc...">
                    </div>
                    <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                        <select id="filter-type"
                                class="border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] py-2.5 px-6 transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-gray-800' : 'bg-gray-50 border-gray-300 text-gray-900'">
                            <option value="">Tous les types</option>
                            <option value="QCM">QCM</option>
                            <option value="REDACTION">Rédaction</option>
                            <option value="MIX">Mixte</option>
                        </select>
                        <select id="filter-formation"
                                class="border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] py-2.5 px-6 transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-gray-800' : 'bg-gray-50 border-gray-300 text-gray-900'">
                            <option value="">Toutes les formations</option>
                            @foreach($mockExams->unique('formation.name')->pluck('formation.name')->filter() as $formationName)
                                <option value="{{ $formationName }}">{{ $formationName }}</option>
                            @endforeach
                        </select>
                        <select id="filter-sort"
                                class="border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] py-2.5 px-6 transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-gray-800' : 'bg-gray-50 border-gray-300 text-gray-900'">
                            <option value="date-desc">Date (récent → ancien)</option>
                            <option value="date-asc">Date (ancien → récent)</option>
                            <option value="duration-asc">Durée (courte → longue)</option>
                            <option value="duration-desc">Durée (longue → courte)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tableau des concours blancs -->
            @if($mockExams->isEmpty())
                <div class="p-8 text-center rounded-lg border transition-colors"
                     :class="darkMode ? 'bg-[#2C3E50] border-[#475569] text-white' : 'bg-white border-gray-200'">
                    <div class="flex flex-col items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-16 w-16 mb-4 transition-colors"
                             :class="darkMode ? 'text-gray-500' : 'text-gray-400'"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-xl font-medium mb-2 transition-colors"
                           :class="darkMode ? 'text-white' : 'text-gray-800'">
                            Aucun concours blanc enregistré
                        </p>
                        <p class="mb-6 transition-colors"
                           :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                            Commencez par créer un nouveau concours blanc pour évaluer vos étudiants
                        </p>
                        @can('gestion.exam.create')
                            <a href="{{ route('admin.mock-exams.create', ['locale' => app()->getLocale()]) }}"
                               class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Créer un concours blanc
                            </a>
                        @endcan
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
                                Concours
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Date & Durée
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Formation
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Cours associés
                            </th>
                            @canany(['gestion.exam.read', 'gestion.exam.update', 'gestion.exam.delete'])
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors"
                                    :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    Actions
                                </th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody class="divide-y transition-colors"
                               :class="darkMode ? 'bg-[#1E293B] divide-[#475569]' : 'bg-white divide-gray-200'">
                        @foreach($mockExams as $mockExam)
                            <tr class="transition-colors duration-150"
                                :class="darkMode ? 'hover:bg-[#2C3E50]' : 'hover:bg-gray-100'">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-full flex items-center justify-center transition-colors
                                                    @if($mockExam->type == 'QCM') text-green-500 @elseif($mockExam->type == 'REDACTION') text-yellow-500 @else text-purple-500 @endif"
                                             :class="darkMode ? '@if($mockExam->type == 'QCM') bg-green-900/30 @elseif($mockExam->type == 'REDACTION') bg-yellow-900/30 @else bg-purple-900/30 @endif' : '@if($mockExam->type == 'QCM') bg-green-50 @elseif($mockExam->type == 'REDACTION') bg-yellow-50 @else bg-purple-50 @endif'">
                                            @if($mockExam->type == 'QCM')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            @elseif($mockExam->type == 'REDACTION')
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.871 4A17.926 17.926 0 003 12c0 2.874.673 5.59 1.871 8m14.13 0a17.926 17.926 0 001.87-8c0-2.874-.673-5.59-1.87-8M9 9h1.246a1 1 0 01.961 1.243l-1.4 6C9.612 17.001 10.763 18 12.054 18h4.657a1 1 0 01.961 1.243l-1.687 7.5" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium transition-colors"
                                                 :class="darkMode ? 'text-white' : 'text-gray-900'">
                                                Concours #{{ $mockExam->id }}
                                            </div>
                                            <div class="text-sm transition-colors"
                                                 :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                      @if($mockExam->type == 'QCM') bg-green-100 text-green-800
                                                      @elseif($mockExam->type == 'REDACTION') bg-yellow-100 text-yellow-800
                                                      @else bg-purple-100 text-purple-800 @endif">
                                                    {{ $mockExam->type }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium transition-colors"
                                         :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        {{ $mockExam->date->format('d/m/Y') }}
                                    </div>
                                    <div class="text-sm transition-colors"
                                         :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                        {{ $mockExam->date->format('H:i') }} • {{ $mockExam->duration }} min
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium transition-colors"
                                         :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        {{ $mockExam->formation->name ?? 'N/A' }}
                                    </div>
                                    @if($mockExam->formation)
                                        <div class="text-sm transition-colors truncate"
                                             :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                            {{ $mockExam->formation->description ?? 'Formation' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4" x-data="{ showTooltip: false, darkMode: localStorage.getItem('theme') === 'dark' }">
                                    @if($mockExam->courses->count())
                                        <div class="relative">
                                            <!-- Affichage principal des cours -->
                                            <div class="flex flex-wrap gap-1.5 max-w-sm">
                                                @foreach($mockExam->courses->take(2) as $course)
                                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full transition-all duration-200 hover:scale-105"
                                                          :class="darkMode ? 'bg-[#4CA3DD]/20 text-[#4CA3DD] border border-[#4CA3DD]/30 hover:bg-[#4CA3DD]/30' : 'bg-blue-50 text-blue-700 border border-blue-200 hover:bg-blue-100'"
                                                          title="{{ $course->title }} @if($course->code)({{ $course->code }})@endif">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        {{ Str::limit($course->title, 15) }}
                    </span>
                                                @endforeach

                                                @if($mockExam->courses->count() > 2)
                                                    <!-- Bouton pour afficher tous les cours -->
                                                    <button @click="showTooltip = !showTooltip"
                                                            @click.away="showTooltip = false"
                                                            class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full transition-all duration-200 hover:scale-105 cursor-pointer"
                                                            :class="darkMode ? 'bg-gray-700 text-gray-300 border border-gray-600 hover:bg-gray-600' : 'bg-gray-100 text-gray-600 border border-gray-300 hover:bg-gray-200'">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                        </svg>
                                                        +{{ $mockExam->courses->count() - 2 }} autres
                                                    </button>
                                                @endif
                                            </div>

                                            <!-- Badge de comptage total -->
                                            <div class="flex items-center mt-2">
                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-full transition-colors"
                      :class="darkMode ? 'bg-emerald-900/30 text-emerald-400' : 'bg-emerald-100 text-emerald-700'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    {{ $mockExam->courses->count() }} cours total{{ $mockExam->courses->count() > 1 ? 'aux' : '' }}
                </span>
                                            </div>

                                            <!-- Tooltip/Dropdown avec tous les cours -->
                                            <div x-show="showTooltip"
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 transform scale-95"
                                                 x-transition:enter-end="opacity-100 transform scale-100"
                                                 x-transition:leave="transition ease-in duration-150"
                                                 x-transition:leave-start="opacity-100 transform scale-100"
                                                 x-transition:leave-end="opacity-0 transform scale-95"
                                                 class="absolute left-0 top-full mt-2 w-80 max-h-64 overflow-y-auto rounded-lg shadow-lg border z-50 p-3"
                                                 :class="darkMode ? 'bg-[#1E293B] border-[#374151]' : 'bg-white border-gray-200'"
                                                 style="display: none;">

                                                <div class="flex items-center mb-3 pb-2 border-b" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                    <h4 class="font-medium text-sm transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                                                        Cours associés ({{ $mockExam->courses->count() }})
                                                    </h4>
                                                </div>

                                                <div class="space-y-2">
                                                    @foreach($mockExam->courses as $course)
                                                        <div class="flex items-start p-2 rounded-md transition-colors hover:bg-opacity-50"
                                                             :class="darkMode ? 'hover:bg-gray-700' : 'hover:bg-gray-50'">
                                                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center mr-3"
                                                                 :class="darkMode ? 'bg-[#4CA3DD]/20 text-[#4CA3DD]' : 'bg-blue-100 text-blue-600'">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                                </svg>
                                                            </div>
                                                            <div class="flex-1 min-w-0">
                                                                <p class="text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                                                    {{ $course->title }}
                                                                </p>
                                                                @if($course->code)
                                                                    <p class="text-xs transition-colors mt-0.5" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                                        Code: {{ $course->code }}
                                                                    </p>
                                                                @endif
                                                                @if($course->description)
                                                                    <p class="text-xs transition-colors mt-1 line-clamp-2" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                                                        {{ Str::limit($course->description, 80) }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <!-- Footer du tooltip -->
                                                <div class="mt-3 pt-2 border-t flex items-center justify-between" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                    <span class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        Concours #{{ $mockExam->id }}
                    </span>
                                                    <button @click="showTooltip = false"
                                                            class="text-xs px-2 py-1 rounded transition-colors"
                                                            :class="darkMode ? 'text-gray-400 hover:text-gray-200 hover:bg-gray-700' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'">
                                                        Fermer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- État vide amélioré -->
                                        <div class="flex items-center space-x-2">
                                            <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center transition-colors"
                                                 :class="darkMode ? 'bg-gray-700 text-gray-400' : 'bg-gray-100 text-gray-400'">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                    Aucun cours associé
                                                </p>
                                                <p class="text-xs transition-colors" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                                    Évaluation générale
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                @canany(['gestion.exam.read', 'gestion.exam.update', 'gestion.exam.delete'])
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <div class="flex justify-center space-x-3">
                                            @can('gestion.exam.read')
                                                <a href="{{ route('admin.mock-exams.show', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}"
                                                   class="transition-colors duration-150"
                                                   :class="darkMode ? 'text-blue-400 hover:text-blue-300' : 'text-blue-600 hover:text-blue-800'"
                                                   title="Voir les détails">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('gestion.exam.update')
                                                <a href="{{ route('admin.mock-exams.edit', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}"
                                                   class="transition-colors duration-150"
                                                   :class="darkMode ? 'text-yellow-400 hover:text-yellow-300' : 'text-yellow-600 hover:text-yellow-800'"
                                                   title="Modifier">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('gestion.exam.delete')
                                                <form action="{{ route('admin.mock-exams.destroy', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce concours blanc ?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="transition-colors duration-150"
                                                            :class="darkMode ? 'text-red-400 hover:text-red-300' : 'text-red-600 hover:text-red-800'"
                                                            title="Supprimer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                @endcanany
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Pagination -->
            @if(isset($mockExams) && method_exists($mockExams, 'links') && $mockExams->hasPages())
                <div class="mt-6">
                    {{ $mockExams->links() }}
                </div>
            @endif
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
                    Vous n'avez pas les permissions nécessaires pour accéder à la gestion des concours blancs.
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

@push('styles')
    <style>
        /* Animations personnalisées */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive pour les tableaux */
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }

            .table-responsive th,
            .table-responsive td {
                padding: 0.5rem 0.75rem;
            }
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Amélioration du scrollbar pour le tooltip */
        .overflow-y-auto::-webkit-scrollbar {
            width: 4px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: transparent;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.5);
            border-radius: 2px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.8);
        }

        /* Mode sombre pour le scrollbar */
        html.dark .overflow-y-auto::-webkit-scrollbar-thumb {
            background: rgba(75, 85, 99, 0.5);
        }

        html.dark .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: rgba(75, 85, 99, 0.8);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables pour les éléments de filtrage
            const searchInput = document.getElementById('search-mock-exams');
            const typeFilter = document.getElementById('filter-type');
            const formationFilter = document.getElementById('filter-formation');
            const sortFilter = document.getElementById('filter-sort');

            // Fonction de filtrage côté client
            function filterMockExams() {
                const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
                const selectedType = typeFilter ? typeFilter.value : '';
                const selectedFormation = formationFilter ? formationFilter.value : '';

                const rows = document.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    if (cells.length === 0) return;

                    let showRow = true;

                    // Filtre de recherche textuelle
                    if (searchTerm) {
                        const rowText = Array.from(cells).map(cell => cell.textContent.toLowerCase()).join(' ');
                        showRow = showRow && rowText.includes(searchTerm);
                    }

                    // Filtre par type
                    if (selectedType) {
                        const typeCell = cells[0]; // Première colonne contient le type
                        const typeText = typeCell.textContent;
                        showRow = showRow && typeText.includes(selectedType);
                    }

                    // Filtre par formation
                    if (selectedFormation) {
                        const formationCell = cells[2]; // Troisième colonne contient la formation
                        const formationText = formationCell.textContent;
                        showRow = showRow && formationText.includes(selectedFormation);
                    }

                    // Afficher/masquer la ligne avec animation
                    if (showRow) {
                        row.style.display = '';
                        row.style.opacity = '0';
                        row.style.animation = 'fadeInUp 0.3s ease-out forwards';
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Afficher un message si aucun résultat
                updateNoResultsMessage();
            }

            // Fonction pour afficher/masquer le message "aucun résultat"
            function updateNoResultsMessage() {
                const tbody = document.querySelector('tbody');
                const visibleRows = Array.from(document.querySelectorAll('tbody tr')).filter(row =>
                    row.style.display !== 'none'
                );

                // Supprimer le message existant
                const existingMessage = document.getElementById('no-results-message');
                if (existingMessage) {
                    existingMessage.remove();
                }

                // Ajouter un nouveau message si nécessaire
                if (visibleRows.length === 0 && tbody) {
                    const noResultsRow = document.createElement('tr');
                    noResultsRow.id = 'no-results-message';
                    noResultsRow.innerHTML = `
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-lg font-medium text-gray-600 mb-2">Aucun concours blanc trouvé</p>
                                <p class="text-sm text-gray-500">Essayez de modifier vos critères de recherche</p>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(noResultsRow);
                }
            }

            // Fonction de tri
            function sortMockExams() {
                const sortValue = sortFilter ? sortFilter.value : '';
                const tbody = document.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr')).filter(row =>
                    !row.id || row.id !== 'no-results-message'
                );

                rows.sort((a, b) => {
                    switch(sortValue) {
                        case 'date-asc':
                        case 'date-desc':
                            const dateA = new Date(a.cells[1].textContent.trim().split(' ')[0].split('/').reverse().join('-'));
                            const dateB = new Date(b.cells[1].textContent.trim().split(' ')[0].split('/').reverse().join('-'));
                            return sortValue === 'date-asc' ? dateA - dateB : dateB - dateA;

                        case 'duration-asc':
                        case 'duration-desc':
                            const durationA = parseInt(a.cells[1].textContent.match(/(\d+) min/)[1]);
                            const durationB = parseInt(b.cells[1].textContent.match(/(\d+) min/)[1]);
                            return sortValue === 'duration-asc' ? durationA - durationB : durationB - durationA;

                        default:
                            return 0;
                    }
                });

                // Réinsérer les lignes triées
                rows.forEach(row => tbody.appendChild(row));
            }

            // Écouteurs d'événements
            if (searchInput) {
                searchInput.addEventListener('input', debounce(filterMockExams, 300));
            }

            if (typeFilter) {
                typeFilter.addEventListener('change', filterMockExams);
            }

            if (formationFilter) {
                formationFilter.addEventListener('change', filterMockExams);
            }

            if (sortFilter) {
                sortFilter.addEventListener('change', sortMockExams);
            }

            // Fonction debounce pour optimiser les performances
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Animation d'entrée pour les lignes du tableau
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    row.style.transition = 'all 0.3s ease-out';
                    row.style.opacity = '1';
                    row.style.transform = 'translateY(0)';
                }, index * 50);
            });

            // Amélioration des confirmations de suppression
            const deleteForms = document.querySelectorAll('form[method="POST"][onsubmit*="confirm"]');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const examRow = this.closest('tr');
                    const examId = examRow.querySelector('td:first-child .text-sm.font-medium').textContent.trim();
                    const examType = examRow.querySelector('.type-badge').textContent.trim();

                    if (confirm(`Êtes-vous sûr de vouloir supprimer le ${examId} de type ${examType} ?\n\nCette action est irréversible et supprimera toutes les données associées.`)) {
                        // Animation de suppression
                        examRow.style.transition = 'all 0.3s ease-out';
                        examRow.style.opacity = '0';
                        examRow.style.transform = 'translateX(-100%)';

                        setTimeout(() => {
                            this.submit();
                        }, 300);
                    }
                });
            });

            // Animation hover pour les cartes de statistiques
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endpush
