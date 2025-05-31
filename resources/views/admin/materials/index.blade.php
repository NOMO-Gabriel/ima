@extends('layouts.app')

@section('title', 'Gestion des Matériels')

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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Gestion des Matériaux</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-5 mb-8">
        <!-- En-tête avec titre et bouton d'ajout -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-400 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                Gestion des Matériels
            </h1>
            <button type="button" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg" onclick="openModal()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouveau matériel
            </button>
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

        <!-- Section des statistiques -->
        <div class="stats-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="stats-card bg-white rounded-lg p-4 shadow border border-gray-200 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <div class="stats-icon primary bg-blue-100 text-[#4CA3DD] p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Total</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold text-gray-800">{{ $materials->total() ?? 0 }}</h3>
                    <p class="stats-label text-sm text-gray-600">Matériaux</p>
                </div>
                <div class="stats-trend mt-3">
                    <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="progress-bar h-full bg-[#4CA3DD]" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <div class="stats-card bg-white rounded-lg p-4 shadow border border-gray-200 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <div class="stats-icon success bg-green-100 text-green-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Stock</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold text-gray-800">{{ $materials->sum('stock') ?? 0 }}</h3>
                    <p class="stats-label text-sm text-gray-600">Unités en stock</p>
                </div>
                <div class="stats-trend mt-3">
                    <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="progress-bar h-full bg-green-500" style="width: 85%"></div>
                    </div>
                </div>
            </div>

            <div class="stats-card bg-white rounded-lg p-4 shadow border border-gray-200 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <div class="stats-icon warning bg-yellow-100 text-yellow-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Valeur</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold text-gray-800">{{ number_format($materials->sum(fn($m) => $m->price * $m->stock), 0, ',', ' ') }} XAF</h3>
                    <p class="stats-label text-sm text-gray-600">Valeur totale</p>
                </div>
                <div class="stats-trend mt-3">
                    <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="progress-bar h-full bg-yellow-500" style="width: 100%"></div>
                    </div>
                </div>
            </div>

            <div class="stats-card bg-white rounded-lg p-4 shadow border border-gray-200 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <div class="stats-icon info bg-purple-100 text-purple-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Types</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold text-gray-800">{{ count($types ?? []) }}</h3>
                    <p class="stats-label text-sm text-gray-600">Types de matériaux</p>
                </div>
                <div class="stats-trend mt-3">
                    <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="progress-bar h-full bg-purple-500" style="width: 100%"></div>
                    </div>
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
                    <input type="search" id="search-materials" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD]" placeholder="Rechercher un matériel...">
                </div>
                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                    <!-- Filtres par type -->
                    <div class="flex flex-wrap gap-2">
                        @foreach($types as $typeOption)
                            <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale(), 'type' => $typeOption]) }}"
                               class="px-3 py-1 text-sm rounded-full transition-colors duration-200 {{ $type === $typeOption ? 'bg-[#4CA3DD] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                {{ ucfirst($typeOption) }}
                            </a>
                        @endforeach
                    </div>
                    <select id="filter-sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5">
                        <option value="name-asc">Nom (A-Z)</option>
                        <option value="name-desc">Nom (Z-A)</option>
                        <option value="price-asc">Prix (croissant)</option>
                        <option value="price-desc">Prix (décroissant)</option>
                        <option value="stock-asc">Stock (croissant)</option>
                        <option value="stock-desc">Stock (décroissant)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tableau des matériaux -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Nom
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Unité
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Stock
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Prix
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Type
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($materials as $material)
                    <tr class="hover:bg-gray-100 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                            {{ $material->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                            <div class="truncate">{{ $material->description ?? '—' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-gray-100 text-gray-800 text-xs font-medium">
                                {{ $material->unit }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <span class="px-2.5 py-1 inline-flex items-center rounded-full
                                {{ $material->stock > 10 ? 'bg-green-100 text-green-800' : ($material->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}
                                text-xs font-medium">
                                {{ $material->stock }}
                                @if($material->stock <= 5)
                                    <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-blue-100 text-blue-800 text-xs font-medium">
                                {{ number_format($material->price, 0, ',', ' ') }} XAF
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-purple-100 text-purple-800 text-xs font-medium">
                                {{ ucfirst($material->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material->id]) }}"
                                   class="text-[#4CA3DD] hover:text-[#2A7AB8] dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150"
                                   title="Voir les détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <button type="button"
                                        class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors duration-150"
                                        title="Modifier"
                                        onclick="editMaterial({{ $material->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button type="button"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors duration-150"
                                        title="Supprimer"
                                        onclick="deleteMaterial({{ $material->id }}, '{{ $material->name }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                <p class="text-lg font-medium">Aucun matériel {{ $type && $type !== 'all' ? 'de type "'.ucfirst($type).'"' : '' }} trouvé</p>
                                <p class="text-sm text-gray-500 mt-1">Commencez par ajouter un matériel en utilisant le bouton ci-dessus</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($materials->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 px-6 py-4 bg-white border-t border-gray-200">
                <div class="pagination-info mb-4 sm:mb-0">
                    Affichage de <span>{{ $materials->firstItem() ?? 0 }}</span> à <span>{{ $materials->lastItem() ?? 0 }}</span> sur <span>{{ $materials->total() }}</span> matériaux
                </div>
                <div class="pagination-controls">
                    {{ $materials->appends(['type' => $type])->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Création/Modification matériel -->
    <div class="modal fade fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden" id="createMaterialModal">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl bg-white rounded-lg shadow-xl">
            <div class="modal-content">
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <span id="modal-title">Nouveau matériel</span>
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none" onclick="closeModal()">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form id="material-form" method="POST">
                    @csrf
                    <div id="method-field"></div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom du matériel <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200"
                                       id="name"
                                       name="name"
                                       required
                                       placeholder="Entrez le nom du matériel">
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description
                                </label>
                                <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200"
                                          id="description"
                                          name="description"
                                          rows="3"
                                          placeholder="Description détaillée du matériel"></textarea>
                            </div>

                            <div>
                                <label for="unit" class="block text-sm font-medium text-gray-700 mb-2">
                                    Unité de mesure <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200"
                                        id="unit"
                                        name="unit"
                                        required>
                                    <option value="">Sélectionnez une unité</option>
                                    <option value="pcs">Pièces</option>
                                    <option value="kg">Kilogrammes</option>
                                    <option value="g">Grammes</option>
                                    <option value="m">Mètres</option>
                                    <option value="cm">Centimètres</option>
                                    <option value="mm">Millimètres</option>
                                    <option value="l">Litres</option>
                                    <option value="ml">Millilitres</option>
                                    <option value="m2">Mètres carrés</option>
                                    <option value="m3">Mètres cubes</option>
                                    <option value="set">Ensemble</option>
                                    <option value="box">Boîte</option>
                                    <option value="pack">Pack</option>
                                </select>
                            </div>

                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Type <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200"
                                        id="type"
                                        name="type"
                                        required>
                                    <option value="">Sélectionnez un type</option>
                                    <option value="booklet" {{ $type === 'booklet' ? 'selected' : '' }}>Livret</option>
                                    <option value="mock_exam" {{ $type === 'mock_exam' ? 'selected' : '' }}>Examen blanc</option>
                                    <option value="sheet" {{ $type === 'sheet' ? 'selected' : '' }}>Feuille</option>
                                    <option value="other" {{ $type === 'other' ? 'selected' : '' }}>Autre</option>
                                </select>
                            </div>

                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stock initial <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200"
                                           id="stock"
                                           name="stock"
                                           min="0"
                                           value="0"
                                           required
                                           placeholder="0">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                                    Prix unitaire (XAF) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-200"
                                           id="price"
                                           name="price"
                                           min="0"
                                           step="0.01"
                                           value="0"
                                           required
                                           placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-400 text-sm">XAF</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Résumé de la valeur totale -->
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Valeur totale estimée :</span>
                                <span id="total-value" class="text-lg font-bold text-[#4CA3DD]">0 XAF</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg space-x-3">
                        <button type="button"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] transition-colors duration-200"
                                onclick="closeModal()">
                            Annuler
                        </button>
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium text-white bg-[#4CA3DD] border border-transparent rounded-lg hover:bg-[#2A7AB8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] transition-colors duration-200 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span id="submit-text">Créer le matériel</span>
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

    /* Progress bars animation */
    .progress-bar {
        transition: width 1s ease-in-out;
    }

    /* Hover effects pour les stats cards */
    .stats-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

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

    // Calcul de la valeur totale en temps réel
    const stockInput = document.getElementById('stock');
    const priceInput = document.getElementById('price');
    const totalValueSpan = document.getElementById('total-value');

    function updateTotalValue() {
        const stock = parseFloat(stockInput.value) || 0;
        const price = parseFloat(priceInput.value) || 0;
        const total = stock * price;
        totalValueSpan.textContent = new Intl.NumberFormat('fr-FR').format(total) + ' XAF';
    }

    if (stockInput && priceInput) {
        stockInput.addEventListener('input', updateTotalValue);
        priceInput.addEventListener('input', updateTotalValue);
    }

    // Filtrage et recherche
    const searchInput = document.getElementById('search-materials');
    const sortFilter = document.getElementById('filter-sort');

    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                console.log('Recherche:', this.value);
                // Implémentation de la recherche en temps réel
            }, 300);
        });
    }

    if (sortFilter) {
        sortFilter.addEventListener('change', function() {
            console.log('Tri:', this.value);
            // Implémentation du tri
        });
    }
});

