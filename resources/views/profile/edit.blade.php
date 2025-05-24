@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow rounded-lg">
        <!-- En-tête -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Modifier mon profil</h2>
        </div>

        <!-- Messages de statut -->
        @if (session('status') === 'profile-updated')
            <div class="px-6 py-4 bg-green-100 border-l-4 border-green-500">
                <p class="text-green-700"><i class="fas fa-check-circle mr-2"></i> Profil mis à jour avec succès</p>
            </div>
        @endif

        <div class="p-6">
            <!-- Formulaire de mise à jour -->
            <form method="POST" action="{{ route('profile.update', ['locale' => app()->getLocale()]) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Photo de profil -->
                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 h-16 w-16">
                                <img class="h-16 w-16 rounded-full object-cover" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->full_name }}">
                            </div>
                            <div class="flex-1">
                                <input type="file" name="photo" id="photo" class="hidden" accept="image/*">
                                <label for="photo" class="cursor-pointer inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-camera mr-2"></i> Changer
                                </label>
                                @if(auth()->user()->profile_photo_path)
                                <button type="button" onclick="confirmDeletePhoto()" class="ml-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <i class="fas fa-trash-alt mr-2"></i> Supprimer
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Informations de base -->
                                <!-- Rôles (uniquement visible pour les utilisateurs ayant la permission de modifier les rôles) -->
                    @if($canEditRoles)
                    <div class="mt-4">
                        <x-input-label :value="__('Type de compte / Rôles')" />
                        <div class="mt-2 max-h-60 overflow-y-auto p-2 border border-gray-300 rounded-md">
                            @foreach($roles as $role)
                                <div class="flex items-center space-x-2 mb-2">
                                    <input type="checkbox" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->name }}"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        {{ in_array($role->name, $userRoles) ? 'checked' : '' }}>
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
                    @else
                    <div class="mt-4">
                        <x-input-label :value="__('Type de compte / Rôles')" />
                        <div class="mt-2 p-2 border border-gray-300 rounded-md bg-gray-100">
                            @foreach($user->roles as $role)
                                <div class="mb-1 text-sm text-gray-700">
                                    {{ $role->name }}
                                    @if($role->description)
                                        <span class="text-xs text-gray-500">({{ $role->description }})</span>
                                    @endif
                                </div>
                            @endforeach
                            <p class="mt-2 text-xs text-gray-500 italic">
                                {{ __('Vous n\'avez pas la permission de modifier les rôles. Contactez un administrateur si nécessaire.') }}
                            </p>
                        </div>
                    </div>
                    @endif

                    <!-- Prénom -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', auth()->user()->first_name) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('first_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nom -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', auth()->user()->last_name) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('last_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Téléphone -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', auth()->user()->phone_number) }}" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('phone_number')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ville -->
                    <div>
                        <x-input-label for="city_id" :value="__('Ville')" />
                        <select id="city_id" name="city_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Sélectionnez une ville --</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}>
                                    {{ $city->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error class="mt-2" :messages="$errors->get('city_id')" />
                    </div>

                    <!-- Adresse
                    <div class="col-span-1 md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <textarea name="address" id="address" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('address', auth()->user()->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> -->
                </div>

                <!-- Boutons de soumission -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-times mr-2"></i> Annuler
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <i class="fas fa-save mr-2"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Suppression du compte -->
    <div class="mt-6 bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Supprimer mon compte</h2>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-600 mb-4">Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.</p>

            <form method="POST" action="{{ route('profile.destroy', ['locale' => app()->getLocale()]) }}">
                @csrf
                @method('DELETE')

                <div class="mt-4">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Confirmez votre mot de passe</label>
                    <input type="password" name="password" id="current_password" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    @error('password', 'userDeletion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="confirmDeleteAccount()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-trash-alt mr-2"></i> Supprimer mon compte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    function confirmDeletePhoto() {
        if (confirm('Êtes-vous sûr de vouloir supprimer votre photo de profil ?')) {
            document.getElementById('delete-photo-form').submit();
        }
    }

    function confirmDeleteAccount() {
        if (confirm('Êtes-vous sûr de vouloir supprimer définitivement votre compte ? Cette action est irréversible.')) {
            event.preventDefault();
            document.querySelector('form[action="{{ route('profile.destroy', ['locale' => app()->getLocale()]) }}"]').submit();
        }
    }

    // Aperçu de la nouvelle photo
    document.getElementById('photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.querySelector('.flex-shrink-0 img').src = event.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
