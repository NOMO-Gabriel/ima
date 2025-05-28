@extends('layouts.app')

@section('title', 'Ajouter une Académie')

@section('content')
    <div class="py-4">
        <!-- Fil d'Ariane -->
        <nav class="flex mb-5" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#4CA3DD]">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Tableau de bord
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('admin.academies.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-[#4CA3DD] md:ml-2">Académies</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 text-sm font-medium text-[#4CA3DD] md:ml-2">Nouvelle académie</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="mb-6">
            <h1 class="text-2xl font-bold">Ajouter une Académie</h1>
            <p class="text-gray-600">Créez une nouvelle académie et attribuez un directeur pour gérer ses opérations.</p>
        </div>

        <div class="bg-white rounded-md shadow-sm">
            <!-- En-tête -->
            <div class="p-4 bg-[#4CA3DD] text-white rounded-t-md">
                <h2 class="text-lg font-medium">Informations de l'académie</h2>
            </div>

            <!-- Formulaire -->
            <form action="{{ route('admin.academies.store', ['locale' => app()->getLocale()]) }}" method="POST" class="p-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50">
                        @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Code</label>
                        <input type="text" name="code" id="code" value="{{ old('code') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50">
                        @error('code')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- <h3 class="text-lg font-medium text-gray-800 mt-6 mb-4">Coordonnées</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50">
                        @error('location')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div> -->

                    <!-- <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Email de contact</label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50">
                        @error('contact_email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone de contact</label>
                        <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}"
                               class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50">
                        @error('contact_phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div> -->
                </div>

                <!-- <h3 class="text-lg font-medium text-gray-800 mt-6 mb-4">Configuration</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="lang" class="block text-sm font-medium text-gray-700 mb-1">Langue</label>
                        <select name="lang" id="lang"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50">
                            <option value="">-- Sélectionner --</option>
                            <option value="FR" {{ old('lang') == 'FR' ? 'selected' : '' }}>Français</option>
                            <option value="EN" {{ old('lang') == 'EN' ? 'selected' : '' }}>Anglais</option>
                        </select>
                        @error('lang')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div> -->

                    <div>
                        <label for="director_id" class="block text-sm font-medium text-gray-700 mb-1">Directeur</label>
                        <select name="director_id" id="director_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-[#4CA3DD] focus:ring focus:ring-[#4CA3DD] focus:ring-opacity-50">
                            <option value="">-- Aucun --</option>
                            @foreach($directors as $director)
                                <option value="{{ $director->id }}" {{ old('director_id') == $director->id ? 'selected' : '' }}>
                                    {{ $director->first_name }} {{ $director->last_name }} ({{ $director->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('director_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- <div class="mb-6">
                    <label for="is_active" class="flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                               {{ old('is_active', '1') ? 'checked' : '' }}
                               class="h-4 w-4 text-[#4CA3DD] border-gray-300 rounded focus:ring-[#4CA3DD]">
                        <span class="ml-2 text-sm text-gray-700">Activer cette académie</span>
                    </label>
                </div> -->

                <div class="flex justify-end space-x-3 border-t pt-4">
                    <a href="{{ route('admin.academies.index', ['locale' => app()->getLocale()]) }}"
                       class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD]">
                        Annuler
                    </a>
                    <button type="submit"
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#4CA3DD] hover:bg-[#2A7AB8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD]">
                        Créer l'académie
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
