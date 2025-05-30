@extends('layouts.app')

@section('page_title', 'Gestion des Enseignants')

@section('breadcrumb')
    <div class="flex items-center space-x-2 text-sm"
         x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-home mr-1"></i>
            Accueil
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <a href="#"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-cogs mr-1"></i>
            Administration
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">Enseignants</span>
    </div>
@endsection

@section('page_header')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-chalkboard-teacher mr-2 text-[#4CA3DD]"></i>
                    Gestion des Enseignants
                </h1>
                <p class="mt-1 text-sm"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Gérez tous les enseignants du système éducatif
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                @can('admin.teacher.create')
                    <a href="{{ route('admin.teachers.create', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2">
                        <i class="fas fa-user-plus mr-2"></i>
                        Ajouter un enseignant
                    </a>
                @endcan

                @can('admin.teacher.export')
                    <button type="button"
                            onclick="exportTeachers()"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                            :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                        <i class="fas fa-download mr-2"></i>
                        Exporter
                    </button>
                @endcan
            </div>
        </div>
    </div>
@endsection


<x-flash-message />

@section('content')
    <div x-data="{
    darkMode: localStorage.getItem('theme') === 'dark',
    viewMode: localStorage.getItem('teachers-view') || 'table',
    showFilters: true,
    selectedTeachers: [],
    selectAll: false
}"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
         class="space-y-6">

        <!-- Statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Enseignants -->
            <div class="rounded-xl shadow-sm border overflow-hidden"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chalkboard-teacher text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium"
                               :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                Total Enseignants
                            </p>
                            <p class="text-2xl font-bold"
                               :class="darkMode ? 'text-white' : 'text-gray-900'">
                                {{ $stats['total'] ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enseignants Actifs -->
            <div class="rounded-xl shadow-sm border overflow-hidden"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-check text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium"
                               :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                Enseignants Actifs
                            </p>
                            <p class="text-2xl font-bold"
                               :class="darkMode ? 'text-white' : 'text-gray-900'">
                                {{ $stats['active'] ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Académies -->
            <div class="rounded-xl shadow-sm border overflow-hidden"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium"
                               :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                Académies
                            </p>
                            <p class="text-2xl font-bold"
                               :class="darkMode ? 'text-white' : 'text-gray-900'">
                                {{ $stats['academies'] ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Départements -->
            <div class="rounded-xl shadow-sm border overflow-hidden"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-sm font-medium"
                               :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                Départements
                            </p>
                            <p class="text-2xl font-bold"
                               :class="darkMode ? 'text-white' : 'text-gray-900'">
                                {{ $stats['departments'] ?? 0 }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="rounded-xl shadow-sm border overflow-hidden"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">

            <!-- En-tête des filtres -->
            <div class="px-6 py-4 border-b flex items-center justify-between"
                 :class="darkMode ? 'border-gray-700 bg-gradient-to-r from-gray-700 to-gray-800' : 'border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100'">
                <h2 class="text-lg font-semibold flex items-center"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-filter mr-2 text-[#4CA3DD]"></i>
                    Filtres et Recherche
                </h2>
                <button type="button"
                        @click="showFilters = !showFilters"
                        class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-md transition-colors"
                        :class="darkMode ? 'bg-gray-600 hover:bg-gray-500 text-gray-200' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                    <i class="fas fa-chevron-down mr-1 transform transition-transform"
                       :class="{ 'rotate-180': showFilters }"></i>
                    <span x-text="showFilters ? 'Masquer' : 'Afficher'"></span>
                </button>
            </div>

            <!-- Formulaire de filtres -->
            <div x-show="showFilters"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 max-h-0"
                 x-transition:enter-end="opacity-100 max-h-96"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 max-h-96"
                 x-transition:leave-end="opacity-0 max-h-0"
                 class="p-6 overflow-hidden">

                <form action="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}"
                      method="GET"
                      class="space-y-6">

                    <!-- Recherche principale -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="lg:col-span-2">
                            <label class="block text-sm font-medium mb-2"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-search mr-1 text-[#4CA3DD]"></i>
                                Recherche générale
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Nom, email, téléphone, matricule..."
                                       class="w-full pl-10 pr-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                       :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filtres spécifiques -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Matricule -->
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-id-badge mr-1 text-[#4CA3DD]"></i>
                                Matricule
                            </label>
                            <input type="text"
                                   name="matricule_filter"
                                   value="{{ request('matricule_filter') }}"
                                   placeholder="Matricule précis..."
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                   :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'">
                        </div>

                        <!-- Statut -->
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-flag mr-1 text-[#4CA3DD]"></i>
                                Statut
                            </label>
                            <select name="status"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Tous les statuts</option>
                                @foreach(['active' => 'Actif', 'inactive' => 'Inactif', 'suspended' => 'Suspendu'] as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Genre -->
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-venus-mars mr-1 text-[#4CA3DD]"></i>
                                Genre
                            </label>
                            <select name="gender"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Tous les genres</option>
                                @foreach(['male' => 'Homme', 'female' => 'Femme'] as $value => $label)
                                    <option value="{{ $value }}" {{ request('gender') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Ville -->
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-city mr-1 text-[#4CA3DD]"></i>
                                Ville
                            </label>
                            <select name="city_id"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Toutes les villes</option>
                                @foreach($cities ?? [] as $city)
                                    @if (is_object($city) && isset($city->id, $city->name))
                                        <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Académie -->
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-graduation-cap mr-1 text-[#4CA3DD]"></i>
                                Académie
                            </label>
                            <select name="academy_id"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Toutes les académies</option>
                                @foreach($academies ?? [] as $academy)
                                    @if(is_object($academy) && isset($academy->id, $academy->name))
                                    <option value="{{ $academy->id }}" {{ request('academy_id') == $academy->id ? 'selected' : '' }}>
                                        {{ $academy->name }}
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Département -->
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-building mr-1 text-[#4CA3DD]"></i>
                                Département
                            </label>
                            <select name="department_id"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Tous les départements</option>
                                @foreach($departments ?? [] as $department)
                                    @if(is_object($department) && isset($departemment->id, $department->name))
                                    <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- Centre -->
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-school mr-1 text-[#4CA3DD]"></i>
                                Centre
                            </label>
                            <select name="center_id"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Tous les centres</option>
                                @foreach($centers ?? [] as $center)
                                    <option value="{{ $center->id }}" {{ request('center_id') == $center->id ? 'selected' : '' }}>
                                        {{ $center->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date d'embauche -->
                        <div>
                            <label class="block text-sm font-medium mb-2"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-calendar mr-1 text-[#4CA3DD]"></i>
                                Date d'embauche
                            </label>
                            <input type="date"
                                   name="hire_date"
                                   value="{{ request('hire_date') }}"
                                   class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                   :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                        </div>
                    </div>

                    <!-- Actions des filtres -->
                    <div class="flex flex-col sm:flex-row gap-3 justify-between items-center pt-4 border-t"
                         :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        <div class="text-sm"
                             :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            <i class="fas fa-info-circle mr-1 text-[#4CA3DD]"></i>
                            {{ $teacherUsers->total() ?? 0 }} enseignant(s) trouvé(s)
                        </div>

                        <div class="flex gap-3">
                            <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}"
                               class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200"
                               :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                                <i class="fas fa-times mr-2"></i>
                                Effacer
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2">
                                <i class="fas fa-search mr-2"></i>
                                Rechercher
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des enseignants -->
        <div class="rounded-xl shadow-sm border overflow-hidden"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">

            <!-- En-tête avec contrôles -->
            <div class="px-6 py-4 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
                 :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                <div class="flex items-center space-x-4">
                    <h2 class="text-lg font-semibold flex items-center"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fas fa-users mr-2 text-[#4CA3DD]"></i>
                        Liste des Enseignants
                        <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full"
                              :class="darkMode ? 'bg-gray-700 text-gray-300' : 'bg-gray-100 text-gray-600'">
                        {{ $teacherUsers->total() ?? 0 }}
                    </span>
                    </h2>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Sélection multiple (si permissions) -->
                    @can('admin.teacher.delete')
                        <div class="flex items-center space-x-2" x-show="selectedTeachers.length > 0">
                        <span class="text-sm"
                              :class="darkMode ? 'text-gray-400' : 'text-gray-600'"
                              x-text="selectedTeachers.length + ' sélectionné(s)'"></span>
                            <button type="button"
                                    onclick="deleteSelectedTeachers()"
                                    class="inline-flex items-center px-3 py-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition-colors">
                                <i class="fas fa-trash mr-1"></i>
                                Supprimer
                            </button>
                        </div>
                    @endcan

                    <!-- Commutateur de vue -->
                    <div class="flex bg-gray-100 rounded-lg p-1"
                         :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                        <button type="button"
                                @click="viewMode = 'table'; localStorage.setItem('teachers-view', 'table')"
                                class="px-3 py-1 text-sm font-medium rounded-md transition-colors"
                                :class="viewMode === 'table' ?
                                'bg-white text-gray-900 shadow-sm' :
                                (darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900')">
                            <i class="fas fa-table mr-1"></i>
                            Tableau
                        </button>
                        <button type="button"
                                @click="viewMode = 'grid'; localStorage.setItem('teachers-view', 'grid')"
                                class="px-3 py-1 text-sm font-medium rounded-md transition-colors"
                                :class="viewMode === 'grid' ?
                                'bg-white text-gray-900 shadow-sm' :
                                (darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-gray-900')">
                            <i class="fas fa-th mr-1"></i>
                            Grille
                        </button>
                    </div>
                </div>
            </div>

            <!-- Vue tableau -->
            <div x-show="viewMode === 'table'" class="overflow-x-auto">
                <table class="w-full">
                    <thead :class="darkMode ? 'bg-gray-750' : 'bg-gray-50'">
                    <tr>
                        @can('admin.teacher.delete')
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox"
                                       x-model="selectAll"
                                       @change="selectedTeachers = selectAll ? {{ json_encode($teacherUsers->pluck('id')->toArray()) }} : []"
                                       class="rounded border-gray-300 text-[#4CA3DD] focus:ring-[#4CA3DD]">
                            </th>
                        @endcan
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            <div class="flex items-center space-x-1">
                                <span>Enseignant</span>
                                <i class="fas fa-sort text-gray-400"></i>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Affectation
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Statut
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y"
                           :class="darkMode ? 'divide-gray-700' : 'divide-gray-200'">
                    @forelse($teacherUsers ?? [] as $teacher)
                        <tr :class="darkMode ? 'hover:bg-gray-300 transition-colors' : 'hover:bg-gray-100 transition-colors'">
                            @can('admin.teacher.delete')
                                <td class="px-6 py-4">
                                    <input type="checkbox"
                                           value="{{ $teacher->id }}"
                                           x-model="selectedTeachers"
                                           class="rounded border-gray-300 text-[#4CA3DD] focus:ring-[#4CA3DD]">
                                </td>
                            @endcan
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="relative flex-shrink-0">
                                        <img src="{{ $teacher->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($teacher->first_name . ' ' . $teacher->last_name) . '&color=4CA3DD&background=EBF8FF' }}"
                                             alt="{{ $teacher->first_name }} {{ $teacher->last_name }}"
                                             class="w-12 h-12 rounded-full object-cover border-2"
                                             :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full border-2 border-white"
                                             :class="{
                                                 'bg-green-500': '{{ $teacher->status }}' === 'active',
                                                 'bg-red-500': '{{ $teacher->status }}' === 'suspended',
                                                 'bg-yellow-500': '{{ $teacher->status }}' === 'pending_validation',
                                                 'bg-gray-500': '{{ $teacher->status }}' === 'inactive'
                                             }"></div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="focus:outline-none">
                                            <p class="text-sm font-medium"
                                               :class="darkMode ? 'text-white' : 'text-gray-900'">
                                                @can('admin.teacher.read')
                                                    <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}"
                                                       class="hover:text-[#4CA3DD] transition-colors">
                                                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                                                    </a>
                                                @else
                                                    {{ $teacher->first_name }} {{ $teacher->last_name }}
                                                @endcan
                                            </p>
                                            <div class="flex items-center space-x-3 mt-1">
                                                @if($teacher->teacher && $teacher->teacher->matricule)
                                                    <p class="text-xs flex items-center"
                                                       :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                        <i class="fas fa-id-badge mr-1 text-[#4CA3DD]"></i>
                                                        {{ $teacher->teacher->matricule }}
                                                    </p>
                                                @endif
                                                @if($teacher->teacher && $teacher->teacher->profession)
                                                    <p class="text-xs flex items-center"
                                                       :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                        <i class="fas fa-briefcase mr-1 text-[#4CA3DD]"></i>
                                                        {{ $teacher->teacher->profession }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <p class="text-sm flex items-center"
                                       :class="darkMode ? 'text-gray-300' : 'text-gray-900'">
                                        <i class="fas fa-envelope mr-2 text-[#4CA3DD] w-4"></i>
                                        <a href="mailto:{{ $teacher->email }}"
                                           class="hover:text-[#4CA3DD] transition-colors truncate">
                                            {{ $teacher->email }}
                                        </a>
                                    </p>
                                    @if($teacher->phone_number)
                                        <p class="text-sm flex items-center"
                                           :class="darkMode ? 'text-gray-300' : 'text-gray-900'">
                                            <i class="fas fa-phone mr-2 text-[#4CA3DD] w-4"></i>
                                            <a href="tel:{{ $teacher->phone_number }}"
                                               class="hover:text-[#4CA3DD] transition-colors">
                                                {{ $teacher->phone_number }}
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    @if($teacher->teacher)
                                        @if($teacher->teacher->academy)
                                            <p class="text-sm flex items-center"
                                               :class="darkMode ? 'text-gray-300' : 'text-gray-900'">
                                                <i class="fas fa-graduation-cap mr-2 text-[#4CA3DD] w-4"></i>
                                                {{ $teacher->teacher->academy->name }}
                                            </p>
                                        @endif
                                        @if($teacher->teacher->department)
                                            <p class="text-sm flex items-center"
                                               :class="darkMode ? 'text-gray-300' : 'text-gray-900'">
                                                <i class="fas fa-building mr-2 text-[#4CA3DD] w-4"></i>
                                                {{ $teacher->teacher->department->name }}
                                            </p>
                                        @endif
                                        @if($teacher->teacher->center)
                                            <p class="text-sm flex items-center"
                                               :class="darkMode ? 'text-gray-300' : 'text-gray-900'">
                                                <i class="fas fa-school mr-2 text-[#4CA3DD] w-4"></i>
                                                {{ $teacher->teacher->center->name }}
                                            </p>
                                        @endif
                                    @else
                                        <span class="text-sm italic"
                                              :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                            Profil incomplet
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusConfig = [
                                        'active' => [
                                            'class' => (isset($darkMode) && $darkMode)
                                                ? 'bg-green-900 text-green-200'
                                                : 'bg-green-100 text-green-800',
                                            'label' => 'Actif'
                                        ],
                                        'inactive' => [
                                            'class' => (isset($darkMode) && $darkMode)
                                                ? 'bg-gray-900 text-gray-200'
                                                : 'bg-gray-100 text-gray-800',
                                            'label' => 'Inactif'
                                        ],
                                        'suspended' => [
                                            'class' => (isset($darkMode) && $darkMode)
                                                ? 'bg-red-900 text-red-200'
                                                : 'bg-red-100 text-red-800',
                                            'label' => 'Suspendu'
                                        ],
                                        'pending_validation' => [
                                            'class' => (isset($darkMode) && $darkMode)
                                                ? 'bg-yellow-900 text-yellow-200'
                                                : 'bg-yellow-100 text-yellow-800',
                                            'label' => 'En attente'
                                        ],
                                    ];
                                    $status = $statusConfig[$teacher->status] ?? $statusConfig['inactive'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status['class'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button type="button"
                                            @click="open = !open"
                                            @click.away="open = false"
                                            class="inline-flex items-center p-2 text-sm font-medium rounded-md transition-colors"
                                            :class="darkMode ? 'text-gray-400 hover:text-white hover:bg-gray-700' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100'">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>

                                    <div x-show="open"
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-75"
                                         x-transition:leave-start="transform opacity-100 scale-100"
                                         x-transition:leave-end="transform opacity-0 scale-95"
                                         class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                         :class="darkMode ? 'bg-gray-800 ring-gray-700' : 'bg-white'">
                                        <div class="py-1">
                                            @can('admin.teacher.read')
                                                <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}"
                                                   class="flex items-center px-4 py-2 text-sm transition-colors"
                                                   :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'">
                                                    <i class="fas fa-eye text-[#4CA3DD] mr-2 w-4"></i>
                                                    Voir le profil
                                                </a>
                                            @endcan

                                            @can('admin.teacher.update')
                                                <a href="{{ route('admin.teachers.edit', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}"
                                                   class="flex items-center px-4 py-2 text-sm transition-colors"
                                                   :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'">
                                                    <i class="fas fa-edit mr-2 w-4"></i>
                                                    Modifier
                                                </a>
                                            @endcan

                                            @can('admin.teacher.delete')
                                                @if(Auth::id() !== $teacher->id)
                                                    <button type="button"
                                                            onclick="deleteTeacher({{ $teacher->id }}, '{{ $teacher->first_name }} {{ $teacher->last_name }}')"
                                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900 dark:hover:text-red-200 transition-colors">
                                                        <i class="fas fa-trash mr-2 w-4"></i>
                                                        Supprimer
                                                    </button>
                                                @endif
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4"
                                         :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                                        <i class="fas fa-chalkboard-teacher text-2xl"
                                           :class="darkMode ? 'text-gray-400' : 'text-gray-400'"></i>
                                    </div>
                                    <h3 class="text-lg font-medium mb-2"
                                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        Aucun enseignant trouvé
                                    </h3>
                                    <p class="text-sm mb-4"
                                       :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        Aucun enseignant ne correspond à vos critères de recherche.
                                    </p>
                                    <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}"
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                                       :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                                        <i class="fas fa-sync-alt mr-2"></i>
                                        Réinitialiser les filtres
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Vue grille -->
            <div x-show="viewMode === 'grid'" class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($teacherUsers ?? [] as $teacher)
                        <div class="rounded-lg border overflow-hidden transition-all duration-200 hover:shadow-lg hover:-translate-y-1"
                             :class="darkMode ? 'bg-gray-750 border-gray-600' : 'bg-white border-gray-200'">

                            <!-- En-tête de la carte -->
                            <div class="p-4 border-b"
                                 :class="darkMode ? 'border-gray-600 bg-gradient-to-r from-gray-700 to-gray-800' : 'border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100'">
                                <div class="flex items-center justify-between">
                                    <div class="relative">
                                        <img src="{{ $teacher->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($teacher->first_name . ' ' . $teacher->last_name) . '&color=4CA3DD&background=EBF8FF' }}"
                                             alt="{{ $teacher->first_name }} {{ $teacher->last_name }}"
                                             class="w-16 h-16 rounded-full object-cover border-2"
                                             :class="darkMode ? 'border-gray-500' : 'border-white'">
                                        <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full border-2 border-white"
                                             :class="{
                                             'bg-green-500': '{{ $teacher->status }}' === 'active',
                                             'bg-red-500': '{{ $teacher->status }}' === 'suspended',
                                             'bg-yellow-500': '{{ $teacher->status }}' === 'pending_validation',
                                             'bg-gray-500': '{{ $teacher->status }}' === 'inactive'
                                         }"></div>
                                    </div>

                                    <!-- Actions de la carte -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button type="button"
                                                @click="open = !open"
                                                @click.away="open = false"
                                                class="p-2 rounded-md transition-colors"
                                                :class="darkMode ? 'text-gray-400 hover:text-white hover:bg-gray-600' : 'text-gray-500 hover:text-gray-700 hover:bg-white'">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>

                                        <div x-show="open"
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="transform opacity-0 scale-95"
                                             x-transition:enter-end="transform opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="transform opacity-100 scale-100"
                                             x-transition:leave-end="transform opacity-0 scale-95"
                                             class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                             :class="darkMode ? 'bg-gray-800 ring-gray-700' : 'bg-white'">
                                            <div class="py-1">
                                                @can('admin.teacher.read')
                                                    <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}"
                                                       class="flex items-center text-[#4CA3DD] px-4 py-2 text-sm transition-colors"
                                                       :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'">
                                                        <i class="fas fa-eye text-[#4CA3DD] mr-2 w-4"></i>
                                                        Voir
                                                    </a>
                                                @endcan

                                                @can('admin.teacher.update')
                                                    <a href="{{ route('admin.teachers.edit', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}"
                                                       class="flex items-center px-4 py-2 text-sm transition-colors"
                                                       :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'">
                                                        <i class="fas fa-edit mr-2 w-4"></i>
                                                        Modifier
                                                    </a>
                                                @endcan

                                                @can('admin.teacher.delete')
                                                    @if(Auth::id() !== $teacher->id)
                                                        <button type="button"
                                                                onclick="deleteTeacher({{ $teacher->id }}, '{{ $teacher->first_name }} {{ $teacher->last_name }}')"
                                                                class="flex items-center w-full px-4 py-2 text-sm text-red-600 transition-colors"
                                                                :class="darkMode ? 'text-red-500 hover:bg-red-50' : 'text-red-600 hover:bg-red-900'">
                                                            <i class="fas fa-trash mr-2 w-4"></i>
                                                            Supprimer
                                                        </button>
                                                    @endif
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Corps de la carte -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2"
                                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    @can('admin.teacher.read')
                                        <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacher->id]) }}"
                                           class="hover:text-[#4CA3DD] transition-colors">
                                            {{ $teacher->first_name }} {{ $teacher->last_name }}
                                        </a>
                                    @else
                                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                                    @endcan
                                </h3>

                                <!-- Informations métier -->
                                <div class="space-y-2 mb-4">
                                    @if($teacher->teacher && $teacher->teacher->matricule)
                                        <p class="text-sm flex items-center"
                                           :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                            <i class="fas fa-id-badge mr-2 text-[#4CA3DD] w-4"></i>
                                            {{ $teacher->teacher->matricule }}
                                        </p>
                                    @endif
                                    @if($teacher->teacher && $teacher->teacher->profession)
                                        <p class="text-sm flex items-center"
                                           :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                            <i class="fas fa-briefcase mr-2 text-[#4CA3DD] w-4"></i>
                                            {{ $teacher->teacher->profession }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Contact -->
                                <div class="space-y-1 mb-4">
                                    <p class="text-sm flex items-center"
                                       :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        <i class="fas fa-envelope mr-2 text-[#4CA3DD] w-4"></i>
                                        <span class="truncate">{{ $teacher->email }}</span>
                                    </p>
                                    @if($teacher->phone_number)
                                        <p class="text-sm flex items-center"
                                           :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                            <i class="fas fa-phone mr-2 text-[#4CA3DD] w-4"></i>
                                            {{ $teacher->phone_number }}
                                        </p>
                                    @endif
                                </div>

                                <!-- Affectation -->
                                @if($teacher->teacher)
                                    <div class="space-y-1 mb-4">
                                        @if($teacher->teacher->academy)
                                            <p class="text-sm flex items-center"
                                               :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                                <i class="fas fa-graduation-cap mr-2 text-[#4CA3DD] w-4"></i>
                                                <span class="truncate">{{ $teacher->teacher->academy->name }}</span>
                                            </p>
                                        @endif
                                        @if($teacher->teacher->center)
                                            <p class="text-sm flex items-center"
                                               :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                                <i class="fas fa-school mr-2 text-[#4CA3DD] w-4"></i>
                                                <span class="truncate">{{ $teacher->teacher->center->name }}</span>
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Pied de la carte -->
                            <div class="px-4 py-3 border-t flex items-center justify-between"
                                 :class="darkMode ? 'border-gray-600 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                                @php
                                    $statusConfig = [
                                        'active' => [
                                            'class' => (isset($darkMode) && $darkMode)
                                                ? 'bg-green-900 text-green-200'
                                                : 'bg-green-100 text-green-800',
                                            'label' => 'Actif'
                                        ],
                                        'inactive' => [
                                            'class' => (isset($darkMode) && $darkMode)
                                                ? 'bg-gray-900 text-gray-200'
                                                : 'bg-gray-100 text-gray-800',
                                            'label' => 'Inactif'
                                        ],
                                        'suspended' => [
                                            'class' => (isset($darkMode) && $darkMode)
                                                ? 'bg-red-900 text-red-200'
                                                : 'bg-red-100 text-red-800',
                                            'label' => 'Suspendu'
                                        ],
                                        'pending_validation' => [
                                            'class' => (isset($darkMode) && $darkMode)
                                                ? 'bg-yellow-900 text-yellow-200'
                                                : 'bg-yellow-100 text-yellow-800',
                                            'label' => 'En attente'
                                        ],
                                    ];
                                    $status = $statusConfig[$teacher->status] ?? $statusConfig['inactive'];
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $status['class'] }}">
                                {{ $status['label'] }}
                            </span>

                                <span class="text-xs flex items-center"
                                      :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $teacher->created_at->format('d/m/Y') }}
                            </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center py-12">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4"
                                 :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                                <i class="fas fa-chalkboard-teacher text-2xl"
                                   :class="darkMode ? 'text-gray-400' : 'text-gray-400'"></i>
                            </div>
                            <h3 class="text-lg font-medium mb-2"
                                :class="darkMode ? 'text-white' : 'text-gray-900'">
                                Aucun enseignant trouvé
                            </h3>
                            <p class="text-sm mb-4 text-center"
                               :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Aucun enseignant ne correspond à vos critères de recherche.
                            </p>
                            <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}"
                               class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                               :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Réinitialiser les filtres
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($teacherUsers && $teacherUsers->hasPages())
                <div class="px-6 py-4 border-t"
                     :class="darkMode ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                    {{ $teachers->links('vendor.pagination.tailwind') }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script>
            /**
             * Fonction pour supprimer un enseignant
             */
            function deleteTeacher(teacherId, teacherName) {
                if (confirm(`Êtes-vous sûr de vouloir supprimer l'enseignant "${teacherName}" ? Cette action est irréversible.`)) {
                    // Créer un formulaire pour la suppression
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}/${teacherId}`;

                    // Ajouter le token CSRF
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '{{ csrf_token() }}';
                    form.appendChild(csrfToken);

                    // Ajouter la méthode DELETE
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'DELETE';
                    form.appendChild(methodField);

                    // Ajouter au DOM et soumettre
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            /**
             * Fonction pour exporter les enseignants
             */
            function exportTeachers() {
                const currentUrl = new URL(window.location);
                currentUrl.pathname = currentUrl.pathname.replace('/teachers', '/teachers/export');
                window.open(currentUrl.toString(), '_blank');
            }

            /**
             * Initialisation au chargement du DOM
             */
            document.addEventListener('DOMContentLoaded', function() {
                // Gestion du tri des colonnes
                const sortableHeaders = document.querySelectorAll('th .fas.fa-sort');

                sortableHeaders.forEach(header => {
                    const th = header.closest('th');
                    if (th) {
                        th.style.cursor = 'pointer';
                        th.addEventListener('click', function() {
                            const currentUrl = new URL(window.location);
                            const sortField = this.textContent.trim().toLowerCase().replace(' ', '_');
                            const currentSort = currentUrl.searchParams.get('sort');
                            const currentDirection = currentUrl.searchParams.get('direction') || 'asc';

                            let newDirection = 'asc';
                            if (currentSort === sortField && currentDirection === 'asc') {
                                newDirection = 'desc';
                            }

                            currentUrl.searchParams.set('sort', sortField);
                            currentUrl.searchParams.set('direction', newDirection);

                            window.location = currentUrl.toString();
                        });
                    }
                });

                // Gestion des raccourcis clavier
                document.addEventListener('keydown', function(e) {
                    // Ctrl+A pour sélectionner tout (si permissions de suppression)
                    if (e.ctrlKey && e.key === 'a' && document.querySelector('input[type="checkbox"][x-model="selectAll"]')) {
                        e.preventDefault();
                        const selectAllCheckbox = document.querySelector('input[type="checkbox"][x-model="selectAll"]');
                        if (selectAllCheckbox) {
                            selectAllCheckbox.click();
                        }
                    }

                    // Échap pour fermer les menus ouverts
                    if (e.key === 'Escape') {
                        document.querySelectorAll('[x-data] [x-show="open"]').forEach(menu => {
                            Alpine.$data(menu.closest('[x-data]')).open = false;
                        });
                    }
                });

                // Animation des statistiques au chargement
                const statNumbers = document.querySelectorAll('.text-2xl.font-bold');
                statNumbers.forEach(stat => {
                    const finalValue = parseInt(stat.textContent);
                    if (!isNaN(finalValue)) {
                        let currentValue = 0;
                        const increment = Math.ceil(finalValue / 30);
                        const timer = setInterval(() => {
                            currentValue += increment;
                            if (currentValue >= finalValue) {
                                currentValue = finalValue;
                                clearInterval(timer);
                            }
                            stat.textContent = currentValue;
                        }, 50);
                    }
                });

                // Sauvegarde automatique des filtres dans localStorage
                const filterForm = document.querySelector('form[method="GET"]');
                if (filterForm) {
                    const inputs = filterForm.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        input.addEventListener('change', function() {
                            const formData = new FormData(filterForm);
                            const filters = Object.fromEntries(formData.entries());
                            localStorage.setItem('teachers-filters', JSON.stringify(filters));
                        });
                    });

                    // Restauration des filtres depuis localStorage (optionnel)
                    const savedFilters = localStorage.getItem('teachers-filters');
                    if (savedFilters && !window.location.search) {
                        try {
                            const filters = JSON.parse(savedFilters);
                            Object.keys(filters).forEach(key => {
                                const input = filterForm.querySelector(`[name="${key}"]`);
                                if (input && filters[key]) {
                                    input.value = filters[key];
                                }
                            });
                        } catch (e) {
                            console.log('Erreur lors de la restauration des filtres:', e);
                        }
                    }
                }

                // Mise à jour automatique du compteur de sélection
                document.addEventListener('change', function(e) {
                    if (e.target.type === 'checkbox' && e.target.hasAttribute('x-model')) {
                        // Le compteur est géré par Alpine.js automatiquement
                    }
                });

                // Amélioration de l'UX avec des tooltips (optionnel)
                const actionButtons = document.querySelectorAll('[title]');
                actionButtons.forEach(button => {
                    button.addEventListener('mouseenter', function() {
                        // Vous pouvez ajouter une librairie de tooltips ici si nécessaire
                    });
                });
            });

            /**
             * Fonction utilitaire pour afficher des notifications
             */
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white text-sm font-medium transform transition-all duration-300 translate-x-full max-w-sm`;

                const colors = {
                    success: 'bg-green-600',
                    error: 'bg-red-600',
                    warning: 'bg-yellow-600',
                    info: 'bg-blue-600'
                };

                notification.className += ` ${colors[type] || colors.info}`;

                const icons = {
                    success: 'fas fa-check-circle',
                    error: 'fas fa-exclamation-circle',
                    warning: 'fas fa-exclamation-triangle',
                    info: 'fas fa-info-circle'
                };

                notification.innerHTML = `
            <div class="flex items-center">
                <i class="${icons[type] || icons.info} mr-2"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;

                document.body.appendChild(notification);

                // Animation d'entrée
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Auto-suppression après 5 secondes
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentElement) {
                            notification.remove();
                        }
                    }, 300);
                }, 5000);
            }

            /**
             * Fonction pour actualiser la liste sans recharger la page (optionnel)
             */
            function refreshTeachersList() {
                // Cette fonction peut être utilisée pour implémenter un rafraîchissement AJAX
                window.location.reload();
            }

            // Gestion des erreurs globales
            window.addEventListener('error', function(e) {
                console.error('Erreur JavaScript:', e.error);
                showNotification('Une erreur inattendue s\'est produite.', 'error');
            });

            // Amélioration de la recherche en temps réel (optionnel)
            let searchTimeout;
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        // Ici vous pourriez implémenter une recherche AJAX en temps réel
                        // Pour l'instant, on se contente de sauvegarder la valeur
                        const currentFilters = JSON.parse(localStorage.getItem('teachers-filters') || '{}');
                        currentFilters.search = this.value;
                        localStorage.setItem('teachers-filters', JSON.stringify(currentFilters));
                    }, 500);
                });
            }

            // Optimisation des performances pour les grandes listes
            if (document.querySelectorAll('tbody tr').length > 100) {
                // Implémentation d'une virtualisation simple (optionnel)
                console.log('Liste importante détectée - optimisations activées');
            }
        </script>
    @endpush

    @push('styles')
        <style>
            /* Améliorations spécifiques pour la vue des enseignants */

            /* Animation pour les cartes en vue grille */
            .grid [class*="rounded-lg"] {
                transition: all 0.2s ease-in-out;
            }

            .grid [class*="rounded-lg"]:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            }

            /* Amélioration des avatars */
            .relative img {
                transition: transform 0.2s ease-in-out;
            }

            .relative:hover img {
                transform: scale(1.05);
            }

            /* Animation des indicateurs de statut */
            .absolute.w-4.h-4,
            .absolute.w-5.h-5 {
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.7; }
            }

            /* Amélioration des liens email et téléphone */
            a[href^="mailto:"],
            a[href^="tel:"] {
                transition: all 0.2s ease-in-out;
            }

            a[href^="mailto:"]:hover,
            a[href^="tel:"]:hover {
                transform: translateX(2px);
            }

            /* Style pour les en-têtes triables */
            th.sortable {
                user-select: none;
                position: relative;
            }

            th.sortable:hover {
                background-color: rgba(79, 70, 229, 0.05);
            }

            /* Amélioration des transitions pour les menus déroulants */
            [x-transition] {
                transition-property: opacity, transform;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Style pour la sélection multiple */
            input[type="checkbox"]:checked {
                background-color: #4CA3DD;
                border-color: #4CA3DD;
            }

            /* Amélioration des badges de statut */
            .inline-flex.items-center.px-2\.5.py-0\.5,
            .inline-flex.items-center.px-2.py-1 {
                font-weight: 600;
                letter-spacing: 0.025em;
            }

            /* Animation de chargement pour les statistiques */
            .text-2xl.font-bold {
                font-variant-numeric: tabular-nums;
            }

            /* Responsive amélioré */
            @media (max-width: 640px) {
                .px-6.py-4 {
                    padding: 1rem;
                }

                .space-x-4 > :not([hidden]) ~ :not([hidden]) {
                    margin-left: 0.5rem;
                }
            }

            /* Dark mode amélioré */
            .dark .bg-gray-750 {
                background-color: #374151;
            }

            .dark .border-gray-600 {
                border-color: #4B5563;
            }

            /* Amélioration des focus states */
            input:focus,
            select:focus,
            button:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(76, 163, 221, 0.1);
            }

            /* Animation pour les notifications */
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }

            /* Amélioration de l'accessibilité */
            @media (prefers-reduced-motion: reduce) {
                *,
                *::before,
                *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }
            }

            /* Print styles */
            @media print {
                .inline-flex.items-center.px-4.py-2,
                .relative.inline-block,
                .flex.bg-gray-100,
                .px-6.py-4.border-t {
                    display: none !important;
                }

                .space-y-6 {
                    space-y: 0;
                }

                .rounded-xl {
                    border-radius: 0;
                    box-shadow: none;
                    border: 1px solid #000;
                }
            }
        </style>
    @endpush
@endsection
