@extends('layouts.app')

@section('title', 'Nouvelle Transaction')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#4CA3DD] dark:text-gray-400 dark:hover:text-white">
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
                    <a href="{{ route('admin.transactions.index', ['locale' => app()->getLocale()]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-[#4CA3DD] md:ml-2 dark:text-gray-400 dark:hover:text-white">Transactions</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 mx-1 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Nouvelle Transaction</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8 dark:bg-gray-800">
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h1 class="text-2xl font-bold text-gray-700 dark:text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Créer une Nouvelle Transaction
            </h1>
            <a href="{{ route('admin.transactions.index', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 font-medium rounded-lg text-sm transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                </svg>
                Retour à la liste
            </a>
        </div>

        <form method="POST" action="{{ route('admin.transactions.store', ['locale' => app()->getLocale()]) }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Raison de la transaction -->
                <div class="md:col-span-2">
                    <label for="reason_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Raison de la transaction <span class="text-red-500">*</span></label>
                    <select name="reason_id" id="reason_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#4CA3DD] dark:focus:border-[#4CA3DD] @error('reason_id') border-red-500 @enderror" required>
                        <option value="">-- Sélectionner une raison --</option>
                        <optgroup label="💰 Entrées (IN)">
                            @foreach($reasons->where('direction', 'IN') as $reason)
                                <option value="{{ $reason->id }}" {{ old('reason_id') == $reason->id ? 'selected' : '' }}>
                                    {{ $reason->label }}
                                </option>
                            @endforeach
                        </optgroup>
                        <optgroup label="💸 Sorties (OUT)">
                            @foreach($reasons->where('direction', 'OUT') as $reason)
                                <option value="{{ $reason->id }}" {{ old('reason_id') == $reason->id ? 'selected' : '' }}>
                                    {{ $reason->label }}
                                </option>
                            @endforeach
                        </optgroup>
                    </select>
                    @error('reason_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Montant -->
                <div>
                    <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Montant (FCFA) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="amount" id="amount"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] block w-full p-2.5 pr-12 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#4CA3DD] dark:focus:border-[#4CA3DD] @error('amount') border-red-500 @enderror"
                               value="{{ old('amount') }}"
                               min="0" step="0.01" required placeholder="0.00">
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 dark:text-gray-400 text-sm">
                            FCFA
                        </span>
                    </div>
                    @error('amount')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bénéficiaire -->
                <div>
                    <label for="receiver_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Bénéficiaire (Optionnel)</label>
                    <select name="receiver_id" id="receiver_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#4CA3DD] dark:focus:border-[#4CA3DD] @error('receiver_id') border-red-500 @enderror">
                        <option value="">-- Aucun bénéficiaire spécifique --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('receiver_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('receiver_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Centre -->
                <div>
                    <label for="center_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Centre (Optionnel)</label>
                    <select name="center_id" id="center_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#4CA3DD] dark:focus:border-[#4CA3DD] @error('center_id') border-red-500 @enderror">
                        <option value="">-- Aucun centre spécifique --</option>
                        @foreach($centers as $center)
                            <option value="{{ $center->id }}" {{ old('center_id') == $center->id ? 'selected' : '' }}>
                                {{ $center->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('center_id')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description (Optionnel)</label>
                    <textarea name="description" id="description" rows="4"
                              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#4CA3DD] focus:border-[#4CA3DD] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-[#4CA3DD] dark:focus:border-[#4CA3DD] @error('description') border-red-500 @enderror"
                              placeholder="Décrivez la transaction en détail (optionnel)..."
                              maxlength="1000">{{ old('description') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400"><span id="description-counter">0</span>/1000 caractères</p>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700 pt-6">
                <a href="{{ route('admin.transactions.index', ['locale' => app()->getLocale()]) }}" class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-[#4CA3DD] focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    Annuler
                </a>
                <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg text-sm transition-colors duration-200 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Créer la Transaction
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Compteur de caractères pour la description
    const descriptionTextarea = document.getElementById('description');
    const descriptionCounter = document.getElementById('description-counter');

    function updateCounter() {
        if (descriptionTextarea && descriptionCounter) {
            descriptionCounter.textContent = descriptionTextarea.value.length;
        }
    }

    if (descriptionTextarea) {
        descriptionTextarea.addEventListener('input', updateCounter);
        updateCounter(); // Initialiser au chargement
    }

    // Auto-focus sur le premier champ (raison_id)
    const reasonSelect = document.getElementById('reason_id');
    if (reasonSelect) {
        reasonSelect.focus();
    }
});
</script>
@endpush
