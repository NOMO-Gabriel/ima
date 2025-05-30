@extends('layouts.app')

@section('page_title', 'Gestion des Commandes')

@section('breadcrumb')
    <div class="flex items-center space-x-2 text-sm"
         x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-home mr-1"></i>
            Tableau de Board
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <a href="#"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-archive mr-1"></i>
            Ressources
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">Commandes</span>
    </div>
@endsection

@section('page_header')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-box-open mr-2 text-[#4CA3DD]"></i>
                    Gestion des Commandes
                </h1>
                <p class="mt-1 text-sm"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Gérez toutes les commandes de matériel du système
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                @can('ressource.material.create')
                    <a href="{{ route('admin.commands.create', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvelle commande
                    </a>
                @endcan

                @can('ressource.material.export')
                    <div class="relative" x-data="{ showExportMenu: false }">
                        <button @click="showExportMenu = !showExportMenu"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                            <i class="fas fa-download mr-2"></i>
                            Exporter
                            <i class="fas fa-chevron-down ml-2"></i>
                        </button>

                        <div x-show="showExportMenu"
                             @click.away="showExportMenu = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 rounded-md shadow-lg z-10"
                             :class="darkMode ? 'bg-gray-800 border border-gray-700' : 'bg-white border border-gray-200'"
                             style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('admin.commands.export', array_merge(['locale' => app()->getLocale()], request()->query())) }}"
                                   class="flex items-center px-4 py-2 text-sm transition-colors"
                                   :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700 hover:bg-gray-100'">
                                    <i class="fas fa-file-csv mr-2 text-green-600"></i>
                                    Export CSV
                                </a>
                                <button onclick="window.print()"
                                        class="w-full flex items-center px-4 py-2 text-sm transition-colors"
                                        :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700 hover:bg-gray-100'">
                                    <i class="fas fa-print mr-2 text-blue-600"></i>
                                    Imprimer
                                </button>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div x-data="{
    darkMode: localStorage.getItem('theme') === 'dark',
    showFilters: true,
    selectedCommand: null,
    showDeleteModal: false,
    showStatusModal: false,
    viewMode: localStorage.getItem('commands-view') || 'table',
    currentStatus: 'pending',
    newStatus: 'pending'
}"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
         class="space-y-6">

        <!-- Statistiques rapides -->
        @if(isset($stats))
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total des commandes -->
                <div class="rounded-xl shadow-sm border overflow-hidden"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-box-open text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                    Total commandes
                                </p>
                                <p class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    {{ $stats['total_commands'] ?? $commands->total() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quantité totale -->
                <div class="rounded-xl shadow-sm border overflow-hidden"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-boxes text-green-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                    Quantité totale
                                </p>
                                <p class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    {{ number_format($stats['total_quantity'] ?? $commands->sum('quantity')) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Commandes ce mois -->
                <div class="rounded-xl shadow-sm border overflow-hidden"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-purple-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                    Ce mois
                                </p>
                                <p class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    {{ $stats['commands_this_month'] ?? $commands->where('created_at', '>=', now()->startOfMonth())->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Commandes en attente -->
                <div class="rounded-xl shadow-sm border overflow-hidden"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-clock text-orange-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                    En attente
                                </p>
                                <p class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    {{ $stats['pending_commands'] ?? $commands->where('status', 'pending')->count() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filtres et actions -->
        <div class="rounded-xl shadow-sm border"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">

            <!-- En-tête des filtres -->
            <div class="px-6 py-4 border-b flex items-center justify-between"
                 :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                <h3 class="text-lg font-semibold flex items-center"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-filter mr-2 text-[#4CA3DD]"></i>
                    Filtres et recherche
                </h3>
                <button @click="showFilters = !showFilters"
                        class="p-2 rounded-lg transition-colors"
                        :class="darkMode ? 'hover:bg-gray-700 text-gray-400' : 'hover:bg-gray-100 text-gray-600'">
                    <i class="fas" :class="showFilters ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                </button>
            </div>

            <!-- Contenu des filtres -->
            <div x-show="showFilters"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="p-6">

                <form method="GET" action="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        <!-- Recherche -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-search mr-1 text-[#4CA3DD]"></i>
                                Recherche
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="ID, utilisateur..."
                                       class="w-full pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                       :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Période -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-calendar mr-1 text-[#4CA3DD]"></i>
                                Période
                            </label>
                            <select name="period"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Toutes les périodes</option>
                                <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Aujourd'hui</option>
                                <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Cette semaine</option>
                                <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Ce mois</option>
                                <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Cette année</option>
                            </select>
                        </div>

                        <!-- Tri -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-sort mr-1 text-[#4CA3DD]"></i>
                                Trier par
                            </label>
                            <select name="sort"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="created_at" {{ request('sort', 'created_at') === 'created_at' ? 'selected' : '' }}>Date de création</option>
                                <option value="updated_at" {{ request('sort') === 'updated_at' ? 'selected' : '' }}>Dernière modification</option>
                                <option value="quantity" {{ request('sort') === 'quantity' ? 'selected' : '' }}>Quantité</option>
                                <option value="user_id" {{ request('sort') === 'user_id' ? 'selected' : '' }}>Utilisateur</option>
                            </select>
                        </div>

                        <!-- Direction du tri -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <i class="fas fa-sort-amount-down mr-1 text-[#4CA3DD]"></i>
                                Ordre
                            </label>
                            <select name="direction"
                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="desc" {{ request('direction', 'desc') === 'desc' ? 'selected' : '' }}>Décroissant</option>
                                <option value="asc" {{ request('direction') === 'asc' ? 'selected' : '' }}>Croissant</option>
                            </select>
                        </div>

                        <!-- Actions -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium opacity-0">Actions</label>
                            <div class="flex gap-2">
                                <button type="submit"
                                        class="flex-1 px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors">
                                    <i class="fas fa-search mr-1"></i>
                                    Filtrer
                                </button>
                                <a href="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}"
                                   class="px-3 py-2 text-sm font-medium rounded-lg transition-colors"
                                   :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-300 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des commandes -->
        <div class="rounded-xl shadow-sm border overflow-hidden"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">

            <!-- En-tête -->
            <div class="px-6 py-4 border-b flex items-center justify-between"
                 :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                <h2 class="text-lg font-semibold flex items-center"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-list mr-2 text-[#4CA3DD]"></i>
                    Liste des commandes
                    <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full"
                          :class="darkMode ? 'bg-gray-700 text-gray-300' : 'bg-gray-100 text-gray-600'">
                    {{ $commands->total() }} commande(s)
                </span>
                </h2>

                <div class="flex items-center space-x-3">
                    <!-- Sélecteur de vue -->
                    <div class="flex rounded-lg overflow-hidden border"
                         :class="darkMode ? 'border-gray-600' : 'border-gray-300'">
                        <button @click="viewMode = 'table'; localStorage.setItem('commands-view', 'table')"
                                class="px-3 py-2 text-sm font-medium transition-colors"
                                :class="viewMode === 'table' ?
                                'bg-[#4CA3DD] text-white' :
                                (darkMode ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-50')">
                            <i class="fas fa-table"></i>
                        </button>
                        <button @click="viewMode = 'grid'; localStorage.setItem('commands-view', 'grid')"
                                class="px-3 py-2 text-sm font-medium transition-colors"
                                :class="viewMode === 'grid' ?
                                'bg-[#4CA3DD] text-white' :
                                (darkMode ? 'bg-gray-700 text-gray-300 hover:bg-gray-600' : 'bg-white text-gray-700 hover:bg-gray-50')">
                            <i class="fas fa-th-large"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Vue tableau -->
            <div x-show="viewMode === 'table'" class="overflow-x-auto">
                <table class="w-full">
                    <thead :class="darkMode ? 'bg-gray-700' : 'bg-gray-50'">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-hashtag text-[#4CA3DD]"></i>
                                <span>ID</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-calendar text-[#4CA3DD]"></i>
                                <span>Date</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-boxes text-[#4CA3DD]"></i>
                                <span>Quantité</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-user text-[#4CA3DD]"></i>
                                <span>Utilisateur</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-info-circle text-[#4CA3DD]"></i>
                                <span>Statut</span>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                            :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                            <div class="flex items-center space-x-1">
                                <i class="fas fa-cog text-[#4CA3DD]"></i>
                                <span>Actions</span>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y" :class="darkMode ? 'divide-gray-700' : 'divide-gray-200'">
                    @forelse($commands as $command)
                        <tr class="hover:bg-opacity-50 transition-colors"
                            :class="darkMode ? 'hover:bg-gray-700' : 'hover:bg-gray-50'">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-[#4CA3DD] bg-opacity-10 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-bold text-[#4CA3DD]">#</span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                            {{ $command->id }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-900'">
                                    {{ $command->created_at->format('d/m/Y') }}
                                </div>
                                <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    {{ $command->created_at->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-boxes text-green-600 text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                            {{ number_format($command->quantity) }}
                                        </div>
                                        <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            {{ $command->commandUnits->count() }} matériel(s)
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-purple-600 text-sm"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                            {{ $command->user->first_name ?? 'N/A' }} {{ $command->user->last_name ?? '' }}
                                        </div>
                                        <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            {{ $command->user->email ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $status = $command->status ?? 'pending';
                                    $statusConfig = [
                                        'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock', 'text' => 'En attente'],
                                        'processing' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-cog', 'text' => 'En cours'],
                                        'completed' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle', 'text' => 'Terminée'],
                                        'cancelled' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'fa-times-circle', 'text' => 'Annulée']
                                    ];
                                    $currentStatusConfig = $statusConfig[$status] ?? $statusConfig['pending'];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $currentStatusConfig['class'] }}">
                                    <i class="fas {{ $currentStatusConfig['icon'] }} mr-1"></i>
                                    {{ $currentStatusConfig['text'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    @can('ressource.material.read.')
                                        <a href="{{ route('admin.commands.show', ['locale' => app()->getLocale(), 'command' => $command->id]) }}"
                                           class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-eye mr-1"></i>
                                            Voir
                                        </a>
                                    @endcan

                                    @can('ressource.material.update')
                                        <a href="{{ route('admin.commands.edit', ['locale' => app()->getLocale(), 'command' => $command->id]) }}"
                                           class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-amber-100 text-amber-800 hover:bg-amber-200 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>
                                            Modifier
                                        </a>
                                    @endcan

                                    <!-- Menu déroulant d'actions -->
                                    @canany(['ressource.material.duplicate', 'ressource.material.update', 'ressource.material.delete'])
                                        <div class="relative" x-data="{ showDropdown: false }">
                                            <button @click="showDropdown = !showDropdown"
                                                    class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>

                                            <div x-show="showDropdown"
                                                 @click.away="showDropdown = false"
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 scale-95"
                                                 x-transition:enter-end="opacity-100 scale-100"
                                                 x-transition:leave="transition ease-in duration-75"
                                                 x-transition:leave-start="opacity-100 scale-100"
                                                 x-transition:leave-end="opacity-0 scale-95"
                                                 class="absolute right-0 mt-2 w-48 rounded-md shadow-lg z-10"
                                                 :class="darkMode ? 'bg-gray-800 border border-gray-700' : 'bg-white border border-gray-200'"
                                                 style="display: none;">
                                                <div class="py-1">
                                                    @can('ressource.material.duplicate')
                                                        <a href="{{ route('admin.commands.duplicate', ['locale' => app()->getLocale(), 'command' => $command->id]) }}"
                                                           class="flex items-center px-4 py-2 text-sm transition-colors"
                                                           :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700 hover:bg-gray-100'">
                                                            <i class="fas fa-copy mr-2 text-blue-600"></i>
                                                            Dupliquer
                                                        </a>
                                                    @endcan

                                                    @can('ressource.material.update')
                                                        @if($command->status !== 'completed' && $command->status !== 'cancelled')
                                                            <button @click="selectedCommand = {{ $command->id }}; currentStatus = '{{ $status }}'; showStatusModal = true; showDropdown = false"
                                                                    class="w-full flex items-center px-4 py-2 text-sm transition-colors"
                                                                    :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700 hover:bg-gray-100'">
                                                                <i class="fas fa-edit mr-2 text-green-600"></i>
                                                                Changer statut
                                                            </button>
                                                        @endif
                                                    @endcan

                                                    @can('ressource.material.delete')
                                                        @if($command->status === 'pending' || $command->status === 'cancelled')
                                                            <div class="border-t my-1" :class="darkMode ? 'border-gray-600' : 'border-gray-200'"></div>
                                                            <button @click="selectedCommand = {{ $command->id }}; showDeleteModal = true; showDropdown = false"
                                                                    class="w-full flex items-center px-4 py-2 text-sm transition-colors"
                                                                    :class="darkMode ? 'text-red-300 hover:bg-gray-700' : 'text-red-700 hover:bg-gray-100'">
                                                                <i class="fas fa-trash mr-2 text-red-600"></i>
                                                                Supprimer
                                                            </button>
                                                        @endif
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    @endcanany
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium mb-2" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        Aucune commande trouvée
                                    </h3>
                                    <p class="text-sm mb-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        @if(request()->hasAny(['search', 'period', 'sort']))
                                            Aucune commande ne correspond aux critères de recherche.
                                        @else
                                            Commencez par créer votre première commande.
                                        @endif
                                    </p>
                                    <div class="flex gap-3">
                                        @if(request()->hasAny(['search', 'period', 'sort']))
                                            <a href="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}"
                                               class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                                               :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-300 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                                                <i class="fas fa-redo mr-2"></i>
                                                Réinitialiser les filtres
                                            </a>
                                        @endif
                                        @can('ressource.material.create')
                                            <a href="{{ route('admin.commands.create', ['locale' => app()->getLocale()]) }}"
                                               class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors">
                                                <i class="fas fa-plus mr-2"></i>
                                                Créer une commande
                                            </a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Vue grille -->
            <div x-show="viewMode === 'grid'" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($commands as $command)
                        @php
                            $status = $command->status ?? 'pending';
                            $statusConfig = [
                                'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'icon' => 'fa-clock', 'text' => 'En attente'],
                                'processing' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'fa-cog', 'text' => 'En cours'],
                                'completed' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'fa-check-circle', 'text' => 'Terminée'],
                                'cancelled' => ['class' => 'bg-red-100 text-red-800', 'icon' => 'fa-times-circle', 'text' => 'Annulée']
                            ];
                            $currentStatusConfig = $statusConfig[$status] ?? $statusConfig['pending'];
                        @endphp
                        <div class="rounded-lg border overflow-hidden hover:shadow-lg transition-shadow"
                             :class="darkMode ? 'bg-gray-750 border-gray-600' : 'bg-white border-gray-200'">

                            <!-- En-tête de carte -->
                            <div class="px-4 py-3 border-b flex items-center justify-between"
                                 :class="darkMode ? 'border-gray-600 bg-gray-700' : 'border-gray-200 bg-gray-50'">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-[#4CA3DD] bg-opacity-10 rounded-lg flex items-center justify-center">
                                        <span class="text-sm font-bold text-[#4CA3DD]">#{{ $command->id }}</span>
                                    </div>
                                    <span class="ml-2 text-sm font-medium" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    Commande {{ $command->id }}
                                </span>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $currentStatusConfig['class'] }}">
                                <i class="fas {{ $currentStatusConfig['icon'] }} mr-1"></i>
                                {{ $currentStatusConfig['text'] }}
                            </span>
                            </div>

                            <!-- Contenu de carte -->
                            <div class="p-4 space-y-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                                            Date de création
                                        </p>
                                        <p class="text-lg font-semibold" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                            {{ $command->created_at->format('d/m/Y') }}
                                        </p>
                                        <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            {{ $command->created_at->format('H:i') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                                            Quantité totale
                                        </p>
                                        <p class="text-2xl font-bold text-[#4CA3DD]">
                                            {{ number_format($command->quantity) }}
                                        </p>
                                        <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            {{ $command->commandUnits->count() }} matériel(s)
                                        </p>
                                    </div>
                                </div>

                                <div class="pt-3 border-t" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-purple-600 text-sm"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                                {{ $command->user->first_name ?? 'N/A' }} {{ $command->user->last_name ?? '' }}
                                            </p>
                                            <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                {{ $command->user->email ?? '-' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @if($command->notes ?? false)
                                    <div class="pt-3 border-t" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                                        <p class="text-sm font-medium mb-1" :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                                            Notes
                                        </p>
                                        <p class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                            {{ Str::limit($command->notes, 100) }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions de carte -->
                            <div class="px-4 py-3 border-t flex justify-between items-center"
                                 :class="darkMode ? 'border-gray-600 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                                <div class="flex space-x-2">
                                    @can('ressource.material.read.')
                                        <a href="{{ route('admin.commands.show', ['locale' => app()->getLocale(), 'command' => $command->id]) }}"
                                           class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-eye mr-1"></i>
                                            Voir
                                        </a>
                                    @endcan

                                    @can('ressource.material.update')
                                        <a href="{{ route('admin.commands.edit', ['locale' => app()->getLocale(), 'command' => $command->id]) }}"
                                           class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-amber-100 text-amber-800 hover:bg-amber-200 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>
                                            Modifier
                                        </a>
                                    @endcan
                                </div>

                                <!-- Menu d'actions pour carte -->
                                @canany(['ressource.material.duplicate', 'ressource.material.update', 'ressource.material.delete'])
                                    <div class="relative" x-data="{ showDropdown: false }">
                                        <button @click="showDropdown = !showDropdown"
                                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800 hover:bg-gray-200 transition-colors">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>

                                        <div x-show="showDropdown"
                                             @click.away="showDropdown = false"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-95"
                                             class="absolute right-0 bottom-full mb-2 w-48 rounded-md shadow-lg z-10"
                                             :class="darkMode ? 'bg-gray-800 border border-gray-700' : 'bg-white border border-gray-200'"
                                             style="display: none;">
                                            <div class="py-1">
                                                @can('ressource.material.duplicate')
                                                    <a href="{{ route('admin.commands.duplicate', ['locale' => app()->getLocale(), 'command' => $command->id]) }}"
                                                       class="flex items-center px-4 py-2 text-sm transition-colors"
                                                       :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700 hover:bg-gray-100'">
                                                        <i class="fas fa-copy mr-2 text-blue-600"></i>
                                                        Dupliquer
                                                    </a>
                                                @endcan

                                                @can('ressource.material.update')
                                                    @if($command->status !== 'completed' && $command->status !== 'cancelled')
                                                        <button @click="selectedCommand = {{ $command->id }}; currentStatus = '{{ $status }}'; showStatusModal = true; showDropdown = false"
                                                                class="w-full flex items-center px-4 py-2 text-sm transition-colors"
                                                                :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-700 hover:bg-gray-100'">
                                                            <i class="fas fa-edit mr-2 text-green-600"></i>
                                                            Changer statut
                                                        </button>
                                                    @endif
                                                @endcan

                                                @can('ressource.material.delete')
                                                    @if($command->status === 'pending' || $command->status === 'cancelled')
                                                        <div class="border-t my-1" :class="darkMode ? 'border-gray-600' : 'border-gray-200'"></div>
                                                        <button @click="selectedCommand = {{ $command->id }}; showDeleteModal = true; showDropdown = false"
                                                                class="w-full flex items-center px-4 py-2 text-sm transition-colors"
                                                                :class="darkMode ? 'text-red-300 hover:bg-gray-700' : 'text-red-700 hover:bg-gray-100'">
                                                            <i class="fas fa-trash mr-2 text-red-600"></i>
                                                            Supprimer
                                                        </button>
                                                    @endif
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                @endcanany
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="flex flex-col items-center py-12">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium mb-2" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    Aucune commande trouvée
                                </h3>
                                <p class="text-sm mb-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    @if(request()->hasAny(['search', 'period', 'sort']))
                                        Aucune commande ne correspond aux critères de recherche.
                                    @else
                                        Commencez par créer votre première commande.
                                    @endif
                                </p>
                                <div class="flex gap-3">
                                    @if(request()->hasAny(['search', 'period', 'sort']))
                                        <a href="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}"
                                           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                                           :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-300 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                                            <i class="fas fa-redo mr-2"></i>
                                            Réinitialiser les filtres
                                        </a>
                                    @endif
                                    @can('ressource.material.create')
                                        <a href="{{ route('admin.commands.create', ['locale' => app()->getLocale()]) }}"
                                           class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors">
                                            <i class="fas fa-plus mr-2"></i>
                                            Créer une commande
                                        </a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($commands->hasPages())
                <div class="px-6 py-4 border-t" :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                    {{ $commands->links() }}
                </div>
            @endif
        </div>

        <!-- Modal de confirmation de suppression -->
        @can('ressource.material.delete')
            <div x-show="showDeleteModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 overflow-y-auto"
                 style="display: none;">

                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showDeleteModal = false"></div>

                    <div class="inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                         :class="darkMode ? 'bg-gray-800' : 'bg-white'">

                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium"
                                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        Confirmer la suppression
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm"
                                           :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                            Êtes-vous sûr de vouloir supprimer la commande <strong x-text="'#' + selectedCommand"></strong> ? Cette action est irréversible.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3"
                             :class="darkMode ? 'bg-gray-750' : 'bg-gray-50'">
                            <form x-bind:action="`{{ route('admin.commands.destroy', ['locale' => app()->getLocale(), 'command' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', selectedCommand)"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200">
                                    <i class="fas fa-trash mr-2"></i>
                                    Supprimer
                                </button>
                            </form>
                            <button type="button"
                                    @click="showDeleteModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors duration-200"
                                    :class="darkMode ? 'border-gray-600 bg-gray-700 text-gray-200 hover:bg-gray-600' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        <!-- Modal de changement de statut -->
        @can('ressource.material.update')
            <div x-show="showStatusModal"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 overflow-y-auto"
                 style="display: none;">

                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showStatusModal = false"></div>

                    <div class="inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                         :class="darkMode ? 'bg-gray-800' : 'bg-white'">

                        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <i class="fas fa-edit text-blue-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium"
                                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        Changer le statut de la commande
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm mb-4"
                                           :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                            Modifiez le statut de la commande <strong x-text="'#' + selectedCommand"></strong>.
                                        </p>

                                        <form x-bind:action="`{{ route('admin.commands.update', ['locale' => app()->getLocale(), 'command' => 'PLACEHOLDER']) }}`.replace('PLACEHOLDER', selectedCommand)"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium mb-2"
                                                           :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                                        Nouveau statut
                                                    </label>
                                                    <select name="status"
                                                            x-model="newStatus"
                                                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                                            :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                                        <option value="pending">En attente</option>
                                                        <option value="processing">En cours</option>
                                                        <option value="completed">Terminée</option>
                                                        <option value="cancelled">Annulée</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <label class="block text-sm font-medium mb-2"
                                                           :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                                        Notes (optionnel)
                                                    </label>
                                                    <textarea name="notes"
                                                              rows="3"
                                                              placeholder="Ajoutez une note sur ce changement de statut..."
                                                              class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                                              :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'"></textarea>
                                                </div>
                                            </div>

                                            <div class="mt-6 flex flex-col sm:flex-row gap-3">
                                                <button type="submit"
                                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#4CA3DD] text-base font-medium text-white hover:bg-[#3d8bc0] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] sm:w-auto sm:text-sm transition-colors duration-200">
                                                    <i class="fas fa-save mr-2"></i>
                                                    Mettre à jour
                                                </button>
                                                <button type="button"
                                                        @click="showStatusModal = false"
                                                        class="w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:w-auto sm:text-sm transition-colors duration-200"
                                                        :class="darkMode ? 'border-gray-600 bg-gray-700 text-gray-200 hover:bg-gray-600' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'">
                                                    Annuler
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Gestion des modales avec Alpine.js intégré

                // Auto-refresh des données toutes les 30 secondes (optionnel)
                setInterval(function() {
                    if (document.hidden) return; // Ne pas actualiser si l'onglet n'est pas visible

                    // Vérifier s'il y a de nouvelles commandes
                    fetch(window.location.href + '?ajax=1', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.has_new_commands) {
                                // Afficher une notification ou un badge indiquant de nouvelles commandes
                                const notification = document.createElement('div');
                                notification.className = 'fixed top-20 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                                notification.innerHTML = '<i class="fas fa-info-circle mr-2"></i>Nouvelles commandes disponibles. <a href="javascript:void(0)" onclick="location.reload()" class="underline ml-2">Actualiser</a>';
                                document.body.appendChild(notification);

                                // Supprimer la notification après 10 secondes
                                setTimeout(() => {
                                    notification.remove();
                                }, 10000);
                            }
                        })
                        .catch(error => {
                            console.log('Erreur lors de la vérification des nouvelles commandes:', error);
                        });
                }, 30000);

                // Gestion du raccourci clavier pour créer une nouvelle commande
                document.addEventListener('keydown', function(e) {
                    // Ctrl/Cmd + N pour nouvelle commande
                    if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
                        e.preventDefault();
                        const createButton = document.querySelector('a[href*="commands.create"]');
                        if (createButton) {
                            createButton.click();
                        }
                    }

                    // Échapper pour fermer les modales
                    if (e.key === 'Escape') {
                        // Les modales Alpine.js se fermeront automatiquement
                    }
                });

                // Amélioration de l'UX pour les tableaux sur mobile
                const table = document.querySelector('table');
                if (table && window.innerWidth < 768) {
                    // Ajouter un scroll horizontal avec indicateur
                    table.parentElement.style.position = 'relative';

                    const scrollIndicator = document.createElement('div');
                    scrollIndicator.className = 'absolute top-0 right-0 h-full w-4 bg-gradient-to-l from-white to-transparent pointer-events-none opacity-0 transition-opacity';
                    table.parentElement.appendChild(scrollIndicator);

                    table.parentElement.addEventListener('scroll', function() {
                        const isScrollable = this.scrollWidth > this.clientWidth;
                        const isAtEnd = this.scrollLeft >= (this.scrollWidth - this.clientWidth - 10);

                        if (isScrollable && !isAtEnd) {
                            scrollIndicator.style.opacity = '1';
                        } else {
                            scrollIndicator.style.opacity = '0';
                        }
                    });

                    // Déclencher l'événement scroll initial
                    table.parentElement.dispatchEvent(new Event('scroll'));
                }

                // Animation d'entrée pour les cartes en mode grille
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '0';
                            entry.target.style.transform = 'translateY(20px)';
                            entry.target.style.transition = 'opacity 0.6s ease, transform 0.6s ease';

                            setTimeout(() => {
                                entry.target.style.opacity = '1';
                                entry.target.style.transform = 'translateY(0)';
                            }, entry.target.dataset.index * 100);

                            observer.unobserve(entry.target);
                        }
                    });
                }, observerOptions);

                // Observer toutes les cartes
                document.querySelectorAll('[class*="grid"] > div[class*="rounded-lg"]').forEach((card, index) => {
                    card.dataset.index = index;
                    observer.observe(card);
                });
            });

            // Fonction utilitaire pour copier l'ID d'une commande dans le presse-papiers
            function copyCommandId(commandId) {
                navigator.clipboard.writeText(commandId).then(() => {
                    // Afficher une notification de succès
                    const notification = document.createElement('div');
                    notification.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                    notification.innerHTML = '<i class="fas fa-check mr-2"></i>ID copié dans le presse-papiers';
                    document.body.appendChild(notification);

                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                }).catch(err => {
                    console.error('Erreur lors de la copie:', err);
                });
            }

            // Fonction pour exporter les données visibles en CSV
            function exportVisibleData() {
                const rows = [];
                const headers = ['ID', 'Date', 'Quantité', 'Utilisateur', 'Statut'];
                rows.push(headers);

                document.querySelectorAll('tbody tr').forEach(row => {
                    const cells = row.querySelectorAll('td');
                    if (cells.length > 0) {
                        const rowData = [
                            cells[0].textContent.trim().replace('#', ''),
                            cells[1].textContent.trim().replace(/\s+/g, ' '),
                            cells[2].textContent.trim().replace(/\s+/g, ' '),
                            cells[3].textContent.trim().replace(/\s+/g, ' '),
                            cells[4].textContent.trim()
                        ];
                        rows.push(rowData);
                    }
                });

                const csvContent = rows.map(row =>
                    row.map(cell => `"${cell.replace(/"/g, '""')}"`).join(',')
                ).join('\n');

                const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement('a');
                const url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', `commandes_${new Date().toISOString().split('T')[0]}.csv`);
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        </script>

        <style>
            @media print {
                /* Styles pour l'impression */
                .no-print {
                    display: none !important;
                }

                body {
                    font-size: 12px;
                    line-height: 1.4;
                }

                .rounded-xl,
                .rounded-lg {
                    border-radius: 0 !important;
                }

                .shadow-sm,
                .shadow-lg {
                    box-shadow: none !important;
                }

                .bg-gray-50,
                .bg-gray-100 {
                    background-color: #f9f9f9 !important;
                }

                table {
                    page-break-inside: auto;
                }

                tr {
                    page-break-inside: avoid;
                    page-break-after: auto;
                }

                thead {
                    display: table-header-group;
                }

                .print-break {
                    page-break-before: always;
                }
            }

            /* Animations personnalisées */
            @keyframes slideInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-slide-in-up {
                animation: slideInUp 0.6s ease-out;
            }

            /* Style pour les notifications toast */
            .toast-notification {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                max-width: 400px;
                padding: 16px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                transform: translateX(100%);
                transition: transform 0.3s ease-in-out;
            }

            .toast-notification.show {
                transform: translateX(0);
            }

            .toast-notification.success {
                background-color: #10b981;
                color: white;
            }

            .toast-notification.error {
                background-color: #ef4444;
                color: white;
            }

            .toast-notification.info {
                background-color: #3b82f6;
                color: white;
            }

            /* Amélioration du scroll horizontal sur mobile */
            .table-container {
                position: relative;
            }

            .table-container::after {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 20px;
                height: 100%;
                background: linear-gradient(to left, rgba(255,255,255,1), rgba(255,255,255,0));
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .table-container.scrollable::after {
                opacity: 1;
            }

            /* Style pour les badges de statut dynamiques */
            .status-badge {
                transition: all 0.2s ease;
            }

            .status-badge:hover {
                transform: scale(1.05);
            }

            /* Amélioration des dropdowns */
            .dropdown-menu {
                backdrop-filter: blur(8px);
                background-color: rgba(255, 255, 255, 0.95);
            }

            .dark .dropdown-menu {
                background-color: rgba(31, 41, 55, 0.95);
            }

            /* Loading state pour les boutons */
            .btn-loading {
                position: relative;
                pointer-events: none;
            }

            .btn-loading::after {
                content: '';
                position: absolute;
                width: 16px;
                height: 16px;
                margin: auto;
                border: 2px solid transparent;
                border-top-color: currentColor;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    @endpush
@endsection
