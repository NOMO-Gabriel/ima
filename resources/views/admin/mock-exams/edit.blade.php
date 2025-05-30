@extends('layouts.app')

@section('title', 'Modifier le Concours Blanc')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }">
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
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Modifier Concours #{{ $mockExam->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    @can('gestion.exam.update')
        <div class="max-w-4xl mx-auto" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }">
            <!-- En-tête avec titre -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-16 w-16 rounded-full flex items-center justify-center text-[#4CA3DD] mr-4 transition-colors"
                         :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-50'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Modifier le Concours Blanc #{{ $mockExam->id }}
                        </h1>
                        <p class="text-lg transition-colors mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            Formation: {{ $mockExam->formation->name ?? 'Non définie' }} •
                            Type: {{ $mockExam->type }} •
                            Durée: {{ $mockExam->duration }}min
                        </p>
                    </div>
                </div>
            </div>

            <!-- Messages d'alerte -->
            <x-flash-message />

            <!-- Affichage des erreurs de validation -->
            @if ($errors->any())
                <div class="mb-6 p-4 border-l-4 border-red-500 rounded-md transition-colors"
                     :class="darkMode ? 'bg-red-900/20 text-red-400' : 'bg-red-50 text-red-700'">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium">Erreurs de validation</h3>
                            <div class="mt-2 text-sm">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Formulaire d'édition -->
            <form action="{{ route('admin.mock-exams.update', ['locale' => app()->getLocale(), 'mock_exam' => $mockExam->id]) }}"
                  method="POST" class="space-y-8" id="edit-exam-form">
                @csrf
                @method('PUT')

                <!-- Section 1: Informations générales -->
                <div class="rounded-lg p-6 shadow-md transition-colors"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-blue-500 mr-3"
                             :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Informations Générales
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Date et heure -->
                        <div class="space-y-2">
                            <label for="date" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Date et heure <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="datetime-local"
                                       id="date"
                                       name="date"
                                       value="{{ old('date', $mockExam->date->format('Y-m-d\TH:i')) }}"
                                       required
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors @error('date') border-red-500 @enderror"
                                       :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            @error('date')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Date et heure actuelles: {{ $mockExam->date->format('d/m/Y à H:i') }}
                            </p>
                        </div>

                        <!-- Type d'examen -->
                        <div class="space-y-2">
                            <label for="type" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Type d'examen <span class="text-red-500">*</span>
                            </label>
                            <select id="type"
                                    name="type"
                                    required
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors @error('type') border-red-500 @enderror"
                                    :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">-- Sélectionner un type --</option>
                                <option value="QCM" {{ old('type', $mockExam->type) == 'QCM' ? 'selected' : '' }}>
                                    📝 QCM (Questions à Choix Multiples)
                                </option>
                                <option value="REDACTION" {{ old('type', $mockExam->type) == 'REDACTION' ? 'selected' : '' }}>
                                    ✍️ Rédaction (Épreuves écrites)
                                </option>
                                <option value="MIX" {{ old('type', $mockExam->type) == 'MIX' ? 'selected' : '' }}>
                                    🔄 Mixte (QCM + Rédaction)
                                </option>
                            </select>
                            @error('type')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <div id="type-description" class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Type actuel: {{ $mockExam->type }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Configuration de l'examen -->
                <div class="rounded-lg p-6 shadow-md transition-colors"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-green-500 mr-3"
                             :class="darkMode ? 'bg-green-900/30' : 'bg-green-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Configuration de l'Examen
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Durée -->
                        <div class="space-y-2">
                            <label for="duration" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Durée <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       id="duration"
                                       name="duration"
                                       value="{{ old('duration', $mockExam->duration) }}"
                                       min="15"
                                       max="480"
                                       step="15"
                                       required
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors @error('duration') border-red-500 @enderror"
                                       :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">min</span>
                                </div>
                            </div>
                            @error('duration')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <div class="flex justify-between text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                <span>Minimum: 15 minutes</span>
                                <span id="duration-display">{{ floor($mockExam->duration / 60) }}h {{ $mockExam->duration % 60 }}min</span>
                                <span>Maximum: 8 heures</span>
                            </div>
                            <!-- Suggestions de durée -->
                            <div class="flex flex-wrap gap-2 mt-2">
                                <button type="button" onclick="setDuration(60)"
                                        class="px-3 py-1 text-xs rounded-full border transition-colors hover:bg-blue-50"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-blue-900/20' : 'border-gray-300 text-gray-600 hover:bg-blue-50'">
                                    1h
                                </button>
                                <button type="button" onclick="setDuration(90)"
                                        class="px-3 py-1 text-xs rounded-full border transition-colors hover:bg-blue-50"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-blue-900/20' : 'border-gray-300 text-gray-600 hover:bg-blue-50'">
                                    1h30
                                </button>
                                <button type="button" onclick="setDuration(120)"
                                        class="px-3 py-1 text-xs rounded-full border transition-colors hover:bg-blue-50"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-blue-900/20' : 'border-gray-300 text-gray-600 hover:bg-blue-50'">
                                    2h
                                </button>
                                <button type="button" onclick="setDuration(180)"
                                        class="px-3 py-1 text-xs rounded-full border transition-colors hover:bg-blue-50"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-blue-900/20' : 'border-gray-300 text-gray-600 hover:bg-blue-50'">
                                    3h
                                </button>
                                <button type="button" onclick="setDuration(240)"
                                        class="px-3 py-1 text-xs rounded-full border transition-colors hover:bg-blue-50"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-blue-900/20' : 'border-gray-300 text-gray-600 hover:bg-blue-50'">
                                    4h
                                </button>
                            </div>
                        </div>

                        <!-- Formation -->
                        <div class="space-y-2">
                            <label for="formation_id" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Formation <span class="text-red-500">*</span>
                            </label>
                            <select id="formation_id"
                                    name="formation_id"
                                    required
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors @error('formation_id') border-red-500 @enderror"
                                    :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">-- Choisir une formation --</option>
                                @foreach($formations as $formation)
                                    <option value="{{ $formation->id }}"
                                            {{ old('formation_id', $mockExam->formation_id) == $formation->id ? 'selected' : '' }}
                                            data-description="{{ $formation->description }}"
                                            data-hours="{{ $formation->hours }}"
                                            data-price="{{ $formation->price }}">
                                        {{ $formation->name }}
                                        @if($formation->hours) ({{ $formation->hours }}h) @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('formation_id')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <div id="formation-info" class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Formation actuelle: {{ $mockExam->formation->name ?? 'Non définie' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Cours associés -->
                <div class="rounded-lg p-6 shadow-md transition-colors"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-purple-500 mr-3"
                             :class="darkMode ? 'bg-purple-900/30' : 'bg-purple-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                                Cours Associés
                            </h2>
                            <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Modifiez les cours à évaluer ({{ $mockExam->courses->count() }} cours actuellement sélectionnés)
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <!-- Cours actuellement sélectionnés -->
                        @if($mockExam->courses->count() > 0)
                            <div class="p-4 rounded-lg transition-colors" :class="darkMode ? 'bg-blue-900/20 border border-blue-700' : 'bg-blue-50 border border-blue-200'">
                                <h4 class="font-medium text-sm mb-2 transition-colors" :class="darkMode ? 'text-blue-300' : 'text-blue-700'">
                                    Cours actuellement associés:
                                </h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($mockExam->courses as $course)
                                        <span class="px-3 py-1 text-xs rounded-full transition-colors"
                                              :class="darkMode ? 'bg-blue-800 text-blue-200' : 'bg-blue-100 text-blue-800'">
                                            {{ $course->title }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Recherche de cours -->
                        <div class="relative">
                            <input type="text"
                                   id="course-search"
                                   placeholder="Rechercher un cours..."
                                   class="w-full px-4 py-3 pl-10 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                   :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Liste des cours avec cases à cocher -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-64 overflow-y-auto" id="courses-list">
                            @foreach($courses as $course)
                                <div class="course-item flex items-start p-3 border rounded-lg transition-all duration-200 hover:shadow-sm"
                                     :class="darkMode ? 'border-gray-600 hover:border-gray-500 bg-[#2C3E50]/30' : 'border-gray-200 hover:border-gray-300 bg-gray-50/50'"
                                     data-course-name="{{ strtolower($course->title) }}"
                                     data-course-code="{{ strtolower($course->code ?? '') }}">
                                    <input type="checkbox"
                                           id="course_{{ $course->id }}"
                                           name="course_ids[]"
                                           value="{{ $course->id }}"
                                           {{ collect(old('course_ids', $mockExam->courses->pluck('id')->toArray()))->contains($course->id) ? 'checked' : '' }}
                                           class="mt-1 h-4 w-4 text-[#4CA3DD] border-gray-300 rounded focus:ring-[#4CA3DD]">
                                    <label for="course_{{ $course->id }}" class="ml-3 flex-1 cursor-pointer">
                                        <div class="font-medium text-sm transition-colors" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                            {{ $course->title }}
                                        </div>
                                        @if($course->code)
                                            <div class="text-xs transition-colors mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                Code: {{ $course->code }}
                                            </div>
                                        @endif
                                        @if($course->description)
                                            <div class="text-xs transition-colors mt-1 line-clamp-2" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                                {{ Str::limit($course->description, 80) }}
                                            </div>
                                        @endif
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        @if($courses->isEmpty())
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <p class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    Aucun cours disponible
                                </p>
                            </div>
                        @endif

                        <!-- Compteur de cours sélectionnés -->
                        <div class="flex items-center justify-between p-3 border-t" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                            <span class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                <span id="selected-count">{{ $mockExam->courses->count() }}</span> cours sélectionné(s)
                            </span>
                            <div class="flex gap-2">
                                <button type="button" onclick="selectAllCourses()"
                                        class="text-xs px-3 py-1 rounded border transition-colors"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-gray-700' : 'border-gray-300 text-gray-600 hover:bg-gray-50'">
                                    Tout sélectionner
                                </button>
                                <button type="button" onclick="deselectAllCourses()"
                                        class="text-xs px-3 py-1 rounded border transition-colors"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-gray-700' : 'border-gray-300 text-gray-600 hover:bg-gray-50'">
                                    Tout désélectionner
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 4: Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                    <a href="{{ route('admin.mock-exams.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-lg transition-colors duration-200 hover:bg-gray-50 sm:order-1"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Annuler
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 bg-[#4CA3DD] text-white font-medium rounded-lg transition-colors duration-200 hover:bg-[#2A7AB8] focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-opacity-50 sm:order-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                        </svg>
                        Mettre à jour le Concours
                    </button>
                </div>
            </form>

            <!-- Section informative - Historique des modifications -->
            <div class="mt-8 rounded-lg p-6 shadow-md transition-colors"
                 :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-amber-500 mr-3"
                         :class="darkMode ? 'bg-amber-900/30' : 'bg-amber-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                        Informations du Concours
                    </h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Créé le:</span>
                            <span class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                {{ $mockExam->created_at->format('d/m/Y à H:i') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Dernière modif:</span>
                            <span class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                {{ $mockExam->updated_at->format('d/m/Y à H:i') }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Statut:</span>
                            <span class="px-2 py-1 text-xs rounded-full {{ $mockExam->date->isPast() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                {{ $mockExam->date->isPast() ? 'Terminé' : 'À venir' }}
                            </span>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Formation:</span>
                            <span class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                {{ $mockExam->formation->name ?? 'Non définie' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Cours associés:</span>
                            <span class="transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                {{ $mockExam->courses->count() }} cours
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">ID:</span>
                            <span class="font-mono text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                #{{ $mockExam->id }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="max-w-2xl mx-auto text-center py-12" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }">
            <div class="rounded-lg p-8 shadow-md transition-colors"
                 :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                </svg>
                <h2 class="text-xl font-semibold mb-2 transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                    Accès non autorisé
                </h2>
                <p class="transition-colors mb-6" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Vous n'avez pas les permissions nécessaires pour modifier ce concours blanc.
                </p>
                <a href="{{ route('admin.mock-exams.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] text-white rounded-lg hover:bg-[#2A7AB8] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Retour à la liste
                </a>
            </div>
        </div>
    @endcan

    <!-- Scripts JavaScript -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la durée
            const durationInput = document.getElementById('duration');
            const durationDisplay = document.getElementById('duration-display');

            function updateDurationDisplay() {
                const minutes = parseInt(durationInput.value) || 0;
                const hours = Math.floor(minutes / 60);
                const remainingMinutes = minutes % 60;

                if (hours > 0) {
                    durationDisplay.textContent = `${hours}h ${remainingMinutes.toString().padStart(2, '0')}min`;
                } else {
                    durationDisplay.textContent = `${minutes}min`;
                }
            }

            durationInput.addEventListener('input', updateDurationDisplay);
            updateDurationDisplay(); // Initialisation

            // Gestion des descriptions de type d'examen
            const typeSelect = document.getElementById('type');
            const typeDescription = document.getElementById('type-description');

            const typeDescriptions = {
                'QCM': 'Format idéal pour évaluer rapidement les connaissances théoriques',
                'REDACTION': 'Format permettant d\'évaluer la capacité de rédaction et d\'analyse',
                'MIX': 'Format combinant QCM et rédaction pour une évaluation complète'
            };

            typeSelect.addEventListener('change', function() {
                const selectedType = this.value;
                if (selectedType && typeDescriptions[selectedType]) {
                    typeDescription.textContent = typeDescriptions[selectedType];
                } else {
                    typeDescription.textContent = 'Type actuel: {{ $mockExam->type }}';
                }
            });

            // Initialiser la description du type
            const currentType = typeSelect.value;
            if (currentType && typeDescriptions[currentType]) {
                typeDescription.textContent = typeDescriptions[currentType];
            }

            // Gestion des informations de formation
            const formationSelect = document.getElementById('formation_id');
            const formationInfo = document.getElementById('formation-info');

            formationSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const description = selectedOption.dataset.description;
                    const hours = selectedOption.dataset.hours;
                    const price = selectedOption.dataset.price;

                    let infoHtml = 'Formation sélectionnée: ' + selectedOption.text;
                    if (description) {
                        infoHtml += `<br><strong>Description:</strong> ${description}`;
                    }
                    if (hours) {
                        infoHtml += `<br><strong>Durée totale:</strong> ${hours} heures`;
                    }
                    if (price) {
                        infoHtml += `<br><strong>Prix:</strong> ${price} FCFA`;
                    }

                    formationInfo.innerHTML = infoHtml;
                } else {
                    formationInfo.innerHTML = 'Formation actuelle: {{ $mockExam->formation->name ?? "Non définie" }}';
                }
            });

            // Gestion de la recherche de cours
            const courseSearch = document.getElementById('course-search');
            const courseItems = document.querySelectorAll('.course-item');

            courseSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                courseItems.forEach(item => {
                    const courseName = item.dataset.courseName;
                    const courseCode = item.dataset.courseCode;

                    if (courseName.includes(searchTerm) || courseCode.includes(searchTerm)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Gestion du compteur de cours sélectionnés
            const courseCheckboxes = document.querySelectorAll('input[name="course_ids[]"]');
            const selectedCount = document.getElementById('selected-count');

            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('input[name="course_ids[]"]:checked');
                selectedCount.textContent = checkedBoxes.length;
            }

            courseCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            // Validation du formulaire
            const form = document.getElementById('edit-exam-form');
            form.addEventListener('submit', function(e) {
                const date = document.getElementById('date').value;
                const type = document.getElementById('type').value;
                const duration = document.getElementById('duration').value;
                const formationId = document.getElementById('formation_id').value;

                let errors = [];

                if (!date) {
                    errors.push('La date et l\'heure sont obligatoires');
                }

                if (!type) {
                    errors.push('Le type d\'examen est obligatoire');
                }

                if (!duration || duration < 15) {
                    errors.push('La durée doit être d\'au moins 15 minutes');
                }

                if (!formationId) {
                    errors.push('La formation est obligatoire');
                }

                if (errors.length > 0) {
                    e.preventDefault();
                    alert('Erreurs de validation:\n\n' + errors.join('\n'));
                    return false;
                }

                // Confirmation avant soumission
                if (!confirm('Êtes-vous sûr de vouloir modifier ce concours blanc ?')) {
                    e.preventDefault();
                    return false;
                }
            });

            // Marquer les changements
            let hasChanges = false;
            const formInputs = form.querySelectorAll('input, select, textarea');

            formInputs.forEach(input => {
                input.addEventListener('change', function() {
                    hasChanges = true;
                });
            });

            // Avertir avant de quitter si des changements non sauvegardés
            window.addEventListener('beforeunload', function(e) {
                if (hasChanges) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });

            form.addEventListener('submit', function() {
                hasChanges = false; // Réinitialiser lors de la soumission
            });
        });

        // Fonctions globales pour les boutons de durée
        function setDuration(minutes) {
            document.getElementById('duration').value = minutes;
            document.getElementById('duration').dispatchEvent(new Event('input'));
        }

        // Fonctions pour la sélection de cours
        function selectAllCourses() {
            const checkboxes = document.querySelectorAll('input[name="course_ids[]"]');
            checkboxes.forEach(checkbox => {
                if (checkbox.closest('.course-item').style.display !== 'none') {
                    checkbox.checked = true;
                }
            });
            document.getElementById('selected-count').textContent = document.querySelectorAll('input[name="course_ids[]"]:checked').length;
        }

        function deselectAllCourses() {
            const checkboxes = document.querySelectorAll('input[name="course_ids[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            document.getElementById('selected-count').textContent = '0';
        }
    </script>
@endpush
@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Personnalisation des cases à cocher */
        input[type="checkbox"]:checked {
            background-color: #4CA3DD;
            border-color: #4CA3DD;
        }

        /* Animation pour les éléments masqués/affichés */
        .course-item {
            transition: all 0.3s ease;
        }

        /* Amélioration du scrollbar */
        #courses-list::-webkit-scrollbar {
            width: 6px;
        }

        #courses-list::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        #courses-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        #courses-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Mode sombre pour le scrollbar */
        html.dark #courses-list::-webkit-scrollbar-track {
            background: #334155;
        }

        html.dark #courses-list::-webkit-scrollbar-thumb {
            background: #475569;
        }

        html.dark #courses-list::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Highlight des changements */
        .changed {
            box-shadow: 0 0 0 2px rgba(76, 163, 221, 0.3);
        }
    </style>
@endpush
