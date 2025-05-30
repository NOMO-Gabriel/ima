@extends('layouts.app')

@section('title', 'Modifier le Matériel')

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
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material]) }}"
                       class="ml-1 text-sm font-medium transition-colors"
                       :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-700 hover:text-[#4CA3DD]'">
                        {{ $material->name }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Modifier</span>
                </div>
            </li>
        </ol>
    </nav>

    @can('ressource.material.update')
        <div class="max-w-4xl mx-auto" x-data="{
            darkMode: localStorage.getItem('theme') === 'dark',
            originalData: {
                name: '{{ $material->name }}',
                description: '{{ $material->description }}',
                unit: '{{ $material->unit }}',
                quantity: {{ $material->quantity }},
                center_id: {{ $material->center_id ?? 'null' }}
            },
            hasChanges: false,
            checkChanges() {
                const form = document.getElementById('edit-material-form');
                const formData = new FormData(form);

                this.hasChanges =
                    formData.get('name') !== this.originalData.name ||
                    formData.get('description') !== this.originalData.description ||
                    formData.get('unit') !== this.originalData.unit ||
                    parseInt(formData.get('quantity')) !== this.originalData.quantity ||
                    parseInt(formData.get('center_id')) !== this.originalData.center_id;
            }
        }">
            <!-- En-tête avec titre -->
            <div class="mb-8">
                <div class="flex items-center">
                    <div class="flex-shrink-0 h-16 w-16 rounded-full flex items-center justify-center text-[#4CA3DD] mr-4 transition-colors"
                         :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-50'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Modifier le Matériel
                        </h1>
                        <p class="text-lg transition-colors mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            Mettez à jour les informations de <span class="font-semibold text-[#4CA3DD]">{{ $material->name }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informations actuelles -->
            <div class="mb-8 rounded-lg p-6 shadow-md transition-colors"
                 :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-blue-500 mr-3"
                         :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-100'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                        Informations Actuelles
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-green-600 mr-3"
                             :class="darkMode ? 'bg-green-900/30' : 'bg-green-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0h3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Centre</p>
                            <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                {{ $material->center->name ?? 'Centre non défini' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-blue-600 mr-3"
                             :class="darkMode ? 'bg-blue-900/30' : 'bg-blue-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Stock actuel</p>
                            <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                {{ number_format($material->quantity) }} {{ $units[$material->unit] ?? $material->unit }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center mr-3
                             @if($material->quantity <= 0) text-red-600 @elseif($material->quantity <= 10) text-yellow-600 @else text-green-600 @endif"
                             :class="darkMode ?
                                @if($material->quantity <= 0) 'bg-red-900/30' @elseif($material->quantity <= 10) 'bg-yellow-900/30' @else 'bg-green-900/30' @endif :
                                @if($material->quantity <= 0) 'bg-red-100' @elseif($material->quantity <= 10) 'bg-yellow-100' @else 'bg-green-100' @endif">
                            @if($material->quantity <= 0)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            @elseif($material->quantity <= 10)
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-medium transition-colors" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Statut</p>
                            <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-900'">
                                @if($material->quantity <= 0)
                                    <span class="text-red-600">Rupture de stock</span>
                                @elseif($material->quantity <= 10)
                                    <span class="text-yellow-600">Stock faible</span>
                                @else
                                    <span class="text-green-600">En stock</span>
                                @endif
                            </p>
                        </div>
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

            <!-- Formulaire de modification -->
            <form action="{{ route('admin.materials.update', ['locale' => app()->getLocale(), 'material' => $material]) }}"
                  method="POST"
                  class="space-y-8"
                  id="edit-material-form"
                  @input="checkChanges()">
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
                                       value="{{ old('name', $material->name) }}"
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
                                                {{ old('center_id', $material->center_id) == $center->id ? 'selected' : '' }}
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
                                Centre où sera stocké ce matériel
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
                                        {{ old('unit', $material->unit) === $value ? 'selected' : '' }}>
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

                        <!-- Quantité -->
                        <div class="space-y-2">
                            <label for="quantity" class="block text-sm font-medium transition-colors"
                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                Quantité <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number"
                                       id="quantity"
                                       name="quantity"
                                       value="{{ old('quantity', $material->quantity) }}"
                                       min="0"
                                       max="999999"
                                       required
                                       class="w-full px-4 py-3 pr-20 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors @error('quantity') border-red-500 @enderror"
                                       :class="darkMode ? 'bg-[#334155] border-[#475569] text-white' : 'bg-white border-gray-300 text-gray-900'"
                                       placeholder="0">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span id="unit-display" class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                        {{ $units[$material->unit] ?? $material->unit }}
                                    </span>
                                </div>
                            </div>
                            @error('quantity')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                            @enderror

                            <!-- Comparaison avec la quantité actuelle -->
                            <div class="mt-2 p-3 rounded-lg border-2 border-dashed transition-colors"
                                 :class="darkMode ? 'border-gray-600 bg-gray-800/30' : 'border-gray-300 bg-gray-50'">
                                <div id="quantity-comparison" class="flex items-center">
                                    <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2"
                                         :class="darkMode ? 'bg-gray-700 text-gray-400' : 'bg-gray-200 text-gray-500'">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                    <span class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                        Quantité actuelle: {{ number_format($material->quantity) }} {{ $units[$material->unit] ?? $material->unit }}
                                    </span>
                                </div>
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
                                      placeholder="Décrivez les caractéristiques, spécifications ou détails importants du matériel...">{{ old('description', $material->description) }}</textarea>
                            <div class="absolute bottom-3 right-3 text-xs transition-colors" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">
                                <span id="char-count">{{ strlen($material->description ?? '') }}</span>/1000
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

                <!-- Section 2: Aperçu des modifications -->
                <div class="rounded-lg p-6 shadow-md transition-colors"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-6">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-yellow-500 mr-3"
                             :class="darkMode ? 'bg-yellow-900/30' : 'bg-yellow-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Aperçu des Modifications
                        </h2>
                    </div>

                    <div x-show="hasChanges" class="space-y-4">
                        <div class="p-4 rounded-lg border-l-4 border-yellow-500 transition-colors"
                             :class="darkMode ? 'bg-yellow-900/20 text-yellow-400' : 'bg-yellow-50 text-yellow-700'">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium">Modifications détectées</p>
                                    <p class="text-sm mt-1">N'oubliez pas de sauvegarder vos modifications.</p>
                                </div>
                            </div>
                        </div>

                        <div id="changes-preview" class="grid grid-cols-1 md:grid-cols-2 gap-4"></div>
                    </div>

                    <div x-show="!hasChanges" class="text-center py-8">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4"
                             :class="darkMode ? 'bg-gray-700 text-gray-400' : 'bg-gray-200 text-gray-500'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            Aucune modification détectée pour le moment
                        </p>
                    </div>
                </div>

                <!-- Section 3: Actions -->
                <div class="flex flex-col sm:flex-row gap-4 justify-end pt-6 border-t" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                    <a href="{{ route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material]) }}"
                       class="inline-flex items-center justify-center px-6 py-3 border font-medium rounded-lg transition-colors duration-200 sm:order-1"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Annuler
                    </a>

                    <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center justify-center px-6 py-3 border font-medium rounded-lg transition-colors duration-200 sm:order-2"
                       :class="darkMode ? 'border-gray-600 text-gray-300 hover:bg-gray-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Retour à la liste
                    </a>

                    @can('ressource.material.update')
                    <button type="submit"
                            :disabled="!hasChanges"
                            class="inline-flex items-center justify-center px-6 py-3 font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-opacity-50 sm:order-3 disabled:opacity-50 disabled:cursor-not-allowed"
                            :class="hasChanges ? 'bg-[#4CA3DD] text-white hover:bg-[#2A7AB8]' : 'bg-gray-400 text-gray-200'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        <span x-text="hasChanges ? 'Sauvegarder les modifications' : 'Aucune modification'"></span>
                    </button>
                    @endcan
                </div>
            </form>

            <!-- Historique des modifications (si disponible) -->
            @if($material->updated_at != $material->created_at)
                <div class="mt-8 rounded-lg p-6 shadow-md transition-colors"
                     :class="darkMode ? 'bg-[#1E293B] border border-[#2C3E50]' : 'bg-white border border-gray-200'">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-gray-500 mr-3"
                             :class="darkMode ? 'bg-gray-800' : 'bg-gray-100'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold transition-colors" :class="darkMode ? 'text-gray-200' : 'text-gray-800'">
                            Historique
                        </h3>
                    </div>

                    <div class="space-y-2 text-sm transition-colors" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                        <div class="flex justify-between">
                            <span>Créé le:</span>
                            <span>{{ $material->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Dernière modification:</span>
                            <span>{{ $material->updated_at->format('d/m/Y à H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Il y a:</span>
                            <span>{{ $material->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            @endif
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
                    Vous n'avez pas les permissions nécessaires pour modifier ce matériel.
                </p>
                <a href="{{ route('admin.materials.show', ['locale' => app()->getLocale(), 'material' => $material]) }}"
                   class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] text-white rounded-lg hover:bg-[#2A7AB8] transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Retour aux détails
                </a>
            </div>
        </div>
    @endcan

    <!-- Scripts JavaScript -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection

@push('scripts')
    <script>
        // Descriptions des unités
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
            });

            // Gestion des informations du centre
            const centerSelect = document.getElementById('center_id');
            const centerInfo = document.getElementById('center-info');

            centerSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                if (this.value) {
                    const centerName = selectedOption.text;
                    const centerAddress = selectedOption.getAttribute('data-address');
                    const centerCity = selectedOption.getAttribute('data-city');

                    centerInfo.innerHTML = `<strong>${centerName}</strong><br>📍 ${centerAddress || 'Adresse non renseignée'} - ${centerCity}`;
                } else {
                    centerInfo.textContent = 'Centre où sera stocké ce matériel';
                }
            });

            // Gestion de la comparaison des quantités
            const quantityInput = document.getElementById('quantity');
            const quantityComparison = document.getElementById('quantity-comparison');
            const originalQuantity = {{ $material->quantity }};

            quantityInput.addEventListener('input', function() {
                const newQuantity = parseInt(this.value) || 0;
                const difference = newQuantity - originalQuantity;

                let icon = '';
                let text = '';
                let colorClass = '';

                if (difference === 0) {
                    icon = '=';
                    text = 'Aucun changement';
                    colorClass = localStorage.getItem('theme') === 'dark' ? 'text-gray-400' : 'text-gray-600';
                } else if (difference > 0) {
                    icon = '↗';
                    text = `+${difference} ${unitSelect.value || 'unité(s)'} (augmentation)`;
                    colorClass = 'text-green-600';
                } else {
                    icon = '↘';
                    text = `${difference} ${unitSelect.value || 'unité(s)'} (diminution)`;
                    colorClass = 'text-red-600';
                }

                quantityComparison.innerHTML = `
                    <div class="w-6 h-6 rounded-full flex items-center justify-center mr-2 text-sm font-bold ${colorClass}">
                        ${icon}
                    </div>
                    <span class="text-sm ${colorClass}">
                        ${text}
                    </span>
                `;
            });

            // Gestion de l'aperçu des modifications
            function updateChangesPreview() {
                const changesPreview = document.getElementById('changes-preview');
                const form = document.getElementById('edit-material-form');
                const formData = new FormData(form);
                const originalData = window.Alpine ? Alpine.store('materialData') : null;

                if (!originalData) return;

                const changes = [];

                // Vérifier chaque champ
                if (formData.get('name') !== originalData.name) {
                    changes.push({
                        field: 'Nom',
                        old: originalData.name,
                        new: formData.get('name')
                    });
                }

                if (formData.get('description') !== originalData.description) {
                    changes.push({
                        field: 'Description',
                        old: originalData.description || 'Aucune description',
                        new: formData.get('description') || 'Aucune description'
                    });
                }

                if (formData.get('unit') !== originalData.unit) {
                    changes.push({
                        field: 'Unité',
                        old: originalData.unit,
                        new: formData.get('unit')
                    });
                }

                if (parseInt(formData.get('quantity')) !== originalData.quantity) {
                    changes.push({
                        field: 'Quantité',
                        old: originalData.quantity,
                        new: parseInt(formData.get('quantity'))
                    });
                }

                if (parseInt(formData.get('center_id')) !== originalData.center_id) {
                    const oldCenter = document.querySelector(`option[value="${originalData.center_id}"]`)?.text || 'Centre non défini';
                    const newCenter = document.querySelector(`option[value="${formData.get('center_id')}"]`)?.text || 'Centre non défini';
                    changes.push({
                        field: 'Centre',
                        old: oldCenter,
                        new: newCenter
                    });
                }

                // Afficher les modifications
                if (changes.length > 0) {
                    changesPreview.innerHTML = changes.map(change => `
                        <div class="p-3 rounded-lg border transition-colors ${localStorage.getItem('theme') === 'dark' ? 'border-gray-600 bg-gray-800/50' : 'border-gray-200 bg-gray-50'}">
                            <h4 class="font-medium text-sm mb-2 ${localStorage.getItem('theme') === 'dark' ? 'text-gray-200' : 'text-gray-800'}">${change.field}</h4>
                            <div class="space-y-1 text-xs">
                                <div class="flex items-center">
                                    <span class="w-12 text-red-600">Avant:</span>
                                    <span class="flex-1 ${localStorage.getItem('theme') === 'dark' ? 'text-gray-400' : 'text-gray-600'}">${change.old}</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="w-12 text-green-600">Après:</span>
                                    <span class="flex-1 ${localStorage.getItem('theme') === 'dark' ? 'text-gray-200' : 'text-gray-900'}">${change.new}</span>
                                </div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    changesPreview.innerHTML = '';
                }
            }

            // Écouter les changements du formulaire
            const form = document.getElementById('edit-material-form');
            form.addEventListener('input', updateChangesPreview);
            form.addEventListener('change', updateChangesPreview);

            // Validation du formulaire
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

            // Avertissement si l'utilisateur quitte sans sauvegarder
            let hasUnsavedChanges = false;

            form.addEventListener('input', function() {
                hasUnsavedChanges = true;
            });

            form.addEventListener('submit', function() {
                hasUnsavedChanges = false;
            });

            window.addEventListener('beforeunload', function(e) {
                if (hasUnsavedChanges) {
                    e.preventDefault();
                    e.returnValue = 'Vous avez des modifications non sauvegardées. Êtes-vous sûr de vouloir quitter ?';
                }
            });

            // Raccourcis clavier
            document.addEventListener('keydown', function(e) {
                // Ctrl+S pour sauvegarder
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    form.submit();
                }

                // Échap pour annuler
                if (e.key === 'Escape') {
                    if (hasUnsavedChanges) {
                        if (confirm('Vous avez des modifications non sauvegardées. Êtes-vous sûr de vouloir annuler ?')) {
                            window.location.href = '{{ route("admin.materials.show", ["locale" => app()->getLocale(), "material" => $material]) }}';
                        }
                    } else {
                        window.location.href = '{{ route("admin.materials.show", ["locale" => app()->getLocale(), "material" => $material]) }}';
                    }
                }
            });
        });
    </script>
@endpush

@push('styles')
    <style>
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

        /* Animation pour les cartes */
        .rounded-lg {
            transition: all 0.3s ease;
        }

        .rounded-lg:hover {
            transform: translateY(-1px);
        }

        /* Effets au survol pour les boutons */
        button:hover:not(:disabled), a:hover {
            transform: translateY(-1px);
        }

        /* Animation des changements */
        #changes-preview > div {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mise en évidence des champs modifiés */
        .field-modified {
            border-color: #fbbf24 !important;
            box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.1);
        }
    </style>
@endpush
