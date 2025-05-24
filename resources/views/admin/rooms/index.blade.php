@extends('layouts.app')

@section('title', 'Liste des Salles')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#4CA3DD] dark:text-gray-400 dark:hover:text-white">
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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Gestion des Salles</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-5 mb-8">
        <!-- En-tête avec titre et bouton d'ajout -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Gestion des salles
            </h1>
            <a href="{{ route('admin.rooms.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouvelle salle
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

        <!-- Section des statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Statistique 1: Total des chambres -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-[#4CA3DD]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Total</span>
                </div>
                <div class="mb-3">
                    <h3 class="text-2xl font-bold text-gray-800">{{ count($rooms) }}</h3>
                    <p class="text-sm text-gray-600">Salle disponibles</p>
                </div>
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#4CA3DD]" style="width: 100%"></div>
                </div>
            </div>

            <!-- Statistique 2: Capacité totale -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-[#34D399]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Capacité</span>
                </div>
                <div class="mb-3">
                    @php
                        $totalCapacity = $rooms->sum('capacity');
                    @endphp
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalCapacity }}</h3>
                    <p class="text-sm text-gray-600">Places Totale</p>
                </div>
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#34D399]" style="width: 100%"></div>
                </div>
            </div>

            <!-- Statistique 3: capacité moyenne -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-[#FBBF24]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Moyenne</span>
                </div>
                <div class="mb-3">
                    @php
                        // Calculer la capacité moyenne des chambres
                        $averageCapacity = count($rooms) > 0 ? round($rooms->avg('capacity'), 1) : 0;
                        // Calculer le pourcentage pour la barre de progression (en supposant une capacité max de 5)
                        $capacityPercentage = min(($averageCapacity / 5) * 100, 100);
                    @endphp
                    <h3 class="text-2xl font-bold text-gray-800">{{ $averageCapacity }}</h3>
                    <p class="text-sm text-gray-600">Capacité moyenne/salle</p>
                </div>
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#FBBF24]" style="width: {{ $capacityPercentage }}%"></div>
                </div>
            </div>

            <!-- Statistique 4: Chambres récemment ajoutées (simulé) -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center text-[#A78BFA]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Récents</span>
                </div>
                <div class="mb-3">
                    @php
                        // Calculer le nombre de cours créés dans les 30 derniers jours
                        $thirtyDaysAgo = \Carbon\Carbon::now()->subDays(30);
                        $recentCourses = $rooms->filter(function($rooms) use ($thirtyDaysAgo) {
                            return $rooms->created_at >= $thirtyDaysAgo;
                        })->count();
                        $recentPercentage = $rooms->count() > 0 ? ($recentCourses / $rooms->count()) * 100 : 0;
                    @endphp
                    <h3 class="text-2xl font-bold text-gray-800">{{ $recentCourses }}</h3>
                    <p class="text-sm text-gray-600">Salles récents (30j)</p>
                </div>
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#A78BFA]" style="width: {{ $recentPercentage }}%"></div>
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
                    <input type="search" id="search-rooms" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD]" placeholder="Rechercher une salle...">
                </div>
                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                    <select id="filter-capacity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5">
                        <option value="">Toutes les capacités</option>
                        <option value="1">1 personne</option>
                        <option value="2">2 personnes</option>
                        <option value="3+">3 personnes ou plus</option>
                    </select>
                    <select id="filter-sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5">
                        <option value="name-asc">Nom (A-Z)</option>
                        <option value="name-desc">Nom (Z-A)</option>
                        <option value="capacity-asc">Capacité (croissant)</option>
                        <option value="capacity-desc">Capacité (décroissant)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tableau des chambres -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Nom
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Capacité
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Formation
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($rooms as $room)
                    <tr class="hover:bg-gray-100 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center text-[#4CA3DD]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $room->name }}</div>
                                    <div class="text-sm text-gray-500">ID: #{{ $room->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>{{ $room->capacity }} {{ $room->capacity > 1 ? 'personnes' : 'personne' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span>{{ $room->formation->name ?? 'Aucune' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('admin.rooms.edit', ['locale' => app()->getLocale(), 'room' => $room->id]) }}"
                                   class="text-[#4CA3DD] hover:text-[#2A7AB8] dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150"
                                   title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.rooms.destroy', ['locale' => app()->getLocale(), 'room' => $room->id]) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette chambre?');">
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
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <p class="text-lg font-medium">Aucune salle enregistrée</p>
                                <p class="text-sm text-gray-500 mt-1">Commencez par ajouter une salle en utilisant le bouton ci-dessus</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (si nécessaire) -->
        @if(isset($rooms) && method_exists($rooms, 'links'))
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 px-6 py-4 bg-white border-t border-gray-200">
                <div class="pagination-info mb-4 sm:mb-0">
                    Affichage de <span>{{ $rooms->firstItem() ?? 0 }}</span> à <span>{{ $rooms->lastItem() ?? 0 }}</span> sur <span>{{ $rooms->total() }}</span> chambres
                </div>
                <div class="pagination-controls">
                    {{ $rooms->links('vendor.pagination.tailwind') }}
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

            // Filtrage des chambres (simulation)
            const searchInput = document.getElementById('search-rooms');
            const capacityFilter = document.getElementById('filter-capacity');
            const sortFilter = document.getElementById('filter-sort');

            // Exemple de traitement des filtres
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    console.log('Recherche:', this.value);
                    // Logique de filtrage à implémenter
                });
            }

            if (capacityFilter) {
                capacityFilter.addEventListener('change', function() {
                    console.log('Filtre capacité:', this.value);
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
