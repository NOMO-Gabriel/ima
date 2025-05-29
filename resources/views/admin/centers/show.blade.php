@extends('layouts.app')

@section('title', 'Détails du Centre - ' . $center->name)

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
                        {{ $center->name }}
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    @can('center.view')
        <!-- En-tête avec titre et actions -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
            <div class="flex items-center">
                <div class="p-4 rounded-xl {{ $center->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold transition-colors duration-300"
                        :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                        {{ $center->name }}
                    </h1>
                    <p class="text-lg transition-colors duration-300"
                       :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                        Code: {{ $center->code }}
                    </p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-2 {{ $center->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $center->is_active ? 'Centre actif' : 'Centre inactif' }}
                    </span>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.centers.index', app()->getLocale()) }}"
                   class="inline-flex items-center px-4 py-2 border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md"
                   :class="{ 'border-gray-600 text-gray-300 bg-gray-800 hover:bg-gray-700': darkMode, 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50': !darkMode }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Retour à la liste
                </a>
                @can('center.update')
                    <a href="{{ route('admin.centers.edit', ['locale' => app()->getLocale(), 'center' => $center]) }}"
                       class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </a>
                @endcan
            </div>
        </div>

        <!-- Messages Flash -->
        <x-flash-message />

        <!-- Contenu principal en grille -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informations principales -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Informations générales -->
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
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="info-item">
                                    <label class="block text-sm font-medium mb-1 transition-colors duration-300"
                                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                        Description
                                    </label>
                                    <p class="text-sm transition-colors duration-300"
                                       :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                                        {{ $center->description ?: 'Aucune description disponible' }}
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label class="block text-sm font-medium mb-1 transition-colors duration-300"
                                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                        Adresse
                                    </label>
                                    <p class="text-sm flex items-start transition-colors duration-300"
                                       :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 mt-0.5 text-[#4CA3DD] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $center->address }}
                                    </p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="info-item">
                                    <label class="block text-sm font-medium mb-1 transition-colors duration-300"
                                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                        Ville
                                    </label>
                                    <p class="text-sm flex items-center transition-colors duration-300"
                                       :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        {{ $center->city ? $center->city->name : 'Non spécifiée' }}
                                    </p>
                                </div>
                                <div class="info-item">
                                    <label class="block text-sm font-medium mb-1 transition-colors duration-300"
                                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                        Académie
                                    </label>
                                    <p class="text-sm flex items-center transition-colors duration-300"
                                       :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        {{ $center->academy ? $center->academy->name : 'Non assignée' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations de contact -->
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
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="info-item">
                                <label class="block text-sm font-medium mb-2 transition-colors duration-300"
                                       :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                    Adresse e-mail
                                </label>
                                @if($center->contact_email)
                                    <a href="mailto:{{ $center->contact_email }}"
                                       class="inline-flex items-center text-sm text-[#4CA3DD] hover:text-[#2A7AB8] transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $center->contact_email }}
                                    </a>
                                @else
                                    <p class="text-sm transition-colors duration-300"
                                       :class="{ 'text-gray-500': darkMode, 'text-gray-500': !darkMode }">
                                        Non renseigné
                                    </p>
                                @endif
                            </div>
                            <div class="info-item">
                                <label class="block text-sm font-medium mb-2 transition-colors duration-300"
                                       :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                    Numéro de téléphone
                                </label>
                                @if($center->contact_phone)
                                    <a href="tel:{{ $center->contact_phone }}"
                                       class="inline-flex items-center text-sm text-[#4CA3DD] hover:text-[#2A7AB8] transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        {{ $center->contact_phone }}
                                    </a>
                                @else
                                    <p class="text-sm transition-colors duration-300"
                                       :class="{ 'text-gray-500': darkMode, 'text-gray-500': !darkMode }">
                                        Non renseigné
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Équipe dirigeante -->
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
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="team-member-card p-4 rounded-lg border transition-all duration-300 hover:shadow-md"
                                     :class="{ 'bg-gray-700 border-gray-600 hover:bg-gray-600': darkMode, 'bg-gray-50 border-gray-200 hover:bg-gray-100': !darkMode }">
                                    <div class="flex items-center">
                                        <div class="p-2 rounded-full bg-blue-100 text-blue-600 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium transition-colors duration-300"
                                               :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                                Directeur
                                            </p>
                                            <p class="text-sm transition-colors duration-300"
                                               :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                                                {{ $center->director ? $center->director->first_name . ' ' . $center->director->last_name : 'Non assigné' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="team-member-card p-4 rounded-lg border transition-all duration-300 hover:shadow-md"
                                     :class="{ 'bg-gray-700 border-gray-600 hover:bg-gray-600': darkMode, 'bg-gray-50 border-gray-200 hover:bg-gray-100': !darkMode }">
                                    <div class="flex items-center">
                                        <div class="p-2 rounded-full bg-purple-100 text-purple-600 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium transition-colors duration-300"
                                               :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                                Directeur Logistique
                                            </p>
                                            <p class="text-sm transition-colors duration-300"
                                               :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                                                {{ $center->logistics_director ? $center->logistics_director->first_name . ' ' . $center->logistics_director->last_name : 'Non assigné' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="team-member-card p-4 rounded-lg border transition-all duration-300 hover:shadow-md"
                                     :class="{ 'bg-gray-700 border-gray-600 hover:bg-gray-600': darkMode, 'bg-gray-50 border-gray-200 hover:bg-gray-100': !darkMode }">
                                    <div class="flex items-center">
                                        <div class="p-2 rounded-full bg-green-100 text-green-600 mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium transition-colors duration-300"
                                               :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                                Directeur Financier
                                            </p>
                                            <p class="text-sm transition-colors duration-300"
                                               :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                                                {{ $center->finance_director ? $center->finance_director->first_name . ' ' . $center->finance_director->last_name : 'Non assigné' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar avec informations complémentaires -->
            <div class="space-y-6">
                <!-- Statut et dates -->
                <div class="rounded-xl shadow-lg border transition-colors duration-300"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 border-b transition-colors duration-300"
                         :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                        <h3 class="text-lg font-semibold flex items-center transition-colors duration-300"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Statut & Dates
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="status-item">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium transition-colors duration-300"
                                      :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                    Statut du centre
                                </span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $center->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $center->is_active ? 'Actif' : 'Inactif' }}
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 transition-colors duration-300"
                                 :class="{ 'bg-gray-700': darkMode, 'bg-gray-200': !darkMode }">
                                <div class="h-2 rounded-full {{ $center->is_active ? 'bg-green-500' : 'bg-red-500' }}" style="width: {{ $center->is_active ? '100' : '0' }}%"></div>
                            </div>
                        </div>

                        <div class="date-info space-y-3">
                            <div class="flex items-center text-sm transition-colors duration-300"
                                 :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <strong>Créé le:</strong>
                                <span class="ml-2">{{ optional($center->created_at)->format('d/m/Y à H:i') ?? 'Non disponible' }}</span>
                            </div>
                            <div class="flex items-center text-sm transition-colors duration-300"
                                 :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <strong>Mis à jour le:</strong>
                                <span class="ml-2">{{ optional($center->updated_at)->format('d/m/Y à H:i') ?? 'Non disponible' }}</span>
                            </div>
                            @if($center->created_at)
                                <div class="flex items-center text-sm transition-colors duration-300"
                                     :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <strong>Âge:</strong>
                                    <span class="ml-2">{{ $center->created_at->diffForHumans() }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="rounded-xl shadow-lg border transition-colors duration-300"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 border-b transition-colors duration-300"
                         :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                        <h3 class="text-lg font-semibold flex items-center transition-colors duration-300"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Actions rapides
                        </h3>
                    </div>
                    <div class="p-6 space-y-3">
                        @can('center.update')
                            <a href="{{ route('admin.centers.edit', ['locale' => app()->getLocale(), 'center' => $center]) }}"
                               class="flex items-center w-full px-4 py-3 text-sm font-medium text-[#4CA3DD] border border-[#4CA3DD] rounded-lg hover:bg-[#4CA3DD] hover:text-white transition-all duration-200 group">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Modifier les informations
                            </a>
                        @endcan

                        <a href="{{ route('admin.centers.index', app()->getLocale()) }}"
                           class="flex items-center w-full px-4 py-3 text-sm font-medium border rounded-lg transition-all duration-200 group"
                           :class="{ 'text-gray-300 border-gray-600 hover:bg-gray-700 hover:text-white': darkMode, 'text-gray-600 border-gray-300 hover:bg-gray-50': !darkMode }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 group-hover:scale-110 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                            Voir tous les centres
                        </a>
                    </div>
                </div>

                <!-- Statistiques rapides -->
                <div class="rounded-xl shadow-lg border transition-colors duration-300"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 border-b transition-colors duration-300"
                         :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                        <h3 class="text-lg font-semibold flex items-center transition-colors duration-300"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Aperçu rapide
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 rounded-lg border transition-colors duration-300"
                                 :class="{ 'bg-gray-700 border-gray-600': darkMode, 'bg-gray-50 border-gray-200': !darkMode }">
                                <div class="text-2xl font-bold text-[#4CA3DD] mb-1">
                                    {{ $center->is_active ? '✓' : '✗' }}
                                </div>
                                <div class="text-xs transition-colors duration-300"
                                     :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                    Statut
                                </div>
                            </div>
                            <div class="text-center p-4 rounded-lg border transition-colors duration-300"
                                 :class="{ 'bg-gray-700 border-gray-600': darkMode, 'bg-gray-50 border-gray-200': !darkMode }">
                                <div class="text-2xl font-bold text-[#4CA3DD] mb-1">
                                    {{ $center->created_at ? $center->created_at->diffInDays(now()) : '0' }}
                                </div>
                                <div class="text-xs transition-colors duration-300"
                                     :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                    Jours d'existence
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                Vous n'avez pas les permissions nécessaires pour voir les détails de ce centre.
            </p>
        </div>
    @endcan
@endsection

@push('styles')
    <style>
        /* Animation pour les cartes au survol */
        .team-member-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .team-member-card:hover {
            transform: translateY(-2px);
        }

        /* Animation pour les boutons d'action */
        .group:hover svg {
            transform: scale(1.1);
        }

        /* Animation des badges de statut */
        .status-badge {
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
        }

        .status-badge:hover::before {
            left: 100%;
        }

        /* Animation pour les barres de progression */
        .progress-bar {
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Effet de brillance pour les cartes principales */
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

        /* Animation d'apparition */
        .animate-fade-in {
            opacity: 0;
            animation: fadeInUp 0.6s ease forwards;
        }

        .animate-fade-in:nth-child(1) { animation-delay: 0.1s; }
        .animate-fade-in:nth-child(2) { animation-delay: 0.2s; }
        .animate-fade-in:nth-child(3) { animation-delay: 0.3s; }

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

        /* Styles responsifs améliorés */
        @media (max-width: 768px) {
            .team-member-card {
                margin-bottom: 1rem;
            }
        }

        /* Hover effects pour les liens de contact */
        a[href^="mailto:"]:hover,
        a[href^="tel:"]:hover {
            transform: translateX(5px);
        }

        /* Style pour les info-items */
        .info-item {
            padding: 0.5rem 0;
            border-bottom: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            border-bottom-color: rgba(76, 163, 221, 0.3);
            padding-left: 0.5rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des éléments au scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observer toutes les cartes principales
            const cards = document.querySelectorAll('.rounded-xl');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = `all 0.6s cubic-bezier(0.4, 0, 0.2, 1) ${index * 0.1}s`;
                observer.observe(card);
            });

            // Animation des barres de progression
            const progressBars = document.querySelectorAll('[style*="width"]');
            const progressObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const bar = entry.target;
                        const originalWidth = bar.style.width;
                        bar.style.width = '0%';
                        setTimeout(() => {
                            bar.style.width = originalWidth;
                        }, 500);
                    }
                });
            }, { threshold: 0.5 });

            progressBars.forEach(bar => progressObserver.observe(bar));

            // Effet de typing pour le titre
            const title = document.querySelector('h1');
            if (title) {
                const originalText = title.textContent;
                title.textContent = '';

                let i = 0;
                function typeWriter() {
                    if (i < originalText.length) {
                        title.textContent += originalText.charAt(i);
                        i++;
                        setTimeout(typeWriter, 50);
                    }
                }

                setTimeout(typeWriter, 800);
            }

            // Animation des membres de l'équipe
            const teamMembers = document.querySelectorAll('.team-member-card');
            teamMembers.forEach((member, index) => {
                member.style.opacity = '0';
                member.style.transform = 'translateX(-20px)';
                member.style.transition = `all 0.5s cubic-bezier(0.4, 0, 0.2, 1) ${(index + 1) * 0.2}s`;

                setTimeout(() => {
                    member.style.opacity = '1';
                    member.style.transform = 'translateX(0)';
                }, 1000 + (index * 200));
            });

            // Smooth scrolling pour les liens internes
            const internalLinks = document.querySelectorAll('a[href^="#"]');
            internalLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Effet de particules subtiles en arrière-plan (optionnel)
            function createParticle() {
                const particle = document.createElement('div');
                particle.style.cssText = `
                    position: fixed;
                    width: 2px;
                    height: 2px;
                    background: rgba(76, 163, 221, 0.3);
                    border-radius: 50%;
                    pointer-events: none;
                    z-index: -1;
                    animation: float 3s linear infinite;
                `;

                particle.style.left = Math.random() * window.innerWidth + 'px';
                particle.style.top = '100vh';

                document.body.appendChild(particle);

                setTimeout(() => {
                    particle.remove();
                }, 3000);
            }

            // Style pour l'animation des particules
            const style = document.createElement('style');
            style.textContent = `
                @keyframes float {
                    to {
                        transform: translateY(-100vh) rotate(360deg);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);

            // Créer une particule toutes les 5 secondes
            setInterval(createParticle, 5000);
        });
    </script>
@endpush
