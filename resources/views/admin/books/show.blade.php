@extends('layouts.app')

@section('title', 'Détails du Livre')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5 transition-colors duration-300" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-sm font-medium transition-colors duration-300"
                   :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.books.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors duration-300 md:ml-2"
                       :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
                        Catalogue des Livres
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium md:ml-2"
                          :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                        Détails du Livre
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- En-tête avec boutons d'action -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold transition-colors duration-300"
            :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
            Détails du Livre
        </h1>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.books.edit', ['locale' => app()->getLocale(), 'book' => $book->id]) }}"
               class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier
            </a>
            <form action="{{ route('admin.books.destroy', ['locale' => app()->getLocale(), 'book' => $book->id]) }}"
                  method="POST" class="inline-block"
                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre du catalogue?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Supprimer
                </button>
            </form>
            <a href="{{ route('admin.books.index', ['locale' => app()->getLocale()]) }}"
               class="inline-flex items-center justify-center px-4 py-2 border rounded-lg font-medium transition-colors duration-200"
               :class="{
                   'bg-gray-700 border-gray-600 text-white hover:bg-gray-600': darkMode,
                   'bg-white border-gray-300 text-gray-700 hover:bg-gray-50': !darkMode
               }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale - Informations du livre -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Carte principale avec informations du livre -->
            <div class="shadow-md rounded-lg p-6 transition-colors duration-300"
                 :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Image de couverture -->
                    <div class="flex-shrink-0">
                        @if($book->coverImage)
                            <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" class="h-64 w-48 object-cover rounded-lg shadow-md">
                        @else
                            <div class="h-64 w-48 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Informations principales -->
                    <div class="flex-1 space-y-4">
                        <div>
                            <h2 class="text-2xl font-bold mb-2 transition-colors duration-300"
                                :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                                {{ $book->title }}
                            </h2>
                            @if($book->author)
                                <p class="text-lg transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                    par <span class="font-medium">{{ $book->author }}</span>
                                </p>
                            @endif
                        </div>

                        <!-- Statut de disponibilité -->
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $book->availability_color }}">
                                @if($book->quantity > 5)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @elseif($book->quantity > 0)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @endif
                                {{ $book->availability_status }}
                            </span>
                            <span class="ml-3 text-lg font-semibold transition-colors duration-300"
                                  :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                {{ $book->quantity }} {{ $book->quantity > 1 ? 'exemplaires' : 'exemplaire' }}
                            </span>
                        </div>

                        <!-- Métadonnées -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                            @if($book->publisher)
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span class="transition-colors duration-300"
                                          :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                        Éditeur: {{ $book->publisher }}
                                    </span>
                                </div>
                            @endif
                            @if($book->publicationYear)
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="transition-colors duration-300"
                                          :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                        Année: {{ $book->publicationYear }}
                                    </span>
                                </div>
                            @endif
                            @if($book->isbn)
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2M7 4h10M7 4l-2 16h14l-2-16" />
                                    </svg>
                                    <span class="transition-colors duration-300"
                                          :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                        ISBN: {{ $book->isbn }}
                                    </span>
                                </div>
                            @endif
                            @if($book->nb_pages)
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="transition-colors duration-300"
                                          :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                        {{ $book->nb_pages }} pages
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Catégorie et Langue -->
                        <div class="flex flex-wrap gap-2">
                            @if($book->category)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $book->category }}
                                </span>
                            @endif
                            @if($book->lang)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $book->lang === 'FR' ? 'Français' : ($book->lang === 'EN' ? 'Anglais' : $book->lang) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($book->description)
                <div class="shadow-md rounded-lg p-6 transition-colors duration-300"
                     :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
                    <h3 class="text-lg font-semibold mb-4 transition-colors duration-300"
                        :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                        Description
                    </h3>
                    <div class="prose max-w-none transition-colors duration-300"
                         :class="{ 'prose-invert': darkMode }">
                        <p class="transition-colors duration-300"
                           :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                            {{ $book->description }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Formations associées -->
            @if($book->formations->count() > 0)
                <div class="shadow-md rounded-lg p-6 transition-colors duration-300"
                     :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
                    <h3 class="text-lg font-semibold mb-4 transition-colors duration-300"
                        :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                        Formations associées
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($book->formations as $formation)
                            <div class="flex items-center p-3 rounded-lg border transition-colors duration-300"
                                 :class="{ 'bg-gray-700 border-gray-600': darkMode, 'bg-gray-50 border-gray-200': !darkMode }">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <span class="text-sm font-medium transition-colors duration-300"
                                      :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    {{ $formation->name }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar - Informations complémentaires -->
        <div class="space-y-6">
            <!-- Statistiques du livre -->
            <div class="shadow-md rounded-lg p-6 transition-colors duration-300"
                 :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
                <h3 class="text-lg font-semibold mb-4 transition-colors duration-300"
                    :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                    Informations
                </h3>
                <div class="space-y-4">
                    <!-- Stock -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm transition-colors duration-300"
                              :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                            Stock actuel
                        </span>
                        <span class="font-semibold text-lg transition-colors duration-300"
                              :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                            {{ $book->quantity }}
                        </span>
                    </div>

                    <!-- Statut -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm transition-colors duration-300"
                              :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                            Statut
                        </span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $book->availability_color }}">
                            {{ $book->availability_status }}
                        </span>
                    </div>

                    <!-- Date d'ajout -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm transition-colors duration-300"
                              :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                            Ajouté le
                        </span>
                        <span class="text-sm font-medium transition-colors duration-300"
                              :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                            {{ $book->created_at->format('d/m/Y') }}
                        </span>
                    </div>

                    <!-- Dernière modification -->
                    <div class="flex justify-between items-center">
                        <span class="text-sm transition-colors duration-300"
                              :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                            Modifié le
                        </span>
                        <span class="text-sm font-medium transition-colors duration-300"
                              :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                            {{ $book->updated_at->format('d/m/Y') }}
                        </span>
                    </div>

                    @if($book->formations->count() > 0)
                        <div class="flex justify-between items-center">
                            <span class="text-sm transition-colors duration-300"
                                  :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                Formations
                            </span>
                            <span class="text-sm font-medium transition-colors duration-300"
                                  :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                {{ $book->formations->count() }} associée(s)
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="shadow-md rounded-lg p-6 transition-colors duration-300"
                 :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
                <h3 class="text-lg font-semibold mb-4 transition-colors duration-300"
                    :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                    Actions rapides
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.books.edit', ['locale' => app()->getLocale(), 'book' => $book->id]) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier le livre
                    </a>

                    <button onclick="window.print()"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border rounded-lg font-medium transition-colors duration-200"
                            :class="{
                                'bg-gray-700 border-gray-600 text-white hover:bg-gray-600': darkMode,
                                'bg-white border-gray-300 text-gray-700 hover:bg-gray-50': !darkMode
                            }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Imprimer la fiche
                    </button>

                    <form action="{{ route('admin.books.destroy', ['locale' => app()->getLocale(), 'book' => $book->id]) }}"
                          method="POST"
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce livre du catalogue?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer du catalogue
                        </button>
                    </form>
                </div>
            </div>

            <!-- Navigation vers d'autres livres -->
            <div class="shadow-md rounded-lg p-6 transition-colors duration-300"
                 :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
                <h3 class="text-lg font-semibold mb-4 transition-colors duration-300"
                    :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                    Navigation
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.books.index', ['locale' => app()->getLocale()]) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Voir tous les livres
                    </a>

                    <a href="{{ route('admin.books.create', ['locale' => app()->getLocale()]) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 border rounded-lg font-medium transition-colors duration-200"
                       :class="{
                           'bg-gray-700 border-gray-600 text-white hover:bg-gray-600': darkMode,
                           'bg-white border-gray-300 text-gray-700 hover:bg-gray-50': !darkMode
                       }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Ajouter un nouveau livre
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {
            .no-print, nav, .flex.flex-col.sm\\:flex-row.justify-between {
                display: none !important;
            }

            body {
                background: white !important;
                color: black !important;
            }

            .bg-gray-800, .bg-white {
                background: white !important;
                border: 1px solid #e5e7eb !important;
            }

            .text-white, .text-gray-800, .text-gray-700, .text-gray-300 {
                color: black !important;
            }
        }
    </style>
@endpush
