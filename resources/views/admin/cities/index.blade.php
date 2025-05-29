@extends('layouts.app')

@section('title', 'Gestion des Villes')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5 transition-colors duration-300" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-sm font-medium transition-colors duration-300"
                   :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
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
                    <span class="ml-1 text-sm font-medium md:ml-2"
                          :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                        Gestion des Villes
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    @canany(['city.view', 'city.create', 'city.update', 'city.delete'])
        <div class="shadow-md rounded-lg p-5 mb-8 transition-colors duration-300"
             :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
            <!-- En-tête avec titre et bouton d'ajout -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold flex items-center transition-colors duration-300"
                    :class="{ 'text-gray-200': darkMode, 'text-gray-400': !darkMode }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Gestion des Villes
                </h1>
                @can('city.create')
                    <a href="{{ route('admin.cities.create', app()->getLocale()) }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Ajouter une ville
                    </a>
                @endcan
            </div>

            <!-- Messages Flash -->
            <x-flash-message />

            @can('city.view')
                <!-- Section des statistiques -->
                <div class="stats-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    <div class="stats-card rounded-lg p-4 shadow border flex flex-col transition-colors duration-300"
                         :class="{ 'bg-gray-700 border-gray-600': darkMode, 'bg-white border-gray-200': !darkMode }">
                        <div class="flex items-center justify-between mb-3">
                            <div class="stats-icon primary bg-blue-100 text-[#4CA3DD] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <span class="text-sm transition-colors duration-300"
                                  :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">Total</span>
                        </div>
                        <div class="stats-content">
                            <h3 class="stats-value text-2xl font-bold transition-colors duration-300"
                                :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">{{ $cities->total() }}</h3>
                            <p class="stats-label text-sm transition-colors duration-300"
                               :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">Villes</p>
                        </div>
                        <div class="stats-trend mt-3">
                            <div class="h-2 w-full rounded-full overflow-hidden transition-colors duration-300"
                                 :class="{ 'bg-gray-600': darkMode, 'bg-gray-200': !darkMode }">
                                <div class="progress-bar h-full bg-[#4CA3DD]" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="stats-card rounded-lg p-4 shadow border flex flex-col transition-colors duration-300"
                         :class="{ 'bg-gray-700 border-gray-600': darkMode, 'bg-white border-gray-200': !darkMode }">
                        <div class="flex items-center justify-between mb-3">
                            <div class="stats-icon success bg-green-100 text-green-600 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <span class="text-sm transition-colors duration-300"
                                  :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">Aujourd'hui</span>
                        </div>
                        <div class="stats-content">
                            @php
                                $today = $cities->filter(function($city) {
                                    return $city->created_at->isToday();
                                })->count();
                            @endphp
                            <h3 class="stats-value text-2xl font-bold transition-colors duration-300"
                                :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">{{ $today }}</h3>
                            <p class="stats-label text-sm transition-colors duration-300"
                               :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">Nouvelles villes</p>
                        </div>
                        <div class="stats-trend mt-3">
                            <div class="h-2 w-full rounded-full overflow-hidden transition-colors duration-300"
                                 :class="{ 'bg-gray-600': darkMode, 'bg-gray-200': !darkMode }">
                                <div class="progress-bar h-full bg-green-500" style="width: {{ $today > 0 ? 100 : 5 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="stats-card rounded-lg p-4 shadow border flex flex-col transition-colors duration-300"
                         :class="{ 'bg-gray-700 border-gray-600': darkMode, 'bg-white border-gray-200': !darkMode }">
                        <div class="flex items-center justify-between mb-3">
                            <div class="stats-icon warning bg-purple-100 text-purple-600 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm transition-colors duration-300"
                                  :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">Cette semaine</span>
                        </div>
                        <div class="stats-content">
                            @php
                                $thisWeek = $cities->filter(function($city) {
                                    return $city->created_at->isCurrentWeek();
                                })->count();
                            @endphp
                            <h3 class="stats-value text-2xl font-bold transition-colors duration-300"
                                :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">{{ $thisWeek }}</h3>
                            <p class="stats-label text-sm transition-colors duration-300"
                               :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">Nouvelles villes</p>
                        </div>
                        <div class="stats-trend mt-3">
                            <div class="h-2 w-full rounded-full overflow-hidden transition-colors duration-300"
                                 :class="{ 'bg-gray-600': darkMode, 'bg-gray-200': !darkMode }">
                                <div class="progress-bar h-full bg-purple-500" style="width: {{ $thisWeek > 0 ? 100 : 5 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtres et recherche -->
                <div class="mb-6">
                    <form method="GET" action="{{ route('admin.cities.index', ['locale' => app()->getLocale()]) }}" class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                        <div class="relative w-full lg:w-80">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" name="search" value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors duration-300"
                                   :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300': !darkMode }"
                                   placeholder="Rechercher une ville...">
                        </div>
                        <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                            <select name="sort" onchange="this.form.submit()"
                                    class="border text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5 transition-colors duration-300"
                                    :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                                <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                                <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                                <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Plus anciennes</option>
                                <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Plus récentes</option>
                            </select>
                            <button type="submit" class="px-4 py-2 bg-[#4CA3DD] text-white rounded-lg hover:bg-[#2A7AB8] transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tableau des villes -->
                <div class="overflow-x-auto rounded-lg border transition-colors duration-300"
                     :class="{ 'border-gray-600': darkMode, 'border-gray-200': !darkMode }">
                    <table class="min-w-full divide-y transition-colors duration-300"
                           :class="{ 'divide-gray-600': darkMode, 'divide-gray-200': !darkMode }">
                        <thead :class="{ 'bg-gray-700': darkMode, 'bg-gray-50': !darkMode }">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-300"
                                :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                                Code de la ville
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-300"
                                :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                                Nom de la ville
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors duration-300"
                                :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                                Date de création
                            </th>
                            @canany(['city.update', 'city.delete'])
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider transition-colors duration-300"
                                    :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                                    Actions
                                </th>
                            @endcanany
                        </tr>
                        </thead>
                        <tbody class="divide-y transition-colors duration-300"
                               :class="{ 'bg-gray-800 divide-gray-600': darkMode, 'bg-white divide-gray-200': !darkMode }">
                        @forelse($cities as $city)
                            <tr class="transition-colors duration-150"
                                :class="{ 'hover:bg-gray-700': darkMode, 'hover:bg-gray-100': !darkMode }">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium transition-colors duration-300"
                                    :class="{ 'text-gray-200': darkMode, 'text-gray-700': !darkMode }">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $city->code }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium transition-colors duration-300"
                                    :class="{ 'text-gray-200': darkMode, 'text-gray-700': !darkMode }">
                                    <div class="flex items-center">
                                        {{ $city->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm transition-colors duration-300"
                                    :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                                    {{ $city->created_at->format('d/m/Y à H:i') }}
                                </td>
                                @canany(['city.update', 'city.delete'])
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <div class="flex justify-center space-x-3">
                                            @can('city.update')
                                                <a href="{{ route('admin.cities.edit', [app()->getLocale(), $city]) }}"
                                                   class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors duration-150"
                                                   title="Modifier">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('city.delete')
                                                <form action="{{ route('admin.cities.destroy', [app()->getLocale(), $city]) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirmDelete('{{ $city->name }}');">
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
                                            @endcan
                                        </div>
                                    </td>
                                @endcanany
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ canany(['city.update', 'city.delete']) ? '4' : '3' }}" class="px-6 py-10 text-center transition-colors duration-300"
                                    :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 transition-colors duration-300"
                                             :class="{ 'text-gray-500': darkMode, 'text-gray-400': !darkMode }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <p class="text-lg font-medium">
                                            @if(request('search'))
                                                Aucun résultat pour "{{ request('search') }}"
                                            @else
                                                Aucune ville enregistrée
                                            @endif
                                        </p>
                                        <p class="text-sm mt-1 transition-colors duration-300"
                                           :class="{ 'text-gray-500': darkMode, 'text-gray-500': !darkMode }">
                                            @if(request('search'))
                                                Essayez avec d'autres mots-clés
                                            @else
                                                Commencez par ajouter une ville en utilisant le bouton ci-dessus
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
                @if($cities->hasPages())
                    <div class="mt-6">
                        {{ $cities->withQueryString()->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            @endcan
        </div>
    @else
        <div class="shadow-md rounded-lg p-8 mb-8 text-center transition-colors duration-300"
             :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 transition-colors duration-300"
                 :class="{ 'text-gray-500': darkMode, 'text-gray-400': !darkMode }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <h3 class="text-lg font-medium mb-2 transition-colors duration-300"
                :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                Accès non autorisé
            </h3>
            <p class="transition-colors duration-300"
               :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                Vous n'avez pas les permissions nécessaires pour accéder à cette section.
            </p>
        </div>
    @endcanany
@endsection

@push('styles')
    <style>
        /* Animation pour les barres de progression */
        .progress-bar {
            transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
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

        /* Styles pour les cartes statistiques */
        .stats-card {
            transform: translateY(0);
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .dark .stats-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Animations pour les lignes du tableau */
        tbody tr {
            transition: all 0.15s ease-in-out;
        }

        /* Styles pour les boutons d'action */
        .action-btn {
            transform: scale(1);
            transition: transform 0.1s ease-in-out;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: 1fr;
            }

            .table-actions {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
@endpush
