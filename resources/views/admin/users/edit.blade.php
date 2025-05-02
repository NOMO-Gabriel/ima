@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('admin.users.update', ['locale' => app()->getLocale()], $user) }}" class="space-y-8">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Informations personnelles -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                {{ __('Informations personnelles') }}
            </h3>
            <div class="space-y-4">
                <!-- Prénom -->
                <div>
                    <x-input-label for="first_name" :value="__('Prénom')" class="mb-1 text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <x-text-input id="first_name" name="first_name" type="text" class="pl-10 block w-full rounded-md shadow-sm" :value="old('first_name', $user->first_name)" required autofocus />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                </div>

                <!-- Nom -->
                <div>
                    <x-input-label for="last_name" :value="__('Nom')" class="mb-1 text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <x-text-input id="last_name" name="last_name" type="text" class="pl-10 block w-full rounded-md shadow-sm" :value="old('last_name', $user->last_name)" required />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" class="mb-1 text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <x-text-input id="email" name="email" type="email" class="pl-10 block w-full rounded-md shadow-sm" :value="old('email', $user->email)" required />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <!-- Téléphone -->
                <div>
                    <x-input-label for="phone_number" :value="__('Téléphone')" class="mb-1 text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-phone text-gray-400"></i>
                        </div>
                        <x-text-input id="phone_number" name="phone_number" type="text" class="pl-10 block w-full rounded-md shadow-sm" :value="old('phone_number', $user->phone_number)" required />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                </div>

                <!-- Ville -->
                <div>
                    <x-input-label for="city" :value="__('Ville')" class="mb-1 text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-city text-gray-400"></i>
                        </div>
                        <x-text-input id="city" name="city" type="text" class="pl-10 block w-full rounded-md shadow-sm" :value="old('city', $user->city)" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('city')" />
                </div>

                <!-- Adresse -->
                <div>
                    <x-input-label for="address" :value="__('Adresse')" class="mb-1 text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <x-text-input id="address" name="address" type="text" class="pl-10 block w-full rounded-md shadow-sm" :value="old('address', $user->address)" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>
            </div>
        </div>

        <!-- Sécurité et rôles -->
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-shield-alt text-blue-500 mr-2"></i>
                {{ __('Sécurité et rôle') }}
            </h3>
            <div class="space-y-4">
                <!-- Mot de passe (optionnel pour modification) -->
                <div>
                    <x-input-label for="password" :value="__('Nouveau mot de passe (facultatif)')" class="mb-1 text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <x-text-input id="password" name="password" type="password" class="pl-10 block w-full rounded-md shadow-sm" autocomplete="new-password" />
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Laissez vide pour conserver le mot de passe actuel</p>
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

                <!-- Confirmation mot de passe -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="mb-1 text-gray-700" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <x-text-input id
::contentReference[oaicite:0]{index=0}

    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="pl-10 block w-full rounded-md shadow-sm" autocomplete="new-password" />
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                </div>

                <!-- Rôle -->
                <div>
                    <x-input-label for="role" :value="__('Rôle')" class="mb-1 text-gray-700" />
                    <select name="role" id="role" class="block w-full mt-1 rounded-md shadow-sm border-gray-300">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" @selected($user->roles->contains($role))>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('role')" />
                </div>

                <!-- Statut -->
                <div>
                    <x-input-label for="status" :value="__('Statut')" class="mb-1 text-gray-700" />
                    <select name="status" id="status" class="block w-full mt-1 rounded-md shadow-sm border-gray-300">
                        <option value="active" @selected($user->status === 'active')>Actif</option>
                        <option value="inactive" @selected($user->status === 'inactive')>Inactif</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('status')" />
                </div>

                <!-- Permissions liées au rôle -->
                <div class="pt-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Permissions du rôle sélectionné</h4>
                    <ul class="text-sm text-gray-600 list-disc list-inside space-y-1">
                        @foreach($user->getPermissionsViaRoles() as $permission)
                            <li>{{ $permission->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bouton de soumission -->
    <div class="flex justify-end">
        <x-primary-button>
            <i class="fas fa-save mr-2"></i> {{ __('Enregistrer les modifications') }}
        </x-primary-button>
    </div>
</form>

@endsection
<!-- resources/views/admin/users/edit.blade.php -->

