@extends('layouts.app')

@section('title', 'Modifier la Formation')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Tableau de bord
                </a>
            </li>
            <li class="inline-flex items-center">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.formations.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Gestion des Formations</a>
                </div>
            </li>
            <li class="inline-flex items-center">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.formations.show', ['locale' => app()->getLocale(), 'formation' => $formation->id]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">{{ $formation->name }}</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm text-[#4CA3DD] font-medium md:ml-2 dark:text-gray-400">Modifier</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-5 mb-8">
        <!-- En-tête avec titre et boutons d'action -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-700 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Modifier la Formation
            </h1>
            <div class="flex flex-wrap gap-3 justify-end">
                <a href="{{ route('admin.formations.show', ['locale' => app()->getLocale(), 'formation' => $formation->id]) }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                    </svg>
                    Retour au détail
                </a>
            </div>
        </div>

        <!-- Message d'erreur général si présent -->
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p><strong>Attention !</strong> Veuillez corriger les erreurs ci-dessous.</p>
                </div>
            </div>
        @endif

        <!-- Formulaire de modification -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-3 rounded-t-lg">
                <h2 class="text-lg font-semibold text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Informations de la formation
                </h2>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.formations.update', ['locale' => app()->getLocale(), 'formation' => $formation->id]) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Colonne gauche -->
                        <div class="space-y-6">
                            <div class="form-group">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nom <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="text" name="name" id="name" value="{{ old('name', $formation->name) }}" required
                                           class="block w-full pr-10 border-gray-300 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] rounded-md @error('name') border-red-300 text-red-900 placeholder-red-300 @enderror">
                                    @error('name')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    @enderror
                                </div>
                                @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                                    Prix (XAF)
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $formation->price) }}"
                                           class="block w-full pr-10 border-gray-300 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] rounded-md @error('price') border-red-300 text-red-900 placeholder-red-300 @enderror">
                                    @error('price')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    @enderror
                                </div>
                                @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="hours" class="block text-sm font-medium text-gray-700 mb-1">
                                    Durée (heures)
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" name="hours" id="hours" value="{{ old('hours', $formation->hours) }}"
                                           class="block w-full pr-10 border-gray-300 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] rounded-md @error('hours') border-red-300 text-red-900 placeholder-red-300 @enderror">
                                    @error('hours')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    @enderror
                                </div>
                                @error('hours')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Colonne droite -->
                        <div class="space-y-6">
                            <div class="form-group">
                                <label for="phase_id" class="block text-sm font-medium text-gray-700 mb-1">
                                    Phase
                                </label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <select name="phase_id" id="phase_id"
                                            class="block w-full border-gray-300 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] rounded-md @error('phase_id') border-red-300 text-red-900 placeholder-red-300 @enderror">
                                        <option value="">-- Sélectionner une phase --</option>
                                        @foreach($phases as $phase)
                                            <option value="{{ $phase->id }}" {{ old('phase_id', $formation->phase_id) == $phase->id ? 'selected' : '' }}>{{ $phase->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('phase_id')
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    @enderror
                                </div>
                                @error('phase_id')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Description
                                </label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <textarea name="description" id="description" rows="6"
                                              class="block w-full border-gray-300 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] rounded-md @error('description') border-red-300 text-red-900 placeholder-red-300 @enderror">{{ old('description', $formation->description) }}</textarea>
                                </div>
                                @error('description')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="pt-5 border-t border-gray-200 mt-8">
                        <div class="flex justify-end">
                            <a href="{{ route('admin.formations.index', ['locale' => app()->getLocale()]) }}" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Annuler
                            </a>
                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-[#4CA3DD] hover:bg-[#2A7AB8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD]">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Validation côté client si nécessaire
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                const nameField = document.getElementById('name');
                if (!nameField.value.trim()) {
                    event.preventDefault();
                    nameField.classList.add('border-red-300');
                    const errorEl = document.createElement('p');
                    errorEl.classList.add('mt-2', 'text-sm', 'text-red-600');
                    errorEl.textContent = 'Le nom de la formation est requis.';
                    nameField.parentNode.appendChild(errorEl);
                }
            });
        });
    </script>
@endpush
