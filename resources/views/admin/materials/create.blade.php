@extends('layouts.app')

@section('title', 'Ajouter un Matériel')

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
                    <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors"
                       :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
                        Matériels
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Ajouter un matériel</span>
                </div>
            </li>
        </ol>
    </nav>

    @can('ressource.material.create')
        <div class="max-w-4xl mx-auto" x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }">
            <!-- En-tête avec titre -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-16 w-16 rounded-full flex items-center justify-center text-[#4CA3DD] mr-4 transition-colors"
                         :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-50'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Ajouter un Matériel
                        </h1>
                        <p class="text-lg transition-colors mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            Enrichissez votre inventaire avec un nouveau matériel
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

            <!-- Formulaire de création -->
            <form action="{{ route('admin.materials.store', ['locale' => app()->getLocale()]) }}"
                  method="POST" class="space-y-8" id="create-material-form">
                @csrf

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
                            Informations du Matériel
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom du matériel -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Nom du matériel <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       required
                                       maxlength="255"
                                       class="w-full px-4 py-3 pr-10 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors @error('name') border-red-500 @enderror"
                                       :class="darkMode ? 'bg-[#334155] border-[#475569] text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'"
                                       placeholder="Ex: Ordinateur portable HP">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                </div>
                            </div>
                            @error('name')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <p class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Nom descriptif et unique pour identifier le matériel
                            </p>
                        </div>

                        <!-- Centre d'affectation -->
                        <div class="space-y-2">
                            <label for="center_id" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Centre d'affectation <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select id="center_id"
                                        name="center_id"
                                        required
                                        class="w-full px-4 py-3 pr-10 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors @error('center_id') border-red-500 @enderror"
                                        :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                                    <option value="">-- Sélectionner un centre --</option>
                                    @foreach($centers as $center)
                                        <option value="{{ $center->id }}"
                                                {{ old('center_id') == $center->id ? 'selected' : '' }}
                                                data-address="{{ $center->address }}"
                                                data-city="{{ $center->city->name ?? 'Ville non définie' }}">
                                            {{ $center->name }}
                                            @if($center->city)
                                                - {{ $center->city->name }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0h3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                            </div>
                            @error('center_id')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <div id="center-info" class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Sélectionnez le centre où sera stocké ce matériel
                            </div>
                        </div>

                        <!-- Unité de mesure -->
                        <div class="space-y-2">
                            <label for="unit" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Unité de mesure <span class="text-red-500">*</span>
                            </label>
                            <select id="unit"
                                    name="unit"
                                    required
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors @error('unit') border-red-500 @enderror"
                                    :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'">
                                <option value="">-- Sélectionner une unité --</option>
                                @foreach($units as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ old('unit') === $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            <div id="unit-description" class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                Choisissez l'unité de mesure appropriée
                            </div>
                        </div>

                        <!-- Quantité initiale -->
                        <div class="space-y-2">
                            <label for="quantity" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Quantité initiale <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       id="quantity"
                                       name="quantity"
                                       value="{{ old('quantity', 0) }}"
                                       min="0"
                                       max="999999"
                                       required
                                       class="w-full px-4 py-3 pr-20 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors @error('quantity') border-red-500 @enderror"
                                       :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'"
                                       placeholder="0">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span id="unit-display" class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        unité(s)
                                    </span>
                                </div>
                            </div>
                            @error('quantity')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror

                            <!-- Suggestions de quantité -->
                            <div class="flex flex-wrap gap-2 mt-2">
                                <button type="button" onclick="setQuantity(1)"
                                        class="px-3 py-1 text-xs rounded-full border transition-colors"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-gray-700' : 'border-gray-300 text-gray-600 hover:bg-gray-50'">
                                    1
                                </button>
                                <button type="button" onclick="setQuantity(10)"
                                        class="px-3 py-1 text-xs rounded-full border transition-colors"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-gray-700' : 'border-gray-300 text-gray-600 hover:bg-gray-50'">
                                    10
                                </button>
                                <button type="button" onclick="setQuantity(50)"
                                        class="px-3 py-1 text-xs rounded-full border transition-colors"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-gray-700' : 'border-gray-300 text-gray-600 hover:bg-gray-50'">
                                    50
                                </button>
                                <button type="button" onclick="setQuantity(100)"
                                        class="px-3 py-1 text-xs rounded-full border transition-colors"
                                        :class="darkMode ? 'border-gray-600 text-gray-400 hover:bg-gray-700' : 'border-gray-300 text-gray-600 hover:bg-gray-50'">
                                    100
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-6 space-y-2">
                        <label for="description" class="block text-sm font-medium transition-colors"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Description (optionnel)
                        </label>
                        <div class="relative">
                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      maxlength="1000"
                                      class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors resize-none @error('description') border-red-500 @enderror"
                                      :class="darkMode ? 'bg-[#334155] border-[#475569] text-white placeholder-gray-400' : 'bg-white border-gray-300 text-gray-900 placeholder-gray-500'"
                                      placeholder="Décrivez les caractéristiques, spécifications ou détails importants du matériel...">{{ old('description') }}</textarea>
                            <div class="absolute bottom-3 right-3 text-xs transition-colors" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                <span id="char-count">0</span>/1000
                            </div>
                        </div>
                        @error('description')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                        <p class="text-xs transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Ajoutez des détails sur les caractéristiques, l'état ou les spécifications
                        </p>
                    </div>
                </div>

                <!-- Section 2: Aperçu du stock -->
                <div class="rounded-lg p-6 shadow-md transition-colors"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-green-500 mr-3"
                             :class="darkMode ? 'bg-green-900/30' : 'bg-green-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Aperçu du Stock
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations du centre sélectionné -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Centre de stockage
                            </label>
                            <div id="selected-center-info" class="p-4 rounded-lg border-2 border-dashed transition-colors"
                                 :class="darkMode ? 'border-gray-600 bg-gray-800/30' : 'border-gray-300 bg-gray-50'">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3"
                                         :class="darkMode ? 'bg-gray-700 text-gray-400' : 'bg-gray-200 text-gray-500'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0h3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                            Aucun centre sélectionné
                                        </p>
                                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                            Choisissez un centre pour continuer
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statut du stock -->
                        <div class="space-y-2">
                            <label class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Statut du stock
                            </label>
                            <div class="p-4 rounded-lg border-2 border-dashed transition-colors"
                                 :class="darkMode ? 'border-gray-600 bg-gray-800/30' : 'border-gray-300 bg-gray-50'">
                                <div id="stock-status" class="flex items-center">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3"
                                         :class="darkMode ? 'bg-gray-700 text-gray-400' : 'bg-gray-200 text-gray-500'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                            Aucune quantité
                                        </p>
                                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                            Saisissez une quantité pour voir le statut
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                    <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-6 py-3 border font-medium rounded-lg transition-colors duration-200 sm:order-1"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Annuler
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-6 py-3 bg-[#4CA3DD] text-white font-medium rounded-lg transition-colors duration-200 hover:bg-[#2A7AB8] focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-opacity-50 sm:order-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Ajouter le Matériel
                    </button>
                </div>
            </form>
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
                    Vous n'avez pas les permissions nécessaires pour ajouter un matériel.
                </p>
                <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}"
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
        // Descriptions et icônes des unités
        const unitDescriptions = {
            'pcs': 'Unité de comptage pour les éléments individuels',
            'kg': 'Kilogrammes - unité de masse',
            'g': 'Grammes - unité de masse pour les petites quantités',
            'm': 'Mètres - unité de longueur',
            'cm': 'Centimètres - unité de longueur',
            'mm': 'Millimètres - unité de longueur précise',
            'l': 'Litres - unité de volume pour les liquides',
            'ml': 'Millilitres - unité de volume pour les petites quantités',
            'm2': 'Mètres carrés - unité de surface',
            'm3': 'Mètres cubes - unité de volume',
            'set': 'Ensembles - groupes d\'éléments',
            'box': 'Boîtes - contenants standardisés',
            'pack': 'Paquets - lots groupés'
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du compteur de caractères pour la description
            const descriptionTextarea = document.getElementById('description');
            const charCount = document.getElementById('char-count');

            function updateCharCount() {
                const length = descriptionTextarea.value.length;
                charCount.textContent = length;

                // Changement de couleur selon la proximité de la limite
                if (length > 900) {
                    charCount.className = 'text-red-500';
                } else if (length > 750) {
                    charCount.className = 'text-yellow-500';
                } else {
                    charCount.className = localStorage.getItem('theme') === 'dark' ? 'text-gray-500' : 'text-gray-400';
                }
            }

            descriptionTextarea.addEventListener('input', updateCharCount);
            updateCharCount(); // Initialisation

            // Gestion des descriptions d'unité
            const unitSelect = document.getElementById('unit');
            const unitDescription = document.getElementById('unit-description');
            const unitDisplay = document.getElementById('unit-display');

            unitSelect.addEventListener('change', function() {
                const selectedUnit = this.value;
                if (selectedUnit && unitDescriptions[selectedUnit]) {
                    unitDescription.textContent = unitDescriptions[selectedUnit];
                    unitDisplay.textContent = selectedUnit;
                } else {
                    unitDescription.textContent = 'Choisissez l\'unité de mesure appropriée';
                    unitDisplay.textContent = 'unité(s)';
                }
                updateStockStatus(); // Mettre à jour le statut quand l'unité change
            });

            // Gestion des informations du centre
            const centerSelect = document.getElementById('center_id');
            const centerInfo = document.getElementById('center-info');
            const selectedCenterInfo = document.getElementById('selected-center-info');

            centerSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                if (this.value) {
                    const centerName = selectedOption.text;
                    const centerAddress = selectedOption.getAttribute('data-address');
                    const centerCity = selectedOption.getAttribute('data-city');

                    centerInfo.innerHTML = `<strong>${centerName}</strong><br>📍 ${centerAddress || 'Adresse non renseignée'} - ${centerCity}`;

                    selectedCenterInfo.innerHTML = `
                        <div class="flex items-start">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0h3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-blue-700">${centerName}</p>
                                <p class="text-sm text-blue-600">${centerCity}</p>
                                ${centerAddress ? `<p class="text-xs text-blue-500 mt-1">${centerAddress}</p>` : ''}
                            </div>
                        </div>
                    `;
                } else {
                    centerInfo.textContent = 'Sélectionnez le centre où sera stocké ce matériel';
                    selectedCenterInfo.innerHTML = `
                        <div class="flex items-center">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 ${localStorage.getItem('theme') === 'dark' ? 'bg-gray-700 text-gray-400' : 'bg-gray-200 text-gray-500'}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0h3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium ${localStorage.getItem('theme') === 'dark' ? 'text-gray-300' : 'text-gray-700'}">
                                    Aucun centre sélectionné
                                </p>
                                <p class="text-sm ${localStorage.getItem('theme') === 'dark' ? 'text-gray-500' : 'text-gray-400'}">
                                    Choisissez un centre pour continuer
                                </p>
                            </div>
                        </div>
                    `;
                }
            });

            // Gestion du statut de stock en temps réel
            const quantityInput = document.getElementById('quantity');
            const stockStatus = document.getElementById('stock-status');

            function updateStockStatus() {
                const quantity = parseInt(quantityInput.value) || 0;
                const selectedUnit = unitSelect.value || 'unité(s)';
                const isDark = localStorage.getItem('theme') === 'dark';

                let statusHtml = '';

                if (quantity === 0) {
                    statusHtml = `
                        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 bg-red-100 text-red-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-red-700">Rupture de stock</p>
                            <p class="text-sm text-red-500">Aucun élément en stock</p>
                        </div>
                    `;
                } else if (quantity <= 10) {
                    statusHtml = `
                        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 bg-yellow-100 text-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-yellow-700">Stock faible</p>
                            <p class="text-sm text-yellow-600">${quantity} ${selectedUnit} disponible(s)</p>
                        </div>
                    `;
                } else {
                    statusHtml = `
                        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 bg-green-100 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-green-700">Stock disponible</p>
                            <p class="text-sm text-green-600">${quantity} ${selectedUnit} en stock</p>
                        </div>
                    `;
                }

                stockStatus.innerHTML = statusHtml;
            }

            quantityInput.addEventListener('input', updateStockStatus);
            unitSelect.addEventListener('change', updateStockStatus);
            updateStockStatus(); // Initialisation

            // Validation du formulaire
            const form = document.getElementById('create-material-form');
            form.addEventListener('submit', function(e) {
                const name = document.getElementById('name').value.trim();
                const unit = document.getElementById('unit').value;
                const quantity = parseInt(document.getElementById('quantity').value);
                const centerId = document.getElementById('center_id').value;

                let errors = [];

                if (!name) {
                    errors.push('Le nom du matériel est obligatoire');
                } else if (name.length < 2) {
                    errors.push('Le nom doit contenir au moins 2 caractères');
                }

                if (!centerId) {
                    errors.push('Le centre d\'affectation est obligatoire');
                }

                if (!unit) {
                    errors.push('L\'unité de mesure est obligatoire');
                }

                if (isNaN(quantity) || quantity < 0) {
                    errors.push('La quantité doit être un nombre positif ou nul');
                }

                if (errors.length > 0) {
                    e.preventDefault();
                    alert('Erreurs de validation:\n\n' + errors.join('\n'));
                    return false;
                }
            });

            // Auto-focus sur le premier champ
            document.getElementById('name').focus();

            // Raccourcis clavier
            document.addEventListener('keydown', function(e) {
                // Ctrl+S pour sauvegarder (soumettre le formulaire)
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    form.submit();
                }

                // Échap pour annuler
                if (e.key === 'Escape') {
                    if (confirm('Êtes-vous sûr de vouloir annuler ? Les modifications non sauvegardées seront perdues.')) {
                        window.location.href = '{{ route("admin.materials.index", ["locale" => app()->getLocale()]) }}';
                    }
                }
            });
        });

        // Fonctions globales pour les boutons de suggestion
        function setQuantity(value) {
            document.getElementById('quantity').value = value;
            document.getElementById('quantity').dispatchEvent(new Event('input'));
        }
    </script>
@endpush

@push('styles')
    <style>
        /* Animation pour les suggestions de quantité */
        button[onclick^="setQuantity"] {
            transition: all 0.2s ease;
        }

        button[onclick^="setQuantity"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Animation pour les champs de formulaire */
        input:focus, select:focus, textarea:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(76, 163, 221, 0.15);
        }

        /* Amélioration du scrollbar */
        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Mode sombre pour le scrollbar */
        html.dark textarea::-webkit-scrollbar-track {
            background: #334155;
        }

        html.dark textarea::-webkit-scrollbar-thumb {
            background: #475569;
        }

        html.dark textarea::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Animation pour le statut de stock */
        #stock-status, #selected-center-info {
            transition: all 0.3s ease;
        }

        /* Mise en évidence des champs requis */
        input:required:invalid {
            border-color: #fbbf24;
        }

        input:required:valid {
            border-color: #10b981;
        }

        /* Animation pour les cartes */
        .rounded-lg {
            transition: all 0.3s ease;
        }

        .rounded-lg:hover {
            transform: translateY(-1px);
        }

        /* Effets au survol pour les boutons */
        button:hover, a:hover {
            transform: translateY(-1px);
        }
    </style>
@endpush
