@extends('layouts.app')

@section('title', 'Ajouter un Utilisateur')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- En-tête avec fil d'ariane -->
        <div class="mb-8">
            <div class="flex items-center text-sm text-gray-500 mb-2">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="hover:text-[#4CA3DD]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <span class="mx-2">›</span>
                <a href="{{ route('admin.users.index', ['locale' => app()->getLocale()]) }}" class="hover:text-[#4CA3DD]">Utilisateurs</a>
                <span class="mx-2">›</span>
                <span class="text-blue-600">Ajouter</span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Ajouter un Utilisateur</h1>
            <p class="mt-2 text-gray-600 max-w-3xl">Créez un nouvel utilisateur et définissez ses informations personnelles, ses accès et ses rôles dans le système.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Merci de corriger les erreurs suivantes:</h3>
                        <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-1">
                <!-- Onglets de navigation pour le formulaire -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px" aria-label="Tabs">
                        <button type="button" class="tab-btn active-tab border-b-2 border-[#4CA3DD] py-4 px-6 text-center text-[#4CA3DD] font-medium text-sm" onclick="showTab('personal')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Informations Personnelles
                        </button>
                        <button type="button" class="tab-btn border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('access')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Accès & Sécurité
                        </button>
                        <button type="button" class="tab-btn border-b-2 border-transparent py-4 px-6 text-center text-gray-500 hover:text-gray-700 font-medium text-sm" onclick="showTab('roles')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Rôles & Permissions
                        </button>
                    </nav>
                </div>

                <form action="{{ route('admin.users.store', ['locale' => app()->getLocale()]) }}" method="POST" class="p-6">
                    @csrf

                    <!-- Section 1: Informations personnelles -->
                    <div id="tab-personal" class="tab-content">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                                           class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full rounded-md border-gray-300 shadow-sm"
                                           placeholder="Jean">
                                </div>
                                @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Nom <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                                           class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full rounded-md border-gray-300 shadow-sm"
                                           placeholder="Dupont">
                                </div>
                                @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                           class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full rounded-md border-gray-300 shadow-sm"
                                           placeholder="jean.dupont@exemple.com">
                                </div>
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="phone_number" class="block text-sm font-medium text-gray-700">Téléphone <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" required
                                           class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full rounded-md border-gray-300 shadow-sm"
                                           placeholder="+237 6XX XX XX XX">
                                </div>
                                @error('phone_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <input type="text" name="city" id="city" value="{{ old('city') }}"
                                           class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full rounded-md border-gray-300 shadow-sm"
                                           placeholder="Yaoundé">
                                </div>
                                @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                                           class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full rounded-md border-gray-300 shadow-sm"
                                           placeholder="123 Rue de l'Exemple">
                                </div>
                                @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 pt-4 flex justify-end">
                                <button type="button" class="px-5 py-2 bg-[#4CA3DD] text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all flex items-center" onclick="showTab('access')">
                                    Suivant: Accès & Sécurité
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Accès & Sécurité -->
                    <div id="tab-access" class="tab-content hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input type="password" name="password" id="password" required
                                           class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères, incluant majuscules, minuscules et chiffres</p>
                                @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 md:col-span-1">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe <span class="text-red-500">*</span></label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                           class="pl-10 focus:ring-blue-500 focus:border-blue-500 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label for="status" class="block text-sm font-medium text-gray-700">Statut du compte <span class="text-red-500">*</span></label>
                                <div class="mt-1">
                                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none status-option
                                         {{ old('status') == 'pending_validation' || !old('status') ? 'border-blue-500 border-2' : 'border-gray-300' }}">
                                            <input type="radio" name="status" id="status_pending" value="pending_validation" class="sr-only"
                                                {{ old('status') == 'pending_validation' || !old('status') ? 'checked' : '' }}>
                                            <div class="flex items-center">
                                                <div class="text-sm">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500 mr-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <p class="font-medium text-gray-900">En attente</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">Requiert validation</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none status-option
                                         {{ old('status') == 'pending_finalization' ? 'border-blue-500 border-2' : 'border-gray-300' }}">
                                            <input type="radio" name="status" id="status_finalization" value="pending_finalization" class="sr-only"
                                                {{ old('status') == 'pending_finalization' ? 'checked' : '' }}>
                                            <div class="flex items-center">
                                                <div class="text-sm">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 mr-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </div>
                                                        <p class="font-medium text-gray-900">À finaliser</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">En cours de finalisation</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none status-option
                                         {{ old('status') == 'active' ? 'border-blue-500 border-2' : 'border-gray-300' }}">
                                            <input type="radio" name="status" id="status_active" value="active" class="sr-only"
                                                {{ old('status') == 'active' ? 'checked' : '' }}>
                                            <div class="flex items-center">
                                                <div class="text-sm">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-500 mr-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <p class="font-medium text-gray-900">Actif</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">Compte actif</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none status-option
                                         {{ old('status') == 'suspended' ? 'border-blue-500 border-2' : 'border-gray-300' }}">
                                            <input type="radio" name="status" id="status_suspended" value="suspended" class="sr-only"
                                                {{ old('status') == 'suspended' ? 'checked' : '' }}>
                                            <div class="flex items-center">
                                                <div class="text-sm">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-500 mr-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </div>
                                                        <p class="font-medium text-gray-900">Suspendu</p>
                                                    </div>
                                                    <p class="text-xs text-gray-500 mt-1">Compte désactivé</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-2 pt-4 flex justify-between">
                                <button type="button" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all flex items-center" onclick="showTab('personal')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                    </svg>
                                    Précédent
                                </button>
                                <button type="button" class="px-5 py-2 bg-[#4CA3DD] text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all flex items-center" onclick="showTab('roles')">
                                    Suivant: Rôles
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Rôles & Permissions -->
                    <div id="tab-roles" class="tab-content hidden">
                        <div class="space-y-6">
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            L'attribution de rôles détermine quelles fonctionnalités et données l'utilisateur pourra accéder. Veuillez sélectionner au moins un rôle.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($roles->chunk(ceil($roles->count() / 3)) as $chunk)
                                    <div class="space-y-4">
                                        @foreach($chunk as $role)
                                            <div class="relative bg-white border rounded-lg shadow-sm p-4 hover:border-blue-500 transition-all duration-200
                                    {{ in_array($role->name, old('roles', [])) ? 'border-blue-500 bg-blue-50' : 'border-gray-300' }}">
                                                <div class="flex items-start">
                                                    <div class="flex items-center h-5">
                                                        <input id="role_{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->name }}"
                                                               {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                                               class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                    </div>
                                                    <div class="ml-3 text-sm">
                                                        <label for="role_{{ $role->id }}" class="font-medium text-gray-700 cursor-pointer flex items-center">
                                                            <span class="capitalize">{{ $role->name }}</span>
                                                            @if($role->level)
                                                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full
                                                    {{ $role->level == 'national' ? 'bg-blue-100 text-blue-800' :
                                                    ($role->level == 'city' ? 'bg-green-100 text-green-800' :
                                                    ($role->level == 'center' ? 'bg-purple-100 text-purple-800' :
                                                    'bg-gray-100 text-gray-800')) }}">
                                                    {{ $role->level }}
                                                </span>
                                                            @endif
                                                        </label>
                                                        @if($role->description)
                                                            <p class="text-gray-500 mt-1">{{ $role->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            @error('roles')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <div class="pt-6 border-t border-gray-200 mt-6 flex justify-between">
                                <button type="button" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all flex items-center" onclick="showTab('access')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                    </svg>
                                    Précédent
                                </button>
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('admin.users.index', ['locale' => app()->getLocale()]) }}" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all">
                                        Annuler
                                    </a>
                                    <button type="submit" class="px-5 py-2 bg-[#4CA3DD] text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Créer l'utilisateur
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Gérer les onglets du formulaire
        function showTab(tabName) {
            // Masquer tous les contenus d'onglets
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Afficher le contenu de l'onglet sélectionné
            document.getElementById('tab-' + tabName).classList.remove('hidden');

            // Mettre à jour les styles des boutons d'onglets
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active-tab', 'border-[#4CA3DD]', 'text-[#4CA3DD]');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            // Activer le bouton de l'onglet sélectionné
            const activeButton = document.querySelector(`.tab-btn[onclick="showTab('${tabName}')"]`);
            activeButton.classList.add('active-tab', 'border-[#4CA3DD]', 'text-[#4CA3DD]');
            activeButton.classList.remove('border-transparent', 'text-gray-500');
        }

        // Gérer les options de statut
        document.querySelectorAll('.status-option').forEach(option => {
            option.addEventListener('click', function() {
                // Désélectionner toutes les options
                document.querySelectorAll('.status-option').forEach(opt => {
                    opt.classList.remove('border-[#4CA3DD]', 'border-2');
                    opt.classList.add('border-gray-300');
                });

                // Sélectionner l'option
                this.classList.remove('border-gray-300');
                this.classList.add('border-[#4CA3DD]', 'border-2');

                // Cocher le bouton radio correspondant
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
            });
        });
    </script>

    <style>
        /* Animation de transition pour les onglets */
        .tab-content {
            transition: all 0.3s ease-in-out;
        }

        /* Style pour l'onglet actif */
        .tab-btn.active-tab {
            position: relative;
        }

        /* Animation en survol pour les options de statut */
        .status-option:hover {
            border-color: #93c5fd;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>
@endsection
