@extends('layouts.app')

@section('title', 'Détails de l\'académie')

@section('content')
    <div class="py-4">
        <!-- Fil d'Ariane -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#4CA3DD]">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Tableau de bord
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('admin.academies.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-[#4CA3DD] md:ml-2">Académies</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-[#4CA3DD] md:ml-2">{{ $academy->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- En-tête avec actions -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold">Détails de l'académie</h1>
                <p class="text-gray-600">Consulter les informations de l'académie "{{ $academy->name }}"</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.academies.edit', ['locale' => app()->getLocale(), 'academy' => $academy->id]) }}"
                   class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4CA3DD] hover:bg-[#2A7AB8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Modifier
                </a>
            </div>
        </div>

        <!-- Carte d'information -->
        <div class="bg-white rounded-md shadow-sm overflow-hidden">
            <!-- En-tête de la carte -->
            <div class="p-4 bg-[#4CA3DD] text-white rounded-t-md">
                <h2 class="text-lg font-medium">Informations de l'académie</h2>
            </div>

            <!-- Contenu de la carte -->
            <div class="p-5">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                    <div class="col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Nom</dt>
                        <dd class="mt-1 text-lg font-medium text-gray-900">{{ $academy->name }}</dd>
                    </div>

                    <div class="col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Code</dt>
                        <dd class="mt-1 text-lg font-medium text-gray-900">{{ $academy->code ?? '—' }}</dd>
                    </div>

                    <div class="col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $academy->description ?? '—' }}</dd>
                    </div>

                    @if($academy->director)
                        <div class="col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Directeur</dt>
                            <dd class="mt-1 text-base text-gray-900">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" 
                                             src="https://ui-avatars.com/api/?name={{ urlencode($academy->director->name) }}&color=7F9CF5&background=EBF4FF" 
                                             alt="{{ $academy->director->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $academy->director->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $academy->director->email }}</div>
                                    </div>
                                </div>
                            </dd>
                        </div>
                    @endif

                    <div class="col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Date de création</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $academy->created_at->format('d/m/Y à H:i') }}</dd>
                    </div>

                    <div class="col-span-1">
                        <dt class="text-sm font-medium text-gray-500">Dernière mise à jour</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $academy->updated_at->format('d/m/Y à H:i') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Boutons d'action en bas -->
        <div class="mt-8 flex justify-between items-center">
            <a href="{{ route('admin.academies.index', ['locale' => app()->getLocale()]) }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <svg class="mr-2 -ml-1 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>
@endsection