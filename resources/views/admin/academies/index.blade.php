@extends('layouts.app')

@section('title', 'Gestion des Académies')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5 text-sm" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-gray-600 hover:text-[#4CA3DD]">
                    <i class="fas fa-home mr-2"></i> Accueil
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2 text-xs"></i>
                    <span class="text-[#4CA3DD] font-medium">Académies</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- En-tête de page -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
            <h1 class="text-2xl font-bold text-gray-800 mb-3 md:mb-0">
                <i class="fas fa-university text-[#4CA3DD] mr-2"></i>Gestion des Académies
            </h1>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.academies.create', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] text-white rounded-md hover:bg-[#2A7AB8] transition-all shadow">
                    <i class="fas fa-plus mr-2"></i> Ajouter une académie
                </a>
            </div>
        </div>

        <p class="text-gray-600 mb-6">Gérez les académies, leurs informations et leurs paramètres.</p>
    </div>

    <!-- Section des statistiques -->
    <div class="stats-container grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="stats-card bg-white rounded-lg p-4 shadow border border-gray-200 flex flex-col">
            <div class="flex items-center justify-between mb-3">
                <div class="stats-icon primary bg-blue-100 text-[#4CA3DD] p-3 rounded-full">
                    <i class="fas fa-university"></i>
                </div>
                <span class="text-sm text-gray-500">Total</span>
            </div>
            <div class="stats-content">
                <h3 class="stats-value text-2xl font-bold text-gray-800">{{ $academies->total() ?? count($academies) }}</h3>
                <p class="stats-label text-sm text-gray-600">Académies</p>
            </div>
            <div class="stats-trend mt-3">
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="progress-bar h-full bg-[#4CA3DD]" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- <div class="stats-card bg-white rounded-lg p-4 shadow border border-gray-200 flex flex-col">
            <div class="flex items-center justify-between mb-3">
                <div class="stats-icon success bg-green-100 text-green-600 p-3 rounded-full">
                    <i class="fas fa-check-circle"></i>
                </div>
                <span class="text-sm text-gray-500">Actives</span>
            </div>
            <div class="stats-content">
                <h3 class="stats-value text-2xl font-bold text-gray-800">{{ $academies->where('is_active', true)->count() }}</h3>
                <p class="stats-label text-sm text-gray-600">Académies actives</p>
            </div>
            <div class="stats-trend mt-3">
                @php
                    $activePercentage = ($academies->total() > 0) ? ($academies->where('is_active', true)->count() / $academies->total()) * 100 : 0;
                @endphp
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="progress-bar h-full bg-green-500" style="width: {{ $activePercentage }}%"></div>
                </div>
            </div>
        </div> -->

        <!-- <div class="stats-card bg-white rounded-lg p-4 shadow border border-gray-200 flex flex-col">
            <div class="flex items-center justify-between mb-3">
                <div class="stats-icon warning bg-blue-100 text-blue-600 p-3 rounded-full">
                    <i class="fas fa-language"></i>
                </div>
                <span class="text-sm text-gray-500">Françaises</span>
            </div>
            <div class="stats-content">
                <h3 class="stats-value text-2xl font-bold text-gray-800">{{ $academies->where('lang', 'FR')->count() }}</h3>
                <p class="stats-label text-sm text-gray-600">Académies francophones</p>
            </div>
            <div class="stats-trend mt-3">
                @php
                    $frPercentage = ($academies->total() > 0) ? ($academies->where('lang', 'FR')->count() / $academies->total()) * 100 : 0;
                @endphp
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="progress-bar h-full bg-blue-500" style="width: {{ $frPercentage }}%"></div>
                </div>
            </div> -->
        <!-- </div>

        <div class="stats-card bg-white rounded-lg p-4 shadow border border-gray-200 flex flex-col">
            <div class="flex items-center justify-between mb-3">
                <div class="stats-icon info bg-red-100 text-red-600 p-3 rounded-full">
                    <i class="fas fa-globe-americas"></i>
                </div>
                <span class="text-sm text-gray-500">Anglaises</span>
            </div>
            <div class="stats-content">
                <h3 class="stats-value text-2xl font-bold text-gray-800">{{ $academies->where('lang', 'EN')->count() }}</h3>
                <p class="stats-label text-sm text-gray-600">Académies anglophones</p>
            </div>
            <div class="stats-trend mt-3">
                @php
                    $enPercentage = ($academies->total() > 0) ? ($academies->where('lang', 'EN')->count() / $academies->total()) * 100 : 0;
                @endphp
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="progress-bar h-full bg-red-500" style="width: {{ $enPercentage }}%"></div>
                </div>
            </div>
        </div> -->
    </div>

    <!-- Barre de recherche et filtres -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow">
        <div class="flex flex-col md:flex-row md:items-end gap-4">
            <div class="flex-grow">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Rechercher</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="search" name="search"
                           class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD]"
                           placeholder="Rechercher une académie...">
                </div>
            </div>
            <div>
                <label for="language-filter" class="block text-sm font-medium text-gray-700 mb-1">Langue</label>
                <select id="language-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-[#4CA3DD] focus:border-[#4CA3DD]">
                    <option value="all">Toutes les langues</option>
                    <option value="FR">Français</option>
                    <option value="EN">Anglais</option>
                </select>
            </div>
            <div>
                <button type="button" id="reset-filters" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    <i class="fas fa-redo-alt mr-1"></i> Réinitialiser
                </button>
            </div>
        </div>
    </div>

    <!-- Messages de succès ou d'erreur -->
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm flex items-start" role="alert">
            <i class="fas fa-check-circle text-green-500 mt-0.5 mr-3 text-lg"></i>
            <div>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
            <button class="ml-auto text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm flex items-start" role="alert">
            <i class="fas fa-exclamation-circle text-red-500 mt-0.5 mr-3 text-lg"></i>
            <div>
                <p class="font-medium">{{ session('error') }}</p>
            </div>
            <button class="ml-auto text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Liste des académies - Version desktop -->
    <div class="bg-white rounded-lg shadow overflow-hidden hidden md:block">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center">
                        Nom de l'académie
                        <button class="ml-1 text-gray-400 hover:text-[#4CA3DD]">
                            <i class="fas fa-sort"></i>
                        </button>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Description
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center">
                        Langue
                        <button class="ml-1 text-gray-400 hover:text-[#4CA3DD]">
                            <i class="fas fa-sort"></i>
                        </button>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    <div class="flex items-center">
                        Date de création
                        <button class="ml-1 text-gray-400 hover:text-[#4CA3DD]">
                            <i class="fas fa-sort"></i>
                        </button>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($academies as $academy)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-[#4CA3DD]/10 text-[#4CA3DD]">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $academy->name }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    Code: {{ $academy->code ?? 'Non défini' }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-500 max-w-xs overflow-hidden text-ellipsis">
                            {{ Str::limit($academy->description, 50) ?? '—' }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($academy->lang === 'FR')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Français
                                </span>
                        @elseif($academy->lang === 'EN')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Anglais
                                </span>
                        @else
                            <span class="text-gray-500">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex items-center">
                            <i class="far fa-calendar-alt mr-2 text-gray-400"></i>
                            {{ $academy->created_at->format('d/m/Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.academies.show', ['locale' => app()->getLocale(), 'academy' => $academy]) }}"
                               class="text-[#4CA3DD] hover:text-[#2A7AB8] bg-[#4CA3DD]/10 p-2 rounded-full" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.academies.edit', ['locale' => app()->getLocale(), 'academy' => $academy]) }}"
                               class="text-amber-600 hover:text-amber-800 bg-amber-100 p-2 rounded-full" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.academies.destroy', ['locale' => app()->getLocale(), 'academy' => $academy]) }}"
                                  method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 bg-red-100 p-2 rounded-full" title="Supprimer"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette académie ?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 whitespace-nowrap text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center">
                            <div class="bg-gray-100 rounded-full p-4 mb-4">
                                <i class="fas fa-university text-gray-400 text-5xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune académie</h3>
                            <p class="text-gray-500 mb-4">Vous n'avez pas encore enregistré d'académie.</p>
                            <a href="{{ route('admin.academies.create', ['locale' => app()->getLocale()]) }}"
                               class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] text-white rounded-md hover:bg-[#2A7AB8] transition-all shadow">
                                <i class="fas fa-plus mr-2"></i> Créer une académie
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- Pagination améliorée -->
        @if($academies->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 px-6 py-4 bg-white border-t border-gray-200">
                <div class="pagination-info mb-4 sm:mb-0">
                    Affichage de <span>{{ $academies->firstItem() ?? 0 }}</span> à <span>{{ $academies->lastItem() ?? 0 }}</span> sur <span>{{ $academies->total() }}</span> académies
                </div>
                <div class="pagination-controls">
                    {{ $academies->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        @endif
    </div>

    <!-- Liste des académies - Version mobile -->
    <div class="block md:hidden space-y-4">
        @forelse ($academies as $academy)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-[#4CA3DD]/10 text-[#4CA3DD]">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-900">{{ $academy->name }}</h3>
                                <p class="text-xs text-gray-500">Code: {{ $academy->code ?? 'Non défini' }}</p>
                            </div>
                        </div>
                        @if($academy->lang === 'FR')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                FR
                            </span>
                        @elseif($academy->lang === 'EN')
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                EN
                            </span>
                        @endif
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-xs">
                    <div class="grid grid-cols-1">
                        <div class="mb-2">
                            <span class="font-medium text-gray-500">Description:</span>
                            <span class="ml-2 text-gray-900">{{ Str::limit($academy->description, 50) ?? '—' }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-medium text-gray-500">Date de création:</span>
                            <span class="ml-2 text-gray-900">{{ $academy->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 border-t border-gray-200 flex justify-between">
                    <a href="{{ route('admin.academies.show', ['locale' => app()->getLocale(), 'academy' => $academy]) }}"
                       class="inline-flex items-center px-3 py-1 bg-[#4CA3DD]/10 text-[#4CA3DD] rounded-md">
                        <i class="fas fa-eye mr-1 text-xs"></i> Voir
                    </a>
                    <a href="{{ route('admin.academies.edit', ['locale' => app()->getLocale(), 'academy' => $academy]) }}"
                       class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-600 rounded-md">
                        <i class="fas fa-edit mr-1 text-xs"></i> Modifier
                    </a>
                    <form action="{{ route('admin.academies.destroy', ['locale' => app()->getLocale(), 'academy' => $academy]) }}"
                          method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-3 py-1 bg-red-100 text-red-600 rounded-md"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette académie ?')">
                            <i class="fas fa-trash mr-1 text-xs"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <div class="flex flex-col items-center justify-center">
                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                        <i class="fas fa-university text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune académie</h3>
                    <p class="text-gray-500 mb-4">Vous n'avez pas encore enregistré d'académie.</p>
                    <a href="{{ route('admin.academies.create', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] text-white rounded-md hover:bg-[#2A7AB8] transition-all shadow">
                        <i class="fas fa-plus mr-2"></i> Créer une académie
                    </a>
                </div>
            </div>
        @endforelse

        <!-- Pagination pour mobile -->
        @if($academies->hasPages())
            <div class="bg-white rounded-lg shadow p-4 my-4">
                {{ $academies->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>

    <!-- Styles pour la pagination -->
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

    <!-- Script pour la fonctionnalité de recherche et tri -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Implémentation de la recherche en temps réel
                const searchInput = document.getElementById('search');
                const rows = document.querySelectorAll('tbody tr');
                const cards = document.querySelectorAll('.block.md\\:hidden > div');

                searchInput.addEventListener('keyup', function() {
                    const searchText = this.value.toLowerCase();

                    // Filtrer les lignes du tableau (desktop)
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        if (text.includes(searchText)) {
                            row.classList.remove('hidden');
                        } else {
                            row.classList.add('hidden');
                        }
                    });

                    // Filtrer les cartes (mobile)
                    cards.forEach(card => {
                        const text = card.textContent.toLowerCase();
                        if (text.includes(searchText)) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                });

                // Réinitialisation des filtres
                document.getElementById('reset-filters').addEventListener('click', function() {
                    searchInput.value = '';
                    document.getElementById('language-filter').value = 'all';

                    // Réinitialiser l'affichage
                    rows.forEach(row => row.classList.remove('hidden'));
                    cards.forEach(card => card.classList.remove('hidden'));
                });

                // Filtrage par langue
                document.getElementById('language-filter').addEventListener('change', function() {
                    const lang = this.value;

                    if (lang === 'all') {
                        rows.forEach(row => row.classList.remove('hidden'));
                        cards.forEach(card => card.classList.remove('hidden'));
                        return;
                    }

                    // Filtrer les lignes du tableau (desktop)
                    rows.forEach(row => {
                        const hasLang = row.textContent.includes(lang === 'FR' ? 'Français' : 'Anglais');
                        if (hasLang) {
                            row.classList.remove('hidden');
                        } else {
                            row.classList.add('hidden');
                        }
                    });

                    // Filtrer les cartes (mobile)
                    cards.forEach(card => {
                        const hasLang = card.textContent.includes(lang);
                        if (hasLang) {
                            card.classList.remove('hidden');
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                });

                // Auto-dismiss pour les alertes
                const alerts = document.querySelectorAll('[role="alert"]');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        alert.classList.add('opacity-0', 'transform', 'translate-y-[-10px]', 'transition-all', 'duration-500');
                        setTimeout(() => {
                            alert.remove();
                        }, 500);
                    }, 5000);
                });
            });
        </script>
    @endpush
@endsection
