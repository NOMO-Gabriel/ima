@extends('layouts.app')

@section('page_title', 'Modifier la commande')

@section('breadcrumb')
    <div class="flex items-center space-x-2 text-sm"
         x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-home mr-1"></i>
            Accueil
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <a href="#"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-archive mr-1"></i>
            Ressources
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <a href="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-box-open mr-1"></i>
            Commandes
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">Modifier #{{ $command->id }}</span>
    </div>
@endsection

@section('page_header')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-edit mr-2 text-[#4CA3DD]"></i>
                    Modifier la commande #{{ $command->id }}
                </h1>
                <p class="mt-1 text-sm"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Modifiez les détails et matériels de cette commande
                </p>
                <div class="mt-2 flex items-center space-x-4 text-sm"
                     :class="darkMode ? 'text-gray-300' : 'text-gray-600'">
                    <span class="flex items-center">
                        <i class="fas fa-calendar mr-1 text-[#4CA3DD]"></i>
                        Créée le {{ $command->created_at->format('d/m/Y à H:i') }}
                    </span>
                    <span class="flex items-center">
                        <i class="fas fa-user mr-1 text-[#4CA3DD]"></i>
                        {{ $command->user->first_name ?? 'N/A' }} {{ $command->user->last_name ?? '' }}
                    </span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                @can('ressource.material.read')
                    <a href="{{ route('admin.commands.show', ['locale' => app()->getLocale(), 'command' => $command->id]) }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                       :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                        <i class="fas fa-eye mr-2"></i>
                        Voir la commande
                    </a>
                @endcan

                @can('ressource.material.duplicate')
                    <a href="{{ route('admin.commands.duplicate', ['locale' => app()->getLocale(), 'command' => $command->id]) }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                       :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                        <i class="fas fa-copy mr-2"></i>
                        Dupliquer
                    </a>
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div x-data="{
    darkMode: localStorage.getItem('theme') === 'dark',
    units: {{ json_encode(array_values(old('units', $command->commandUnits->map(function($unit) {
        return [
            'id' => $unit->id,
            'material_id' => $unit->material_id,
            'quantity' => $unit->quantity
        ];
    })->toArray()))) }},
    materials: {{ json_encode($materials->map(function($material) {
        return [
            'id' => $material->id,
            'name' => $material->name,
            'unit' => $material->unit ?? 'pcs',
            'available_quantity' => $material->quantity ?? 0
        ];
    })) }},
    isSubmitting: false,
    showDeleteConfirm: false,
    unitToDelete: null
}"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
         class="space-y-6">

        <!-- Informations de la commande -->
        <div class="rounded-xl shadow-sm border overflow-hidden"
             :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
            <div class="px-6 py-4 border-b"
                 :class="darkMode ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                <h2 class="text-lg font-semibold flex items-center"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-info-circle mr-2 text-[#4CA3DD]"></i>
                    Informations de la commande
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            <i class="fas fa-hashtag mr-1 text-[#4CA3DD]"></i>
                            ID de la commande
                        </label>
                        <div class="flex items-center space-x-2">
                            <input type="text"
                                   value="#{{ $command->id }}"
                                   readonly
                                   class="flex-1 px-3 py-2 border rounded-lg font-mono text-sm transition-colors"
                                   :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-300' : 'bg-gray-50 border-gray-300 text-gray-600'">
                            <button type="button"
                                    onclick="copyToClipboard('{{ $command->id }}')"
                                    class="px-3 py-2 text-sm font-medium rounded-lg transition-colors"
                                    :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-300 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            <i class="fas fa-calendar mr-1 text-[#4CA3DD]"></i>
                            Date de création
                        </label>
                        <input type="text"
                               value="{{ $command->created_at->format('d/m/Y à H:i') }}"
                               readonly
                               class="w-full px-3 py-2 border rounded-lg transition-colors"
                               :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-300' : 'bg-gray-50 border-gray-300 text-gray-600'">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium"
                               :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            <i class="fas fa-user mr-1 text-[#4CA3DD]"></i>
                            Créée par
                        </label>
                        <input type="text"
                               value="{{ $command->user->first_name ?? 'N/A' }} {{ $command->user->last_name ?? '' }}"
                               readonly
                               class="w-full px-3 py-2 border rounded-lg transition-colors"
                               :class="darkMode ? 'bg-gray-700 border-gray-600 text-gray-300' : 'bg-gray-50 border-gray-300 text-gray-600'">
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulaire de modification -->
        @can('ressource.material.update')
            <form action="{{ route('admin.commands.update', ['locale' => app()->getLocale(), 'command' => $command->id]) }}"
                  method="POST"
                  @submit="isSubmitting = true"
                  class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Liste des matériels -->
                <div class="rounded-xl shadow-sm border overflow-hidden"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">

                    <!-- En-tête -->
                    <div class="px-6 py-4 border-b flex items-center justify-between"
                         :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        <h2 class="text-lg font-semibold flex items-center"
                            :class="darkMode ? 'text-white' : 'text-gray-900'">
                            <i class="fas fa-boxes mr-2 text-[#4CA3DD]"></i>
                            Matériels commandés
                            <span class="ml-2 px-2 py-1 text-xs font-medium rounded-full"
                                  :class="darkMode ? 'bg-gray-700 text-gray-300' : 'bg-gray-100 text-gray-600'"
                                  x-text="units.length + ' matériel' + (units.length > 1 ? 's' : '')"></span>
                        </h2>

                        <button type="button"
                                @click="units.push({ id: '', material_id: '', quantity: 1 })"
                                class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter un matériel
                        </button>
                    </div>

                    <!-- Liste des unités -->
                    <div class="p-6">
                        <div class="space-y-4">
                            <template x-for="(unit, index) in units" :key="index">
                                <div class="relative rounded-lg border p-4 transition-all duration-200 hover:shadow-md"
                                     :class="darkMode ? 'border-gray-600 bg-gray-750' : 'border-gray-200 bg-gray-50'">

                                    <!-- Numéro d'unité et bouton de suppression -->
                                    <div class="flex items-center justify-between mb-4">
                                    <span class="flex items-center text-sm font-medium"
                                          :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                        <span class="w-6 h-6 bg-[#4CA3DD] text-white rounded-full flex items-center justify-center text-xs mr-2"
                                              x-text="index + 1"></span>
                                        Matériel <span x-text="index + 1"></span>
                                    </span>

                                        <button type="button"
                                                @click="if(units.length > 1) { unitToDelete = index; showDeleteConfirm = true; }"
                                                :disabled="units.length <= 1"
                                                class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-md transition-colors"
                                                :class="units.length <= 1 ?
                                                'bg-gray-200 text-gray-400 cursor-not-allowed' :
                                                'bg-red-100 text-red-800 hover:bg-red-200'">
                                            <i class="fas fa-trash mr-1"></i>
                                            Supprimer
                                        </button>
                                    </div>

                                    <!-- Champs cachés pour l'ID -->
                                    <input type="hidden"
                                           :name="'units[' + index + '][id]'"
                                           :value="unit.id">

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <!-- Sélection du matériel -->
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium"
                                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                                <i class="fas fa-box mr-1 text-[#4CA3DD]"></i>
                                                Matériel *
                                            </label>
                                            <select :name="'units[' + index + '][material_id]'"
                                                    x-model="unit.material_id"
                                                    required
                                                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                                    :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'">
                                                <option value="">-- Choisir un matériel --</option>
                                                <template x-for="material in materials" :key="material.id">
                                                    <option :value="material.id"
                                                            x-text="material.name + ' (Dispo: ' + material.available_quantity + ' ' + material.unit + ')'"></option>
                                                </template>
                                            </select>

                                            <!-- Information sur la disponibilité -->
                                            <template x-if="unit.material_id">
                                                <div x-data="{ selectedMaterial: materials.find(m => m.id == unit.material_id) }">
                                                    <template x-if="selectedMaterial">
                                                        <div class="flex items-center text-xs"
                                                             :class="selectedMaterial.available_quantity >= unit.quantity ?
                                                             (darkMode ? 'text-green-400' : 'text-green-600') :
                                                             (darkMode ? 'text-red-400' : 'text-red-600')">
                                                            <i :class="selectedMaterial.available_quantity >= unit.quantity ?
                                                               'fas fa-check-circle' : 'fas fa-exclamation-triangle'"
                                                               class="mr-1"></i>
                                                            <span x-text="selectedMaterial.available_quantity >= unit.quantity ?
                                                                     'Stock disponible: ' + selectedMaterial.available_quantity + ' ' + selectedMaterial.unit :
                                                                     'Stock insuffisant! Disponible: ' + selectedMaterial.available_quantity + ' ' + selectedMaterial.unit"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Quantité -->
                                        <div class="space-y-2">
                                            <label class="block text-sm font-medium"
                                                   :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                                                <i class="fas fa-calculator mr-1 text-[#4CA3DD]"></i>
                                                Quantité *
                                            </label>
                                            <div class="relative">
                                                <input type="number"
                                                       :name="'units[' + index + '][quantity]'"
                                                       x-model.number="unit.quantity"
                                                       min="1"
                                                       step="1"
                                                       required
                                                       class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-colors"
                                                       :class="darkMode ? 'bg-gray-700 border-gray-600 text-white' : 'bg-white border-gray-300 text-gray-900'"
                                                       placeholder="Ex: 10">

                                                <!-- Boutons d'incrémentation/décrémentation -->
                                                <div class="absolute right-1 top-1 bottom-1 flex flex-col">
                                                    <button type="button"
                                                            @click="unit.quantity = (unit.quantity || 0) + 1"
                                                            class="flex-1 px-2 text-xs rounded-t hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                                        <i class="fas fa-chevron-up"></i>
                                                    </button>
                                                    <button type="button"
                                                            @click="if(unit.quantity > 1) unit.quantity = unit.quantity - 1"
                                                            class="flex-1 px-2 text-xs rounded-b hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                                        <i class="fas fa-chevron-down"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Unité du matériel -->
                                            <template x-if="unit.material_id">
                                                <div x-data="{ selectedMaterial: materials.find(m => m.id == unit.material_id) }">
                                                    <template x-if="selectedMaterial">
                                                        <p class="text-xs"
                                                           :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                                            Unité: <span x-text="selectedMaterial.unit" class="font-medium"></span>
                                                        </p>
                                                    </template>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- État vide -->
                            <div x-show="units.length === 0" class="text-center py-8">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                                </div>
                                <h3 class="text-lg font-medium mb-2" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    Aucun matériel sélectionné
                                </h3>
                                <p class="text-sm mb-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    Ajoutez au moins un matériel à votre commande.
                                </p>
                                <button type="button"
                                        @click="units.push({ id: '', material_id: '', quantity: 1 })"
                                        class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors">
                                    <i class="fas fa-plus mr-2"></i>
                                    Ajouter le premier matériel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Résumé et total -->
                <div class="rounded-xl shadow-sm border overflow-hidden"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="px-6 py-4 border-b"
                         :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        <h3 class="text-lg font-semibold flex items-center"
                            :class="darkMode ? 'text-white' : 'text-gray-900'">
                            <i class="fas fa-calculator mr-2 text-[#4CA3DD]"></i>
                            Résumé de la commande
                        </h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-boxes text-blue-600 text-xl"></i>
                                </div>
                                <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                    Types de matériels
                                </p>
                                <p class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'"
                                   x-text="units.length"></p>
                            </div>

                            <div class="text-center">
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-calculator text-green-600 text-xl"></i>
                                </div>
                                <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                    Quantité totale
                                </p>
                                <p class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'"
                                   x-text="units.reduce((total, unit) => total + (parseInt(unit.quantity) || 0), 0)"></p>
                            </div>

                            <div class="text-center">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                                </div>
                                <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                    Statut
                                </p>
                                <p class="text-sm font-semibold" :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    En cours de modification
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="rounded-xl shadow-sm border overflow-hidden"
                     :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row gap-3 justify-between items-center">
                            <div class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                                <i class="fas fa-info-circle mr-1 text-[#4CA3DD]"></i>
                                Vérifiez bien tous les détails avant de sauvegarder les modifications.
                            </div>

                            <div class="flex gap-3">
                                <a href="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}"
                                   class="inline-flex items-center px-6 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                   :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                                    <i class="fas fa-times mr-2"></i>
                                    Annuler
                                </a>

                                <button type="submit"
                                        :disabled="isSubmitting || units.length === 0"
                                        class="inline-flex items-center px-6 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed"
                                        :class="{ 'opacity-50 cursor-not-allowed': isSubmitting || units.length === 0 }">
                                    <template x-if="isSubmitting">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                    </template>
                                    <template x-if="!isSubmitting">
                                        <i class="fas fa-save mr-2"></i>
                                    </template>
                                    <span x-text="isSubmitting ? 'Sauvegarde...' : 'Mettre à jour la commande'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <!-- Message si pas de permission de modification -->
            <div class="rounded-xl shadow-sm border overflow-hidden"
                 :class="darkMode ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200'">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lock text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium mb-2" :class="darkMode ? 'text-white' : 'text-gray-900'">
                        Accès non autorisé
                    </h3>
                    <p class="text-sm mb-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                        Vous n'avez pas les permissions nécessaires pour modifier cette commande.
                    </p>
                    <a href="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}"
                       class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour à la liste
                    </a>
                </div>
            </div>
        @endcan

        <!-- Modal de confirmation de suppression -->
        <div x-show="showDeleteConfirm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto"
             style="display: none;">

            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showDeleteConfirm = false"></div>

                <div class="inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                     :class="darkMode ? 'bg-gray-800' : 'bg-white'">

                    <!-- En-tête du modal -->
                    <div class="px-6 py-4 border-b"
                         :class="darkMode ? 'border-gray-700' : 'border-gray-200'">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium"
                                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                                    Supprimer ce matériel
                                </h3>
                                <p class="text-sm"
                                   :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                                    Cette action est irréversible
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contenu du modal -->
                    <div class="px-6 py-4">
                        <p class="text-sm"
                           :class="darkMode ? 'text-gray-300' : 'text-gray-700'">
                            Êtes-vous sûr de vouloir supprimer ce matériel de la commande ? Cette action ne peut pas être annulée.
                        </p>
                    </div>

                    <!-- Actions du modal -->
                    <div class="px-6 py-4 border-t flex justify-end space-x-3"
                         :class="darkMode ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                        <button type="button"
                                @click="showDeleteConfirm = false"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </button>

                        <button type="button"
                                @click="units.splice(unitToDelete, 1); showDeleteConfirm = false; unitToDelete = null"
                                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        <script>
            /**
             * Fonction pour copier du texte dans le presse-papiers
             */
            function copyToClipboard(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text).then(() => {
                        showNotification('ID copié dans le presse-papiers', 'success');
                    }).catch(() => {
                        fallbackCopyTextToClipboard(text);
                    });
                } else {
                    fallbackCopyTextToClipboard(text);
                }
            }

            /**
             * Méthode de fallback pour copier du texte
             */
            function fallbackCopyTextToClipboard(text) {
                const textArea = document.createElement("textarea");
                textArea.value = text;
                textArea.style.top = "0";
                textArea.style.left = "0";
                textArea.style.position = "fixed";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                try {
                    document.execCommand('copy');
                    showNotification('ID copié dans le presse-papiers', 'success');
                } catch (err) {
                    showNotification('Erreur lors de la copie', 'error');
                }

                document.body.removeChild(textArea);
            }

            /**
             * Fonction pour afficher une notification temporaire
             */
            function showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg text-white text-sm font-medium transform transition-all duration-300 translate-x-full`;

                // Couleurs selon le type
                switch(type) {
                    case 'success':
                        notification.className += ' bg-green-600';
                        break;
                    case 'error':
                        notification.className += ' bg-red-600';
                        break;
                    case 'warning':
                        notification.className += ' bg-yellow-600';
                        break;
                    default:
                        notification.className += ' bg-blue-600';
                }

                notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} mr-2"></i>
                <span>${message}</span>
            </div>
        `;

                document.body.appendChild(notification);

                // Animation d'entrée
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);

                // Animation de sortie et suppression
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            /**
             * Validation du formulaire côté client
             */
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form[method="POST"]');

                if (form) {
                    form.addEventListener('submit', function(e) {
                        const formData = new FormData(form);
                        const units = [];

                        // Collecter les données des unités
                        for (let [key, value] of formData.entries()) {
                            if (key.startsWith('units[')) {
                                const match = key.match(/units\[(\d+)\]\[(\w+)\]/);
                                if (match) {
                                    const index = parseInt(match[1]);
                                    const field = match[2];

                                    if (!units[index]) {
                                        units[index] = {};
                                    }
                                    units[index][field] = value;
                                }
                            }
                        }

                        // Validation
                        let hasErrors = false;
                        const errors = [];

                        if (units.length === 0) {
                            errors.push('Au moins un matériel doit être ajouté à la commande.');
                            hasErrors = true;
                        }

                        units.forEach((unit, index) => {
                            if (!unit.material_id) {
                                errors.push(`Matériel ${index + 1}: Veuillez sélectionner un matériel.`);
                                hasErrors = true;
                            }

                            if (!unit.quantity || parseInt(unit.quantity) < 1) {
                                errors.push(`Matériel ${index + 1}: La quantité doit être supérieure à 0.`);
                                hasErrors = true;
                            }
                        });

                        if (hasErrors) {
                            e.preventDefault();
                            showNotification(errors.join('<br>'), 'error');
                            return false;
                        }

                        return true;
                    });
                }
            });

            /**
             * Gestion des raccourcis clavier
             */
            document.addEventListener('keydown', function(e) {
                // Échapper ferme les modals
                if (e.key === 'Escape') {
                    const alpineData = Alpine.$data(document.querySelector('[x-data]'));
                    if (alpineData && alpineData.showDeleteConfirm) {
                        alpineData.showDeleteConfirm = false;
                    }
                }

                // Ctrl+S pour sauvegarder (empêche le comportement par défaut du navigateur)
                if (e.ctrlKey && e.key === 's') {
                    e.preventDefault();
                    const submitButton = document.querySelector('button[type="submit"]');
                    if (submitButton && !submitButton.disabled) {
                        submitButton.click();
                    }
                }
            });
        </script>
    @endpush

    @push('styles')
        <style>
            /* Améliorations pour les sélecteurs et inputs */
            select:focus,
            input:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(76, 163, 221, 0.1);
            }

            /* Animation pour les éléments de liste */
            [x-transition\:enter] {
                transition-property: opacity, transform;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Amélioration de l'apparence des boutons d'incrémentation */
            .number-input-buttons button {
                border: none;
                background: transparent;
                color: #6b7280;
                transition: all 0.2s;
            }

            .number-input-buttons button:hover {
                color: #4ca3dd;
                background-color: rgba(76, 163, 221, 0.1);
            }

            /* Styles pour les notifications */
            .notification-enter {
                opacity: 0;
                transform: translateX(100%);
            }

            .notification-enter-active {
                opacity: 1;
                transform: translateX(0);
                transition: opacity 300ms, transform 300ms;
            }

            .notification-exit {
                opacity: 1;
                transform: translateX(0);
            }

            .notification-exit-active {
                opacity: 0;
                transform: translateX(100%);
                transition: opacity 300ms, transform 300ms;
            }

            /* Amélioration responsive */
            @media (max-width: 640px) {
                .button-group > * {
                    width: 100%;
                    justify-content: center;
                }
            }

            /* Animation de chargement pour le bouton de soumission */
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            /* Amélioration de l'indicateur de stock */
            .stock-indicator {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
                border-radius: 0.375rem;
                font-weight: 500;
            }

            .stock-available {
                background-color: rgba(34, 197, 94, 0.1);
                color: rgb(34, 197, 94);
            }

            .stock-insufficient {
                background-color: rgba(239, 68, 68, 0.1);
                color: rgb(239, 68, 68);
            }

            /* Dark mode pour les indicateurs de stock */
            .dark .stock-available {
                background-color: rgba(34, 197, 94, 0.2);
                color: rgb(74, 222, 128);
            }

            .dark .stock-insufficient {
                background-color: rgba(239, 68, 68, 0.2);
                color: rgb(248, 113, 113);
            }
        </style>
    @endpush
@endsection
