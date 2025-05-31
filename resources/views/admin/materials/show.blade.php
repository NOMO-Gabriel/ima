@extends('layouts.app')

@section('title', 'Détails du Matériel')

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
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Matériaux</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $material->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- En-tête du matériel -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
            <div class="flex-1">
                <div class="flex items-center mb-4">
                    <div class="bg-[#4CA3DD] p-3 rounded-full mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $material->name }}</h1>
                        <p class="text-gray-600 mt-1">{{ $material->description ?: 'Aucune description disponible' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-sm font-medium text-gray-500">Type</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $material->getTypeLabel() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-sm font-medium text-gray-500">Unité</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $material->getUnitLabel() }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-sm font-medium text-gray-500">Prix unitaire</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $material->formatted_price }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-sm font-medium text-gray-500">Stock actuel</p>
                        <div class="flex items-center">
                            <span class="text-lg font-semibold mr-2 {{ $material->stock <= 5 ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $material->stock }}
                            </span>
                            @if($material->stock <= 5)
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button"
                        class="inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                        onclick="openCommandModal('in')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Enregistrer une entrée
                </button>
                <button type="button"
                        class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg"
                        onclick="openCommandModal('out')">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                    Enregistrer une sortie
                </button>
            </div>
        </div>
    </div>

    <!-- Messages de notification -->
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

    <!-- Section des statistiques des commandes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg p-4 shadow border border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-blue-100 text-[#4CA3DD] p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5a2 2 0 012 2v11a2 2 0 01-2 2h-2a2 2 0 01-2-2V7a2 2 0 012-2h2z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 5h2a2 2 0 012 2v11a2 2 0 01-2 2h-2a2 2 0 01-2-2V7a2 2 0 012-2z" />
                    </svg>
                </div>
                <span class="text-sm text-gray-500">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $commandStats['total_commands'] }}</h3>
            <p class="text-sm text-gray-600">Commandes</p>
        </div>

        <div class="bg-white rounded-lg p-4 shadow border border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-green-100 text-green-600 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <span class="text-sm text-gray-500">Entrées</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $commandStats['total_in'] }}</h3>
            <p class="text-sm text-gray-600">Unités entrées</p>
        </div>

        <div class="bg-white rounded-lg p-4 shadow border border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-red-100 text-red-600 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </div>
                <span class="text-sm text-gray-500">Sorties</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $commandStats['total_out'] }}</h3>
            <p class="text-sm text-gray-600">Unités sorties</p>
        </div>

        <div class="bg-white rounded-lg p-4 shadow border border-gray-200">
            <div class="flex items-center justify-between mb-3">
                <div class="bg-purple-100 text-purple-600 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-sm text-gray-500">Récentes</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-800">{{ $commandStats['recent_commands'] }}</h3>
            <p class="text-sm text-gray-600">Cette semaine</p>
        </div>
    </div>

    <!-- Section des commandes -->
    <div class="bg-white shadow-md rounded-lg p-5">
        <!-- En-tête de la section des commandes -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5a2 2 0 012 2v11a2 2 0 01-2 2h-2a2 2 0 01-2-2V7a2 2 0 012-2h2z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 5h2a2 2 0 012 2v11a2 2 0 01-2 2h-2a2 2 0 01-2-2V7a2 2 0 012-2z" />
                </svg>
                Historique des commandes
            </h2>
        </div>

        <!-- Filtres et recherche -->
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <!-- Filtres par direction -->
                <div class="flex gap-2">
                    <a href="{{ route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material->id, 'direction' => 'all']) }}"
                       class="px-3 py-1 text-sm rounded-full transition-colors duration-200 {{ $direction === 'all' ? 'bg-[#4CA3DD] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Toutes
                    </a>
                    <a href="{{ route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material->id, 'direction' => 'in']) }}"
                       class="px-3 py-1 text-sm rounded-full transition-colors duration-200 {{ $direction === 'in' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Entrées
                    </a>
                    <a href="{{ route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material->id, 'direction' => 'out']) }}"
                       class="px-3 py-1 text-sm rounded-full transition-colors duration-200 {{ $direction === 'out' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Sorties
                    </a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <select id="filter-sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5" onchange="changeSorting(this.value)">
                    <option value="recent" {{ $sort === 'recent' ? 'selected' : '' }}>Plus récentes</option>
                    <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Plus anciennes</option>
                    <option value="quantity-desc" {{ $sort === 'quantity-desc' ? 'selected' : '' }}>Quantité (décroissant)</option>
                    <option value="quantity-asc" {{ $sort === 'quantity-asc' ? 'selected' : '' }}>Quantité (croissant)</option>
                </select>
            </div>
        </div>

        <!-- Tableau des commandes -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Quantité
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Utilisateur
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Localisation
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($commands as $command)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 inline-flex items-center rounded-full text-xs font-medium {{ $command->direction_color }}">
                                @if($command->direction === 'in')
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                                {{ $command->direction_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $command->quantity }} {{ $material->unit }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $command->user->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($command->city)
                                <div class="flex flex-col">
                                    <span class="font-medium">{{ $command->city->name }}</span>
                                    @if($command->center)
                                        <span class="text-xs text-gray-400">{{ $command->center->name }}</span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400">Non spécifiée</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex flex-col">
                                <span>{{ $command->formatted_date }}</span>
                                <span class="text-xs text-gray-400">{{ $command->human_date }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <div class="flex justify-center space-x-3">
                                <button type="button"
                                        class="text-[#4CA3DD] hover:text-[#2A7AB8] transition-colors duration-150"
                                        title="Voir les détails"
                                        onclick="showCommandDetails({{ $command->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button"
                                        class="text-red-600 hover:text-red-800 transition-colors duration-150"
                                        title="Supprimer"
                                        onclick="deleteCommand({{ $command->id }}, '{{ $command->direction_label }}', {{ $command->quantity }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5a2 2 0 012 2v11a2 2 0 01-2 2h-2a2 2 0 01-2-2V7a2 2 0 012-2h2z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 5h2a2 2 0 012 2v11a2 2 0 01-2 2h-2a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                </svg>
                                <p class="text-lg font-medium">Aucune commande {{ $direction !== 'all' ? 'de type "'.($direction === 'in' ? 'Entrée' : 'Sortie').'"' : '' }} enregistrée</p>
                                <p class="text-sm text-gray-500 mt-1">Commencez par enregistrer une entrée ou une sortie pour ce matériel</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($commands->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 px-6 py-4 bg-white border-t border-gray-200">
                <div class="pagination-info mb-4 sm:mb-0">
                    Affichage de <span>{{ $commands->firstItem() ?? 0 }}</span> à <span>{{ $commands->lastItem() ?? 0 }}</span> sur <span>{{ $commands->total() }}</span> commandes
                </div>
                <div class="pagination-controls">
                    {{ $commands->appends(['direction' => $direction, 'sort' => $sort])->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Création commande -->
    <div class="modal fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden" id="commandModal">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg bg-white rounded-lg shadow-xl">
            <div class="modal-content">
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                        <span id="modal-icon" class="mr-2"></span>
                        <span id="modal-title">Nouvelle commande</span>
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="closeCommandModal()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="command-form" action="{{ route('admin.commands.store', ['locale' => app()->getLocale(), 'material' => $material->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" id="direction" name="direction" value="">

                    <div class="p-6 space-y-6">
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                Quantité <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200"
                                       id="quantity"
                                       name="quantity"
                                       min="1"
                                       max="{{ $material->stock }}"
                                       required
                                       placeholder="Entrez la quantité">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-400 text-sm">{{ $material->unit }}</span>
                                </div>
                            </div>
                            <p id="stock-info" class="mt-1 text-sm text-gray-500">Stock disponible : {{ $material->stock }} {{ $material->unit }}</p>
                        </div>

                        <div>
                            <label for="city_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Ville (optionnel)
                            </label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200"
                                    id="city_id"
                                    name="city_id"
                                    onchange="loadCenters(this.value)">
                                <option value="">Sélectionnez une ville</option>
                                <!-- Options chargées via AJAX -->
                            </select>
                        </div>

                        <div>
                            <label for="center_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Centre (optionnel)
                            </label>
                            <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200"
                                    id="center_id"
                                    name="center_id"
                                    disabled>
                                <option value="">Sélectionnez d'abord une ville</option>
                            </select>
                        </div>

                        <!-- Résumé -->
                        <div id="command-summary" class="bg-gray-50 rounded-lg p-4 hidden">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Impact sur le stock :</span>
                                <span id="stock-impact" class="text-lg font-bold"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg space-x-3">
                        <button type="button"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] transition-colors duration-200"
                                onclick="closeCommandModal()">
                            Annuler
                        </button>
                        <button type="submit"
                                id="submit-button"
                                class="px-4 py-2 text-sm font-medium text-white border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span id="submit-text">Enregistrer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* Animations */
    @keyframes fade-in-down {
        0% {
            opacity: 0;
            transform: translateY(-10px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-down {
        animation: fade-in-down 0.5s ease-out;
    }

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

    /* Transition pour le modal */
    .modal {
        transition: opacity 0.3s ease-out;
    }

    .modal.show {
        opacity: 1;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des alertes
    const alerts = document.querySelectorAll('[id^="alert-"]');
    alerts.forEach(alert => {
        const closeBtn = alert.querySelector('[data-dismiss-target]');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]', 'transition-all', 'duration-500');
                setTimeout(() => {
                    alert.remove();
                }, 500);
            });
        }

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

    // Charger les villes au chargement de la page
    loadCities();

    // Calculer l'impact sur le stock en temps réel
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.addEventListener('input', updateStockImpact);
    }
});

// Fonction pour ouvrir le modal de commande
function openCommandModal(direction) {
    const modal = document.getElementById('commandModal');
    const modalTitle = document.getElementById('modal-title');
    const modalIcon = document.getElementById('modal-icon');
    const submitButton = document.getElementById('submit-button');
    const submitText = document.getElementById('submit-text');
    const directionInput = document.getElementById('direction');
    const quantityInput = document.getElementById('quantity');
    const stockInfo = document.getElementById('stock-info');

    directionInput.value = direction;

    if (direction === 'in') {
        modalTitle.textContent = 'Enregistrer une entrée';
        modalIcon.innerHTML = `<svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>`;
        submitButton.className = 'px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 flex items-center';
        submitText.textContent = 'Enregistrer l\'entrée';
        quantityInput.removeAttribute('max');
        stockInfo.textContent = 'Stock actuel : {{ $material->stock }} {{ $material->unit }}';
    } else {
        modalTitle.textContent = 'Enregistrer une sortie';
        modalIcon.innerHTML = `<svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
        </svg>`;
        submitButton.className = 'px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200 flex items-center';
        submitText.textContent = 'Enregistrer la sortie';
        quantityInput.setAttribute('max', '{{ $material->stock }}');
        stockInfo.textContent = 'Stock disponible : {{ $material->stock }} {{ $material->unit }}';
    }

    // Réinitialiser le formulaire
    document.getElementById('command-form').reset();
    directionInput.value = direction;
    document.getElementById('command-summary').classList.add('hidden');

    modal.classList.remove('hidden');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

// Fonction pour fermer le modal de commande
function closeCommandModal() {
    const modal = document.getElementById('commandModal');
    modal.classList.add('hidden');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Fonction pour charger les villes
function loadCities() {
    fetch('/admin/commands/cities')
        .then(response => response.json())
        .then(cities => {
            const citySelect = document.getElementById('city_id');
            citySelect.innerHTML = '<option value="">Sélectionnez une ville</option>';
            cities.forEach(city => {
                const option = document.createElement('option');
                option.value = city.id;
                option.textContent = city.name;
                citySelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erreur lors du chargement des villes:', error);
        });
}

// Fonction pour charger les centres d'une ville
function loadCenters(cityId) {
    const centerSelect = document.getElementById('center_id');

    if (!cityId) {
        centerSelect.innerHTML = '<option value="">Sélectionnez d\'abord une ville</option>';
        centerSelect.disabled = true;
        return;
    }

    centerSelect.disabled = false;
    centerSelect.innerHTML = '<option value="">Chargement...</option>';

    fetch(`/admin/commands/centers?city_id=${cityId}`)
        .then(response => response.json())
        .then(centers => {
            centerSelect.innerHTML = '<option value="">Sélectionnez un centre</option>';
            centers.forEach(center => {
                const option = document.createElement('option');
                option.value = center.id;
                option.textContent = center.name;
                centerSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Erreur lors du chargement des centres:', error);
            centerSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        });
}

// Fonction pour mettre à jour l'impact sur le stock
function updateStockImpact() {
    const quantity = parseInt(document.getElementById('quantity').value) || 0;
    const direction = document.getElementById('direction').value;
    const currentStock = {{ $material->stock }};

    if (quantity > 0) {
        const summary = document.getElementById('command-summary');
        const stockImpact = document.getElementById('stock-impact');

        let newStock = direction === 'in' ? currentStock + quantity : currentStock - quantity;
        let impactText = direction === 'in' ?
            `${currentStock} + ${quantity} = ${newStock}` :
            `${currentStock} - ${quantity} = ${newStock}`;

        stockImpact.textContent = impactText;
        stockImpact.className = newStock < 0 ? 'text-lg font-bold text-red-600' : 'text-lg font-bold text-[#4CA3DD]';

        summary.classList.remove('hidden');
    } else {
        document.getElementById('command-summary').classList.add('hidden');
    }
}

// Fonction pour changer le tri
function changeSorting(sort) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', sort);
    window.location.href = url.toString();
}

// Fonction pour afficher les détails d'une commande
function showCommandDetails(commandId) {
    fetch(`/admin/commands/${commandId}`)
        .then(response => response.json())
        .then(command => {
            alert(`Détails de la commande #${command.id}:\n\n` +
                  `Type: ${command.direction_text}\n` +
                  `Quantité: ${command.quantity}\n` +
                  `Matériel: ${command.material}\n` +
                  `Utilisateur: ${command.user}\n` +
                  `Ville: ${command.city}\n` +
                  `Centre: ${command.center}\n` +
                  `Date: ${command.created_at}\n` +
                  `Il y a: ${command.formatted_date}`);
        })
        .catch(error => {
            console.error('Erreur lors du chargement des détails:', error);
            alert('Erreur lors du chargement des détails de la commande');
        });
}

// Fonction pour supprimer une commande
function deleteCommand(commandId, directionLabel, quantity) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer cette commande ?\n\n` +
                `Type: ${directionLabel}\n` +
                `Quantité: ${quantity}\n\n` +
                `Cette action ajustera automatiquement le stock et est irréversible.`)) {

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/commands/${commandId}`;

        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken.getAttribute('content');
            form.appendChild(csrfInput);
        }

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        document.body.appendChild(form);
        form.submit();
    }
}

// Fermer le modal en cliquant en dehors
document.addEventListener('click', function(event) {
    const modal = document.getElementById('commandModal');
    if (event.target === modal) {
        closeCommandModal();
    }
});

// Fermer le modal avec la touche Échap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('commandModal');
        if (!modal.classList.contains('hidden')) {
            closeCommandModal();
        }
    }
});
</script>
@endpush