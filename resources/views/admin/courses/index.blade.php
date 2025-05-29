@extends('layouts.app')

@section('title', 'Gestion des Cours')

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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Gestion des Cours</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-5 mb-8">
        <!-- En-tête avec titre et bouton d'ajout -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-400 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6m12 6V6a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2z" />
                </svg>
                Gestion des Cours
            </h1>
            <a href="{{ route('admin.courses.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Ajouter un cours
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

        @if(session('error'))
            <div id="alert-error" class="flex p-4 mb-6 text-[#F87171] border-l-4 border-[#F87171] bg-[#FEF2F2] rounded-md fade-in-down" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{ session('error') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-[#FEF2F2] text-[#F87171] rounded-lg p-1.5 hover:bg-[#FEE2E2] inline-flex h-8 w-8" data-dismiss-target="#alert-error" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif


        <!-- Section des statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Statistique 1: Total des cours -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-[#4CA3DD]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6m12 6V6a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Total</span>
                </div>
                <div class="mb-3">
                    <h3 class="text-2xl font-bold text-gray-800">{{ $courses->total() }}</h3>
                    <p class="text-sm text-gray-600">Cours enregistrés</p>
                </div>
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#4CA3DD]" style="width: 100%"></div>
                </div>
            </div>

            <!-- Statistique 2: Cours avec description -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-[#34D399]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Documentés</span>
                </div>
                <div class="mb-3">
                    @php
                        $coursesWithDescription = $courses->filter(function($course) {
                            return !empty($course->description);
                        })->count();
                        $descriptionPercentage = $courses->count() > 0 ? ($coursesWithDescription / $courses->count()) * 100 : 0;
                    @endphp
                    <h3 class="text-2xl font-bold text-gray-800">{{ $coursesWithDescription }}</h3>
                    <p class="text-sm text-gray-600">Cours avec description</p>
                </div>
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#34D399]" style="width: {{ $descriptionPercentage }}%"></div>
                </div>
            </div>

            <!-- Statistique 3: Formations associées -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-[#FBBF24]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-gray-500">Formations</span>
                </div>
                <div class="mb-3">
                    @php
                        // Compter toutes les formations liées aux cours
                        $totalFormations = 0;
                        foreach ($courses as $course) {
                            if ($course->formations) {
                                $totalFormations += $course->formations->count();
                            }
                        }
                    @endphp
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalFormations }}</h3>
                    <p class="text-sm text-gray-600">Formations associées</p>
                </div>
                <div class="h-2 w-full bg-gray-200 rounded-full overflow-hidden">
                    <div class="h-full bg-[#FBBF24]" style="width: 100%"></div>
                </div>
            </div>

            <!-- Statistique 4: Cours créés récemment -->
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
                        $recentCourses = $courses->filter(function($course) use ($thirtyDaysAgo) {
                            return $course->created_at >= $thirtyDaysAgo;
                        })->count();
                        $recentPercentage = $courses->count() > 0 ? ($recentCourses / $courses->count()) * 100 : 0;
                    @endphp
                    <h3 class="text-2xl font-bold text-gray-800">{{ $recentCourses }}</h3>
                    <p class="text-sm text-gray-600">Cours récents (30j)</p>
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
                    <input type="search" id="search-courses" class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-300 rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD]" placeholder="Rechercher un cours...">
                </div>
                <div class="flex flex-wrap items-center gap-4 w-full lg:w-auto">
                    <select id="filter-formation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5">
                        <option value="">Toutes les formations</option>
                        <!-- Options à remplir dynamiquement -->
                    </select>
                    <select id="filter-sort" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] p-2.5">
                        <option value="title-asc">Titre (A-Z)</option>
                        <option value="title-desc">Titre (Z-A)</option>
                        <option value="code-asc">Code (croissant)</option>
                        <option value="code-desc">Code (décroissant)</option>
                        <option value="created-desc">Date de création (récent)</option>
                        <option value="created-asc">Date de création (ancien)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tableau des cours -->
        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Code
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Titre
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Description
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Formations
                    </th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-400">
                        Actions
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($courses as $course)
                    <tr class="hover:bg-gray-100 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                            <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-blue-100 text-blue-800 text-xs font-medium">
                                {{ $course->code }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                            {{ $course->title }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs">
                            <div class="truncate">{{ $course->description ?? '—' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            @if($course->formations && $course->formations->count() > 0)
                                <div class="flex flex-wrap gap-1">
                                    @foreach($course->formations->take(2) as $formation)
                                        <span class="px-2 py-1 inline-flex items-center rounded-full bg-purple-100 text-purple-800 text-xs font-medium">
                                            {{ $formation->name }}
                                        </span>
                                    @endforeach
                                    @if($course->formations->count() > 2)
                                        <span class="px-2 py-1 inline-flex items-center rounded-full bg-gray-100 text-gray-800 text-xs font-medium">
                                            +{{ $course->formations->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('admin.courses.show', ['locale' => app()->getLocale(), 'course' => $course->id]) }}"
                                   class="text-[#4CA3DD] hover:text-[#2A7AB8] dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-150"
                                   title="Voir les détails">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.courses.edit', ['locale' => app()->getLocale(), 'course' => $course->id]) }}"
                                   class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors duration-150"
                                   title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.courses.destroy', ['locale' => app()->getLocale(), 'course' => $course->id]) }}"
                                      method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?');">
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
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6m12 6V6a2 2 0 00-2-2H8a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2z" />
                                </svg>
                                <p class="text-lg font-medium">Aucun cours enregistré</p>
                                <p class="text-sm text-gray-500 mt-1">Commencez par ajouter un cours en utilisant le bouton ci-dessus</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($courses->hasPages())
            <div class="flex flex-col sm:flex-row justify-between items-center mt-6 px-6 py-4 bg-white border-t border-gray-200">
                <div class="pagination-info mb-4 sm:mb-0">
                    Affichage de <span>{{ $courses->firstItem() ?? 0 }}</span> à <span>{{ $courses->lastItem() ?? 0 }}</span> sur <span>{{ $courses->total() }}</span> cours
                </div>
                <div class="pagination-controls">
                    {{ $courses->links() }}
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

            // Filtrage des cours (simulation)
            const searchInput = document.getElementById('search-courses');
            const formationFilter = document.getElementById('filter-formation');
            const sortFilter = document.getElementById('filter-sort');

            // Exemple de traitement des filtres
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    console.log('Recherche:', this.value);
                    // Logique de filtrage à implémenter
                });
            }

            if (formationFilter) {
                formationFilter.addEventListener('change', function() {
                    console.log('Filtre formation:', this.value);
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
