@extends('layouts.app')

@section('title', 'Ajouter un Centre')

@section('content')
    <div class="bg-white rounded-xl p-6 shadow-md mb-8">
        <!-- Fil d'Ariane -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-[#64748B] hover:text-[#2A7AB8]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Tableau de bord
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-[#64748B] hover:text-[#2A7AB8]">Centres</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#64748B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <span class="ml-1 text-sm font-medium text-[#4CA3DD]">Ajouter un centre</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
            <h1 class="text-2xl font-bold text-[#1E293B] flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Ajouter un Centre
            </h1>
        </div>

        <div class="bg-[#F8FAFC] rounded-lg shadow-md overflow-hidden">
            <div class="p-1 bg-gradient-to-r from-[#4CA3DD] to-[#2A7AB8]"></div>
            <div class="p-6">
                <form action="{{ route('admin.centers.store', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Première colonne -->
                        <div class="space-y-6">
                            <div class="relative form-group">
                                <label for="name" class="block font-medium text-[#1E293B] mb-1">
                                    Nom <span class="text-[#F87171]">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 2a1 1 0 00-1 1v1a1 1 0 002 0V3a1 1 0 00-1-1zM4 4h3a3 3 0 006 0h3a2 2 0 012 2v9a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45 4a2.5 2.5 0 10-4.9 0h4.9zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                           class="pl-10 block w-full rounded-md border-gray-300 focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50 transition-all" placeholder="Nom du centre" />
                                </div>
                                @error('name') <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p> @enderror
                            </div>

                            <div class="relative form-group">
                                <label for="code" class="block font-medium text-[#1E293B] mb-1">
                                    Code
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="code" name="code" value="{{ old('code') }}"
                                           class="pl-10 block w-full rounded-md border-gray-300 focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50 transition-all" placeholder="Code unique du centre" />
                                </div>
                                @error('code') <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p> @enderror
                            </div>

                            <div class="relative form-group">
                                <label for="academy_id" class="block font-medium text-[#1E293B] mb-1">
                                    Académie <span class="text-[#F87171]">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                        </svg>
                                    </div>
                                    <select id="academy_id" name="academy_id" required
                                            class="pl-10 block w-full rounded-md border-gray-300 focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50 transition-all">
                                        <option value="">-- Sélectionner une académie --</option>
                                        @foreach($academies as $academy)
                                            <option value="{{ $academy->id }}" {{ old('academy_id') == $academy->id ? 'selected' : '' }}>{{ $academy->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('academy_id') <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p> @enderror
                            </div>

                            <div class="relative form-group">
                                <label for="director_id" class="block font-medium text-[#1E293B] mb-1">
                                    Directeur
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <select id="director_id" name="director_id"
                                            class="pl-10 block w-full rounded-md border-gray-300 focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50 transition-all">
                                        <option value="">-- Sélectionner un directeur --</option>
                                        @foreach($directors as $director)
                                            <option value="{{ $director->id }}" {{ old('director_id') == $director->id ? 'selected' : '' }}>
                                                {{ $director->first_name }} {{ $director->last_name }} ({{ $director->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('director_id') <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Deuxième colonne -->
                        <div class="space-y-6">
                            <div class="relative form-group">
                                <label for="city_id" class="block font-medium text-[#1E293B] mb-1">
                                    Ville <span class="text-[#F87171]">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <select id="city_id" name="city_id" required
                                            class="pl-10 block w-full rounded-md border-gray-300 focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50 transition-all">
                                        <option value="">-- Sélectionner une ville --</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('city_id') <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p> @enderror
                            </div>

                            <div class="relative form-group">
                                <label for="address" class="block font-medium text-[#1E293B] mb-1">
                                    Adresse <span class="text-[#F87171]">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input type="text" id="address" name="address" value="{{ old('address') }}" required
                                           class="pl-10 block w-full rounded-md border-gray-300 focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50 transition-all" placeholder="Adresse complète du centre" />
                                </div>
                                @error('address') <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p> @enderror
                            </div>

                            <div class="relative form-group">
                                <label for="contact_email" class="block font-medium text-[#1E293B] mb-1">
                                    Email de contact
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email') }}"
                                           class="pl-10 block w-full rounded-md border-gray-300 focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50 transition-all" placeholder="example@domain.com" />
                                </div>
                                @error('contact_email') <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p> @enderror
                            </div>

                            <div class="relative form-group">
                                <label for="contact_phone" class="block font-medium text-[#1E293B] mb-1">
                                    Téléphone de contact
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#64748B]" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone') }}"
                                           class="pl-10 block w-full rounded-md border-gray-300 focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50 transition-all" placeholder="+237 XXX XXX XXX" />
                                </div>
                                @error('contact_phone') <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="p-4 mt-6 bg-white border border-gray-200 rounded-lg">
                        <label for="is_active" class="inline-flex items-center cursor-pointer">
                            <span class="relative">
                                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="sr-only peer" />
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4CA3DD]"></div>
                            </span>
                            <span class="ml-3 text-sm font-medium text-[#1E293B]">Centre actif</span>
                        </label>
                        @error('is_active') <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end pt-5 border-t border-gray-200">
                        <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}"
                           class="px-4 py-2 text-sm font-medium text-[#1E293B] bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] transition-all duration-200">
                            Annuler
                        </a>
                        <button type="submit"
                                class="ml-3 inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-[#4CA3DD] border border-transparent rounded-md shadow-sm hover:bg-[#2A7AB8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 -ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Créer le centre
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Animation d'apparition du formulaire */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .bg-white {
            animation: fadeIn 0.3s ease-out;
        }

        /* Amélioration des champs de formulaire */
        .form-group {
            transition: all 0.3s ease;
        }

        .form-group:hover {
            transform: translateY(-2px);
        }

        /* Style des sélecteurs au survol */
        select:hover, input:hover {
            border-color: #4CA3DD;
        }

        /* Animation des boutons */
        button[type="submit"], a.inline-flex {
            transition: all 0.2s ease;
        }

        button[type="submit"]:hover, a.inline-flex:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Effet de focus amélioré */
        input:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(76, 163, 221, 0.2);
        }

        /* Responsive pour petit mobile */
        @media (max-width: 400px) {
            .flex.justify-end {
                flex-direction: column;
            }

            .flex.justify-end a, .flex.justify-end button {
                width: 100%;
                margin-left: 0;
                margin-top: 0.5rem;
                text-align: center;
            }
        }
    </style>
@endpush
