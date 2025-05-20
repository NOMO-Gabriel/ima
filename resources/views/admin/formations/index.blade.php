@extends('layouts.app')

@section('title', 'Gestion des Formations')

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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Gestion des Formations</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-5 mb-8">
        <!-- En-tête avec titre et bouton d'ajout -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-400 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Gestion des Formations
            </h1>
            <a href="{{ route('admin.formations.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Ajouter une formation
            </a>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div id="alert-success" class="flex items-center p-4 mb-6 text-green-800 border-l-4 border-green-500 bg-green-50" role="alert">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-success" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Total</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold text-gray-800">{{ $formationsCount ?? $formations->total() }}</h3>
                    <p class="stats-label text-sm text-gray-600">Formations</p>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Actives</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold text-gray-800">{{ $activeFormationsCount ?? $formations->where('status', 'active')->count() }}</h3>
                    <p class="stats-label text-sm text-gray-600">Formations actives</p>
                </div>
                <div class="stats-trend mt-3">
                    @php
                        $activePercentage = ($formations->total() > 0) ? ($formations->where('status', 'active')->count() / $formations->total()) * 100 : 0;
                    @endphp
                    <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                        <div class="progress-bar h-full bg-green-500" style="width: {{ $activePercentage }}%"></div>
                    </div>
                </div>
            </div>

            <div class="stats-card bg-white rounded-lg p-4 shadow border border-gray-200 flex flex-col">
                <div class="flex items-center justify-between mb-3">
                    <div class="stats-icon warning bg-yellow-100 text-yellow-600 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Total heures</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold text-gray-800">{{ $totalHours ?? $formations->sum('hours') }}</h3>
                    <p class="stats-label text-sm text-gray-600">Heures de formation</p>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="text-sm text-gray-500">Phases</span>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value text-2xl font-bold text-gray-800">{{ $phasesCount ?? (isset($phases) ? $phases->count() : 0) }}</h3>
                    <p class="stats-label text-sm text-gray-600">Types de phases</p>
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
                    <input type="search" id="search-formations" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD]" placeholder="Rechercher une formation...">
                </div>
                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                    <select id="filter-phase" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5">
                        <option value="">Toutes les phases</option>
                        <!-- Options à remplir dynamiquement -->
                    </select>
                    <select id="filter-sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5">
                        <option value="name-asc">Nom (A-Z)</option>
                        <option value="name-desc">Nom (Z-A)</option>
                        <option value="price-asc">Prix (croissant)</option>
                        <option value="price-desc">Prix (décroissant)</option>
                        <option value="hours-asc">Heures (croissant)</option>
                        <option value="hours-desc">Heures (décroissant)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tableau des formations -->
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
                        Prix
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Nombre d'heures
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Phase
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($formations as $formation)
                    <tr class="hover:bg-gray-100 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                            {{ $formation->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                            <div class="truncate">{{ $formation->description ?? '—' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-yellow-100 text-yellow-800 text-xs font-medium">
                                {{ number_format($formation->price, 2, ',', ' ') }} €
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-blue-200 text-blue-800 text-xs font-medium">
                                {{ $formation->hours }} h
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            @if($formation->phase)
                                <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-purple-100 text-purple-800 text-xs font-medium">
                                    {{ $formation->phase->name }}
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('admin.formations.show', ['locale' => app()->getLocale(), 'formation' => $formation->id]) }}"
                                   class="text-[#4CA3DD] hover:text-[#2A7AB8] dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150"
                                   title="Voir les détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.formations.edit', ['locale' => app()->getLocale(), 'formation' => $formation->id]) }}"
                                   class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors duration-150"
                                   title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.formations.destroy', ['locale' => app()->getLocale(), 'formation' => $formation->id]) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette formation?');">
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
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <p class="text-lg font-medium">Aucune formation enregistrée</p>
                                <p class="text-sm text-gray-500 mt-1">Commencez par ajouter une formation en utilisant le bouton ci-dessus</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination - Corrigé -->
        @if($formations->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 px-6 py-4 bg-white border-t border-gray-200">
                <div class="pagination-info mb-4 sm:mb-0">
                    Affichage de <span>{{ $formations->firstItem() ?? 0 }}</span> à <span>{{ $formations->lastItem() ?? 0 }}</span> sur <span>{{ $formations->total() }}</span> formations
                </div>
                <div class="pagination-controls">
                    {{ $formations->links('vendor.pagination.tailwind') }}
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
    </style>
@endpush

@push('scripts')
    <script>
        // Auto-dismiss pour les alertes
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des alertes
            const alerts = document.querySelectorAll('[id^="alert-"]');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]', 'transition-all', 'duration-500');
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 5000);
            });

            // Filtrage des formations (simulation)
            const searchInput = document.getElementById('search-formations');
            const phaseFilter = document.getElementById('filter-phase');
            const sortFilter = document.getElementById('filter-sort');

            // Exemple de traitement des filtres
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    console.log('Recherche:', this.value);
                    // Logique de filtrage à implémenter
                });
            }

            if (phaseFilter) {
                phaseFilter.addEventListener('change', function() {
                    console.log('Filtre phase:', this.value);
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
