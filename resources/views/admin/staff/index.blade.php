@extends('layouts.app')

@section('page_title', 'Gestion du Personnel')

@section('breadcrumb')
    <div class="flex items-center space-x-2 text-sm"
         x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center text-sm font-medium transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
            <i class="fas fa-home mr-1"></i>
            Accueil
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <a href="#"
           class="inline-flex items-center text-sm font-medium transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
            <i class="fas fa-cogs mr-1"></i>
            Administration
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <span class="inline-flex items-center text-sm font-medium"
              :class="darkMode ? 'text-gray-300' : 'text-gray-800'">Personnel</span>
    </div>
@endsection

@section('content')
    <div x-data="{
        darkMode: localStorage.getItem('theme') === 'dark',
        viewMode: localStorage.getItem('staff-view-preference') || 'table', // 'table' ou 'grid'
        showFilters: true,
        selectedStaff: [],
        selectAll: false,
        activeDropdown: null
    }"
         x-init="
            $watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'));
            $watch('viewMode', val => localStorage.setItem('staff-view-preference', val));
         "
         class="space-y-8">

        <!-- En-tête de page avec actions -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h1 class="text-3xl lg:text-4xl font-bold">
                    <i class="fas fa-users-cog mr-3 text-[#4CA3DD]"></i>
                    Gestion du Personnel
                </h1>
                <p class="mt-2 text-lg"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Administrez les membres du personnel et leurs attributions.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                @can('admin.user.create') {{-- Adaptez la permission --}}
                <a href="{{ route('admin.staff.create', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-6 py-3 bg-[#4CA3DD] text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <i class="fas fa-user-plus mr-2"></i>
                    Nouveau Membre
                </a>
                @endcan
                {{-- @can('admin.user.export')
                    <button type="button"
                            onclick="exportStaff()"
                            class="inline-flex items-center px-6 py-3 text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
                            :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                        <i class="fas fa-download mr-2"></i>
                        Exporter
                    </button>
                @endcan --}}
                <button type="button"
                        @click="showFilters = !showFilters"
                        class="inline-flex items-center px-6 py-3 text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"
                        :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                    <i class="fas fa-filter mr-2"></i>
                    Filtres
                    <i class="fas fa-chevron-down ml-2 transform transition-transform"
                       :class="{ 'rotate-180': showFilters }"></i>
                </button>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6"> {{-- Ajusté à 2 colonnes pour les stats du personnel --}}
            <div class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300"
                 :class="darkMode ? 'bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700' : 'bg-gradient-to-br from-white to-gray-50 border border-gray-200'">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-500 to-purple-600 opacity-5"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-[#4CA3DD] rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $stats['total'] ?? 0 }}</p>
                            <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Total Personnel</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300"
                 :class="darkMode ? 'bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700' : 'bg-gradient-to-br from-white to-gray-50 border border-gray-200'">
                <div class="absolute inset-0 bg-gradient-to-r from-teal-500 to-cyan-600 opacity-5"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-user-shield text-white text-xl"></i>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $stats['active'] ?? 0 }}</p>
                            <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Personnel Actif</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Filtres -->
        <div x-show="showFilters"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95"
             class="backdrop-blur-sm rounded-2xl shadow-xl border overflow-hidden"
             :class="darkMode ? 'bg-gray-800/80 border-gray-700' : 'bg-white/80 border-gray-200'">
            <div class="px-8 py-6 border-b" :class="darkMode ? 'border-gray-700 bg-gradient-to-r from-gray-700/50 to-gray-800/50' : 'border-gray-200 bg-gradient-to-r from-gray-50/50 to-gray-100/50'">
                <h2 class="text-xl font-bold flex items-center" :class="darkMode ? 'text-white' : 'text-gray-900'"><i class="fas fa-filter mr-3 text-[#4CA3DD]"></i>Filtres</h2>
            </div>
            <div class="p-8">
                <form action="{{ route('admin.staff.index', ['locale' => app()->getLocale()]) }}" method="GET" class="space-y-8">
                    <div class="relative">
                        <label class="block text-sm font-semibold mb-3" :class="darkMode ? 'text-gray-300' : 'text-gray-700'"><i class="fas fa-search mr-2 text-[#4CA3DD]"></i>Recherche globale</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone..."
                                   class="w-full pl-12 pr-4 py-4 text-lg border-2 rounded-xl focus:ring-4 focus:ring-[#4CA3DD]/20 focus:border-[#4CA3DD] transition-all duration-200 backdrop-blur-sm"
                                   :class="darkMode ? 'bg-gray-700/50 border-gray-600 text-white placeholder-gray-400' : 'bg-white/70 border-gray-300 text-gray-900 placeholder-gray-500'">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><i class="fas fa-search text-[#4CA3DD] text-xl"></i></div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6"> {{-- Ajusté pour 2 filtres principaux --}}
                        <div>
                            <label class="block text-sm font-semibold mb-2" :class="darkMode ? 'text-gray-300' : 'text-gray-700'"><i class="fas fa-user-tag mr-2 text-[#4CA3DD]"></i>Rôle</label>
                            <select name="role" class="w-full px-4 py-3 border-2 rounded-xl focus:ring-4 focus:ring-[#4CA3DD]/20 focus:border-[#4CA3DD] transition-all duration-200"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Tous les rôles</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" :class="darkMode ? 'text-gray-300' : 'text-gray-700'"><i class="fas fa-toggle-on mr-2 text-[#4CA3DD]"></i>Statut</label>
                            <select name="status" class="w-full px-4 py-3 border-2 rounded-xl focus:ring-4 focus:ring-[#4CA3DD]/20 focus:border-[#4CA3DD] transition-all duration-200"
                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">Tous les statuts</option>
                                @foreach(\App\Models\User::getStatuses() as $value => $label) {{-- Utilise la méthode statique du modèle User --}}
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center pt-6 border-t" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                        <div class="flex items-center text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'"><i class="fas fa-info-circle mr-2 text-[#4CA3DD]"></i>{{ $staffMembers->total() ?? 0 }} membre(s) trouvé(s)</div>
                        <div class="flex gap-4">
                            <a href="{{ route('admin.staff.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-6 py-3 text-sm font-semibold rounded-xl transition-all duration-200 hover:-translate-y-0.5"
                               :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border-2 border-gray-300'"><i class="fas fa-times mr-2"></i>Réinitialiser</a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200"><i class="fas fa-search mr-2"></i>Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Section Liste du Personnel -->
        <div class="backdrop-blur-sm rounded-2xl shadow-xl border overflow-hidden"
             :class="darkMode ? 'bg-gray-800/80 border-gray-700' : 'bg-white/80 border-gray-200'">
            <div class="px-8 py-6 border-b" :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <h2 class="text-xl font-bold flex items-center" :class="darkMode ? 'text-white' : 'text-gray-900'">
                        <i class="fas fa-id-card-alt mr-3 text-[#4CA3DD]"></i> Liste du Personnel
                        <span class="ml-2 px-2.5 py-1 text-xs font-semibold rounded-full" :class="darkMode ? 'bg-gray-700 text-gray-300' : 'bg-gray-100 text-gray-600'">{{ $staffMembers->total() }}</span>
                    </h2>
                    <div class="flex items-center space-x-2">
                        {{-- Actions de masse (si sélection multiple) --}}
                        <div x-show="selectedStaff.length > 0" class="flex items-center space-x-2">
                            <span class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-600'" x-text="selectedStaff.length + ' sélectionné(s)'"></span>
                            @can('admin.user.delete') {{-- Adaptez la permission --}}
                            <button type="button" @click="confirmBulkDelete()" {{-- Créez cette fonction JS --}}
                            class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md transition-colors">
                                <i class="fas fa-trash mr-1"></i> Supprimer la sélection
                            </button>
                            @endcan
                        </div>
                        <div class="flex p-0.5 rounded-lg" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'">
                            <button type="button" @click="viewMode = 'table'" class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors focus:outline-none" :class="viewMode === 'table' ? (darkMode ? 'bg-gray-600 text-white shadow-sm' : 'bg-white text-gray-900 shadow-sm') : (darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-800')"><i class="fas fa-table"></i></button>
                            <button type="button" @click="viewMode = 'grid'" class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors focus:outline-none" :class="viewMode === 'grid' ? (darkMode ? 'bg-gray-600 text-white shadow-sm' : 'bg-white text-gray-900 shadow-sm') : (darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-500 hover:text-gray-800')"><i class="fas fa-th-large"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vue Tableau -->
            <div x-show="viewMode === 'table'" class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[900px]">
                        <thead class="border-b" :class="darkMode ? 'bg-gray-700/50 border-gray-600' : 'bg-gray-50/50 border-gray-200'">
                        <tr>
                            @can('admin.user.delete')
                                <th class="px-4 py-3 text-left w-12">
                                    <input type="checkbox" x-model="selectAll" @change="selectedStaff = selectAll ? {{ json_encode(($staffMembers ?? collect())->pluck('id')->toArray()) }} : []"
                                           class="rounded border-gray-300 text-[#4CA3DD] focus:ring-[#4CA3DD] shadow-sm"
                                           :class="darkMode ? 'bg-gray-600 border-gray-500' : 'bg-white border-gray-300'">
                                </th>
                            @endcan
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider cursor-pointer hover:bg-opacity-75" :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-500 hover:bg-gray-100'" onclick="sortBy('first_name')">Membre <i class="fas fa-sort ml-1 text-gray-400"></i></th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">Contact</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">Rôles</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">Poste(s) Principal(aux)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider cursor-pointer hover:bg-opacity-75" :class="darkMode ? 'text-gray-300 hover:bg-gray-700' : 'text-gray-500 hover:bg-gray-100'" onclick="sortBy('status')">Statut <i class="fas fa-sort ml-1 text-gray-400"></i></th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider" :class="darkMode ? 'text-gray-300' : 'text-gray-500'">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y" :class="darkMode ? 'divide-gray-700' : 'divide-gray-200'">
                        @forelse($staffMembers as $staffMember)
                            <tr class="transition-colors duration-200" :class="darkMode ? 'hover:bg-gray-700/30' : 'hover:bg-gray-50/80'">
                                @can('admin.user.delete')
                                    <td class="px-4 py-4">
                                        <input type="checkbox" value="{{ $staffMember->id }}" x-model="selectedStaff"
                                               class="rounded border-gray-300 text-[#4CA3DD] focus:ring-[#4CA3DD] shadow-sm"
                                               :class="darkMode ? 'bg-gray-600 border-gray-500' : 'bg-white border-gray-300'">
                                    </td>
                                @endcan
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-11 w-11 relative">
                                            <img class="h-11 w-11 rounded-xl object-cover border-2" :class="darkMode ? 'border-gray-600' : 'border-gray-200'" src="{{ $staffMember->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($staffMember->first_name . ' ' . $staffMember->last_name) . '&color=4CA3DD&background=EBF8FF' }}" alt="{{ $staffMember->full_name }}">
                                            @php $statusConfigTableAvatar = \App\Models\User::getStatusConfig($staffMember->status); @endphp
                                            <span class="absolute -bottom-1 -right-1 block h-3.5 w-3.5 rounded-full ring-2 {{ $statusConfigTableAvatar['bg_color'] }} {{ $statusConfigTableAvatar['dark_bg_color'] }}" :class="darkMode ? 'ring-gray-800' : 'ring-white'"></span>
                                        </div>
                                        <div class="ml-4">
                                            @can('admin.user.read')
                                                <a href="{{ route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffMember->id]) }}" class="text-sm font-semibold hover:text-[#4CA3DD] transition-colors" :class="darkMode ? 'text-gray-100 hover:text-[#4CA3DD]' : 'text-gray-900 hover:text-[#4CA3DD]'">{{ $staffMember->full_name }}</a>
                                            @else
                                                <span class="text-sm font-semibold" :class="darkMode ? 'text-gray-100' : 'text-gray-900'">{{ $staffMember->full_name }}</span>
                                            @endcan
                                            <div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $staffMember->city ?? 'Ville N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    <div>{{ $staffMember->email }}</div>
                                    @if($staffMember->phone_number)<div class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $staffMember->phone_number }}</div>@endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs">
                                    @foreach($staffMember->roles as $role)
                                        <span class="px-2 py-1 font-semibold leading-tight rounded-full mr-1 mb-1 inline-block" :class="darkMode ? 'bg-gray-600 text-gray-200' : 'bg-gray-100 text-gray-700'">{{ ucfirst($role->name) }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                    {{-- Afficher le premier job_title de la collection staff, s'il existe --}}
                                    {{ $staffMember->staff->first()->job_title ?? 'N/A' }}
                                    @if($staffMember->staff->count() > 1)
                                        <span class="ml-1 px-1.5 py-0.5 text-xs font-semibold rounded-full" :class="darkMode ? 'bg-indigo-600 text-indigo-100' : 'bg-indigo-100 text-indigo-700'">+{{ $staffMember->staff->count() - 1 }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php $statusConfigTable = \App\Models\User::getStatusConfig($staffMember->status); @endphp
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusConfigTable['bg_color'] }} {{ $statusConfigTable['text_color'] }}" :class="{ '{{ str_replace(':', '\:', $statusConfigTable['dark_bg_color']) }} {{ str_replace(':', '\:', $statusConfigTable['dark_text_color']) }}': darkMode }"><i class="{{ $statusConfigTable['icon'] }} mr-1 opacity-75"></i>{{ $statusConfigTable['label'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div x-data="{ openActions: false }" @click.outside="if(activeDropdown === 'staff-{{ $staffMember->id }}') openActions = false" class="relative inline-block text-left">
                                        <button @click="openActions = !openActions; activeDropdown = (openActions ? 'staff-{{ $staffMember->id }}' : null)" type="button" class="p-2 rounded-full transition-colors focus:outline-none" :class="darkMode ? 'text-gray-400 hover:bg-gray-700 hover:text-white' : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'"><i class="fas fa-ellipsis-v"></i></button>
                                        <div x-show="openActions && activeDropdown === 'staff-{{ $staffMember->id }}'" x-transition class="origin-top-right absolute right-0 mt-2 w-56 rounded-xl shadow-2xl z-20 ring-1 ring-black ring-opacity-5 focus:outline-none backdrop-blur-md" :class="darkMode ? 'bg-gray-750/90 ring-gray-600' : 'bg-white/90'">
                                            <div class="py-1" role="menu" aria-orientation="vertical">
                                                @can('admin.user.read')<a href="{{ route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffMember->id]) }}" class="flex items-center w-full px-4 py-2.5 text-sm transition-colors" :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'" role="menuitem"><i class="fas fa-eye mr-2 w-4 opacity-75"></i> Voir Profil</a>@endcan
                                                @can('admin.user.update')<a href="{{ route('admin.staff.edit', ['locale' => app()->getLocale(), 'staffUser' => $staffMember->id]) }}" class="flex items-center w-full px-4 py-2.5 text-sm transition-colors" :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'" role="menuitem"><i class="fas fa-edit mr-2 w-4 opacity-75"></i> Modifier</a>@endcan
                                                {{-- @can('admin.user.manage_permissions')<a href="#" class="flex items-center w-full px-4 py-2.5 text-sm transition-colors" :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'" role="menuitem"><i class="fas fa-user-shield mr-2 w-4 opacity-75"></i> Gérer Permissions</a>@endcan --}}
                                                @can('admin.user.delete')
                                                    @if(Auth::id() !== $staffMember->id)
                                                        <button type="button" onclick="confirmStaffDelete('{{ $staffMember->id }}', '{{ addslashes($staffMember->full_name) }}')" class="flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors" :class="darkMode ? 'dark:hover:bg-red-700/30 dark:hover:text-red-300' : ''" role="menuitem"><i class="fas fa-trash mr-2 w-4 opacity-75"></i> Supprimer</button>
                                                    @endif
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="{{ Auth::user()->can('admin.user.delete') ? '7' : '6' }}" class="px-6 py-12 text-center"><div class="flex flex-col items-center justify-center"><div class="p-4 rounded-full mb-4" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'"><i class="fas fa-users-cog text-3xl" :class="darkMode ? 'text-gray-500' : 'text-gray-400'"></i></div><h3 class="text-lg font-medium mb-1" :class="darkMode ? 'text-white' : 'text-gray-900'">Aucun membre du personnel</h3><p class="text-sm mb-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Essayez d'ajuster vos filtres.</p><a href="{{ route('admin.staff.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors" :class="darkMode ? 'bg-gray-600 hover:bg-gray-500 text-gray-200 border border-gray-500' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'"><i class="fas fa-sync-alt mr-2"></i>Réinitialiser</a></div></td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Vue Grille -->
            <div x-show="viewMode === 'grid'" class="p-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @forelse($staffMembers as $staffMember)
                        <div class="rounded-2xl border overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col" :class="darkMode ? 'bg-gray-800/60 border-gray-600' : 'bg-white/60 border-gray-200'">
                            <div class="p-5 flex flex-col items-center text-center border-b" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                                <div class="relative mb-3">
                                    <img class="h-20 w-20 rounded-full object-cover shadow-md" src="{{ $staffMember->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($staffMember->first_name . ' ' . $staffMember->last_name) . '&color=4CA3DD&background=EBF8FF' }}" alt="{{ $staffMember->full_name }}">
                                    @php $statusConfigGridAvatar = \App\Models\User::getStatusConfig($staffMember->status); @endphp
                                    <span class="absolute bottom-0 right-0 block h-4 w-4 rounded-full ring-2 {{ $statusConfigGridAvatar['bg_color'] }} {{ $statusConfigGridAvatar['dark_bg_color'] }}" :class="darkMode ? 'ring-gray-750' : 'ring-white'"></span>
                                </div>
                                @can('admin.user.read')<a href="{{ route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffMember->id]) }}" class="text-lg font-semibold hover:text-[#4CA3DD] transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $staffMember->full_name }}</a>
                                @else<h3 class="text-lg font-semibold" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $staffMember->full_name }}</h3>@endcan
                                <p class="text-xs mt-0.5" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">{{ $staffMember->staff->first()->job_title ?? 'Poste N/A' }}</p>
                            </div>
                            <div class="p-5 space-y-2 text-sm flex-grow">
                                <p class="flex items-center" :class="darkMode ? 'text-gray-300' : 'text-gray-700'"><i class="fas fa-envelope mr-2 w-4 text-[#4CA3DD]"></i> <span class="truncate">{{ $staffMember->email }}</span></p>
                                @if($staffMember->phone_number)<p class="flex items-center" :class="darkMode ? 'text-gray-300' : 'text-gray-700'"><i class="fas fa-phone mr-2 w-4 text-[#4CA3DD]"></i> {{ $staffMember->phone_number }}</p>@endif
                                <div class="pt-1">
                                    @foreach($staffMember->roles->take(2) as $role)
                                        <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-full mr-1 mb-1" :class="darkMode ? 'bg-gray-600 text-gray-200' : 'bg-gray-100 text-gray-700'">{{ ucfirst($role->name) }}</span>
                                    @endforeach
                                    @if($staffMember->roles->count() > 2)<span class="text-xs" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">+{{ $staffMember->roles->count() - 2 }}</span>@endif
                                </div>
                            </div>
                            <div class="px-5 py-3 border-t flex items-center justify-between" :class="darkMode ? 'border-gray-600 bg-gray-700' : 'border-gray-200 bg-gray-50'">
                                @php $statusConfigGrid = \App\Models\User::getStatusConfig($staffMember->status); @endphp
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusConfigGrid['bg_color'] }} {{ $statusConfigGrid['text_color'] }}" :class="{ '{{ str_replace(':', '\:', $statusConfigGrid['dark_bg_color']) }} {{ str_replace(':', '\:', $statusConfigGrid['dark_text_color']) }}': darkMode }">{{ $statusConfigGrid['label'] }}</span>
                                <div x-data="{ openGridActions: false }" @click.outside="if(activeDropdown === 'staff-grid-{{ $staffMember->id }}') openGridActions = false" class="relative">
                                    <button @click="openGridActions = !openGridActions; activeDropdown = (openGridActions ? 'staff-grid-{{ $staffMember->id }}' : null)" type="button" class="p-1.5 rounded-full transition-colors focus:outline-none" :class="darkMode ? 'text-gray-400 hover:bg-gray-600 hover:text-white' : 'text-gray-500 hover:bg-gray-200 hover:text-gray-700'"><i class="fas fa-ellipsis-v"></i></button>
                                    <div x-show="openGridActions && activeDropdown === 'staff-grid-{{ $staffMember->id }}'" x-transition class="origin-top-right absolute right-0 bottom-full mb-1 w-40 rounded-xl shadow-2xl z-20 ring-1 ring-black ring-opacity-5 focus:outline-none backdrop-blur-md" :class="darkMode ? 'bg-gray-750/90 ring-gray-600' : 'bg-white/90'">
                                        <div class="py-1">
                                            @can('admin.user.read')<a href="{{ route('admin.staff.show', ['locale' => app()->getLocale(), 'staffUser' => $staffMember->id]) }}" class="flex items-center w-full px-3 py-1.5 text-xs transition-colors" :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'"><i class="fas fa-eye mr-2 w-3 opacity-75"></i> Voir</a>@endcan
                                            @can('admin.user.update')<a href="{{ route('admin.staff.edit', ['locale' => app()->getLocale(), 'staffUser' => $staffMember->id]) }}" class="flex items-center w-full px-3 py-1.5 text-xs transition-colors" :class="darkMode ? 'text-gray-300 hover:bg-gray-700 hover:text-white' : 'text-gray-700 hover:bg-gray-100'"><i class="fas fa-edit mr-2 w-3 opacity-75"></i> Modifier</a>@endcan
                                            @can('admin.user.delete') @if(Auth::id() !== $staffMember->id)<button type="button" onclick="confirmStaffDelete('{{ $staffMember->id }}', '{{ addslashes($staffMember->full_name) }}')" class="flex items-center w-full px-3 py-1.5 text-xs text-red-600 hover:bg-red-50 transition-colors" :class="darkMode ? 'dark:hover:bg-red-700/30 dark:hover:text-red-300' : ''"><i class="fas fa-trash mr-2 w-3 opacity-75"></i> Supprimer</button>@endif @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full flex flex-col items-center py-12"><div class="p-4 rounded-full mb-4" :class="darkMode ? 'bg-gray-700' : 'bg-gray-100'"><i class="fas fa-users-cog text-3xl" :class="darkMode ? 'text-gray-500' : 'text-gray-400'"></i></div><h3 class="text-lg font-medium mb-1" :class="darkMode ? 'text-white' : 'text-gray-900'">Aucun membre du personnel</h3><p class="text-sm mb-4 text-center" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Aucun membre du personnel ne correspond à vos critères.</p><a href="{{ route('admin.staff.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors" :class="darkMode ? 'bg-gray-600 hover:bg-gray-500 text-gray-200 border border-gray-500' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'"><i class="fas fa-sync-alt mr-2"></i>Réinitialiser</a></div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            @if(($staffMembers ?? collect())->hasPages())
                <div class="px-8 py-4 border-t rounded-b-2xl" :class="darkMode ? 'border-gray-700 bg-gray-800/80' : 'border-gray-200 bg-white/80'">
                    {{ $staffMembers->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Modal de confirmation de suppression pour le personnel --}}
    <div x-data="{ showConfirmStaffDeleteModal: false, staffIdToDelete: null, staffNameToDelete: '' }"
         @keydown.escape.window="showConfirmStaffDeleteModal = false"
         x-show="showConfirmStaffDeleteModal"
         class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title-staff" role="dialog" aria-modal="true" style="display: none;">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showConfirmStaffDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 transition-opacity bg-gray-500/75 dark:bg-gray-900/75 backdrop-blur-sm" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div x-show="showConfirmStaffDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                 :class="darkMode ? 'bg-gray-800 border border-gray-700' : 'bg-white'">
                <div class="px-6 pt-6 pb-4" :class="darkMode ? 'bg-gray-800' : 'bg-white'">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10" :class="darkMode ? 'bg-red-900/30' : 'bg-red-100'"><i class="fas fa-exclamation-triangle text-red-500" :class="darkMode ? 'text-red-400' : 'text-red-600'" aria-hidden="true"></i></div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-xl leading-6 font-bold" :class="darkMode ? 'text-gray-100' : 'text-gray-900'" id="modal-title-staff">Supprimer Membre du Personnel</h3>
                            <div class="mt-2"><p class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Êtes-vous sûr de vouloir supprimer <strong x-text="staffNameToDelete" class="font-semibold" :class="darkMode ? 'text-white' : 'text-black'"></strong> ? Cette action est irréversible.</p></div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 sm:flex sm:flex-row-reverse" :class="darkMode ? 'bg-gray-800/50 border-t border-gray-700' : 'bg-gray-50'">
                    <button @click="processStaffDelete(staffIdToDelete)" type="button" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-6 py-3 bg-red-600 text-base font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-150" :class="darkMode ? 'focus:ring-offset-gray-800' : 'focus:ring-offset-white'">Confirmer</button>
                    <button @click="showConfirmStaffDeleteModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-xl border shadow-md px-6 py-3 text-base font-semibold focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-150" :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-300 hover:bg-gray-600 focus:ring-offset-gray-800' : 'bg-white border-gray-300 text-gray-700 hover:bg-gray-50'">Annuler</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    {{-- Styles de la page précédente (enseignants) peuvent être réutilisés ou adaptés --}}
    <style>
        .backdrop-blur-sm { backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); }
        .dark .bg-gray-800\/80 { background-color: rgba(31, 41, 55, 0.8); }
        .dark .bg-white\/80 { background-color: rgba(255, 255, 255, 0.8); }
        .dark .bg-gray-700\/50 { background-color: rgba(55, 65, 81, 0.5); }
        .dark .bg-gray-50\/50 { background-color: rgba(249, 250, 251, 0.5); }
        .dark .bg-gray-750 { background-color: #374151; }
        .dark .bg-gray-750\/90 { background-color: rgba(55, 65, 81, 0.9); }
        .dark .bg-white\/90 { background-color: rgba(255, 255, 255, 0.9); }
        .ring-white { --tw-ring-color: white; }
        .dark .ring-gray-800 { --tw-ring-color: #1f2937; }
        .dark .ring-gray-750 { --tw-ring-color: #374151; }
        .dark input::placeholder, .dark textarea::placeholder { color: #9ca3af; }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function sortBy(field) { /* ... (Identique à la page enseignants) ... */ }
        function confirmStaffDelete(staffId, staffName) {
            const alpineComponent = document.querySelector('[x-data*="showConfirmStaffDeleteModal"]');
            if (alpineComponent) {
                Alpine.$data(alpineComponent).staffIdToDelete = staffId;
                Alpine.$data(alpineComponent).staffNameToDelete = staffName;
                Alpine.$data(alpineComponent).showConfirmStaffDeleteModal = true;
            }
        }
        function processStaffDelete(staffId) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url(app()->getLocale() . '/admin/staff') }}/${staffId}`; // Adaptez la route
            const csrfTokenField = document.createElement('input'); csrfTokenField.type = 'hidden'; csrfTokenField.name = '_token'; csrfTokenField.value = '{{ csrf_token() }}'; form.appendChild(csrfTokenField);
            const methodField = document.createElement('input'); methodField.type = 'hidden'; methodField.name = '_method'; methodField.value = 'DELETE'; form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
        function exportStaff() { console.log("Fonction d'exportation du personnel appelée."); /* Implémentez l'export */ }
        function confirmBulkDelete() { /* Implémentez la logique pour la suppression en masse */ console.log('Suppression en masse:', Alpine.$data(document.querySelector('[x-data*="selectedStaff"]')).selectedStaff); alert('Fonction de suppression en masse à implémenter.'); }

        document.addEventListener('DOMContentLoaded', function() { /* ... (Animation des cartes identique) ... */ });
        window.addEventListener('click', function(e) { /* ... (Fermeture dropdown identique) ... */ });
    </script>
@endpush
