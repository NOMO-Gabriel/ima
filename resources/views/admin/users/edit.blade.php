<!-- resources/views/admin/users/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Modifier un utilisateur') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left mr-2"></i>{{ __('Retour') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Informations personnelles -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Informations personnelles') }}</h3>

                                <!-- Prénom -->
                                <div>
                                    <x-input-label for="first_name" :value="__('Prénom')" />
                                    <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus />
                                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                                </div>

                                <!-- Nom -->
                                <div>
                                    <x-input-label for="last_name" :value="__('Nom')" />
                                    <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                                </div>

                                <!-- Email -->
                                <div>
                                    <x-input-label for="email" :value="__('Email')" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                </div>

                                <!-- Téléphone -->
                                <div>
                                    <x-input-label for="phone_number" :value="__('Téléphone')" />
                                    <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                                </div>

                                <!-- Ville -->
                                <div>
                                    <x-input-label for="city" :value="__('Ville')" />
                                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('city')" />
                                </div>

                                <!-- Adresse -->
                                <div>
                                    <x-input-label for="address" :value="__('Adresse')" />
                                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" />
                                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                                </div>
                            </div>

                            <!-- Sécurité et rôles -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">{{ __('Sécurité et rôles') }}</h3>

                                <!-- Mot de passe (optionnel pour modification) -->
                                <div>
                                    <x-input-label for="password" :value="__('Nouveau mot de passe (laissez vide pour ne pas changer)')" />
                                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                                </div>

                                <!-- Confirmation mot de passe -->
                                <div>
                                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                                </div>

                                @can('user.role.assign')
                                <!-- Statut du compte -->
                                <div>
                                    <x-input-label for="status" :value="__('Statut du compte')" />
                                    <select id="status" name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                                        <option value="pending_validation" {{ old('status', $user->status) === 'pending_validation' ? 'selected' : '' }}>En attente de validation</option>
                                        <option value="pending_finalization" {{ old('status', $user->status) === 'pending_finalization' ? 'selected' : '' }}>En attente de finalisation</option>
                                        <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Actif</option>
                                        <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>Suspendu</option>
                                        <option value="rejected" {{ old('status', $user->status) === 'rejected' ? 'selected' : '' }}>Rejeté</option>
                                        <option value="archived" {{ old('status', $user->status) === 'archived' ? 'selected' : '' }}>Archivé</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                                </div>

                                <!-- Rôles -->
                                <div class="mt-4">
                                    <x-input-label :value="__('Rôles')" />
                                    <div class="mt-2 max-h-60 overflow-y-auto p-2 border border-gray-300 rounded-md">
                                        @foreach($roles as $role)
                                            <div class="flex items-center space-x-2 mb-2">
                                                <input type="checkbox" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->name }}"
                                                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                                       {{ in_array($role->name, $user->roles->pluck('name')->toArray()) ? 'checked' : '' }}>
                                                <label for="role_{{ $role->id }}" class="text-sm font-medium text-gray-700">
                                                    {{ $role->name }} 
                                                    @if($role->description)
                                                        <span class="text-xs text-gray-500">({{ $role->description }})</span>
                                                    @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <x-input-error class="mt-2" :messages="$errors->get('roles')" />
                                </div>
                                @endcan
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex items-center justify-end mt-6 gap-4">
                            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Annuler') }}
                            </a>
                            <x-primary-button>{{ __('Mettre à jour') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>