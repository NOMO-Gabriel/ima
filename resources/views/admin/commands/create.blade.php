@extends('layouts.app')

@section('title', 'Créer une Commande')

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
                    <a href="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}"
                       class="ml-1 text-sm font-medium transition-colors duration-300 md:ml-2"
                       :class="{ 'text-gray-400 hover:text-white': darkMode, 'text-gray-700 hover:text-[#4CA3DD]': !darkMode }">
                        Commandes
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
                        Créer une commande
                    </span>
                </div>
            </li>
        </ol>
    </nav>

    @can('ressource.material.create') {{-- Permission adaptée --}}
    <!-- En-tête -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
        <div class="flex items-center">
            <div class="p-4 rounded-xl bg-[#4CA3DD] text-white mr-4">
                {{-- Icon for creating command --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold transition-colors duration-300"
                    :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                    Créer une nouvelle commande
                </h1>
                <p class="text-lg transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                    Ajoutez les matériels et quantités souhaités pour la commande.
                </p>
            </div>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('admin.commands.index', app()->getLocale()) }}"
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
    <form action="{{ route('admin.commands.store', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-8">
        @csrf

        <!-- Section Détails de la commande -->
        <div class="rounded-xl shadow-lg border transition-colors duration-300"
             :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
            <div class="p-6 border-b transition-colors duration-300"
                 :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                <h2 class="text-xl font-semibold flex items-center transition-colors duration-300"
                    :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                    {{-- Icon for order details --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-[#4CA3DD]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Matériels commandés
                </h2>
                <p class="text-sm mt-1 transition-colors duration-300"
                   :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                    Ajoutez ou supprimez des matériels pour cette commande.
                </p>
            </div>
            <div class="p-6">
                <div id="units-container" class="space-y-6">
                    {{-- Initial unit row - Blade will process this one for old() and @error --}}
                    @php $initialUnits = old('units', [['material_id' => '', 'quantity' => '']]); @endphp
                    @foreach($initialUnits as $index => $unit)
                        <div class="unit-row form-group p-4 rounded-lg border transition-colors duration-300"
                             :class="{ 'bg-gray-700/50 border-gray-600': darkMode, 'bg-gray-50 border-gray-200': !darkMode }">
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                                <!-- Matériel -->
                                <div class="md:col-span-6">
                                    <label for="units_{{ $index }}_material_id" class="block text-sm font-medium mb-1 transition-colors duration-300"
                                           :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                        Matériel <span class="text-red-500">*</span>
                                    </label>
                                    <select name="units[{{ $index }}][material_id]" id="units_{{ $index }}_material_id" required
                                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('units.'.$index.'.material_id') border-red-500 @enderror"
                                            :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-white border-gray-300': !darkMode }">
                                        <option value="">-- Choisir un matériel --</option>
                                        @foreach($materials as $material)
                                            <option value="{{ $material->id }}" {{ (isset($unit['material_id']) && $unit['material_id'] == $material->id) ? 'selected' : '' }}>
                                                {{ $material->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('units.'.$index.'.material_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Quantité -->
                                <div class="md:col-span-4">
                                    <label for="units_{{ $index }}_quantity" class="block text-sm font-medium mb-1 transition-colors duration-300"
                                           :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                        Quantité <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="units[{{ $index }}][quantity]" id="units_{{ $index }}_quantity" value="{{ $unit['quantity'] ?? '' }}" min="1" required
                                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('units.'.$index.'.quantity') border-red-500 @enderror"
                                           :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-white border-gray-300': !darkMode }"
                                           placeholder="Qté">
                                    @error('units.'.$index.'.quantity')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Bouton Supprimer -->
                                <div class="md:col-span-2 flex items-end">
                                    @if($index > 0 || count($initialUnits) > 1) {{-- Show remove button if not the first row or if there are multiple initial rows --}}
                                    <button type="button" class="remove-unit-btn w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200"
                                            :class="{ 'bg-red-500 hover:bg-red-400 focus:ring-offset-gray-800': darkMode, 'bg-red-600 hover:bg-red-700 focus:ring-offset-white': !darkMode }">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Supprimer
                                    </button>
                                    @else
                                        <div class="w-full h-[50px]"></div> {{-- Placeholder to maintain layout for the first row if it's the only one --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    <button type="button" id="add-unit-btn"
                            class="inline-flex items-center px-4 py-2 border border-dashed border-gray-400 text-sm font-medium rounded-md shadow-sm transition-all duration-200 hover:shadow-md"
                            :class="{ 'text-gray-300 hover:bg-gray-700 hover:border-gray-500': darkMode, 'text-gray-700 hover:bg-gray-50 hover:border-gray-500': !darkMode }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Ajouter un matériel
                    </button>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6">
            <a href="{{ route('admin.commands.index', app()->getLocale()) }}"
               class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md order-2 sm:order-1"
               :class="{ 'border-gray-600 text-gray-300 bg-gray-800 hover:bg-gray-700': darkMode, 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50': !darkMode }">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                Annuler
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center px-8 py-3 bg-[#4CA3DD] hover:bg-[#2A7AB8] text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 order-1 sm:order-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Créer la commande
            </button>
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
                Vous n'avez pas les permissions nécessaires pour créer une commande.
            </p>
        </div>
    @endcan
@endsection

@push('styles')
    {{-- Copied styles from the example --}}
    <style>
        .form-group { opacity: 0; animation: fadeInUp 0.6s ease forwards; }
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.15s; }
        .form-group:nth-child(3) { animation-delay: 0.2s; }
        /* Add more if needed for static elements, dynamic ones will just get fadeInUp */

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        input:focus, textarea:focus, select:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(76, 163, 221, 0.15);
        }
        .dark input:focus, .dark textarea:focus, .dark select:focus {
            box-shadow: 0 4px 12px rgba(76, 163, 221, 0.25);
        }

        .form-group label { transition: all 0.3s ease; }
        .form-group:hover label { transform: translateX(2px); }

        .rounded-xl { position: relative; overflow: hidden; }
        .rounded-xl::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(76, 163, 221, 0.1), transparent);
            transition: left 0.8s ease; z-index: 1;
        }
        .rounded-xl:hover::before { left: 100%; }
        .rounded-xl > * { position: relative; z-index: 2; }

        .btn-loading { position: relative; color: transparent !important; } /* !important to override text color */
        .btn-loading::after {
            content: ''; position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 20px; height: 20px; border: 2px solid #ffffff;
            border-radius: 50%; border-top-color: transparent;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: translate(-50%, -50%) rotate(360deg); } }

        /* Basic visual validation feedback (can be enhanced by JS) */
        .form-group select.border-red-500,
        .form-group input.border-red-500 { /* Targeting specifically if error class is present */
            /* border-color: #ef4444; /* Tailwind class already does this */
        }
        .form-group select.border-green-500, /* For JS validation */
        .form-group input.border-green-500 {
            /* border-color: #10b981; */
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let unitIndex = {{ count($initialUnits) }};
            console.log("Unit Index:", unitIndex);
            const unitsContainer = document.getElementById('units-container');
            const materials = @json($materials->map(fn($m) => ['id' => $m->id, 'name' => $m->name]));
            const darkMode = document.documentElement.classList.contains('dark'); // Detect dark mode

            // Function to create a new unit row (material + quantity)
            function createUnitRow(index) {
                const newUnitDiv = document.createElement('div');
                newUnitDiv.classList.add('unit-row', 'form-group', 'p-4', 'rounded-lg', 'border', 'transition-colors', 'duration-300');
                if (darkMode) {
                    newUnitDiv.classList.add('bg-gray-700/50', 'border-gray-600');
                } else {
                    newUnitDiv.classList.add('bg-gray-50', 'border-gray-200');
                }
                // Apply fadeInUp animation directly as it's added
                newUnitDiv.style.opacity = '0';
                newUnitDiv.style.transform = 'translateY(20px)';


                let optionsHtml = '<option value="">-- Choisir un matériel --</option>';
                materials.forEach(material => {
                    optionsHtml += `<option value="${material.id}">${material.name}</option>`;
                });

                newUnitDiv.innerHTML = `
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    <div class="md:col-span-6">
                        <label for="units_${index}_material_id" class="block text-sm font-medium mb-1 transition-colors duration-300 ${darkMode ? 'text-gray-300' : 'text-gray-700'}">Matériel <span class="text-red-500">*</span></label>
                        <select name="units[${index}][material_id]" id="units_${index}_material_id" required
                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 ${darkMode ? 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400' : 'bg-white border-gray-300'}">
                            ${optionsHtml}
                        </select>
                        <p class="text-red-500 text-sm mt-1 error-message" data-field="units.${index}.material_id"></p>
                    </div>
                    <div class="md:col-span-4">
                        <label for="units_${index}_quantity" class="block text-sm font-medium mb-1 transition-colors duration-300 ${darkMode ? 'text-gray-300' : 'text-gray-700'}">Quantité <span class="text-red-500">*</span></label>
                        <input type="number" name="units[${index}][quantity]" id="units_${index}_quantity" min="1" required
                               class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 ${darkMode ? 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400' : 'bg-white border-gray-300'}"
                               placeholder="Qté">
                        <p class="text-red-500 text-sm mt-1 error-message" data-field="units.${index}.quantity"></p>
                    </div>
                    <div class="md:col-span-2 flex items-end">
                        <button type="button" class="remove-unit-btn w-full inline-flex items-center justify-center px-4 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white transition-all duration-200 ${darkMode ? 'bg-red-500 hover:bg-red-400 focus:ring-offset-gray-800' : 'bg-red-600 hover:bg-red-700 focus:ring-offset-white'}"
                                title="Supprimer ce matériel">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                            Supprimer
                        </button>
                    </div>
                </div>
            `;
                // Trigger animation
                setTimeout(() => {
                    newUnitDiv.style.opacity = '1';
                    newUnitDiv.style.transform = 'translateY(0)';
                }, 50);


                // Add event listener for the new remove button
                newUnitDiv.querySelector('.remove-unit-btn').addEventListener('click', function () {
                    this.closest('.unit-row').remove();
                    updateRemoveButtonVisibility();
                });

                // Add validation listeners for new fields
                const newInputs = newUnitDiv.querySelectorAll('select, input');
                newInputs.forEach(input => {
                    input.addEventListener('blur', function () {
                        validateField(this);
                    });
                    input.addEventListener('input', function () {
                        if (this.classList.contains('border-red-500')) {
                            validateField(this);
                        }
                    });
                    // Apply focus/blur styling from example
                    input.addEventListener('focus', fieldFocusEffect);
                    input.addEventListener('blur', fieldBlurEffect);
                });
                // Apply select UX from example
                const newSelects = newUnitDiv.querySelectorAll('select');
                newSelects.forEach(select => {
                    select.addEventListener('change', selectChangeEffect);
                });

                return newUnitDiv;
            }

            // Add unit button
            document.getElementById('add-unit-btn').addEventListener('click', () => {
                const newRow = createUnitRow(unitIndex);
                unitsContainer.appendChild(newRow);
                unitIndex++;
                updateRemoveButtonVisibility();
            });

            // Initial remove buttons
            unitsContainer.querySelectorAll('.remove-unit-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    this.closest('.unit-row').remove();
                    updateRemoveButtonVisibility();
                });
            });

            function updateRemoveButtonVisibility() {
                const rows = unitsContainer.querySelectorAll('.unit-row');
                rows.forEach((row, idx) => {
                    const removeBtn = row.querySelector('.remove-unit-btn');
                    if (removeBtn) {
                        if (rows.length === 1) {
                            // If it's the only row, hide or disable the remove button
                            // For simplicity, we'll just ensure it's not there if it's the very first one.
                            // Or, if you want to always have one row, you can hide it.
                            // The current Blade logic handles the initial row. This is for dynamically added/removed ones.
                            // If you want to hide the button on the last remaining row:
                            // removeBtn.style.display = 'none';
                        } else {
                            // removeBtn.style.display = ''; // Or 'inline-flex' etc.
                        }
                    }
                });
            }

            updateRemoveButtonVisibility(); // Initial check


            // --- Copied JS from example (adapted) ---
            const form = document.querySelector('form');
            const allInputs = () => form.querySelectorAll('input, textarea, select'); // Function to get current inputs

            // Progressive animation for sections (already animated via CSS .form-group)
            const sections = document.querySelectorAll('.rounded-xl[class*="shadow-lg"]'); // Target main sections
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(30px)';
                section.style.transition = `all 0.6s cubic-bezier(0.4, 0, 0.2, 1) ${index * 0.15}s`;
                setTimeout(() => {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, 50 + (index * 150));
            });

            // Real-time Validation
            function validateField(field) {
                const errorElement = field.parentNode.querySelector('.error-message'); // For dynamic rows
                const bladeErrorElement = field.parentNode.querySelector('p.text-red-500:not(.error-message)');

                if (field.checkValidity()) {
                    field.classList.remove('border-red-500');
                    field.classList.add('border-green-500');
                    if (errorElement) errorElement.textContent = '';
                    if (bladeErrorElement) bladeErrorElement.style.display = 'none';
                } else {
                    field.classList.remove('border-green-500');
                    field.classList.add('border-red-500');
                    if (errorElement) errorElement.textContent = field.validationMessage;
                    if (bladeErrorElement) bladeErrorElement.style.display = 'block';
                }
            }

            allInputs().forEach(input => {
                input.addEventListener('blur', function () {
                    validateField(this);
                });
                input.addEventListener('input', function () {
                    if (this.classList.contains('border-red-500')) {
                        validateField(this);
                    }
                });
            });

            // Form Submission Animation
            form.addEventListener('submit', function (e) {
                let formIsValid = true;
                allInputs().forEach(input => {
                    if (input.required && !input.checkValidity()) {
                        formIsValid = false;
                        validateField(input);
                    }
                });

                if (!formIsValid) {
                    e.preventDefault();
                    // Find first invalid field and focus it
                    const firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        firstInvalid.focus();
                    }
                    // Optionally, show a general error message
                    alert("Veuillez corriger les erreurs dans le formulaire.");
                    return;
                }

                const submitBtn = this.querySelector('button[type="submit"]');
                submitBtn.classList.add('btn-loading');
                submitBtn.disabled = true;
                // No timeout needed, let form submit naturally after adding class
            });

            // UX for Selects
            function selectChangeEffect() {
                if (this.value) {
                    this.style.fontWeight = '500';
                } else {
                    this.style.fontWeight = 'normal';
                }
            }

            form.querySelectorAll('select').forEach(select => {
                select.addEventListener('change', selectChangeEffect);
                selectChangeEffect.call(select); // Initial call
            });


            // Confirmation before unload
            let formChanged = false;

            function markFormAsChanged() {
                formChanged = true;
            }

            allInputs().forEach(input => {
                input.addEventListener('input', markFormAsChanged);
                input.addEventListener('change', markFormAsChanged); // For selects
            });

            window.addEventListener('beforeunload', function (e) {
                if (formChanged) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
            form.addEventListener('submit', function () {
                formChanged = false;
            }); // Reset on submit

            // Effet de focus progressif
            function fieldFocusEffect() {
                this.style.transform = 'scale(1.02)';
                this.style.zIndex = '10';
            }

            function fieldBlurEffect() {
                this.style.transform = 'scale(1)';
                this.style.zIndex = '1';
            }

            allInputs().forEach((input) => {
                input.addEventListener('focus', fieldFocusEffect);
                input.addEventListener('blur', fieldBlurEffect);
            });
        });
    </script>
@endpush