// Fonctions pour le modal
function openModal(materialId = null) {
    const modal = document.getElementById('createMaterialModal');
    const form = document.getElementById('material-form');
    const modalTitle = document.getElementById('modal-title');
    const submitText = document.getElementById('submit-text');
    const methodField = document.getElementById('method-field');

    if (materialId) {
        // Mode édition
        modalTitle.textContent = 'Modifier le matériel';
        submitText.textContent = 'Mettre à jour';
        form.action = `/admin/materials/${materialId}`;
        methodField.innerHTML = '@method("PUT")';

        // Charger les données du matériel (AJAX)
        loadMaterialData(materialId);
    } else {
        // Mode création
        modalTitle.textContent = 'Nouveau matériel';
        submitText.textContent = 'Créer le matériel';
        form.action = '{{ route("admin.materials.store", ["locale" => app()->getLocale()]) }}';
        methodField.innerHTML = '';

        // Réinitialiser le formulaire
        form.reset();
        document.getElementById('total-value').textContent = '0 XAF';
    }

    modal.classList.remove('hidden');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('createMaterialModal');
    modal.classList.add('hidden');
    modal.classList.remove('show');
    document.body.style.overflow = 'auto';
}

function editMaterial(materialId) {
    openModal(materialId);
}

function deleteMaterial(materialId, materialName) {
    if (confirm(`Êtes-vous sûr de vouloir supprimer le matériel "${materialName}" ?\n\nCette action est irréversible.`)) {
        // Créer et soumettre un formulaire de suppression
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/materials/${materialId}`;

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

function loadMaterialData(materialId) {
    // Fonction pour charger les données d'un matériel via AJAX
    fetch(`/admin/materials/${materialId}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('name').value = data.name || '';
            document.getElementById('description').value = data.description || '';
            document.getElementById('unit').value = data.unit || '';
            document.getElementById('stock').value = data.stock || 0;
            document.getElementById('price').value = data.price || 0;
            document.getElementById('type').value = data.type || '';

            // Mettre à jour la valeur totale
            const stock = parseFloat(data.stock) || 0;
            const price = parseFloat(data.price) || 0;
            const total = stock * price;
            document.getElementById('total-value').textContent = new Intl.NumberFormat('fr-FR').format(total) + ' XAF';
        })
        .catch(error => {
            console.error('Erreur lors du chargement des données:', error);
        });
}

// Fermer le modal en cliquant en dehors
document.addEventListener('click', function(event) {
    const modal = document.getElementById('createMaterialModal');
    if (event.target === modal) {
        closeModal();
    }
});

// Fermer le modal avec la touche Échap
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('createMaterialModal');
        if (!modal.classList.contains('hidden')) {
            closeModal();
        }
    }
});
</script>
@endpush