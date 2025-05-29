@extends('layouts.app')

@section('title', 'Créer un Centre')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-6 transition-colors duration-300" aria-label="Breadcrumb">
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
                    <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors duration-300 md:ml-2"
                       :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
                        Centres
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
                        Créer un centre
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    @can('gestion.center.create')
        <!-- En-tête -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
            <div class="flex items-center">
                <div class="p-4 rounded-xl bg-[#4CA3DD] text-white mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold transition-colors duration-300"
                        :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                        Créer un nouveau centre
                    </h1>
                    <p class="text-lg transition-colors duration-300"
                       :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                        Ajoutez un nouveau centre à votre réseau
                    </p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.centers.index', app()->getLocale()) }}"
                   class="inline-flex items-center px-4 py-2 border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md"
                   :class="{ 'border-gray-600 text-gray-300 bg-gray-800 hover:bg-gray-700': darkMode, 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50': !darkMode }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Annuler
                </a>
            </div>
        </div>

        <!-- Messages Flash -->
        <x-flash-message />

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div class="mb-8 p-6 rounded-xl border-l-4 border-red-500 shadow-lg transition-colors duration-300"
                 :class="{ 'bg-red-900/20 text-red-300': darkMode, 'bg-red-50 text-red-700': !darkMode }">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 flex-shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <h3 class="font-medium mb-2">Des erreurs ont été détectées :</h3>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Formulaire principal -->
        <form action="{{ route('admin.centers.store', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-8">
            @csrf

            <!-- Section Informations générales -->
            <div class="rounded-xl shadow-lg border transition-colors duration-300"
                 :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                <div class="p-6 border-b transition-colors duration-300"
                     :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                    <h2 class="text-xl font-semibold flex items-center transition-colors duration-300"
                        :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Informations générales
                    </h2>
                    <p class="text-sm mt-1 transition-colors duration-300"
                       :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                        Renseignez les informations de base du centre
                    </p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div class="form-group">
                            <label for="name" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                Nom du centre <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('name') border-red-500 @enderror"
                                   :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300': !darkMode }"
                                   placeholder="Entrez le nom du centre">
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Code -->
                        <div class="form-group">
                            <label for="code" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                Code du centre <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="code"
                                   id="code"
                                   value="{{ old('code') }}"
                                   required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('code') border-red-500 @enderror"
                                   :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300': !darkMode }"
                                   placeholder="Ex: CTR-001">
                            @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group md:col-span-2">
                            <label for="description" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                Description
                            </label>
                            <textarea name="description"
                                      id="description"
                                      rows="4"
                                      class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('description') border-red-500 @enderror"
                                      :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300': !darkMode }"
                                      placeholder="Décrivez brièvement le centre...">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Adresse -->
                        <div class="form-group md:col-span-2">
                            <label for="address" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                Adresse complète <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="address"
                                   id="address"
                                   value="{{ old('address') }}"
                                   required
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('address') border-red-500 @enderror"
                                   :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300': !darkMode }"
                                   placeholder="Adresse complète du centre">
                            @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ville -->
                        <div class="form-group">
                            <label for="city_id" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                Ville
                            </label>
                            <select name="city_id"
                                    id="city_id"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('city_id') border-red-500 @enderror"
                                    :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300': !darkMode }">
                                <option value="">-- Choisir une ville --</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('city_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Académie -->
                        <div class="form-group">
                            <label for="academy_id" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                Académie
                            </label>
                            <select name="academy_id"
                                    id="academy_id"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('academy_id') border-red-500 @enderror"
                                    :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300': !darkMode }">
                                <option value="">-- Choisir une académie --</option>
                                @foreach ($academies as $academy)
                                    <option value="{{ $academy->id }}" {{ old('academy_id') == $academy->id ? 'selected' : '' }}>
                                        {{ $academy->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('academy_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Statut -->
                        <div class="form-group md:col-span-2">
                            <label for="is_active" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                Statut du centre
                            </label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="is_active" value="1"
                                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                                           class="h-4 w-4 text-[#4CA3DD] focus:ring-[#4CA3DD] border-gray-300">
                                    <span class="ml-2 text-sm transition-colors duration-300"
                                          :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                        Centre actif
                                    </span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="is_active" value="0"
                                           {{ old('is_active') == '0' ? 'checked' : '' }}
                                           class="h-4 w-4 text-[#4CA3DD] focus:ring-[#4CA3DD] border-gray-300">
                                    <span class="ml-2 text-sm transition-colors duration-300"
                                          :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                        Centre inactif
                                    </span>
                                </label>
                            </div>
                            @error('is_active')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Contact -->
            <div class="rounded-xl shadow-lg border transition-colors duration-300"
                 :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                <div class="p-6 border-b transition-colors duration-300"
                     :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                    <h2 class="text-xl font-semibold flex items-center transition-colors duration-300"
                        :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Informations de contact
                    </h2>
                    <p class="text-sm mt-1 transition-colors duration-300"
                       :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                        Coordonnées pour contacter le centre
                    </p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email -->
                        <div class="form-group">
                            <label for="contact_email" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                Adresse e-mail
                            </label>
                            <input type="email"
                                   name="contact_email"
                                   id="contact_email"
                                   value="{{ old('contact_email') }}"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('contact_email') border-red-500 @enderror"
                                   :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300': !darkMode }"
                                   placeholder="contact@centre.com">
                            @error('contact_email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="form-group">
                            <label for="contact_phone" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                Numéro de téléphone
                            </label>
                            <input type="text"
                                   name="contact_phone"
                                   id="contact_phone"
                                   value="{{ old('contact_phone') }}"
                                   class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('contact_phone') border-red-500 @enderror"
                                   :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300': !darkMode }"
                                   placeholder="+237 6XX XXX XXX">
                            @error('contact_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Équipe dirigeante -->
            <div class="rounded-xl shadow-lg border transition-colors duration-300"
                 :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                <div class="p-6 border-b transition-colors duration-300"
                     :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                    <h2 class="text-xl font-semibold flex items-center transition-colors duration-300"
                        :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Équipe dirigeante
                    </h2>
                    <p class="text-sm mt-1 transition-colors duration-300"
                       :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                        Assignez les responsables du centre
                    </p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Directeur -->
                        <div class="form-group">
                            <label for="director_id" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Directeur général
                                </span>
                            </label>
                            <select name="director_id"
                                    id="director_id"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('director_id') border-red-500 @enderror"
                                    :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300': !darkMode }">
                                <option value="">-- Choisir un directeur --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('director_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('director_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Directeur Logistique -->
                        <div class="form-group">
                            <label for="logistics_director_id" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Directeur logistique
                                </span>
                            </label>
                            <select name="logistics_director_id"
                                    id="logistics_director_id"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('logistics_director_id') border-red-500 @enderror"
                                    :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300': !darkMode }">
                                <option value="">-- Choisir un directeur logistique --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('logistics_director_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('logistics_director_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Directeur Financier -->
                        <div class="form-group">
                            <label for="finance_director_id" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                <span class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Directeur financier
                                </span>
                            </label>
                            <select name="finance_director_id"
                                    id="finance_director_id"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('finance_director_id') border-red-500 @enderror"
                                    :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300': !darkMode }">
                                <option value="">-- Choisir un directeur financier --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('finance_director_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->first_name }} {{ $user->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('finance_director_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6">
                <a href="{{ route('admin.centers.index', app()->getLocale()) }}"
                   class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md order-2 sm:order-1"
                   :class="{ 'border-gray-600 text-gray-300 bg-gray-800 hover:bg-gray-700': darkMode, 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50': !darkMode }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Annuler
                </a>

                @can('gestion.center.create')
                <button type="submit"
                        class="inline-flex items-center justify-center px-8 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 order-1 sm:order-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Créer le centre
                </button>
                @endcan
            </div>
        </form>
    @else
        <!-- Accès non autorisé -->
        <div class="shadow-md rounded-xl p-8 mb-8 text-center transition-colors duration-300"
             :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 transition-colors duration-300"
                 :class="{ 'text-gray-500': darkMode, 'text-gray-400': !darkMode }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            <h3 class="text-lg font-medium mb-2 transition-colors duration-300"
                :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                Accès non autorisé
            </h3>
            <p class="transition-colors duration-300"
               :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                Vous n'avez pas les permissions nécessaires pour créer un centre.
            </p>
        </div>
    @endcan
@endsection

@push('styles')
    <style>
        /* Animation pour les form groups */
        .form-group {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.15s; }
        .form-group:nth-child(3) { animation-delay: 0.2s; }
        .form-group:nth-child(4) { animation-delay: 0.25s; }
        .form-group:nth-child(5) { animation-delay: 0.3s; }
        .form-group:nth-child(6) { animation-delay: 0.35s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styles pour les inputs avec focus amélioré */
        input:focus,
        textarea:focus,
        select:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(76, 163, 221, 0.15);
        }

        /* Animation pour les labels */
        .form-group label {
            transition: all 0.3s ease;
        }

        .form-group:hover label {
            transform: translateX(2px);
        }

        /* Styles pour les radio buttons */
        input[type="radio"]:checked {
            background-color: #4CA3DD;
            border-color: #4CA3DD;
        }

        /* Effet de brillance pour les sections */
        .rounded-xl {
            position: relative;
            overflow: hidden;
        }

        .rounded-xl::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(76, 163, 221, 0.1), transparent);
            transition: left 0.8s ease;
            z-index: 1;
        }

        .rounded-xl:hover::before {
            left: 100%;
        }

        .rounded-xl > * {
            position: relative;
            z-index: 2;
        }

        /* Styles pour les boutons avec effet loading */
        .btn-loading {
            position: relative;
            color: transparent;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Validation visuelle */
        .form-group input:valid,
        .form-group textarea:valid,
        .form-group select:valid {
            border-color: #10b981;
        }

        .form-group input:invalid:not(:placeholder-shown),
        .form-group textarea:invalid:not(:placeholder-shown),
        .form-group select:invalid:not(:placeholder-shown) {
            border-color: #ef4444;
        }

        /* Responsive amélioré */
        @media (max-width: 768px) {
            .form-group {
                margin-bottom: 1.5rem;
            }
        }

        /* Styles pour le mode sombre */
        .dark input:focus,
        .dark textarea:focus,
        .dark select:focus {
            box-shadow: 0 4px 12px rgba(76, 163, 221, 0.25);
        }

        /* Animation de typing pour les placeholders */
        @keyframes typing {
            from { width: 0; }
            to { width: 100%; }
        }

        .typing-placeholder::placeholder {
            animation: typing 2s steps(20, end) infinite;
            overflow: hidden;
            white-space: nowrap;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation progressive des éléments
            const sections = document.querySelectorAll('.rounded-xl');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                section.style.transition = `all 0.6s cubic-bezier(0.4, 0, 0.2, 1) ${index * 0.2}s`;

                setTimeout(() => {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, 100 + (index * 200));
            });

            // Validation en temps réel
            const form = document.querySelector('form');
            const inputs = form.querySelectorAll('input, textarea, select');

            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    if (this.classList.contains('border-red-500')) {
                        validateField(this);
                    }
                });
            });

            function validateField(field) {
                const errorElement = field.parentNode.querySelector('.text-red-500');

                if (field.checkValidity()) {
                    field.classList.remove('border-red-500');
                    field.classList.add('border-green-500');
                } else {
                    field.classList.remove('border-green-500');
                    field.classList.add('border-red-500');
                }
            }

            // Auto-génération du code basé sur le nom
            const nameInput = document.getElementById('name');
            const codeInput = document.getElementById('code');

            nameInput.addEventListener('input', function() {
                if (!codeInput.value) {
                    const name = this.value.trim();
                    if (name) {
                        const code = 'CTR-' + name.substring(0, 3).toUpperCase().replace(/[^A-Z]/g, '');
                        codeInput.value = code;
                    }
                }
            });

            // Animation de soumission du formulaire
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;

                // Simuler un délai pour l'animation
                setTimeout(() => {
                    // Le formulaire sera soumis normalement
                }, 500);
            });

            // Amélioration UX pour les selects
            const selects = document.querySelectorAll('select');
            selects.forEach(select => {
                select.addEventListener('change', function() {
                    if (this.value) {
                        this.style.fontWeight = '500';
                    } else {
                        this.style.fontWeight = 'normal';
                    }
                });
            });

            // Sauvegarde automatique du brouillon
            const saveInterval = setInterval(() => {
                const formData = new FormData(form);
                const draft = {};

                for (let [key, value] of formData.entries()) {
                    if (value.trim() !== '') {
                        draft[key] = value;
                    }
                }

                if (Object.keys(draft).length > 0) {
                    localStorage.setItem('center_draft', JSON.stringify(draft));
                }
            }, 30000); // Sauvegarde toutes les 30 secondes

            // Restauration du brouillon
            const draft = localStorage.getItem('center_draft');
            if (draft) {
                const draftData = JSON.parse(draft);

                if (confirm('Un brouillon a été trouvé. Voulez-vous le restaurer ?')) {
                    Object.keys(draftData).forEach(key => {
                        const field = form.querySelector(`[name="${key}"]`);
                        if (field) {
                            field.value = draftData[key];
                        }
                    });
                }
            }

            // Nettoyage du brouillon lors de la soumission réussie
            form.addEventListener('submit', function() {
                localStorage.removeItem('center_draft');
            });

            // Confirmation avant de quitter la page avec des données non sauvegardées
            let formChanged = false;
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    formChanged = true;
                });
            });

            window.addEventListener('beforeunload', function(e) {
                if (formChanged) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });

            // Masquer l'alerte beforeunload lors de la soumission
            form.addEventListener('submit', function() {
                formChanged = false;
            });

            // Effet de focus progressif
            inputs.forEach((input, index) => {
                input.addEventListener('focus', function() {
                    this.style.transform = 'scale(1.02)';
                    this.style.zIndex = '10';
                });

                input.addEventListener('blur', function() {
                    this.style.transform = 'scale(1)';
                    this.style.zIndex = '1';
                });
            });

            // Animation des icônes dans les labels
            const labelIcons = document.querySelectorAll('label svg');
            labelIcons.forEach(icon => {
                icon.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.2) rotate(10deg)';
                });

                icon.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1) rotate(0deg)';
                });
            });
        });
    </script>
@endpush
