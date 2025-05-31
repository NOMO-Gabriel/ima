@extends('layouts.app')

@section('page_title', 'Départements')

@section('breadcrumb')
    <div class="breadcrumb-item">
        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">Tableau de bord</a>
    </div>
    <div class="breadcrumb-item">
        <a href="#">Gestion</a>
    </div>
    <div class="breadcrumb-item active">Départements</div>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark',
    showFilters: false,
    selectedItems: [],
    selectAll: false,
    searchQuery: '',
    statusFilter: '',
    academyFilter: '',
    toggleSelectAll() {
        this.selectAll = !this.selectAll;
        const checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(cb => cb.checked = this.selectAll);
        this.updateSelectedItems();
    },
    updateSelectedItems() {
        this.selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);
    },
    deleteSelected() {
        if (this.selectedItems.length === 0) {
            alert('Veuillez sélectionner au moins un élément à supprimer.');
            return;
        }
        if (confirm(`Êtes-vous sûr de vouloir supprimer ${this.selectedItems.length} département(s) ?`)) {
            // Logique de suppression en lot
            console.log('Suppression des éléments:', this.selectedItems);
        }
    }
}">

        <!-- En-tête de la page -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Gestion des départements
                    </h1>
                    <p class="mt-2 text-lg transition-colors"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        Gérez les départements de votre organisation
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    @can('gestion.department.create')
                        <a href="{{ route('admin.departments.create', ['locale' => app()->getLocale()]) }}"
                           class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#4CA3DD] hover:bg-[#3A8BC8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] transition-all duration-200">
                            <i class="fas fa-plus mr-2"></i>
                            Nouveau département
                        </a>
                    @endcan

                    <button @click="showFilters = !showFilters"
                            class="inline-flex items-center justify-center px-4 py-3 border rounded-lg text-sm font-medium transition-all duration-200"
                            :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700' : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50'">
                        <i class="fas fa-filter mr-2"></i>
                        Filtres
                    </button>
                </div>
            </div>
        </div>

        @canany([ 'gestion.department.read', 'gestion.department.update', 'gestion.department.delete', 'gestion.department.create' ])
            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="rounded-xl shadow-sm p-6 transition-colors border"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium transition-colors"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                Total départements
                            </p>
                            <p class="text-2xl font-bold transition-colors"
                               :class="darkMode ? 'text-white' : 'text-gray-900'">
                                {{ $departments->total() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl shadow-sm p-6 transition-colors border"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium transition-colors"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                Départements actifs
                            </p>
                            <p class="text-2xl font-bold text-green-600">
                                {{ $departments->where('is_active', true)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl shadow-sm p-6 transition-colors border"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-pause-circle text-orange-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium transition-colors"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                Départements inactifs
                            </p>
                            <p class="text-2xl font-bold text-orange-600">
                                {{ $departments->where('is_active', false)->count() }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-xl shadow-sm p-6 transition-colors border"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-tie text-purple-600 text-xl"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium transition-colors"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                Avec responsable
                            </p>
                            <p class="text-2xl font-bold text-purple-600">
                                {{ $departments->whereNotNull('head_id')->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panneau de filtres -->
            <div x-show="showFilters"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform scale-95"
                 x-transition:enter-end="opacity-100 transform scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform scale-100"
                 x-transition:leave-end="opacity-0 transform scale-95"
                 class="mb-6">
                <div class="rounded-xl shadow-sm p-6 transition-colors border"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <h3 class="text-lg font-semibold mb-4 transition-colors"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Filtres de recherche
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="search" class="block text-sm font-medium mb-2 transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Rechercher
                            </label>
                            <input type="text"
                                   id="search"
                                   x-model="searchQuery"
                                   placeholder="Nom ou code du département..."
                                   class="w-full px-4 py-2 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                   :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900'">
                        </div>
                        <div>
                            <label for="status_filter" class="block text-sm font-medium mb-2 transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Statut
                            </label>
                            <select id="status_filter"
                                    x-model="statusFilter"
                                    class="w-full px-4 py-2 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Tous les statuts</option>
                                <option value="1">Actifs</option>
                                <option value="0">Inactifs</option>
                            </select>
                        </div>
                        <div>
                            <label for="academy_filter" class="block text-sm font-medium mb-2 transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Académie
                            </label>
                            <select id="academy_filter"
                                    x-model="academyFilter"
                                    class="w-full px-4 py-2 rounded-lg border transition-all duration-200 focus:ring-2 focus:ring-[#4CA3DD] focus:border-transparent"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Toutes les académies</option>
                                @foreach($departments->pluck('academy')->filter()->unique('id') as $academy)
                                    <option value="{{ $academy->id }}">{{ $academy->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section principale -->
            <div class="rounded-xl shadow-sm transition-colors border"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">

                <!-- En-tête du tableau -->
                <div class="px-6 py-4 border-b transition-colors"
                     :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center">
                            <h3 class="text-lg font-semibold transition-colors"
                                :class="darkMode ? 'text-white' : 'text-gray-900'">
                                Liste des départements
                            </h3>
                            <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#4CA3DD] text-white">
                            {{ $departments->total() }} {{ $departments->total() > 1 ? 'départements' : 'département' }}
                        </span>
                        </div>

                        <div class="flex items-center space-x-3" x-show="selectedItems.length > 0">
                        <span class="text-sm transition-colors"
                              :class="darkMode ? 'text-gray-300' : 'text-gray-600'"
                              x-text="`${selectedItems.length} sélectionné(s)`"></span>
                            @can('gestion.department.delete')
                                <button @click="deleteSelected()"
                                        class="inline-flex items-center px-3 py-2 border border-transparent rounded-md text-xs font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                    <i class="fas fa-trash mr-1"></i>
                                    Supprimer
                                </button>
                            @endcan
                        </div>
                    </div>
                </div>

                @if($departments->count())
                    <!-- Tableau responsive -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y transition-colors"
                               :class="darkMode ? 'divide-gray-700' : 'divide-gray-200'">
                            <thead :class="darkMode ? 'bg-gray-700' : 'bg-gray-50'">
                            <tr>
                                <th scope="col" class="relative w-12 px-6 sm:w-16 sm:px-8">
                                    <input type="checkbox"
                                           @change="toggleSelectAll()"
                                           class="absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-[#4CA3DD] focus:ring-[#4CA3DD]">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                    :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                    Département
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                    :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                    Code
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                    :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                    :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                    Académie
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                    :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                    Responsable
                                </th>
                                @canany(['gestion.department.update', 'gestion.department.delete', 'gestion.department.read'])
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider transition-colors"
                                    :class="darkMode ? 'text-gray-300' : 'text-gray-500'">
                                    Actions
                                </th>
                                @endcanany
                            </tr>
                            </thead>
                            <tbody class="divide-y transition-colors"
                                   :class="darkMode ? 'bg-gray-800 divide-gray-700' : 'bg-white divide-gray-200'">
                            @foreach($departments as $department)
                                <tr class="hover:bg-opacity-50 transition-colors"
                                    :class="darkMode ? 'hover:bg-gray-700' : 'hover:bg-gray-50'">
                                    <td class="relative w-12 px-6 sm:w-16 sm:px-8">
                                        <input type="checkbox"
                                               class="item-checkbox absolute left-4 top-1/2 -mt-2 h-4 w-4 rounded border-gray-300 text-[#4CA3DD] focus:ring-[#4CA3DD]"
                                               value="{{ $department->id }}"
                                               @change="updateSelectedItems()">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-lg flex items-center justify-center"
                                                     :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                                                    <i class="fas fa-building text-[#4CA3DD]"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium transition-colors"
                                                     :class="darkMode ? 'text-white' : 'text-gray-900'">
                                                    @can('department.view')
                                                        <a href="{{ route('admin.departments.show', ['locale' => app()->getLocale(), 'department' => $department]) }}"
                                                           class="hover:text-[#4CA3DD] transition-colors">
                                                            {{ $department->name }}
                                                        </a>
                                                    @else
                                                        {{ $department->name }}
                                                    @endcan
                                                </div>
                                                @if($department->description)
                                                    <div class="text-sm transition-colors"
                                                         :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                        {{ Str::limit($department->description, 50) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($department->code)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors"
                                                  :class="darkMode ? 'bg-gray-700 text-gray-300' : 'bg-gray-100 text-gray-800'">
                                            {{ $department->code }}
                                        </span>
                                        @else
                                            <span class="text-sm transition-colors"
                                                  :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                            -
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($department->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Actif
                                        </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Inactif
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($department->academy)
                                            <div class="text-sm transition-colors"
                                                 :class="darkMode ? 'text-white' : 'text-gray-900'">
                                                {{ $department->academy->name }}
                                            </div>
                                            @if($department->academy->code)
                                                <div class="text-sm transition-colors"
                                                     :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                    {{ $department->academy->code }}
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-sm transition-colors"
                                                  :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                            Aucune académie
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($department->head)
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8">
                                                    <img class="h-8 w-8 rounded-full object-cover"
                                                         src="{{ $department->head->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($department->head->first_name . ' ' . $department->head->last_name) . '&background=4CA3DD&color=fff' }}"
                                                         alt="{{ $department->head->first_name }} {{ $department->head->last_name }}">
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium transition-colors"
                                                         :class="darkMode ? 'text-white' : 'text-gray-900'">
                                                        {{ $department->head->first_name }} {{ $department->head->last_name }}
                                                    </div>
                                                    @if($department->head->email)
                                                        <div class="text-sm transition-colors"
                                                             :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                            {{ $department->head->email }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-sm transition-colors"
                                                  :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                            Aucun responsable
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            @can('gestion.department.update')
                                                <a href="{{ route('admin.departments.edit', ['locale' => app()->getLocale(), 'department' => $department]) }}"
                                                   class="inline-flex items-center p-2 border border-transparent rounded-md text-sm leading-4 font-medium text-orange-600 hover:text-orange-900 hover:bg-orange-100 transition-all duration-200"
                                                   title="Modifier">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('gestion.department.delete')
                                                <form action="{{ route('admin.departments.destroy', ['locale' => app()->getLocale(), 'department' => $department]) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce département ? Cette action est irréversible.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center p-2 border border-transparent rounded-md text-sm leading-4 font-medium text-red-600 hover:text-red-900 hover:bg-red-100 transition-all duration-200"
                                                            title="Supprimer">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t transition-colors"
                         :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        {{ $departments->links() }}
                    </div>
                @else
                    <!-- État vide -->
                    <div class="text-center py-12">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full flex items-center justify-center transition-colors"
                             :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                            <i class="fas fa-building text-4xl transition-colors"
                               :class="darkMode ? 'text-gray-500' : 'text-gray-400'"></i>
                        </div>
                        <h3 class="text-lg font-medium mb-2 transition-colors"
                            :class="darkMode ? 'text-white' : 'text-gray-900'">
                            Aucun département trouvé
                        </h3>
                        <p class="text-sm mb-6 transition-colors"
                           :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Il n'y a actuellement aucun département dans le système.
                        </p>
                        @can('department.create')
                            <a href="{{ route('admin.departments.create', ['locale' => app()->getLocale()]) }}"
                               class="inline-flex items-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-[#4CA3DD] hover:bg-[#3A8BC8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] transition-all duration-200">
                                <i class="fas fa-plus mr-2"></i>
                                Créer le premier département
                            </a>
                        @endcan
                    </div>
                @endif
            </div>
        @else
            <!-- Message d'accès refusé -->
            <div class="p-8 text-center rounded-lg border transition-colors"
                 :class="darkMode ? 'bg-[#2C3E50] border-[#475569] text-white' : 'bg-white border-gray-200'">
                <div class="flex flex-col items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-16 w-16 mb-4 transition-colors"
                         :class="darkMode ? 'text-red-500' : 'text-red-400'"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <p class="text-xl font-medium mb-2 transition-colors"
                       :class="darkMode ? 'text-white' : 'text-gray-800'">
                        Accès refusé
                    </p>
                    <p class="mb-6 transition-colors"
                       :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                        Vous n'avez pas les permissions nécessaires pour accéder à la gestion des phases.
                    </p>
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour au tableau de bord
                    </a>
                </div>
            </div>
        @endcanany
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@push('styles')
    <style>
        /* Animations et transitions personnalisées */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Amélioration du hover sur les lignes du tableau */
        tbody tr:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Style pour les checkboxes */
        input[type="checkbox"]:checked {
            background-color: #4CA3DD;
            border-color: #4CA3DD;
        }

        /* Responsive amélioré pour les boutons d'action */
        @media (max-width: 640px) {
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation d'entrée pour les cartes statistiques
            const statCards = document.querySelectorAll('.grid > div');
            statCards.forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('fade-in');
                }, index * 100);
            });

            // Gestion de la recherche en temps réel
            const searchInput = document.getElementById('search');
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        // Ici vous pouvez implémenter la recherche AJAX
                        console.log('Recherche:', this.value);
                    }, 300);
                });
            }

            // Gestion des filtres
            const filters = ['status_filter', 'academy_filter'];
            filters.forEach(filterId => {
                const filterElement = document.getElementById(filterId);
                if (filterElement) {
                    filterElement.addEventListener('change', function() {
                        // Ici vous pouvez implémenter le filtrage AJAX
                        console.log('Filtre changé:', filterId, this.value);
                    });
                }
            });

            // Confirmation de suppression améliorée
            const deleteButtons = document.querySelectorAll('form[onsubmit*="confirm"]');
            deleteButtons.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Créer une modal de confirmation personnalisée
                    const departmentName = this.closest('tr').querySelector('td:nth-child(2) .text-sm.font-medium').textContent.trim();

                    if (confirm(`⚠️ Attention!\n\nVous êtes sur le point de supprimer le département "${departmentName}".\n\nCette action est irréversible et supprimera également :\n• Tous les enseignants associés\n• Toutes les données liées\n\nÊtes-vous absolument certain de vouloir continuer ?`)) {
                        this.submit();
                    }
                });
            });

            // Gestion du clic sur les lignes du tableau (navigation)
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('click', function(e) {
                    // Éviter la navigation si on clique sur un bouton, lien ou checkbox
                    if (e.target.closest('button, a, input[type="checkbox"]')) {
                        return;
                    }

                    const viewLink = this.querySelector('a[href*="show"]');
                    if (viewLink) {
                        window.location.href = viewLink.href;
                    }
                });

                // Ajouter un style cursor pointer pour indiquer la navigation
                row.style.cursor = 'pointer';
            });

            // Tooltip pour les actions
            const actionButtons = document.querySelectorAll('[title]');
            actionButtons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    // Ici vous pouvez ajouter une logique de tooltip personnalisée si nécessaire
                });
            });

            // Gestion du redimensionnement de la fenêtre pour le responsive
            window.addEventListener('resize', function() {
                // Ajuster l'affichage du tableau sur mobile
                const table = document.querySelector('table');
                if (table && window.innerWidth < 768) {
                    table.classList.add('text-xs');
                } else if (table) {
                    table.classList.remove('text-xs');
                }
            });

            // Auto-refresh des données (optionnel)
            const autoRefreshCheckbox = document.getElementById('auto-refresh');
            if (autoRefreshCheckbox) {
                let refreshInterval;

                autoRefreshCheckbox.addEventListener('change', function() {
                    if (this.checked) {
                        refreshInterval = setInterval(() => {
                            console.log('Auto-refresh des données...');
                            // Ici vous pouvez implémenter le rafraîchissement AJAX
                        }, 30000); // 30 secondes
                    } else {
                        clearInterval(refreshInterval);
                    }
                });
            }

            // Sauvegarde des préférences de filtres dans localStorage
            const saveFiltersToStorage = () => {
                const filters = {
                    search: document.getElementById('search')?.value || '',
                    status: document.getElementById('status_filter')?.value || '',
                    academy: document.getElementById('academy_filter')?.value || ''
                };
                localStorage.setItem('departmentFilters', JSON.stringify(filters));
            };

            const loadFiltersFromStorage = () => {
                const savedFilters = localStorage.getItem('departmentFilters');
                if (savedFilters) {
                    const filters = JSON.parse(savedFilters);
                    if (document.getElementById('search')) document.getElementById('search').value = filters.search;
                    if (document.getElementById('status_filter')) document.getElementById('status_filter').value = filters.status;
                    if (document.getElementById('academy_filter')) document.getElementById('academy_filter').value = filters.academy;
                }
            };

            // Charger les filtres sauvegardés
            loadFiltersFromStorage();

            // Sauvegarder les filtres à chaque changement
            ['search', 'status_filter', 'academy_filter'].forEach(id => {
                const element = document.getElementById(id);
                if (element) {
                    element.addEventListener('input', saveFiltersToStorage);
                    element.addEventListener('change', saveFiltersToStorage);
                }
            });

            // Notification de succès avec auto-hide
            const successAlerts = document.querySelectorAll('.alert-success');
            successAlerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'all 0.5s ease-out';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            });

            // Performance: Lazy loading des avatars
            const avatarImages = document.querySelectorAll('img[src*="ui-avatars.com"]');
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src || img.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                avatarImages.forEach(img => imageObserver.observe(img));
            }
        });

        // Fonction globale pour les actions en lot
        window.performBulkAction = function(action) {
            const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked')).map(cb => cb.value);

            if (selectedItems.length === 0) {
                alert('Veuillez sélectionner au moins un élément.');
                return;
            }

            let confirmMessage = '';
            switch (action) {
                case 'delete':
                    confirmMessage = `Êtes-vous sûr de vouloir supprimer ${selectedItems.length} département(s) ?`;
                    break;
                case 'activate':
                    confirmMessage = `Êtes-vous sûr de vouloir activer ${selectedItems.length} département(s) ?`;
                    break;
                case 'deactivate':
                    confirmMessage = `Êtes-vous sûr de vouloir désactiver ${selectedItems.length} département(s) ?`;
                    break;
                default:
                    confirmMessage = `Êtes-vous sûr de vouloir effectuer cette action sur ${selectedItems.length} département(s) ?`;
            }

            if (confirm(confirmMessage)) {
                // Logique de suppression en lot
                console.log('Suppression des éléments:', selectedItems);
            }
        };
    </script>
@endpush
