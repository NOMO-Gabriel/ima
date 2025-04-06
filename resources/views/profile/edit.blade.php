<!-- resources/views/profile/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Section Photo de Profil -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Photo de Profil') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Mettez à jour votre photo de profil.') }}
                            </p>
                        </header>

                        <div class="mt-6 flex items-center gap-6">
                            <!-- Photo actuelle -->
                            <div>
                                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->first_name }}" class="rounded-full h-20 w-20 object-cover">
                            </div>

                            <!-- Formulaire d'upload -->
                            <form method="post" action="{{ route('profile.photo.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
                                @csrf

                                <div>
                                    <x-input-label for="profile_photo" :value="__('Nouvelle photo')" />
                                    <x-text-input id="profile_photo" name="profile_photo" type="file" class="mt-1 block w-full" accept="image/*" required />
                                    <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Télécharger') }}</x-primary-button>
                                </div>
                            </form>

                            <!-- Bouton supprimer -->
                            @if (Auth::user()->profile_photo_path)
                                <form method="post" action="{{ route('profile.photo.destroy') }}" class="mt-6">
                                    @csrf
                                    @method('delete')
                                    <x-danger-button>{{ __('Supprimer') }}</x-danger-button>
                                </form>
                            @endif
                        </div>
                    </section>
                </div>
            </div>

            <!-- Section Mise à jour des informations du profil -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Section Mise à jour du mot de passe -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Section Suppression du compte -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>