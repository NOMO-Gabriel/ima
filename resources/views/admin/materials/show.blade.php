@extends('layouts.app')

@section('page_title', 'Détail du matériel')

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
        <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-tools mr-1"></i>
            Matériels
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $material->name }}</span>
    </div>
@endsection

@section('page_header')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-tools mr-2 text-[#4CA3DD]"></i>
                    {{ $material->name }}
                </h1>
                <p class="mt-1 text-sm"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Informations détaillées du matériel
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                @can('ressource.material.update')
                    <a href="{{ route('admin.materials.edit', ['locale' => app()->getLocale(), 'material' => $material->id]) }}"
                       class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier
                    </a>
                @endcan
                <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                   :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour
                </a>
            </div>
        </div>
    </div>
@endsection

@can('ressource.material.read')
@section('content')
    <div x-data="{
    darkMode: localStorage.getItem('theme') === 'dark',
    showDeleteModal: false
}"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
         class="space-y-6">

        <!-- Carte principale avec les informations -->
        <div class="rounded-xl shadow-sm border overflow-hidden"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">

            <!-- En-tête de la carte -->
            <div class="px-6 py-4 border-b"
                 :class="darkMode ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold"
                        :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fas fa-info-circle mr-2 text-[#4CA3DD]"></i>
                        Informations générales
                    </h2>
                    <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-full"
                          :class="$material->quantity > 0 ?
                              (darkMode ? 'bg-green-900 text-green-200' : 'bg-green-100 text-green-800') :
                              (darkMode ? 'bg-red-900 text-red-200' : 'bg-red-100 text-red-800')">
                        <i class="fas fa-circle mr-1 text-xs"></i>
                        {{ $material->quantity > 0 ? 'En stock' : 'Rupture de stock' }}
                    </span>
                    </div>
                </div>
            </div>

            <!-- Contenu de la carte -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Nom du matériel -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            <i class="fas fa-tag mr-1 text-[#4CA3DD]"></i>
                            Nom du matériel
                        </label>
                        <div class="p-3 rounded-lg border"
                             :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-gray-50 border-gray-200 text-gray-900'">
                            {{ $material->name }}
                        </div>
                    </div>

                    <!-- Unité de mesure -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            <i class="fas fa-ruler mr-1 text-[#4CA3DD]"></i>
                            Unité de mesure
                        </label>
                        <div class="p-3 rounded-lg border"
                             :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-gray-50 border-gray-200 text-gray-900'">
                            {{ ucfirst($material->unit) }}
                        </div>
                    </div>

                    <!-- Quantité -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            <i class="fas fa-boxes mr-1 text-[#4CA3DD]"></i>
                            Quantité disponible
                        </label>
                        <div class="p-3 rounded-lg border flex items-center justify-between"
                             :class="darkMode ? 'bg-gray-700 border-gray-600' : 'bg-gray-50 border-gray-200'">
                        <span :class="darkMode ? 'text-white' : 'text-gray-900'">
                            {{ $material->quantity }}
                        </span>
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded"
                                  :class="$material->quantity > 10 ?
                                  (darkMode ? 'bg-green-800 text-green-200' : 'bg-green-100 text-green-700') :
                                  $material->quantity > 0 ?
                                      (darkMode ? 'bg-yellow-800 text-yellow-200' : 'bg-yellow-100 text-yellow-700') :
                                      (darkMode ? 'bg-red-800 text-red-200' : 'bg-red-100 text-red-700')">
                            @if($material->quantity > 10)
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Stock suffisant
                                @elseif($material->quantity > 0)
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Stock faible
                                @else
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Rupture
                                @endif
                        </span>
                        </div>
                    </div>
                </div>

                <!-- Description (pleine largeur) -->
                <div class="mt-6 space-y-2">
                    <label class="block text-sm font-medium"
                           :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                        <i class="fas fa-align-left mr-1 text-[#4CA3DD]"></i>
                        Description
                    </label>
                    <div class="p-4 rounded-lg border min-h-[100px]"
                         :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-gray-50 border-gray-200 text-gray-900'">
                        @if($material->description)
                            {{ $material->description }}
                        @else
                            <span :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            <i class="fas fa-info-circle mr-1"></i>
                            Aucune description disponible
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte des métadonnées -->
        <div class="rounded-xl shadow-sm border overflow-hidden"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">

            <!-- En-tête -->
            <div class="px-6 py-4 border-b"
                 :class="darkMode ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                <h2 class="text-lg font-semibold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-clock mr-2 text-[#4CA3DD]"></i>
                    Informations système
                </h2>
            </div>

            <!-- Contenu -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Date de création -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            <i class="fas fa-calendar-plus mr-1 text-green-500"></i>
                            Date de création
                        </label>
                        <div class="p-3 rounded-lg border"
                             :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-gray-50 border-gray-200 text-gray-900'">
                            {{ $material->created_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>

                    <!-- Dernière modification -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            <i class="fas fa-calendar-edit mr-1 text-blue-500"></i>
                            Dernière modification
                        </label>
                        <div class="p-3 rounded-lg border"
                             :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-gray-50 border-gray-200 text-gray-900'">
                            {{ $material->updated_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="rounded-xl shadow-sm border overflow-hidden"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">

            <!-- En-tête -->
            <div class="px-6 py-4 border-b"
                 :class="darkMode ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                <h2 class="text-lg font-semibold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-tools mr-2 text-[#4CA3DD]"></i>
                    Actions disponibles
                </h2>
            </div>

            <!-- Contenu -->
            <div class="p-6">
                <div class="flex flex-wrap gap-3">
                    @can('ressource.material.update')
                        <a href="{{ route('admin.materials.edit', ['locale' => app()->getLocale(), 'material' => $material->id]) }}"
                           class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transform hover:-translate-y-0.5">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier le matériel
                        </a>
                    @endcan

                    @can('ressource.material.delete')
                        <button @click="showDeleteModal = true"
                                class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transform hover:-translate-y-0.5">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    @endcan

                    <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transform hover:-translate-y-0.5"
                       :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                        <i class="fas fa-list mr-2"></i>
                        Voir tous les matériels
                    </a>
                </div>
            </div>
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
                                            Êtes-vous sûr de vouloir supprimer le matériel "<strong>{{ $material->name }}</strong>" ? Cette action est irréversible.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3"
                             :class="darkMode ? 'bg-gray-750' : 'bg-gray-50'">
                            <form method="POST" action="{{ route('admin.materials.destroy', ['locale' => app()->getLocale(), 'material' => $material->id]) }}">
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
    </div>

    @push('scripts')
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush
@endsection
@endcan
