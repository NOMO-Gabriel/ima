@extends('layouts.app')

@section('title', 'Gestion des Centres')

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
                        Gestion des Centres
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    @canany(['center.view', 'center.create', 'center.update', 'center.delete'])
        <div class="transition-colors duration-300">
            <!-- En-tête avec titre et bouton d'ajout -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-3xl font-bold flex items-center transition-colors duration-300"
                    :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Gestion des Centres
                </h1>
                @can('center.create')
                    <a href="{{ route('admin.centers.create', app()->getLocale()) }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Créer un centre
                    </a>
                @endcan
            </div>

            <!-- Messages Flash -->
            <x-flash-message />

            @can('center.view')
                <!-- Section des statistiques -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="stats-card rounded-xl p-6 shadow-lg border transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
                         :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stats-icon bg-blue-100 text-[#4CA3DD] p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold mb-1 transition-colors duration-300"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">{{ $centers->total() }}</h3>
                        <p class="text-sm transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">Centres au total</p>
                        <div class="mt-3">
                            <div class="h-2 w-full rounded-full overflow-hidden transition-colors duration-300"
                                 :class="{ 'bg-gray-700': darkMode, 'bg-gray-200': !darkMode }">
                                <div class="progress-bar h-full bg-[#4CA3DD]" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="stats-card rounded-xl p-6 shadow-lg border transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
                         :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stats-icon bg-green-100 text-green-600 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        @php
                            $activeCenters = $centers->where('is_active', true)->count();
                        @endphp
                        <h3 class="text-2xl font-bold mb-1 transition-colors duration-300"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">{{ $activeCenters }}</h3>
                        <p class="text-sm transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">Centres actifs</p>
                        <div class="mt-3">
                            <div class="h-2 w-full rounded-full overflow-hidden transition-colors duration-300"
                                 :class="{ 'bg-gray-700': darkMode, 'bg-gray-200': !darkMode }">
                                <div class="progress-bar h-full bg-green-500" style="width: {{ $centers->total() > 0 ? ($activeCenters / $centers->total()) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="stats-card rounded-xl p-6 shadow-lg border transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
                         :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stats-icon bg-red-100 text-red-600 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        @php
                            $inactiveCenters = $centers->where('is_active', false)->count();
                        @endphp
                        <h3 class="text-2xl font-bold mb-1 transition-colors duration-300"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">{{ $inactiveCenters }}</h3>
                        <p class="text-sm transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">Centres inactifs</p>
                        <div class="mt-3">
                            <div class="h-2 w-full rounded-full overflow-hidden transition-colors duration-300"
                                 :class="{ 'bg-gray-700': darkMode, 'bg-gray-200': !darkMode }">
                                <div class="progress-bar h-full bg-red-500" style="width: {{ $centers->total() > 0 ? ($inactiveCenters / $centers->total()) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="stats-card rounded-xl p-6 shadow-lg border transition-all duration-300 hover:shadow-xl hover:-translate-y-1"
                         :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                        <div class="flex items-center justify-between mb-4">
                            <div class="stats-icon bg-purple-100 text-purple-600 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        @php
                            $recentCenters = $centers->filter(function($center) {
                                return $center->created_at->isCurrentWeek();
                            })->count();
                        @endphp
                        <h3 class="text-2xl font-bold mb-1 transition-colors duration-300"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">{{ $recentCenters }}</h3>
                        <p class="text-sm transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">Nouveaux cette semaine</p>
                        <div class="mt-3">
                            <div class="h-2 w-full rounded-full overflow-hidden transition-colors duration-300"
                                 :class="{ 'bg-gray-700': darkMode, 'bg-gray-200': !darkMode }">
                                <div class="progress-bar h-full bg-purple-500" style="width: {{ $recentCenters > 0 ? 100 : 5 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtres et recherche -->
                <div class="mb-8 p-6 rounded-xl shadow-lg border transition-colors duration-300"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <form method="GET" action="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}" class="flex flex-col lg:flex-row gap-4 items-center justify-between">
                        <div class="relative w-full lg:w-96">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="search" name="search" value="{{ request('search') }}"
                                   class="w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300"
                                   :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300': !darkMode }"
                                   placeholder="Rechercher un centre...">
                        </div>
                        <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                            <select name="status" onchange="this.form.submit()"
                                    class="border text-sm rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-3 transition-all duration-300"
                                    :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                                <option value="">Tous les statuts</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actifs</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactifs</option>
                            </select>
                            <select name="sort" onchange="this.form.submit()"
                                    class="border text-sm rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-3 transition-all duration-300"
                                    :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                                <option value="name-asc" {{ request('sort') == 'name-asc' ? 'selected' : '' }}>Nom (A-Z)</option>
                                <option value="name-desc" {{ request('sort') == 'name-desc' ? 'selected' : '' }}>Nom (Z-A)</option>
                                <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Plus anciens</option>
                                <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Plus récents</option>
                            </select>
                            <button type="submit" class="px-4 py-3 bg-[#4CA3DD] text-white rounded-lg hover:bg-[#2A7AB8] transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Grille des centres -->
                @if($centers->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($centers as $center)
                            <div class="center-card rounded-xl shadow-lg border transition-all duration-300 hover:shadow-xl hover:-translate-y-1 overflow-hidden"
                                 :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                                <!-- En-tête de la carte -->
                                <div class="p-6 border-b transition-colors duration-300"
                                     :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                                    <div class="flex items-start justify-between mb-4">
                                        <div class="flex items-center">
                                            <div class="p-3 rounded-full {{ $center->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-lg font-semibold transition-colors duration-300"
                                                    :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                                                    {{ $center->name }}
                                                </h3>
                                                <p class="text-sm transition-colors duration-300"
                                                   :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                                    Code: {{ $center->code }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $center->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $center->is_active ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Corps de la carte -->
                                <div class="p-6">
                                    <div class="space-y-3 mb-6">
                                        <div class="flex items-center text-sm transition-colors duration-300"
                                             :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            Ville: {{ $center->city ? $center->city->name : 'Non spécifiée' }}
                                        </div>
                                        <div class="flex items-center text-sm transition-colors duration-300"
                                             :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Directeur: {{ $center->director ? $center->director->first_name . ' ' . $center->director->last_name : 'Non assigné' }}
                                        </div>
                                        @if($center->contact_email)
                                            <div class="flex items-center text-sm transition-colors duration-300"
                                                 :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $center->contact_email }}
                                            </div>
                                        @endif
                                        @if($center->contact_phone)
                                            <div class="flex items-center text-sm transition-colors duration-300"
                                                 :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>
                                                {{ $center->contact_phone }}
                                            </div>
                                        @endif
                                        <div class="flex items-center text-sm transition-colors duration-300"
                                             :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Créé le {{ $center->created_at->format('d/m/Y') }}
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    @canany(['center.view', 'center.update', 'center.delete'])
                                        <div class="flex flex-wrap gap-2">
                                            @can('center.view')
                                                <a href="{{ route('admin.centers.show', [app()->getLocale(), $center]) }}"
                                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-[#4CA3DD] bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200"
                                                   title="Voir les détails">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Voir
                                                </a>
                                            @endcan
                                            @can('center.update')
                                                <a href="{{ route('admin.centers.edit', [app()->getLocale(), $center]) }}"
                                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-yellow-700 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition-colors duration-200"
                                                   title="Modifier">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Modifier
                                                </a>
                                            @endcan
                                            @can('center.delete')
                                                <form action="{{ route('admin.centers.destroy', [app()->getLocale(), $center]) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirmDelete('{{ $center->name }}');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200"
                                                            title="Supprimer">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Supprimer
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    @endcanany
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- État vide -->
                    <div class="text-center py-16 rounded-xl shadow-lg border transition-colors duration-300"
                         :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 transition-colors duration-300"
                             :class="{ 'text-gray-500': darkMode, 'text-gray-400': !darkMode }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <h3 class="text-xl font-medium mb-2 transition-colors duration-300"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            @if(request('search'))
                                Aucun résultat pour "{{ request('search') }}"
                            @else
                                Aucun centre enregistré
                            @endif
                        </h3>
                        <p class="mb-6 transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                            @if(request('search'))
                                Essayez avec d'autres mots-clés ou modifiez vos filtres
                            @else
                                Commencez par créer votre premier centre
                            @endif
                        </p>
                        @if(!request('search'))
                            @can('center.create')
                                <a href="{{ route('admin.centers.create', app()->getLocale()) }}"
                                   class="inline-flex items-center justify-center px-6 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Créer le premier centre
                                </a>
                            @endcan
                        @endif
                    </div>
                @endif

                <!-- Pagination -->
                @if($centers->hasPages())
                    <div class="mt-8">
                        {{ $centers->withQueryString()->links('vendor.pagination.tailwind') }}
                    </div>
                @endif
            @endcan
        </div>
    @else
        <!-- Accès non autorisé -->
        <div class="shadow-md rounded-xl p-8 mb-8 text-center transition-colors duration-300"
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

        /* Styles pour les cartes statistiques */
        .stats-card {
            transform: translateY(0);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stats-card:hover {
            transform: translateY(-8px);
        }

        /* Styles pour les cartes de centres */
        .center-card {
            transform: translateY(0);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .center-card:hover {
            transform: translateY(-8px);
        }

        /* Animation des icônes dans les cartes */
        .stats-icon, .center-card .p-3 {
            transition: all 0.3s ease;
        }

        .stats-card:hover .stats-icon,
        .center-card:hover .p-3 {
            transform: scale(1.1);
        }

        /* Animation pour les boutons d'action */
        .center-card button,
        .center-card a {
            transition: all 0.2s ease;
        }

        .center-card button:hover,
        .center-card a:hover {
            transform: translateY(-1px);
        }

        /* Effet de brillance pour les cartes */
        .center-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .center-card:hover::before {
            left: 100%;
        }

        /* Responsive amélioré */
        @media (max-width: 768px) {
            .center-card {
                margin-bottom: 1rem;
            }

            .stats-card {
                margin-bottom: 1rem;
            }

            .flex-wrap {
                flex-direction: column;
                align-items: stretch;
            }

            .flex-wrap > * {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }

        /* Animation d'apparition */
        .center-card {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }

        .center-card:nth-child(1) { animation-delay: 0.1s; }
        .center-card:nth-child(2) { animation-delay: 0.2s; }
        .center-card:nth-child(3) { animation-delay: 0.3s; }
        .center-card:nth-child(4) { animation-delay: 0.4s; }
        .center-card:nth-child(5) { animation-delay: 0.5s; }
        .center-card:nth-child(6) { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Style pour les badges de statut */
        .status-badge {
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .center-card:hover .status-badge::before {
            left: 100%;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
                        }, 300);
                    }
                });
            }, { threshold: 0.5 });

            progressBars.forEach(bar => observer.observe(bar));

            // Fonction de confirmation de suppression améliorée
            window.confirmDelete = function(centerName) {
                return confirm(
                    `Êtes-vous sûr de vouloir supprimer le centre "${centerName}" ?\n\n` +
                    'Cette action est irréversible et supprimera toutes les données associées.'
                );
            };

            // Animation des cartes au scroll
            const cards = document.querySelectorAll('.center-card, .stats-card');
            const cardObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });

            cards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                cardObserver.observe(card);
            });

            // Effet de recherche en temps réel (optionnel)
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        // Vous pouvez ajouter ici une fonction de recherche AJAX
                        // pour une expérience utilisateur plus fluide
                    }, 500);
                });
            }

            // Animation de suppression
            const deleteButtons = document.querySelectorAll('form[onsubmit*="confirmDelete"]');
            deleteButtons.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const centerCard = this.closest('.center-card');
                    const centerName = this.getAttribute('onsubmit').match(/'([^']+)'/)[1];

                    if (confirmDelete(centerName)) {
                        // Animation de suppression
                        centerCard.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                        centerCard.style.transform = 'scale(0.95) translateY(-20px)';
                        centerCard.style.opacity = '0';

                        setTimeout(() => {
                            this.submit();
                        }, 500);
                    }
                });
            });

            // Tooltip pour les boutons d'action
            const actionButtons = document.querySelectorAll('[title]');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05)';
                });

                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            });
        });
    </script>
@endpush
