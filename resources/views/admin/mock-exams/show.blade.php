@extends('layouts.app')

@section('title', 'Détails du Concours Blanc')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center text-sm font-medium transition-colors"
                   :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
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
                    <a href="{{ route('admin.mock-exams.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors"
                       :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
                        Concours Blancs
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Concours #{{ $mockExam->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    @can('gestion.exam.read')
        <div class="max-w-7xl mx-auto">
            <!-- En-tête avec titre et actions -->
            <div class="mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-16 w-16 rounded-full flex items-center justify-center mr-4 transition-colors
                                    @if($mockExam->type == 'QCM') text-green-500 @elseif($mockExam->type == 'REDACTION') text-yellow-500 @else text-purple-500 @endif"
                             :class="darkMode ? '@if($mockExam->type == 'QCM') bg-green-900/30 @elseif($mockExam->type == 'REDACTION') bg-yellow-900/30 @else bg-purple-900/30 @endif' : '@if($mockExam->type == 'QCM') bg-green-50 @elseif($mockExam->type == 'REDACTION') bg-yellow-50 @else bg-purple-50 @endif'">
                            @if($mockExam->type == 'QCM')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            @elseif($mockExam->type == 'REDACTION')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.871 4A17.926 17.926 0 003 12c0 2.874.673 5.59 1.871 8m14.13 0a17.926 17.926 0 001.87-8c0-2.874-.673-5.59-1.87-8M9 9h1.246a1 1 0 01.961 1.243l-1.4 6C9.612 17.001 10.763 18 12.054 18h4.657a1 1 0 01.961 1.243l-1.687 7.5" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                                Concours Blanc #{{ $mockExam->id }}
                            </h1>
                            <p class="text-lg transition-colors mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                <span class="px-3 py-1 text-sm font-semibold rounded-full
                                      @if($mockExam->type == 'QCM') bg-green-100 text-green-800
                                      @elseif($mockExam->type == 'REDACTION') bg-yellow-100 text-yellow-800
                                      @else bg-purple-100 text-purple-800 @endif">
                                    {{ $mockExam->type }}
                                </span>
                                <span class="ml-2">{{ $mockExam->formation->name ?? 'Formation non spécifiée' }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @can('gestion.exam.update')
                            <a href="{{ route('admin.mock-exams.edit', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}"
                               class="inline-flex items-center justify-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Modifier
                            </a>
                        @endcan
                        @can('gestion.exam.delete')
                            <form action="{{ route('admin.mock-exams.destroy', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}"
                                  method="POST"
                                  class="inline-block"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce concours blanc ? Cette action est irréversible.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Supprimer
                                </button>
                            </form>
                        @endcan
                        <a href="{{ route('admin.mock-exams.index', ['locale' => app()->getLocale()]) }}"
                           class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-200 hover:bg-gray-50"
                           :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Retour
                        </a>
                    </div>
                </div>
            </div>

            <!-- Messages d'alerte -->
            <x-flash-message />

            <!-- Cartes d'informations principales -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Carte Date et Heure -->
                <div class="rounded-lg p-6 shadow-md transition-all duration-300 hover:shadow-lg"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-blue-500 mr-4"
                             :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Date & Heure
                        </h3>
                    </div>
                    <div class="space-y-2">
                        <p class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">
                            {{ $mockExam->date->format('d/m/Y') }}
                        </p>
                        <p class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            {{ $mockExam->date->format('H:i') }} - {{ $mockExam->date->format('l') }}
                        </p>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-500' : 'text-gray-500'">
                            {{ $mockExam->date->diffForHumans() }}
                        </p>
                    </div>
                </div>

                <!-- Carte Durée -->
                <div class="rounded-lg p-6 shadow-md transition-all duration-300 hover:shadow-lg"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-green-500 mr-4"
                             :class="darkMode ? 'bg-green-900/30' : 'bg-green-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Durée
                        </h3>
                    </div>
                    <div class="space-y-2">
                        <p class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">
                            {{ $mockExam->duration }} min
                        </p>
                        <p class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            @if($mockExam->duration >= 60)
                                {{ floor($mockExam->duration / 60) }}h {{ $mockExam->duration % 60 }}min
                            @else
                                {{ $mockExam->duration }} minutes
                            @endif
                        </p>
                        <div class="w-full bg-gray-200 rounded-full h-2" :class="darkMode ? 'bg-gray-600' : 'bg-gray-200'">
                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ min(($mockExam->duration / 180) * 100, 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Carte Type d'Examen -->
                <div class="rounded-lg p-6 shadow-md transition-all duration-300 hover:shadow-lg"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-purple-500 mr-4"
                             :class="darkMode ? 'bg-purple-900/30' : 'bg-purple-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Type d'Examen
                        </h3>
                    </div>
                    <div class="space-y-2">
                        <p class="text-2xl font-bold transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">
                            {{ $mockExam->type }}
                        </p>
                        <p class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            @if($mockExam->type == 'QCM')
                                Questions à choix multiples
                            @elseif($mockExam->type == 'REDACTION')
                                Épreuves de rédaction
                            @else
                                QCM et rédaction combinés
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section Formation et Cours -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Carte Formation -->
                <div class="rounded-lg p-6 shadow-md transition-all duration-300 hover:shadow-lg"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-indigo-500 mr-4"
                             :class="darkMode ? 'bg-indigo-900/30' : 'bg-indigo-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Formation
                        </h3>
                    </div>
                    @if($mockExam->formation)
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-lg font-medium transition-colors mb-2" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    {{ $mockExam->formation->name }}
                                </h4>
                                @if($mockExam->formation->description)
                                    <p class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                        {{ $mockExam->formation->description }}
                                    </p>
                                @endif
                            </div>
                            @if($mockExam->formation->hours || $mockExam->formation->price)
                                <div class="flex flex-wrap gap-4 pt-4 border-t" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                                    @if($mockExam->formation->hours)
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                                {{ $mockExam->formation->hours }}h
                                            </span>
                                        </div>
                                    @endif
                                    @if($mockExam->formation->price)
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                            </svg>
                                            <span class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                                {{ number_format($mockExam->formation->price) }} FCFA
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Aucune formation associée
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Carte Cours Associés -->
                <div class="rounded-lg p-6 shadow-md transition-all duration-300 hover:shadow-lg"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-orange-500 mr-4"
                             :class="darkMode ? 'bg-orange-900/30' : 'bg-orange-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                                Cours Associés
                            </h3>
                            <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                {{ $mockExam->courses->count() }} cours
                            </p>
                        </div>
                    </div>
                    @if($mockExam->courses->count())
                        <div class="space-y-3 max-h-64 overflow-y-auto">
                            @foreach($mockExam->courses as $index => $course)
                                <div class="flex items-center p-3 rounded-lg border transition-all duration-200 hover:shadow-sm"
                                     :class="darkMode ? 'border-gray-600 hover:border-gray-500 bg-[#2C3E50]/50' : 'border-gray-200 hover:border-gray-300 bg-gray-50/50'">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white mr-3"
                                         style="background-color: {{ sprintf('#%06X', mt_rand(0, 0xFFFFFF)) }}">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium transition-colors truncate" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                            {{ $course->title }}
                                        </h4>
                                        @if($course->code)
                                            <p class="text-xs transition-colors mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                Code: {{ $course->code }}
                                            </p>
                                        @endif
                                        @if($course->description)
                                            <p class="text-xs transition-colors mt-1 line-clamp-2" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                                {{ Str::limit($course->description, 80) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <p class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Aucun cours associé à ce concours
                            </p>
                            <p class="text-sm transition-colors mt-2" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                Les cours peuvent être ajoutés lors de la modification
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section Informations Supplémentaires -->
            <div class="rounded-lg p-6 shadow-md mb-8 transition-all duration-300 hover:shadow-lg"
                 :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-teal-500 mr-4"
                         :class="darkMode ? 'bg-teal-900/30' : 'bg-teal-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                        Informations Supplémentaires
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Statut du Concours -->
                    <div class="text-center p-4 rounded-lg border transition-colors"
                         :class="darkMode ? 'border-gray-600 bg-[#2C3E50]/30' : 'border-gray-200 bg-gray-50/50'">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full flex items-center justify-center
                                    @if($mockExam->date->isPast()) text-red-500 @elseif($mockExam->date->isToday()) text-yellow-500 @else text-green-500 @endif"
                             :class="darkMode ? '@if($mockExam->date->isPast()) bg-red-900/30 @elseif($mockExam->date->isToday()) bg-yellow-900/30 @else bg-green-900/30 @endif' : '@if($mockExam->date->isPast()) bg-red-100 @elseif($mockExam->date->isToday()) bg-yellow-100 @else bg-green-100 @endif'">
                            @if($mockExam->date->isPast())
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @elseif($mockExam->date->isToday())
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                        <h4 class="font-semibold mb-2 transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">
                            Statut
                        </h4>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            @if($mockExam->date->isPast())
                                Terminé
                            @elseif($mockExam->date->isToday())
                                Aujourd'hui
                            @else
                                À venir
                            @endif
                        </p>
                    </div>

                    <!-- Date de Création -->
                    <div class="text-center p-4 rounded-lg border transition-colors"
                         :class="darkMode ? 'border-gray-600 bg-[#2C3E50]/30' : 'border-gray-200 bg-gray-50/50'">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full flex items-center justify-center text-blue-500"
                             :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2 transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">
                            Créé le
                        </h4>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            {{ $mockExam->created_at->format('d/m/Y à H:i') }}
                        </p>
                        <p class="text-xs transition-colors mt-1" :class="darkMode ? 'text-gray-500' : 'text-gray-500'">
                            {{ $mockExam->created_at->diffForHumans() }}
                        </p>
                    </div>

                    <!-- Dernière Modification -->
                    <div class="text-center p-4 rounded-lg border transition-colors"
                         :class="darkMode ? 'border-gray-600 bg-[#2C3E50]/30' : 'border-gray-200 bg-gray-50/50'">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-full flex items-center justify-center text-purple-500"
                             :class="darkMode ? 'bg-purple-900/30' : 'bg-purple-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <h4 class="font-semibold mb-2 transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">
                            Modifié le
                        </h4>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            {{ $mockExam->updated_at->format('d/m/Y à H:i') }}
                        </p>
                        <p class="text-xs transition-colors mt-1" :class="darkMode ? 'text-gray-500' : 'text-gray-500'">
                            {{ $mockExam->updated_at->diffForHumans() }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section Actions Rapides -->
            @canany(['gestion.exam.update', 'gestion.exam.create'])
                <div class="rounded-lg p-6 shadow-md mb-8 transition-all duration-300 hover:shadow-lg"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-indigo-500 mr-4"
                             :class="darkMode ? 'bg-indigo-900/30' : 'bg-indigo-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Actions Rapides
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @can('gestion.exam.create')
                            <a href="{{ route('admin.mock-exams.create', ['locale' => app()->getLocale()]) }}"
                               class="flex items-center p-4 rounded-lg border transition-all duration-200 hover:shadow-md hover:scale-105"
                               :class="darkMode ? 'border-gray-600 hover:border-blue-500 bg-[#2C3E50]/30' : 'border-gray-200 hover:border-blue-500 bg-blue-50/50'">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-blue-500 mr-3"
                                     :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-100'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        Nouveau Concours
                                    </h4>
                                    <p class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                        Créer un nouveau concours blanc
                                    </p>
                                </div>
                            </a>
                        @endcan

                        @can('gestion.exam.update')
                            <a href="{{ route('admin.mock-exams.edit', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}"
                               class="flex items-center p-4 rounded-lg border transition-all duration-200 hover:shadow-md hover:scale-105"
                               :class="darkMode ? 'border-gray-600 hover:border-yellow-500 bg-[#2C3E50]/30' : 'border-gray-200 hover:border-yellow-500 bg-yellow-50/50'">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-yellow-500 mr-3"
                                     :class="darkMode ? 'bg-yellow-900/30' : 'bg-yellow-100'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-medium transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                        Modifier
                                    </h4>
                                    <p class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                        Éditer ce concours blanc
                                    </p>
                                </div>
                            </a>
                        @endcan

                        <a href="{{ route('admin.mock-exams.index', ['locale' => app()->getLocale()]) }}"
                           class="flex items-center p-4 rounded-lg border transition-all duration-200 hover:shadow-md hover:scale-105"
                           :class="darkMode ? 'border-gray-600 hover:border-gray-500 bg-[#2C3E50]/30' : 'border-gray-200 hover:border-gray-500 bg-gray-50/50'">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 mr-3"
                                 :class="darkMode ? 'bg-gray-700/30' : 'bg-gray-100'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-medium transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    Liste Complète
                                </h4>
                                <p class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                    Voir tous les concours blancs
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            @endcanany
        </div>
    @else
        <!-- Message d'accès refusé -->
        <div class="max-w-2xl mx-auto p-8 text-center rounded-lg border transition-colors"
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
                    Vous n'avez pas les permissions nécessaires pour consulter les détails de ce concours blanc.
                </p>
                <div class="flex flex-wrap gap-3 justify-center">
                    <a href="{{ route('admin.mock-exams.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Liste des Concours
                    </a>
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-200 hover:bg-gray-50"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Tableau de bord
                    </a>
                </div>
            </div>
        </div>
    @endcan
@endsection

@push('styles')
    <style>
        /* Animations personnalisées */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .slide-in-up {
            animation: slideInUp 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

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

        /* Style pour la limitation de lignes */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Amélioration du hover des cartes */
        .hover-lift:hover {
            transform: translateY(-4px);
            transition: all 0.3s ease;
        }

        /* Style pour les badges de statut */
        .status-badge {
            transition: all 0.2s ease-in-out;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        /* Scroll personnalisé pour la liste des cours */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Dark mode pour le scroll */
        [x-data].dark .custom-scrollbar::-webkit-scrollbar-track {
            background: #374151;
        }

        [x-data].dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #6B7280;
        }

        [x-data].dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }

        /* Animation de progression */
        .progress-bar {
            transition: width 1s ease-in-out;
        }

        /* Responsive améliorations */
        @media (max-width: 768px) {
            .mobile-stack {
                flex-direction: column;
                gap: 1rem;
            }

            .mobile-full {
                width: 100%;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation d'entrée pour les cartes
            const cards = document.querySelectorAll('[class*="shadow-md"]');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Animation de la barre de progression de durée
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                setTimeout(() => {
                    progressBar.style.width = progressBar.getAttribute('data-width') || '0%';
                }, 500);
            }

            // Amélioration de la confirmation de suppression
            const deleteForm = document.querySelector('form[method="POST"][onsubmit*="confirm"]');
            if (deleteForm) {
                deleteForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Créer une modale de confirmation personnalisée
                    const examId = '{{ $mockExam->id }}';
                    const examType = '{{ $mockExam->type }}';
                    const examDate = '{{ $mockExam->date->format("d/m/Y à H:i") }}';

                    const confirmMessage = `⚠️ ATTENTION: Suppression définitive\n\n` +
                        `Concours: #${examId}\n` +
                        `Type: ${examType}\n` +
                        `Date: ${examDate}\n\n` +
                        `Cette action est IRRÉVERSIBLE et supprimera:\n` +
                        `• Le concours blanc\n` +
                        `• Toutes les données associées\n` +
                        `• Les résultats éventuels\n\n` +
                        `Confirmez-vous la suppression ?`;

                    if (confirm(confirmMessage)) {
                        // Animation de suppression
                        const container = document.querySelector('.max-w-7xl');
                        if (container) {
                            container.style.transition = 'all 0.5s ease-out';
                            container.style.opacity = '0.5';
                            container.style.transform = 'scale(0.95)';
                        }

                        setTimeout(() => {
                            this.submit();
                        }, 500);
                    }
                });
            }

            // Effet de hover amélioré pour les actions rapides
            const actionCards = document.querySelectorAll('[class*="hover:scale-105"]');
            actionCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.05) translateY(-2px)';
                    this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            // Animation pour les cours associés
            const courseItems = document.querySelectorAll('[class*="border-gray-200"]');
            courseItems.forEach((item, index) => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                    this.style.borderColor = '#4CA3DD';
                });

                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0)';
                    this.style.borderColor = '';
                });
            });

            // Tooltip pour les informations supplémentaires
            const statElements = document.querySelectorAll('[title]');
            statElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    // Créer un tooltip personnalisé si nécessaire
                    console.log('Tooltip:', this.getAttribute('title'));
                });
            });
        });
    </script>
@endpush
