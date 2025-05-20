@extends('layouts.app')

@section('title', 'Détail du Centre')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li class="inline-flex items-center">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Gestion des Centres</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm text-[#4CA3DD] font-medium md:ml-2 dark:text-gray-400">{{ $center->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-5 mb-8">
        <!-- En-tête avec titre et boutons d'action -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                {{ $center->name }}
            </h1>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Retour à la liste
                </a>
                <a href="{{ route('admin.centers.edit', ['locale' => app()->getLocale(), 'center' => $center->id]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
                <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'center_id' => $center->id]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Voir le planning
                </a>
            </div>
        </div>

        <!-- Message de succès (si présent) -->
        @if(session('success'))
            <div id="alert-success" class="flex items-center p-4 mb-6 text-green-800 border-l-4 border-green-500 bg-green-50" role="alert">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-success" aria-label="Close">
                    <span class="sr-only">Fermer</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Contenu principal divisé en sections -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Informations principales -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                        <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Informations générales
                        </h2>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <p class="mb-3">
                                    <span class="text-sm font-medium text-gray-500 block mb-1">Nom du centre</span>
                                    <span class="text-base text-gray-800">{{ $center->name }}</span>
                                </p>
                                <p class="mb-3">
                                    <span class="text-sm font-medium text-gray-500 block mb-1">Code</span>
                                    <span class="text-base text-gray-800">{{ $center->code ?? '—' }}</span>
                                </p>
                                <p class="mb-3">
                                    <span class="text-sm font-medium text-gray-500 block mb-1">Académie</span>
                                    <span class="text-base text-gray-800">{{ $center->academy->name ?? '—' }}</span>
                                </p>
                                <p class="mb-3">
                                    <span class="text-sm font-medium text-gray-500 block mb-1">Nombre d'étudiants</span>
                                    <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-blue-200 text-blue-800 text-xs font-medium">
                                        {{ $center->nb_students }}
                                    </span>
                                </p>
                            </div>
                            <div class="flex flex-col">
                                <p class="mb-3">
                                    <span class="text-sm font-medium text-gray-500 block mb-1">Statut</span>
                                    @if($center->is_active)
                                        <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-green-200 text-green-800 text-xs font-medium">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Actif
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 inline-flex items-center rounded-full bg-red-200 text-red-800 text-xs font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Inactif
                                        </span>
                                    @endif
                                </p>
                                <p class="mb-3">
                                    <span class="text-sm font-medium text-gray-500 block mb-1">Créé le</span>
                                    <span class="text-base text-gray-800">{{ $center->created_at->format('d/m/Y') }}</span>
                                </p>
                                <p class="mb-3">
                                    <span class="text-sm font-medium text-gray-500 block mb-1">Dernière mise à jour</span>
                                    <span class="text-base text-gray-800">{{ $center->updated_at->format('d/m/Y') }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <span class="text-sm font-medium text-gray-500 block mb-1">Description</span>
                            <div class="p-3 bg-gray-50 rounded-md border border-gray-200">
                                <p class="text-base text-gray-800">{{ $center->description ?? 'Aucune description disponible' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact et adresse -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm mt-6">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                        <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Contact et localisation
                        </h2>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex flex-col">
                                <p class="mb-3">
                                    <span class="text-sm font-medium text-gray-500 block mb-1">Email de contact</span>
                                    @if($center->contact_email)
                                        <a href="mailto:{{ $center->contact_email }}" class="text-base text-blue-600 hover:underline">
                                            {{ $center->contact_email }}
                                        </a>
                                    @else
                                        <span class="text-base text-gray-500">—</span>
                                    @endif
                                </p>
                                <p class="mb-3">
                                    <span class="text-sm font-medium text-gray-500 block mb-1">Téléphone de contact</span>
                                    @if($center->contact_phone)
                                        <a href="tel:{{ $center->contact_phone }}" class="text-base text-blue-600 hover:underline">
                                            {{ $center->contact_phone }}
                                        </a>
                                    @else
                                        <span class="text-base text-gray-500">—</span>
                                    @endif
                                </p>
                            </div>
                            <div class="flex flex-col">
                                <p class="mb-3">
                                    <span class="text-sm font-medium text-gray-500 block mb-1">Adresse</span>
                                    <span class="text-base text-gray-800">{{ $center->address ?? '—' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Directeur et informations complémentaires -->
            <div class="lg:col-span-1">
                @if($center->director)
                    <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                            <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Directeur
                            </h2>
                        </div>
                        <div class="p-4">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mb-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800">{{ $center->director->first_name ?? '' }} {{ $center->director->last_name ?? '' }}</h3>
                                <p class="text-sm text-gray-500">Directeur du centre</p>

                                @if($center->director->email ?? false)
                                    <a href="mailto:{{ $center->director->email }}" class="mt-3 inline-flex items-center text-sm text-blue-600 hover:underline">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Contacter par email
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions rapides -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                        <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Actions rapides
                        </h2>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            <a href="{{ route('admin.timetables.index', ['locale' => app()->getLocale(), 'center_id' => $center->id]) }}" class="flex items-center p-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="flex-1">Planning du centre</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.centers.edit', ['locale' => app()->getLocale(), 'center' => $center->id]) }}" class="flex items-center p-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span class="flex-1">Modifier le centre</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                            <form action="{{ route('admin.centers.destroy', ['locale' => app()->getLocale(), 'center' => $center->id]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce centre? Cette action est irréversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full flex items-center p-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 hover:bg-red-50 hover:text-red-700 hover:border-red-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span class="flex-1">Supprimer le centre</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-dismiss pour les alertes
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('[id^="alert-"]');

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
