{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.app')

@section('title', __('Modifier l\'utilisateur'))

@section('content')
    <div x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
         :class="darkMode ? 'bg-[#1E293B]' : 'bg-[#F8FAFC]'"
         class="transition-colors duration-300 p-4 rounded-lg">

        <!-- Fil d'Ariane et Titre -->
        <div class="mb-6">
            <div class="flex items-center text-sm mb-2 text-[#64748B]">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="hover:text-[#4CA3DD]">
                    <i class="fas fa-home text-[#4CA3DD]"></i>
                </a>
                <span class="mx-2">/</span>
                <a href="{{ route('admin.users.index', ['locale' => app()->getLocale()]) }}" class="hover:text-[#4CA3DD]">
                    {{ __('Utilisateurs') }}
                </a>
                <span class="mx-2">/</span>
                <span class="text-[#1E293B]">{{ __('Modifier') }}</span>
            </div>
            <h1 class="text-2xl font-bold flex items-center text-[#1E293B]">
                <i class="fas fa-user-edit text-[#4CA3DD] mr-3"></i>
                {{ __('Modifier l\'utilisateur') }}: {{ $user->first_name }} {{ $user->last_name }}
            </h1>
        </div>

        <form method="POST" action="{{ route('admin.users.update', ['user' => $user, 'locale' => app()->getLocale()]) }}" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <!-- Informations personnelles -->
                <div :class="darkMode ? 'bg-[#2C3E50] border-gray-700' : 'bg-white border-gray-100'"
                     class="rounded-xl shadow-md border overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="bg-gradient-to-r from-[#4CA3DD] to-[#2A7AB8] px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-user-circle mr-2"></i>
                            {{ __('Informations personnelles') }}
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <!-- Prénom et Nom sur la même ligne sur grands écrans -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Prénom -->
                            <div class="transition-all duration-200">
                                <label for="first_name" class="block text-sm font-medium mb-1 text-[#1E293B]">
                                    {{ __('Prénom') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-[#4CA3DD]"></i>
                                    </div>
                                    <input id="first_name" name="first_name" type="text"
                                           :class="darkMode ? 'bg-[#334155] border-gray-600' : 'bg-white border-[#E2E8F0]'"
                                           class="block w-full pl-10 pr-3 py-2.5 border rounded-md focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                           value="{{ old('first_name', $user->first_name) }}" required autofocus>
                                </div>
                                @error('first_name')
                                <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Nom -->
                            <div class="transition-all duration-200">
                                <label for="last_name" class="block text-sm font-medium mb-1 text-[#1E293B]">
                                    {{ __('Nom') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-[#4CA3DD]"></i>
                                    </div>
                                    <input id="last_name" name="last_name" type="text"
                                           :class="darkMode ? 'bg-[#334155] border-gray-600' : 'bg-white border-[#E2E8F0]'"
                                           class="block w-full pl-10 pr-3 py-2.5 border rounded-md focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                           value="{{ old('last_name', $user->last_name) }}" required>
                                </div>
                                @error('last_name')
                                <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="transition-all duration-200">
                            <label for="email" class="block text-sm font-medium mb-1 text-[#1E293B]">
                                {{ __('Email') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-[#4CA3DD]"></i>
                                </div>
                                <input id="email" name="email" type="email"
                                       :class="darkMode ? 'bg-[#334155] border-gray-600' : 'bg-white border-[#E2E8F0]'"
                                       class="block w-full pl-10 pr-3 py-2.5 border rounded-md focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                            @error('email')
                            <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Téléphone -->
                        <div class="transition-all duration-200">
                            <label for="phone_number" class="block text-sm font-medium mb-1 text-[#1E293B]">
                                {{ __('Téléphone') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-[#4CA3DD]"></i>
                                </div>
                                <input id="phone_number" name="phone_number" type="text"
                                       :class="darkMode ? 'bg-[#334155] border-gray-600' : 'bg-white border-[#E2E8F0]'"
                                       class="block w-full pl-10 pr-3 py-2.5 border rounded-md focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                       value="{{ old('phone_number', $user->phone_number) }}" required>
                            </div>
                            @error('phone_number')
                            <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Ville et Adresse sur une ligne sur les grands écrans -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Ville -->
                            <div class="transition-all duration-200">
                                <label for="city_id" class="block text-sm font-medium mb-1 text-[#1E293B]">
                                    {{ __('Ville') }}
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-city text-[#4CA3DD]"></i>
                                    </div>
                                    <select id="city_id" name="city_id"
                                            :class="darkMode ? 'bg-[#334155] border-gray-600' : 'bg-white border-[#E2E8F0]'"
                                            class="block w-full pl-10 pr-3 py-2.5 border rounded-md focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]">
                                        <option value="">{{ __('Sélectionner une ville') }}</option>
                                        @isset($cities)
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" @selected(old('city_id', $user->city_id) == $city->id)>
                                                    {{ $city->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                                @error('city_id')
                                <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Adresse -->
                            <div class="transition-all duration-200">
                                <label for="address" class="block text-sm font-medium mb-1 text-[#1E293B]">
                                    {{ __('Adresse') }}
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-[#4CA3DD]"></i>
                                    </div>
                                    <input id="address" name="address" type="text"
                                           :class="darkMode ? 'bg-[#334155] border-gray-600' : 'bg-white border-[#E2E8F0]'"
                                           class="block w-full pl-10 pr-3 py-2.5 border rounded-md focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                           value="{{ old('address', $user->address) }}">
                                </div>
                                @error('address')
                                <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sécurité et rôles -->
                <div :class="darkMode ? 'bg-[#2C3E50] border-gray-700' : 'bg-white border-gray-100'"
                     class="rounded-xl shadow-md border overflow-hidden transition-all duration-300 hover:shadow-lg">
                    <div class="bg-gradient-to-r from-[#4CA3DD] to-[#2A7AB8] px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-shield-alt mr-2"></i>
                            {{ __('Sécurité et rôle') }}
                        </h3>
                    </div>
                    <div class="p-6 space-y-5">
                        <!-- Mot de passe et confirmation sur la même ligne -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Mot de passe -->
                            <div class="transition-all duration-200">
                                <label for="password" class="block text-sm font-medium mb-1 text-[#1E293B]">
                                    {{ __('Nouveau mot de passe') }}
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-[#4CA3DD]"></i>
                                    </div>
                                    <input id="password" name="password" type="password"
                                           :class="darkMode ? 'bg-[#334155] border-gray-600' : 'bg-white border-[#E2E8F0]'"
                                           class="block w-full pl-10 pr-3 py-2.5 border rounded-md focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                           autocomplete="new-password">
                                </div>
                                <p class="mt-1 text-xs text-[#64748B]">
                                    {{ __('Laissez vide pour conserver le mot de passe actuel') }}
                                </p>
                                @error('password')
                                <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div class="transition-all duration-200">
                                <label for="password_confirmation" class="block text-sm font-medium mb-1 text-[#1E293B]">
                                    {{ __('Confirmer le mot de passe') }}
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-[#4CA3DD]"></i>
                                    </div>
                                    <input id="password_confirmation" name="password_confirmation" type="password"
                                           :class="darkMode ? 'bg-[#334155] border-gray-600' : 'bg-white border-[#E2E8F0]'"
                                           class="block w-full pl-10 pr-3 py-2.5 border rounded-md focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]"
                                           autocomplete="new-password">
                                </div>
                                @error('password_confirmation')
                                <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Rôle et Statut sur la même ligne -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Rôle -->
                            <div class="transition-all duration-200">
                                <label for="role" class="block text-sm font-medium mb-1 text-[#1E293B]">
                                    {{ __('Rôle') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user-tag text-[#4CA3DD]"></i>
                                    </div>
                                    <select id="role" name="role"
                                            :class="darkMode ? 'bg-[#334155] border-gray-600' : 'bg-white border-[#E2E8F0]'"
                                            class="block w-full pl-10 pr-3 py-2.5 border rounded-md focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" @selected($user->roles->contains($role))>
                                                {{ __($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('role')
                                <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Statut -->
                            <div class="transition-all duration-200">
                                <label for="status" class="block text-sm font-medium mb-1 text-[#1E293B]">
                                    {{ __('Statut') }} <span class="text-red-500">*</span>
                                </label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-toggle-on text-[#4CA3DD]"></i>
                                    </div>
                                    <select id="status" name="status"
                                            :class="darkMode ? 'bg-[#334155] border-gray-600' : 'bg-white border-[#E2E8F0]'"
                                            class="block w-full pl-10 pr-3 py-2.5 border rounded-md focus:ring-[#4CA3DD] focus:border-[#4CA3DD] text-[#1E293B]">
                                        <option value="active" @selected($user->status === 'active')>{{ __('Actif') }}</option>
                                        <option value="pending_validation" @selected($user->status === 'pending_validation')>{{ __('En attente de validation') }}</option>
                                        <option value="pending_finalization" @selected($user->status === 'pending_finalization')>{{ __('En attente de finalisation') }}</option>
                                        <option value="suspended" @selected($user->status === 'suspended')>{{ __('Suspendu') }}</option>
                                        <option value="rejected" @selected($user->status === 'rejected')>{{ __('Rejeté') }}</option>
                                        <option value="archived" @selected($user->status === 'archived')>{{ __('Archivé') }}</option>
                                    </select>
                                </div>
                                @error('status')
                                <p class="mt-1 text-sm text-[#F87171]">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Permissions liées au rôle -->
                        <div class="mt-5 rounded-lg p-4 border"
                             :class="darkMode ? 'bg-[#1E293B] border-gray-700' : 'bg-[#EEF2F7] border-[#E2E8F0]'">
                            <h4 class="text-sm font-semibold mb-2 flex items-center text-[#1E293B]">
                                <i class="fas fa-key text-[#4CA3DD] mr-2"></i>
                                {{ __('Permissions du rôle') }}
                            </h4>
                            <div class="max-h-48 overflow-y-auto pr-2">
                                <ul class="text-sm grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-1 text-[#1E293B]">
                                    @foreach($user->getPermissionsViaRoles() as $permission)
                                        <li class="flex items-start">
                                            <i class="fas fa-check-circle text-[#34D399] mt-0.5 mr-2"></i>
                                            <span>{{ $permission->name }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-wrap justify-between items-center pt-6 border-t"
                 :class="darkMode ? 'border-gray-700' : 'border-[#E2E8F0]'">
                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 text-[#1E293B]"
                   :class="darkMode ? 'bg-[#334155] hover:bg-[#475569] focus:ring-offset-[#1E293B]' : 'bg-[#EEF2F7] hover:bg-[#E2E8F0] focus:ring-[#4CA3DD]'">
                    <i class="fas fa-arrow-left text-[#4CA3DD] mr-2"></i> {{ __('Retour') }}
                </a>

                <div class="flex space-x-3">
                    <button type="reset"
                            class="inline-flex items-center px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 text-[#1E293B]"
                            :class="darkMode ? 'bg-[#2C3E50] hover:bg-[#334155] focus:ring-offset-[#1E293B]' : 'bg-[#EEF2F7] hover:bg-[#E2E8F0] focus:ring-[#4CA3DD]'">
                        <i class="fas fa-undo text-[#4CA3DD] mr-2"></i> {{ __('Réinitialiser') }}
                    </button>
                    <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-[#4CA3DD] text-white rounded-md hover:bg-[#2A7AB8] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#4CA3DD] transition-all duration-200"
                            :class="darkMode ? 'focus:ring-offset-[#1E293B]' : ''">
                        <i class="fas fa-save mr-2"></i> {{ __('Enregistrer') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Script pour pré-visualiser les permissions selon le rôle sélectionné
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');

            if (roleSelect) {
                roleSelect.addEventListener('change', function() {
                    // Appel AJAX pour récupérer les permissions du rôle sélectionné
                    const roleId = this.value;
                    // Créer la route et l'appel AJAX ici
                });
            }
        });
    </script>
@endpush
