@extends('layouts.app')

@section('title', 'Gestion des Concours')

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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Gestion des Concours</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="shadow-md rounded-lg p-5 mb-8 transition-colors" :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white'">
        <!-- En-tête avec titre et bouton d'ajout -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold flex items-center transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Gestion des Concours
            </h1>
            <a href="{{ route('admin.entrance-exams.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouveau Concours
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
                    <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $entrance_exams->count() }}</h3>
                    <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">Concours disponibles</p>
                </div>
                <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                    <div class="h-full bg-[#4CA3DD]" style="width: 100%"></div>
                </div>
            </div>

            <!-- Statistique 2: Concours récents -->
            <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#34D399]"
                         :class="darkMode ? 'bg-green-900/30' : 'bg-green-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Récents</span>
                </div>
                <div class="mb-3">
                    @php
                        $now = \Carbon\Carbon::now();
                        $startOfWeek = $now->startOfWeek();
                        $recentExams = $entrance_exams->filter(function($exam) use ($startOfWeek) {
                            return isset($exam->created_at) && \Carbon\Carbon::parse($exam->created_at)->gte($startOfWeek);
                        })->count();
                        $recentPercentage = $entrance_exams->count() > 0 ? ($recentExams / $entrance_exams->count()) * 100 : 0;
                    @endphp
                    <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $recentExams }}</h3>
                    <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">Cette semaine</p>
                </div>
                <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                    <div class="h-full bg-[#34D399]" style="width: {{ $recentPercentage }}%"></div>
                </div>
            </div>

            <!-- Statistique 3: Concours avec codes -->
            <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#FBBF24]"
                         :class="darkMode ? 'bg-yellow-900/30' : 'bg-yellow-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Codifiés</span>
                </div>
                <div class="mb-3">
                    @php
                        $codedExams = $entrance_exams->filter(function($exam) {
                            return !empty($exam->code);
                        })->count();
                        $codedPercentage = $entrance_exams->count() > 0 ? ($codedExams / $entrance_exams->count()) * 100 : 0;
                    @endphp
                    <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $codedExams }}</h3>
                    <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">Avec codes</p>
                </div>
                <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                    <div class="h-full bg-[#FBBF24]" style="width: {{ $codedPercentage }}%"></div>
                </div>
            </div>

            <!-- Statistique 4: Moyenne des caractères des noms -->
            <div class="rounded-lg p-5 shadow-sm transition-all duration-300 hover:shadow-md"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569]' : 'bg-white border border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-[#A78BFA]"
                         :class="darkMode ? 'bg-indigo-900/30' : 'bg-indigo-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Analyse</span>
                </div>
                <div class="mb-3">
                    @php
                        $averageNameLength = $entrance_exams->count() > 0
                            ? round($entrance_exams->avg(function($exam) { return strlen($exam->name); }))
                            : 0;
                    @endphp
                    <h3 class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-800'">{{ $averageNameLength }}</h3>
                    <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">Chars moyenne</p>
                </div>
                <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                    <div class="h-full bg-[#A78BFA]" style="width: {{ min($averageNameLength * 2, 100) }}%"></div>
                </div>
            </div>
        </div>

        <!-- Barre de recherche et filtres -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                <div class="relative w-full lg:w-80">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="search" id="search-exams"
                           class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                           :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-gray-50 border-gray-300 text-gray-900'"
                           placeholder="Rechercher un concours...">
                </div>
                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                    <select id="filter-sort"
                            class="border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5 transition-colors"
                            :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-gray-50 border-gray-300 text-gray-900'">
                        <option value="name-asc">Nom (A → Z)</option>
                        <option value="name-desc">Nom (Z → A)</option>
                        <option value="code-asc">Code (A → Z)</option>
                        <option value="code-desc">Code (Z → A)</option>
                    </select>
                    <select id="filter-status"
                            class="border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5 transition-colors"
                            :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-gray-50 border-gray-300 text-gray-900'">
                        <option value="">Tous les concours</option>
                        <option value="with-code">Avec code</option>
                        <option value="without-code">Sans code</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tableau des concours -->
        @if($entrance_exams->isEmpty())
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
                        Aucun concours enregistré
                    </p>
                    <p class="mb-6 transition-colors"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        Commencez par créer un nouveau concours pour gérer vos examens d'entrée
                    </p>
                    <a href="{{ route('admin.entrance-exams.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer un concours
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
                            Code
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Nom du Concours
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Date de Création
                        </th>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y transition-colors"
                           :class="darkMode ? 'bg-[#1E293B] divide-[#475569]' : 'bg-white divide-gray-200'">
                    @foreach($entrance_exams as $exam)
                        <tr class="transition-colors duration-150"
                            :class="darkMode ? 'hover:bg-[#2C3E50]' : 'hover:bg-gray-100'">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center transition-colors"
                                         :class="darkMode ? 'bg-indigo-900/30 text-indigo-400' : 'bg-indigo-50 text-indigo-600'">
                                        @if(!empty($exam->code))
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium transition-colors"
                                             :class="darkMode ? 'text-white' : 'text-gray-900'">
                                            @if(!empty($exam->code))
                                                {{ $exam->code }}
                                            @else
                                                <span class="text-gray-500 italic">Aucun code</span>
                                            @endif
                                        </div>
                                        <div class="text-xs transition-colors"
                                             :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            @if(!empty($exam->code))
                                                {{ strlen($exam->code) }} caractères
                                            @else
                                                Code non défini
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium transition-colors"
                                     :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    {{ $exam->name }}
                                </div>
                                <div class="text-xs transition-colors mt-1"
                                     :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    {{ strlen($exam->name) }} caractères
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if($exam->created_at)
                                        <div class="text-xs transition-colors"
                                             :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            <span class="font-medium">Créé:</span>
                                            {{ \Carbon\Carbon::parse($exam->created_at)->format('d/m/Y à H:i') }}
                                        </div>
                                    @endif
                                    @if($exam->updated_at && $exam->updated_at != $exam->created_at)
                                        <div class="text-xs transition-colors"
                                             :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            <span class="font-medium">Modifié:</span>
                                            {{ \Carbon\Carbon::parse($exam->updated_at)->format('d/m/Y à H:i') }}
                                        </div>
                                    @endif
                                    @if(isset($exam->description) && !empty($exam->description))
                                        <div class="text-xs transition-colors"
                                             :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            <span class="font-medium">Description:</span>
                                            {{ Str::limit($exam->description, 50) }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- Bouton Modifier -->
                                    <a href="{{ route('admin.entrance-exams.edit', ['locale' => app()->getLocale(), 'entrance_exam' => $exam->id]) }}"
                                       class="transition-colors duration-150 text-[#4CA3DD]"
                                       :class="darkMode ? 'text-yellow-400 hover:text-yellow-300' : 'text-yellow-600 hover:text-yellow-800'"
                                       title="Modifier">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>

                                    <!-- Bouton Supprimer -->
                                    <button type="button"
                                            onclick="confirmDelete({{ $exam->id }}, '{{ addslashes($exam->name) }}')"
                                            class="transition-colors duration-150 text-red-600"
                                            :class="darkMode ? 'text-red-400 hover:text-red-300' : 'text-red-600 hover:text-red-800'"
                                            title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination (si nécessaire) -->
            @if(method_exists($entrance_exams, 'links'))
                <div class="mt-6">
                    {{ $entrance_exams->links() }}
                </div>
            @endif
        @endif
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-white bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md transition-colors"
             :class="darkMode ? 'bg-[#1E293B] border-[#475569]' : 'bg-white'">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full"
                     :class="darkMode ? 'bg-red-900/30' : 'bg-red-100'">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium leading-6 mb-2 transition-colors"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    Confirmer la suppression
                </h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm transition-colors"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        Êtes-vous sûr de vouloir supprimer le concours <strong id="examName"></strong> ?
                        Cette action est irréversible.
                    </p>
                </div>
                <div class="flex justify-center gap-4 mt-6">
                    <button id="cancelDelete"
                            class="px-4 py-2 text-sm font-medium rounded-md transition-colors"
                            :class="darkMode ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' : 'bg-gray-300 text-gray-700 hover:bg-gray-400'">
                        Annuler
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 transition-colors">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la recherche
            const searchInput = document.getElementById('search-exams');
            const filterSort = document.getElementById('filter-sort');
            const filterStatus = document.getElementById('filter-status');
            const tableRows = document.querySelectorAll('tbody tr');

            function filterAndSortTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const sortValue = filterSort.value;
                const statusValue = filterStatus.value;

                // Convertir NodeList en Array pour pouvoir utiliser les méthodes de tri
                let rowsArray = Array.from(tableRows);

                // Filtrage
                rowsArray.forEach(row => {
                    const examName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const examCode = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                    const hasCode = !examCode.includes('aucun code') && !examCode.includes('code non défini');

                    let showRow = true;

                    // Filtre de recherche
                    if (searchTerm && !examName.includes(searchTerm) && !examCode.includes(searchTerm)) {
                        showRow = false;
                    }

                    // Filtre de statut
                    if (statusValue === 'with-code' && !hasCode) {
                        showRow = false;
                    } else if (statusValue === 'without-code' && hasCode) {
                        showRow = false;
                    }

                    row.style.display = showRow ? '' : 'none';
                });

                // Tri des lignes visibles
                const visibleRows = rowsArray.filter(row => row.style.display !== 'none');
                visibleRows.sort((a, b) => {
                    let aValue, bValue;

                    switch (sortValue) {
                        case 'name-asc':
                            aValue = a.querySelector('td:nth-child(2)').textContent.toLowerCase();
                            bValue = b.querySelector('td:nth-child(2)').textContent.toLowerCase();
                            return aValue.localeCompare(bValue);
                        case 'name-desc':
                            aValue = a.querySelector('td:nth-child(2)').textContent.toLowerCase();
                            bValue = b.querySelector('td:nth-child(2)').textContent.toLowerCase();
                            return bValue.localeCompare(aValue);
                        case 'code-asc':
                            aValue = a.querySelector('td:nth-child(1)').textContent.toLowerCase();
                            bValue = b.querySelector('td:nth-child(1)').textContent.toLowerCase();
                            return aValue.localeCompare(bValue);
                        case 'code-desc':
                            aValue = a.querySelector('td:nth-child(1)').textContent.toLowerCase();
                            bValue = b.querySelector('td:nth-child(1)').textContent.toLowerCase();
                            return bValue.localeCompare(aValue);
                        default:
                            return 0;
                    }
                });

                // Réorganiser les lignes dans le DOM
                const tbody = document.querySelector('tbody');
                visibleRows.forEach(row => {
                    tbody.appendChild(row);
                });
            }

            // Event listeners pour les filtres
            searchInput.addEventListener('input', filterAndSortTable);
            filterSort.addEventListener('change', filterAndSortTable);
            filterStatus.addEventListener('change', filterAndSortTable);

            // Gestion de la suppression
            window.confirmDelete = function(examId, examName) {
                document.getElementById('examName').textContent = examName;
                document.getElementById('deleteForm').action = `{{ url()->current() }}/${examId}`;
                document.getElementById('deleteModal').classList.remove('hidden');
            };

            document.getElementById('cancelDelete').addEventListener('click', function() {
                document.getElementById('deleteModal').classList.add('hidden');
            });

            // Fermer le modal en cliquant à l'extérieur
            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });

            // Gestion de la fermeture automatique des alertes
            setTimeout(function() {
                const successAlert = document.getElementById('alert-success');
                const errorAlert = document.getElementById('alert-error');

                if (successAlert) {
                    successAlert.style.opacity = '0';
                    setTimeout(() => successAlert.remove(), 300);
                }

                if (errorAlert) {
                    errorAlert.style.opacity = '0';
                    setTimeout(() => errorAlert.remove(), 300);
                }
            }, 5000);

            // Gestion des boutons de fermeture des alertes
            document.querySelectorAll('[data-dismiss-target]').forEach(button => {
                button.addEventListener('click', function() {
                    const target = document.querySelector(this.getAttribute('data-dismiss-target'));
                    if (target) {
                        target.style.opacity = '0';
                        setTimeout(() => target.remove(), 300);
                    }
                });
            });
        });
    </script>
@endpush
