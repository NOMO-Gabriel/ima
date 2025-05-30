@extends('layouts.app')

@section('title', 'Gestion des Étudiants')

@section('breadcrumb')
    <div class="flex items-center space-x-2 text-sm"
         x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-home mr-1"></i>
            Tableau de bord
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">Étudiants</span>
    </div>
@endsection

@section('page_header')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-user-graduate mr-2 text-[#4CA3DD]"></i>
                    Gestion des Étudiants
                </h1>
                <p class="mt-1 text-sm"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Consultez, filtrez et gérez les informations des étudiants.
                </p>
            </div>
            {{--<div class="flex flex-wrap gap-2">
                @can('admin.student.create') --}}{{-- Permission pour créer un étudiant --}}{{--
                <a href="{{ route('admin.students.create', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2">
                    <i class="fas fa-user-plus mr-2"></i>
                    Ajouter un étudiant
                </a>
                @endcan
                --}}{{-- Ajoutez d'autres boutons d'action ici si nécessaire (ex: Exporter) --}}{{--
            </div>--}}
        </div>
    </div>
@endsection

@section('content')
    <div x-data="{
        darkMode: localStorage.getItem('theme') === 'dark',
        viewMode: localStorage.getItem('students-view-preference') || 'table',
        showFilters: true,
        selectedStudents: [], // Pour la sélection multiple si implémentée
        selectAll: false      // Pour la sélection multiple si implémentée
     }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'));
             $watch('viewMode', val => localStorage.setItem('students-view-preference', val));"
         class="space-y-6">

        <!-- Métriques/Statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="rounded-xl shadow-sm border overflow-hidden transition-all duration-300 hover:shadow-lg"
                 :class="darkMode ? 'bg-gray-800 border-gray-700 hover:border-gray-600' : 'bg-white border-gray-200 hover:border-gray-300'">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-full" :class="darkMode ? 'bg-blue-500/20' : 'bg-blue-100'">
                            <i class="fas fa-user-graduate text-xl" :class="darkMode ? 'text-blue-400' : 'text-blue-600'"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $stats['total'] ?? 0 }}</p>
                            <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Total Étudiants</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-xl shadow-sm border overflow-hidden transition-all duration-300 hover:shadow-lg"
                 :class="darkMode ? 'bg-gray-800 border-gray-700 hover:border-gray-600' : 'bg-white border-gray-200 hover:border-gray-300'">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-full" :class="darkMode ? 'bg-green-500/20' : 'bg-green-100'">
                            <i class="fas fa-user-check text-xl" :class="darkMode ? 'text-green-400' : 'text-green-600'"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $stats['active'] ?? 0 }}</p>
                            <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Étudiants Actifs</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rounded-xl shadow-sm border overflow-hidden transition-all duration-300 hover:shadow-lg"
                 :class="darkMode ? 'bg-gray-800 border-gray-700 hover:border-gray-600' : 'bg-white border-gray-200 hover:border-gray-300'">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 p-3 rounded-full" :class="darkMode ? 'bg-yellow-500/20' : 'bg-yellow-100'">
                            <i class="fas fa-hourglass-half text-xl" :class="darkMode ? 'text-yellow-400' : 'text-yellow-500'"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <p class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $stats['pending_validation'] ?? 0 }}</p>
                            <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">En Attente Validation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et recherche -->
        <div class="rounded-xl shadow-sm border overflow-hidden"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
            <div class="px-6 py-4 border-b flex items-center justify-between"
                 :class="darkMode ? 'border-gray-700 bg-gradient-to-r from-gray-750 to-gray-800' : 'border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100'">
                <h2 class="text-lg font-semibold flex items-center" :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-filter mr-2 text-[#4CA3DD]"></i> Filtres et Recherche
                </h2>
                <button type="button" @click="showFilters = !showFilters"
                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium rounded-md transition-colors"
                        :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                    <i class="fas fa-chevron-down mr-1 transform transition-transform duration-200" :class="{ 'rotate-180': showFilters }"></i>
                    <span x-text="showFilters ? 'Masquer' : 'Afficher'"></span>
                </button>
            </div>

            <div x-show="showFilters" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-[500px]"
                 x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 max-h-[500px]" x-transition:leave-end="opacity-0 max-h-0"
                 class="p-6 overflow-hidden">
                <form action="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}" method="GET" class="space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-3">
                            <label class="block text-sm font-medium mb-1" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Recherche générale</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone..."
                                       class="w-full pl-10 pr-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                       :class="darkMode ? 'bg-gray-700 border-gray-600 text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Genre</label>
                            <select name="gender" class="w-full px-3 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Tous</option>
                                @foreach($genders ?? [] as $value => $label)
                                    <option value="{{ $value }}" {{ request('gender') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Ville</label>
                            <select name="city_id" class="w-full px-3 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Toutes</option>
                                @foreach($citiesForFilter ?? [] as $id => $name)
                                    <option value="{{ $id }}" {{ request('city_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Centre</label>
                            <select name="center_id" class="w-full px-3 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Tous</option>
                                @foreach($centersForFilter ?? [] as $id => $name)
                                    <option value="{{ $id }}" {{ request('center_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Statut</label>
                            <select name="status" class="w-full px-3 py-2.5 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Tous</option>
                                @foreach($statuses ?? [] as $value => $label)
                                    <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 justify-end items-center pt-4 border-t" :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}"
                           class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200"
                           :class="darkMode ? 'bg-gray-600 hover:bg-gray-500 text-gray-200 border border-gray-500' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                            <i class="fas fa-times mr-2"></i> Effacer
                        </a>
                        <button type="submit"
                                class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2">
                            <i class="fas fa-search mr-2"></i> Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des étudiants -->
        <div class="rounded-xl shadow-sm border overflow-hidden"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
            <div class="px-6 py-4 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4"
                 :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                <h2 class="text-lg font-semibold flex items-center" :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-users mr-2 text-[#4CA3DD]"></i> Liste des Étudiants
                    <span class="ml-2 px-2.5 py-1 text-xs font-semibold rounded-full"
                          :class="darkMode ? 'bg-gray-700 text-gray-300' : 'bg-gray-100 text-gray-600'">
                    {{ $studentUsers->total() }}
                </span>
                </h2>
                <div class="flex items-center space-x-2">
                    {{-- Actions de masse (si sélection multiple) --}}
                    <div x-show="selectedStudents.length > 0" class="flex items-center space-x-2">
                        <span class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-600'" x-text="selectedStudents.length + ' sélectionné(s)'"></span>
                        @can('admin.student.delete') {{-- Ou une permission plus spécifique pour actions de masse --}}
                        <button type="button" @click="console.log('Supprimer sélectionnés:', selectedStudents)"
                                class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition-colors">
                            <i class="fas fa-trash mr-1"></i> Supprimer
                        </button>
                        @endcan
                    </div>
                    <div class="flex p-0.5 rounded-lg" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                        <button type="button" @click="viewMode = 'table'"
                                class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors focus:outline-none"
                                :class="viewMode === 'table' ? (darkMode ? 'bg-gray-600 text-white shadow-sm' : 'bg-white text-gray-900 shadow-sm') : (darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-800')">
                            <i class="fas fa-table"></i>
                        </button>
                        <button type="button" @click="viewMode = 'grid'"
                                class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors focus:outline-none"
                                :class="viewMode === 'grid' ? (darkMode ? 'bg-gray-600 text-white shadow-sm' : 'bg-white text-gray-900 shadow-sm') : (darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-800')">
                            <i class="fas fa-th-large"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Vue Tableau -->
            <div x-show="viewMode === 'table'" class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead :class="darkMode ? 'bg-gray-750' : 'bg-gray-50'">
                    <tr>
                        {{-- <th class="px-4 py-3 text-left w-12">
                            <input type="checkbox" x-model="selectAll" @change="selectedStudents = selectAll ? {{ json_encode($studentUsers->pluck('id')->toArray()) }} : []"
                                   class="rounded border-gray-300 text-[#4CA3DD] focus:ring-[#4CA3DD] shadow-sm"
                                   :class="darkMode ? 'bg-gray-600 border-gray-500' : 'bg-white border-gray-300'">
                        </th> --}}
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer hover:bg-opacity-75"
                            :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-500 hover:bg-gray-100'"
                            onclick="sortBy('first_name')">
                            Étudiant <i class="fas fa-sort ml-1 text-gray-400"></i>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">Contact</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">Ville</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">Centre Principal</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer hover:bg-opacity-75"
                            :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-500 hover:bg-gray-100'"
                            onclick="sortBy('status')">
                            Statut <i class="fas fa-sort ml-1 text-gray-400"></i>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer hover:bg-opacity-75"
                            :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-500 hover:bg-gray-100'"
                            onclick="sortBy('created_at')">
                            Inscrit le <i class="fas fa-sort ml-1 text-gray-400"></i>
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y" :class="darkMode ? 'divide-gray-700' : 'divide-gray-200'">
                    @forelse($studentUsers as $studentUser)
                        <tr class="transition-colors duration-150" :class="darkMode ? 'hover:bg-gray-750' : 'hover:bg-gray-50'">
                            {{-- <td class="px-4 py-4">
                                <input type="checkbox" :value="$studentUser->id" x-model="selectedStudents"
                                       class="rounded border-gray-300 text-[#4CA3DD] focus:ring-[#4CA3DD] shadow-sm"
                                       :class="darkMode ? 'bg-gray-600 border-gray-500' : 'bg-white border-gray-300'">
                            </td> --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-11 w-11 relative">
                                        <img class="h-11 w-11 rounded-full object-cover" src="{{ $studentUser->profile_photo_url }}" alt="{{ $studentUser->full_name }}">
                                        @php $statusConfigAvatar = \App\Models\User::getStatusConfig($studentUser->status); @endphp
                                        <span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full ring-2 ring-white {{ $statusConfigAvatar['bg_color'] }} {{ $statusConfigAvatar['dark_bg_color'] }}"
                                              :class="darkMode ? 'ring-gray-800' : 'ring-white'"></span>
                                    </div>
                                    <div class="ml-4">
                                        @can('admin.student.read')
                                            <a href="{{ route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}"
                                               class="text-sm font-medium hover:text-[#4CA3DD] transition-colors"
                                               :class="darkMode ? 'text-gray-100 hover:text-[#4CA3DD]' : 'text-gray-900 hover:text-[#4CA3DD]'">
                                                {{ $studentUser->full_name }}
                                            </a>
                                        @else
                                            <span class="text-sm font-medium" :class="darkMode ? 'text-gray-100' : 'text-gray-900'">{{ $studentUser->full_name }}</span>
                                        @endcan
                                        <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $studentUser->gender_label ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                <div>{{ $studentUser->email }}</div>
                                @if($studentUser->phone_number)
                                    <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $studentUser->phone_number }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                {{ $studentUser->city->name ?? ($studentUser->city ?? 'N/A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                @if($studentUser->student && $studentUser->student->enrollments->isNotEmpty())
                                    {{ $studentUser->student->enrollments->first()->center->name ?? 'N/A' }}
                                    @if($studentUser->student->enrollments->count() > 1)
                                        <span class="ml-1 px-1.5 py-0.5 text-xs font-semibold rounded-full"
                                              :class="darkMode ? 'bg-blue-600 text-blue-100' : 'bg-blue-100 text-blue-700'">
                                            +{{ $studentUser->student->enrollments->count() - 1 }}
                                        </span>
                                    @endif
                                @else
                                    <span class="italic text-xs" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">Non inscrit</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php $statusConfig = \App\Models\User::getStatusConfig($studentUser->status); @endphp
                                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusConfig['bg_color'] }} {{ $statusConfig['text_color'] }}"
                                      :class="{ '{{ str_replace(':', '\:', $statusConfig['dark_bg_color']) }} {{ str_replace(':', '\:', $statusConfig['dark_text_color']) }}': darkMode }">
                                    {{ $statusConfig['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                {{ $studentUser->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button @click="open = !open" @click.away="open = false" type="button"
                                            class="p-2 rounded-full transition-colors focus:outline-none"
                                            :class="darkMode ? 'text-gray-400 hover:bg-gray-700 hover:text-white' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div x-show="open" x-transition
                                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg z-10 ring-1 ring-black ring-opacity-5 focus:outline-none"
                                         :class="darkMode ? 'bg-gray-750 ring-gray-600' : 'bg-white'">
                                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                            @can('admin.student.read')
                                                <a href="{{ route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}"
                                                   class="flex items-center w-full px-4 py-2 text-sm transition-colors"
                                                   :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'" role="menuitem">
                                                    <i class="fas fa-eye text-[#4CA3DD] mr-2 w-4"></i> Voir
                                                </a>
                                            @endcan
                                            @can('admin.student.update')
                                                <a href="{{ route('admin.students.edit', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}"
                                                   class="flex items-center w-full px-4 py-2 text-sm transition-colors"
                                                   :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'" role="menuitem">
                                                    <i class="fas fa-edit text-[#4CA3DD] mr-2 w-4"></i> Modifier
                                                </a>
                                            @endcan
                                            @can('admin.student.delete')
                                                <button type="button" onclick="confirmDelete('{{ $studentUser->id }}', '{{ $studentUser->full_name }}')"
                                                        class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors"
                                                        :class="darkMode ? 'dark:hover:bg-red-700/30 dark:hover:text-red-300' : ''" role="menuitem">
                                                    <i class="fas fa-trash mr-2 w-4"></i> Supprimer
                                                </button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="p-4 rounded-full mb-4" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                                        <i class="fas fa-user-graduate text-3xl" :class="darkMode ? 'text-gray-500' : 'text-gray-400'"></i>
                                    </div>
                                    <h3 class="text-lg font-medium mb-1" :class="darkMode ? 'text-white' : 'text-gray-900'">Aucun étudiant trouvé</h3>
                                    <p class="text-sm mb-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Essayez d'ajuster vos filtres ou d'ajouter de nouveaux étudiants.</p>
                                    <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}"
                                       class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                                       :class="darkMode ? 'bg-gray-600 hover:bg-gray-500 text-gray-200 border border-gray-500' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                                        <i class="fas fa-sync-alt mr-2"></i> Réinitialiser les filtres
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Vue Grille -->
            <div x-show="viewMode === 'grid'" class="p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($studentUsers as $studentUser)
                        <div class="rounded-lg border overflow-hidden transition-all duration-200 hover:shadow-xl hover:-translate-y-1 flex flex-col"
                             :class="darkMode ? 'bg-gray-750 border-gray-600' : 'bg-white border-gray-200'">
                            <div class="p-5 flex flex-col items-center text-center border-b" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                                <div class="relative mb-3">
                                    <img class="h-20 w-20 rounded-full object-cover shadow-md" src="{{ $studentUser->profile_photo_url }}" alt="{{ $studentUser->full_name }}">
                                    @php $statusConfigAvatarGrid = \App\Models\User::getStatusConfig($studentUser->status); @endphp
                                    <span class="absolute bottom-0 right-0 block h-4 w-4 rounded-full ring-2 {{ $statusConfigAvatarGrid['bg_color'] }} {{ $statusConfigAvatarGrid['dark_bg_color'] }}"
                                          :class="darkMode ? 'ring-gray-750' : 'ring-white'"></span>
                                </div>
                                @can('admin.student.read')
                                    <a href="{{ route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}"
                                       class="text-lg font-semibold hover:text-[#4CA3DD] transition-colors"
                                       :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        {{ $studentUser->full_name }}
                                    </a>
                                @else
                                    <h3 class="text-lg font-semibold" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $studentUser->full_name }}</h3>
                                @endcan
                                <p class="text-xs mt-0.5" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $studentUser->gender_label ?? '' }}</p>
                            </div>
                            <div class="p-5 space-y-2 text-sm flex-grow">
                                <p class="flex items-center" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    <i class="fas fa-envelope mr-2 w-4 text-[#4CA3DD]"></i> <span class="truncate">{{ $studentUser->email }}</span>
                                </p>
                                @if($studentUser->phone_number)
                                    <p class="flex items-center" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        <i class="fas fa-phone mr-2 w-4 text-[#4CA3DD]"></i> {{ $studentUser->phone_number }}
                                    </p>
                                @endif
                                <p class="flex items-center" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    <i class="fas fa-city mr-2 w-4 text-[#4CA3DD]"></i> {{ $studentUser->city->name ?? ($studentUser->city ?? 'N/A') }}
                                </p>
                                @if($studentUser->student && $studentUser->student->enrollments->isNotEmpty())
                                    <p class="flex items-center" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        <i class="fas fa-school mr-2 w-4 text-[#4CA3DD]"></i> {{ $studentUser->student->enrollments->first()->center->name ?? 'N/A' }}
                                    </p>
                                @endif
                            </div>
                            <div class="px-5 py-3 border-t flex items-center justify-between" :class="darkMode ? 'border-gray-600 bg-gray-700' : 'border-gray-200 bg-gray-50'">
                                @php $statusConfigGrid = \App\Models\User::getStatusConfig($studentUser->status); @endphp
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusConfigGrid['bg_color'] }} {{ $statusConfigGrid['text_color'] }}"
                                      :class="{ '{{ str_replace(':', '\:', $statusConfigGrid['dark_bg_color']) }} {{ str_replace(':', '\:', $statusConfigGrid['dark_text_color']) }}': darkMode }">
                                {{ $statusConfigGrid['label'] }}
                            </span>
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" @click.away="open = false" type="button"
                                            class="p-1.5 rounded-full transition-colors focus:outline-none"
                                            :class="darkMode ? 'text-gray-400 hover:bg-gray-600 hover:text-white' : 'text-gray-500 hover:bg-gray-200 hover:text-gray-700'">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div x-show="open" x-transition
                                         class="origin-top-right absolute right-0 bottom-full mb-1 w-40 rounded-md shadow-lg z-10 ring-1 ring-black ring-opacity-5 focus:outline-none"
                                         :class="darkMode ? 'bg-gray-750 ring-gray-600' : 'bg-white'">
                                        <div class="py-1">
                                            @can('admin.student.read')
                                                <a href="{{ route('admin.students.show', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}" class="flex items-center w-full px-3 py-1.5 text-xs transition-colors" :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'"><i class="fas fa-eye text-[#4CA3DD] mr-2 w-3"></i> Voir</a>
                                            @endcan
                                            @can('admin.student.update')
                                                <a href="{{ route('admin.students.edit', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}" class="flex items-center w-full px-3 py-1.5 text-xs transition-colors" :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'"><i class="fas fa-edit text-[#4CA3DD] mr-2 w-3"></i> Modifier</a>
                                            @endcan
                                            @can('admin.student.delete')
                                                <button type="button" onclick="confirmDelete('{{ $studentUser->id }}', '{{ $studentUser->full_name }}')" class="flex items-center w-full px-3 py-1.5 text-xs text-red-600 hover:bg-red-50 transition-colors" :class="darkMode ? 'dark:hover:bg-red-700/30 dark:hover:text-red-300' : ''"><i class="fas fa-trash mr-2 w-3"></i> Supprimer</button>
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center py-12">
                            <div class="p-4 rounded-full mb-4" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                                <i class="fas fa-user-graduate text-3xl" :class="darkMode ? 'text-gray-500' : 'text-gray-400'"></i>
                            </div>
                            <h3 class="text-lg font-medium mb-1" :class="darkMode ? 'text-white' : 'text-gray-900'">Aucun étudiant trouvé</h3>
                            <p class="text-sm mb-4 text-center" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Aucun étudiant ne correspond à vos critères de recherche.</p>
                            <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}"
                               class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                               :class="darkMode ? 'bg-gray-600 hover:bg-gray-500 text-gray-200 border border-gray-500' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                                <i class="fas fa-sync-alt mr-2"></i> Réinitialiser les filtres
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if($studentUsers->hasPages())
                <div class="px-6 py-4 border-t" :class="darkMode ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                    {{ $studentUsers->links() }} {{-- Assurez-vous que votre pagination est stylée pour Tailwind --}}
                </div>
            @endif
        </div>

        {{-- Modal de confirmation de suppression (exemple) --}}
        <div x-data="{ showConfirmDeleteModal: false, studentIdToDelete: null, studentNameToDelete: '' }"
             @keydown.escape.window="showConfirmDeleteModal = false"
             x-show="showConfirmDeleteModal"
             class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showConfirmDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>

                <div x-show="showConfirmDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                     :class="darkMode ? 'bg-gray-800' : 'bg-white'">
                    <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4" :class="darkMode ? 'bg-gray-800' : 'bg-white'">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10"
                                 :class="darkMode ? 'bg-red-700/30' : 'bg-red-100'">
                                <i class="fas fa-exclamation-triangle text-red-600" :class="darkMode ? 'text-red-400' : 'text-red-600'" aria-hidden="true"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium" :class="darkMode ? 'text-gray-100' : 'text-gray-900'" id="modal-title">
                                    Supprimer l'Étudiant
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        Êtes-vous sûr de vouloir supprimer l'étudiant <strong x-text="studentNameToDelete"></strong> ? Cette action est irréversible.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse" :class="darkMode ? 'bg-gray-800 border-t border-gray-700' : 'bg-gray-50'">
                        <button @click="processDelete(studentIdToDelete)" type="button"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm"
                                :class="darkMode ? 'focus:ring-offset-gray-800' : 'focus:ring-offset-white'">
                            Supprimer
                        </button>
                        <button @click="showConfirmDeleteModal = false" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-300 hover:bg-gray-600 focus:ring-offset-gray-800' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Styles pour les en-têtes de tableau triables */
        .data-table th.cursor-pointer:hover {
            /* background-color: rgba(0,0,0,0.03); /* Light mode */
        }

        /* Amélioration pour les indicateurs de statut sur avatar */
        .ring-white { --tw-ring-color: white; }
        .dark .ring-gray-800 { --tw-ring-color: #1f2937; } /* bg-gray-800 */
        .dark .ring-gray-750 { --tw-ring-color: #374151; } /* bg-gray-750 */

        /* Style pour les placeholders des inputs en mode sombre */
        .dark input::placeholder, .dark textarea::placeholder {
            color: #9ca3af; /* text-gray-400 */
        }
        .dark select {
            /* Pour certains navigateurs, le style du select en mode sombre peut nécessiter des ajustements spécifiques */
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function sortBy(field) {
            const url = new URL(window.location);
            const currentSort = url.searchParams.get('sort');
            const currentDirection = url.searchParams.get('direction');
            let direction = 'asc';
            if (currentSort === field && currentDirection === 'asc') {
                direction = 'desc';
            }
            url.searchParams.set('sort', field);
            url.searchParams.set('direction', direction);
            window.location.href = url.toString();
        }

        function confirmDelete(studentId, studentName) {
            const alpineComponent = document.querySelector('[x-data*="showConfirmDeleteModal"]');
            if (alpineComponent) {
                Alpine.$data(alpineComponent).studentIdToDelete = studentId;
                Alpine.$data(alpineComponent).studentNameToDelete = studentName;
                Alpine.$data(alpineComponent).showConfirmDeleteModal = true;
            }
        }

        function processDelete(studentId) {
            // Créer un formulaire dynamiquement pour envoyer la requête DELETE
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url(app()->getLocale() . '/admin/students') }}/${studentId}`; // Adaptez si votre route est différente

            const csrfTokenField = document.createElement('input');
            csrfTokenField.type = 'hidden';
            csrfTokenField.name = '_token';
            csrfTokenField.value = '{{ csrf_token() }}'; // Nécessaire pour la protection CSRF
            form.appendChild(csrfTokenField);

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE'; // Laravel utilise _method pour simuler DELETE
            form.appendChild(methodField);

            document.body.appendChild(form);
            form.submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes au chargement
            const cards = document.querySelectorAll('.rounded-xl.shadow-sm, .rounded-lg.border');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(15px)';
                card.style.transition = `all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) ${index * 0.05}s`;
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50 + (index * 50));
            });
        });
    </script>
@endpush
