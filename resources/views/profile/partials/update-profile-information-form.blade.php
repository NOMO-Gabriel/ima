<!-- resources/views/profile/partials/update-profile-information-form.blade.php -->
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informations du Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettez à jour vos informations personnelles et votre adresse email.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Prénom -->
        <div>
            <x-input-label for="first_name" :value="__('Prénom')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus autocomplete="first_name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <!-- Nom -->
        <div>
            <x-input-label for="last_name" :value="__('Nom')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required autocomplete="last_name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Votre adresse e-mail n\'est pas vérifiée.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Cliquez ici pour renvoyer l\'e-mail de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Téléphone -->
        <div>
            <x-input-label for="phone_number" :value="__('Numéro de téléphone')" />
            <x-text-input id="phone_number" name="phone_number" type="tel" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <!-- Ville -->
        <div>
            <x-input-label for="city_id" :value="__('Ville')" />
            <select id="city_id" name="city_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">-- Sélectionnez une ville --</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}"
                        {{ (old('city_id', $user->city_id) == $city->id) ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('city_id')" />
        </div>
        <!-- Adresse -->
        <div>
            <x-input-label for="address" :value="__('Adresse')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)" autocomplete="street-address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

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

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section>