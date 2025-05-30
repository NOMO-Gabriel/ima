@extends('layouts.app')

@section('title', 'Gestion des Matériels')

@section('content')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }">
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
                        <span class="ml-1 text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Matériels
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- En-tête de page -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="mb-4 sm:mb-0">
                    <h1 class="text-3xl font-bold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                        Gestion des Matériels
                    </h1>
                    <p class="mt-2 text-lg transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                        Gérez l'inventaire et le stock de vos matériels
                    </p>
                </div>

                @can('ressource.material.create')
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('admin.materials.create', ['locale' => app()->getLocale()]) }}"
                           class="inline-flex items-center justify-center px-4 py-2 bg-[#4CA3DD] text-white text-sm font-medium rounded-lg hover:bg-[#2A7AB8] focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-opacity-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Ajouter un matériel
                        </a>

                        @can('ressource.material.export')
                            <a href="{{ route('admin.materials.export', array_merge(['locale' => app()->getLocale()], request()->query())) }}"
                               class="inline-flex items-center justify-center px-4 py-2 border text-sm font-medium rounded-lg transition-colors"
                               :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Exporter
                            </a>
                        @endcan
                    </div>
                @endcan
            </div>
        </div>

        <!-- Messages Flash -->
        <x-flash-message />

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="rounded-lg p-6 shadow-md transition-colors"
                 :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-blue-100 text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                            {{ $stats['total'] }}
                        </p>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            Total matériels
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg p-6 shadow-md transition-colors"
                 :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-green-100 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                            {{ $stats['in_stock'] }}
                        </p>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            En stock
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg p-6 shadow-md transition-colors"
                 :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-yellow-100 text-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                            {{ $stats['low_stock'] }}
                        </p>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            Stock faible
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-lg p-6 shadow-md transition-colors"
                 :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center bg-red-100 text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                            {{ $stats['out_of_stock'] }}
                        </p>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            Rupture de stock
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="rounded-lg p-6 shadow-md mb-8 transition-colors"
             :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
            <form method="GET" action="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Recherche -->
                    <div>
                        <label for="search" class="block text-sm font-medium mb-2 transition-colors"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Recherche
                        </label>
                        <input type="text"
                               id="search"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Nom ou description..."
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                               :class="darkMode ? 'bg-[#334155] border-[#475569] text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'">
                    </div>

                    <!-- Centre -->
                    <div>
                        <label for="center_id" class="block text-sm font-medium mb-2 transition-colors"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Centre
                        </label>
                        <select id="center_id" name="center_id"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                            <option value="">Tous les centres</option>
                            @foreach($centers as $center)
                                <option value="{{ $center->id }}" {{ request('center_id') == $center->id ? 'selected' : '' }}>
                                    {{ $center->name }}@if($center->city) - {{ $center->city->name }}@endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Unité -->
                    <div>
                        <label for="unit" class="block text-sm font-medium mb-2 transition-colors"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Unité
                        </label>
                        <select id="unit" name="unit"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                            <option value="">Toutes les unités</option>
                            @foreach($units as $value => $label)
                                <option value="{{ $value }}" {{ request('unit') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Statut de stock -->
                    <div>
                        <label for="stock_status" class="block text-sm font-medium mb-2 transition-colors"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Statut de stock
                        </label>
                        <select id="stock_status" name="stock_status"
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                            <option value="">Tous les statuts</option>
                            <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>En stock</option>
                            <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>Stock faible</option>
                            <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>Rupture</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-2 bg-[#4CA3DD] text-white text-sm font-medium rounded-lg hover:bg-[#2A7AB8] transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Filtrer
                    </button>

                    <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-4 py-2 border text-sm font-medium rounded-lg transition-colors"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Réinitialiser
                    </a>
                </div>
            </form>
        </div>

        <!-- Liste des matériels -->
        <div class="rounded-lg shadow-md overflow-hidden transition-colors"
             :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">

            @if($materials->count() > 0)
                <!-- En-tête du tableau -->
                <div class="px-6 py-4 border-b transition-colors" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Matériels ({{ $materials->total() }})
                        </h3>

                        <!-- Tri -->
                        <div class="flex items-center space-x-2">
                            <span class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Trier par:</span>
                            <select onchange="updateSort(this.value)"
                                    class="text-sm border rounded px-2 py-1 transition-colors"
                                    :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="name,asc" {{ request('sort') === 'name' && request('direction') === 'asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                                <option value="name,desc" {{ request('sort') === 'name' && request('direction') === 'desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                                <option value="quantity,asc" {{ request('sort') === 'quantity' && request('direction') === 'asc' ? 'selected' : '' }}>Quantité (croissant)</option>
                                <option value="quantity,desc" {{ request('sort') === 'quantity' && request('direction') === 'desc' ? 'selected' : '' }}>Quantité (décroissant)</option>
                                <option value="created_at,desc" {{ request('sort') === 'created_at' && request('direction') === 'desc' ? 'selected' : '' }}>Plus récent</option>
                                <option value="created_at,asc" {{ request('sort') === 'created_at' && request('direction') === 'asc' ? 'selected' : '' }}>Plus ancien</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Tableau desktop -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full">
                        <thead class="transition-colors" :class="darkMode ? 'bg-gray-800' : 'bg-gray-50'">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Matériel
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Centre
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Stock
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Dernière MAJ
                            </th>
                            @canany(['ressource.material.read', 'ressource.material.update', 'ressource.material.delete'])
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider transition-colors"
                                    :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    Actions
                                </th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody class="divide-y transition-colors" :class="darkMode ? 'divide-gray-600' : 'divide-gray-200'">
                        @foreach($materials as $material)
                            <tr class="hover:bg-opacity-50 transition-colors"
                                :class="darkMode ? 'hover:bg-gray-700' : 'hover:bg-gray-50'">
                                <!-- Matériel -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-[#4CA3DD] mr-3"
                                             :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-50'">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                                {{ $material->name }}
                                            </div>
                                            @if($material->description)
                                                <div class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                    {{ Str::limit($material->description, 50) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Centre -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                        {{ $material->center->name ?? 'Centre non défini' }}
                                    </div>
                                    @if($material->center && $material->center->city)
                                        <div class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            {{ $material->center->city->name }}
                                        </div>
                                    @endif
                                </td>

                                <!-- Stock -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                        {{ number_format($material->quantity) }} {{ $units[$material->unit] ?? $material->unit }}
                                    </div>
                                </td>

                                <!-- Statut -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($material->quantity <= 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3"/>
                                                </svg>
                                                Rupture
                                            </span>
                                    @elseif($material->quantity <= 10)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3"/>
                                                </svg>
                                                Stock faible
                                            </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-1.5 h-1.5 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3"/>
                                                </svg>
                                                En stock
                                            </span>
                                    @endif
                                </td>

                                <!-- Dernière MAJ -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    {{ $material->updated_at->diffForHumans() }}
                                </td>

                                <!-- Actions -->
                                @canany(['ressource.material.read', 'ressource.material.update', 'ressource.material.delete'])
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            @can('ressource.material.read')
                                                <a href="{{ route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material]) }}"
                                                   class="text-[#4CA3DD] hover:text-[#2A7AB8] transition-colors"
                                                   title="Voir les détails">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                            @endcan

                                            @can('ressource.material.update')
                                                <a href="{{ route('admin.materials.edit', ['locale' => app()->getLocale(), 'material' => $material]) }}"
                                                   class="text-yellow-600 hover:text-yellow-500 transition-colors"
                                                   title="Modifier">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            @endcan

                                            @can('ressource.material.delete')
                                                <form action="{{ route('admin.materials.destroy', ['locale' => app()->getLocale(), 'material' => $material]) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce matériel ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-red-600 hover:text-red-500 transition-colors"
                                                            title="Supprimer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

                <!-- Vue mobile -->
                <div class="md:hidden">
                    @foreach($materials as $material)
                        <div class="px-6 py-4 border-b transition-colors" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-2">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[#4CA3DD] mr-3"
                                             :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-50'">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                                {{ $material->name }}
                                            </h3>
                                            <p class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                {{ $material->center->name ?? 'Centre non défini' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Stock:</span>
                                            <span class="transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                                {{ number_format($material->quantity) }} {{ $units[$material->unit] ?? $material->unit }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Statut:</span>
                                            @if($material->quantity <= 0)
                                                <span class="text-red-600">Rupture</span>
                                            @elseif($material->quantity <= 10)
                                                <span class="text-yellow-600">Stock faible</span>
                                            @else
                                                <span class="text-green-600">En stock</span>
                                            @endif
                                        </div>
                                    </div>

                                    @if($material->description)
                                        <p class="text-xs mt-2 transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            {{ Str::limit($material->description, 80) }}
                                        </p>
                                    @endif
                                </div>

                                @canany(['ressource.material.view', 'ressource.material.update', 'ressource.material.delete'])
                                    <div class="flex items-center space-x-2 ml-4">
                                        @can('ressource.material.view')
                                            <a href="{{ route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material]) }}"
                                               class="p-2 text-[#4CA3DD] hover:text-[#2A7AB8] transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('ressource.material.update')
                                            <a href="{{ route('admin.materials.edit', ['locale' => app()->getLocale(), 'material' => $material]) }}"
                                               class="p-2 text-yellow-600 hover:text-yellow-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('ressource.material.delete')
                                            <form action="{{ route('admin.materials.destroy', ['locale' => app()->getLocale(), 'material' => $material]) }}"
                                                  method="POST"
                                                  class="inline-block"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce matériel ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-600 hover:text-red-500 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                @endcanany
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t transition-colors" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                    {{ $materials->links() }}
                </div>
            @else
                <!-- État vide -->
                <div class="px-6 py-12 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                        Aucun matériel trouvé
                    </h3>
                    <p class="mt-1 text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        @if(request()->hasAny(['search', 'center_id', 'unit', 'stock_status']))
                            Aucun matériel ne correspond à vos critères de recherche.
                        @else
                            Commencez par ajouter votre premier matériel.
                        @endif
                    </p>
                    @can('ressource.material.create')
                        <div class="mt-6">
                            <a href="{{ route('admin.materials.create', ['locale' => app()->getLocale()]) }}"
                               class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] text-white text-sm font-medium rounded-lg hover:bg-[#2A7AB8] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Ajouter un matériel
                            </a>
                        </div>
                    @endcan
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection

@push('scripts')
    <script>
        function updateSort(value) {
            const [sort, direction] = value.split(',');
            const url = new URL(window.location);
            url.searchParams.set('sort', sort);
            url.searchParams.set('direction', direction);
            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Auto-submit du formulaire de filtre lors du changement
            const filterForm = document.querySelector('form[method="GET"]');
            const filterInputs = filterForm.querySelectorAll('select, input');

            let filterTimeout;
            filterInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.type === 'text') {
                        // Pour les champs de texte, attendre un peu avant de soumettre
                        clearTimeout(filterTimeout);
                        filterTimeout = setTimeout(() => {
                            filterForm.submit();
                        }, 500);
                    } else {
                        // Pour les selects, soumettre immédiatement
                        filterForm.submit();
                    }
                });
            });

            // Confirmation de suppression améliorée
            document.querySelectorAll('form[onsubmit*="confirm"]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const materialName = this.closest('tr, div').querySelector('[class*="font-medium"]').textContent.trim();

                    if (confirm(`Êtes-vous sûr de vouloir supprimer le matériel "${materialName}" ?\n\nCette action est irréversible.`)) {
                        this.submit();
                    }
                });
            });

            // Raccourcis clavier
            document.addEventListener('keydown', function(e) {
                // Ctrl+N pour nouveau matériel
                if (e.ctrlKey && e.key === 'n') {
                    e.preventDefault();
                    const createButton = document.querySelector('a[href*="create"]');
                    if (createButton) {
                        window.location.href = createButton.href;
                    }
                }

                // Ctrl+F pour focus sur la recherche
                if (e.ctrlKey && e.key === 'f') {
                    e.preventDefault();
                    const searchInput = document.getElementById('search');
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        /* Améliorations visuelles */
        .hover\:bg-opacity-50:hover {
            background-opacity: 0.5;
        }

        /* Animation des badges de statut */
        .inline-flex.items-center.px-2\.5.py-0\.5 {
            transition: all 0.2s ease;
        }

        .inline-flex.items-center.px-2\.5.py-0\.5:hover {
            transform: scale(1.05);
        }

        /* Animation de chargement */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        /* Amélioration des tooltips */
        [title]:hover::after {
            content: attr(title);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            white-space: nowrap;
            z-index: 1000;
        }
    </style>
@endpush
