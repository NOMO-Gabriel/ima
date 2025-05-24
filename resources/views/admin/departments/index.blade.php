@extends('layouts.app')

@section('title', 'Gestion des Départements')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Gestion des Départements</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-5 mb-8" :class="darkMode ? 'dark:bg-gray-800' : ''">
        <!-- En-tête avec titre et bouton d'ajout -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-400 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Gestion des Départements
            </h1>
            <a href="{{ route('admin.departments.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Ajouter un département
            </a>
        </div>

        <!-- Messages d'alerte -->
        @if(session('success'))
            <div id="alert-success" class="flex p-4 mb-6 text-[#34D399] border-l-4 border-[#34D399] bg-[#F0FDF4] rounded-md fade-in-down" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-[#F0FDF4] text-[#34D399] rounded-lg p-1.5 hover:bg-[#ECFDF5] inline-flex h-8 w-8" data-dismiss-target="#alert-success" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="alert-error" class="flex p-4 mb-6 text-[#F87171] border-l-4 border-[#F87171] bg-[#FEF2F2] rounded-md fade-in-down" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{ session('error') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-[#FEF2F2] text-[#F87171] rounded-lg p-1.5 hover:bg-[#FEE2E2] inline-flex h-8 w-8" data-dismiss-target="#alert-error" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Section des statistiques -->
        <div class="stats-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="stats-card rounded-lg p-4 shadow border flex flex-col"
                 :class="darkMode ? 'bg-gray-700 border-gray-600' : 'bg-white border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="stats-icon primary bg-blue-100 text-[#4CA3DD] p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Total</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">{{ $departments->count() }}</h3>
                    <p class="stats-label text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Départements</p>
                </div>
                <div class="stats-trend mt-3">
                    <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                        <div class="progress-bar h-full bg-[#4CA3DD]" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <div class="stats-card rounded-lg p-4 shadow border flex flex-col"
                 :class="darkMode ? 'bg-gray-700 border-gray-600' : 'bg-white border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="stats-icon success bg-green-100 text-green-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Actifs</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">{{ $departments->where('is_active', true)->count() }}</h3>
                    <p class="stats-label text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Départements actifs</p>
                </div>
                <div class="stats-trend mt-3">
                    @php
                        $activePercentage = ($departments->count() > 0) ? ($departments->where('is_active', true)->count() / $departments->count()) * 100 : 0;
                    @endphp
                    <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                        <div class="progress-bar h-full bg-green-500" style="width: {{ $activePercentage }}%"></div>
                    </div>
                </div>
            </div>

            <div class="stats-card rounded-lg p-4 shadow border flex flex-col"
                 :class="darkMode ? 'bg-gray-700 border-gray-600' : 'bg-white border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="stats-icon warning bg-orange-100 text-orange-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Inactifs</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">{{ $departments->where('is_active', false)->count() }}</h3>
                    <p class="stats-label text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Départements inactifs</p>
                </div>
                <div class="stats-trend mt-3">
                    @php
                        $inactivePercentage = ($departments->count() > 0) ? ($departments->where('is_active', false)->count() / $departments->count()) * 100 : 0;
                    @endphp
                    <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                        <div class="progress-bar h-full bg-orange-500" style="width: {{ $inactivePercentage > 0 ? $inactivePercentage : 5 }}%"></div>
                    </div>
                </div>
            </div>

            <div class="stats-card rounded-lg p-4 shadow border flex flex-col"
                 :class="darkMode ? 'bg-gray-700 border-gray-600' : 'bg-white border-gray-200'">
                <div class="flex items-center justify-between mb-3">
                    <div class="stats-icon info bg-purple-100 text-purple-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Académies</span>
                </div>
                <div class="stats-content">
                    @php
                        $academiesCount = $departments->pluck('academy_id')->unique()->count();
                    @endphp
                    <h3 class="stats-value text-2xl font-bold" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">{{ $academiesCount }}</h3>
                    <p class="stats-label text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Académies représentées</p>
                </div>
                <div class="stats-trend mt-3">
                    <div class="h-2 w-full rounded-full overflow-hidden" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                        <div class="progress-bar h-full bg-purple-500" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="mb-6">
            <form method="GET" action="{{ route('admin.departments.index', app()->getLocale()) }}">
                <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                    <div class="relative w-full lg:w-80">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="search" name="search" id="search-departments"
                               class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD]"
                               :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400' : 'bg-gray-50 border-gray-300'"
                               placeholder="Rechercher un département..." value="{{ request('search') }}">
                    </div>
                    <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                        <select name="academy_id"
                                class="border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5"
                                :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-200' : 'bg-gray-50 border-gray-300 text-gray-900'">
                            <option value="">Toutes les académies</option>
                            @foreach ($academies as $academy)
                                <option value="{{ $academy->id }}" {{ request('academy_id') == $academy->id ? 'selected' : '' }}>
                                    {{ $academy->name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="status"
                                class="border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] py-2.5 px-3.5"
                                :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-200' : 'bg-gray-50 border-gray-300 text-gray-900'">
                            <option value="">Tous les statuts</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactif</option>
                        </select>
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z" />
                            </svg>
                            Filtrer
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Tableau des départements -->
        <div class="overflow-x-auto rounded-lg border" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
            <table class="min-w-full divide-y" :class="darkMode ? 'divide-gray-600' : 'divide-gray-200'">
                <thead :class="darkMode ? 'bg-gray-700' : 'bg-gray-50'">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                        :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                        Nom
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                        :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                        Code
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                        :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                        Académie
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                        :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                        Chef de département
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                        :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                        Statut
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider"
                        :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y" :class="darkMode ? 'bg-gray-800 divide-gray-600' : 'bg-white divide-gray-200'">
                @forelse($departments as $department)
                    <tr class="transition-colors duration-150" :class="darkMode ? 'hover:bg-gray-700' : 'hover:bg-gray-100'">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" :class="darkMode ? 'text-gray-200' : 'text-gray-700'">
                            {{ $department->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                            {{ $department->code ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                            {{ $department->academy->name ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                            {{ $department->head->first_name ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($department->is_active)
                                <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-green-200 text-green-800 text-xs font-medium">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Actif
                                </span>
                            @else
                                <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-red-200 text-red-800 text-xs font-medium">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    Inactif
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('admin.departments.edit', ['locale' => app()->getLocale(), 'department' => $department]) }}"
                                   class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors duration-150"
                                   title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.departments.destroy', ['locale' => app()->getLocale(), 'department' => $department]) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce département?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-150"
                                            title="Supprimer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4" :class="darkMode ? 'text-gray-500' : 'text-gray-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p class="text-lg font-medium">Aucun département trouvé</p>
                                <p class="text-sm mt-1" :class="darkMode ? 'text-gray-500' : 'text-gray-500'">
                                    @if(request()->hasAny(['search', 'academy_id', 'status']))
                                        Aucun résultat ne correspond à vos critères de recherche
                                    @else
                                        Commencez par ajouter un département en utilisant le bouton ci-dessus
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($departments) && method_exists($departments, 'hasPages') && $departments->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 px-6 py-4 border-t"
                 :class="darkMode ? 'bg-gray-800 border-gray-600' : 'bg-white border-gray-200'">
                <div class="pagination-info mb-4 sm:mb-0">
                    Affichage de <span>{{ $departments->firstItem() ?? 0 }}</span> à <span>{{ $departments->lastItem() ?? 0 }}</span> sur <span>{{ $departments->total() }}</span> départements
                </div>
                <div class="pagination-controls">
                    {{ $departments->appends(request()->query())->links('vendor.pagination.tailwind') }}
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

        .pagination li:not(.active) a {
            background-color: #f3f4f6;
            color: #374151;
        }

        .pagination li:not(.active) a:hover {
            background-color: #e5e7eb;
        }

        .pagination li.active span {
            background-color: #4CA3DD;
            color: white;
        }

        /* Style pour les points de suspension */
        .pagination li.dots span {
            display: flex;
            align-items: center;
            color: #6b7280;
            padding: 0 0.25rem;
        }

        /* Animation pour les alertes */
        .fade-in-down {
            animation: fadeInDown 0.5s ease-out forwards;
        }

        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-10px);
            }
            100% {
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

            // Filtrage en temps réel pour la recherche
            const searchInput = document.getElementById('search-departments');
            if (searchInput) {
                let debounceTimer;
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        // Auto-submit du formulaire après 500ms d'inactivité
                        if (this.value.length >= 2 || this.value.length === 0) {
                            this.closest('form').submit();
                        }
                    }, 500);
                });
            }

            // Effet de survol amélioré pour les boutons d'action
            const actionButtons = document.querySelectorAll('table a, table button');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.2s ease-in-out';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });

            // Confirmation améliorée pour la suppression
            const deleteButtons = document.querySelectorAll('form[onsubmit*="confirm"]');
            deleteButtons.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Récupérer le nom du département depuis la ligne du tableau
                    const row = this.closest('tr');
                    const departmentName = row.querySelector('td:first-child').textContent.trim();

                    const isConfirmed = confirm(
                        `Êtes-vous sûr de vouloir supprimer le département "${departmentName}" ?\n\n` +
                        'Cette action est irréversible et supprimera toutes les données associées.'
                    );

                    if (isConfirmed) {
                        this.submit();
                    }
                });
            });

            // Animation des barres de progression
            const progressBars = document.querySelectorAll('.progress-bar');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const bar = entry.target;
                        const width = bar.style.width;
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = width;
                        }, 200);
                    }
                });
            }, { threshold: 0.5 });

            progressBars.forEach(bar => observer.observe(bar));
        });
    </script>
@endpush
