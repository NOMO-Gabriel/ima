@extends('layouts.app')

@section('title', 'Ajouter un Centre')

@section('content')
<div class="container flex flex-col mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Ajouter un Centre</h1>
        <p class="mt-1 text-sm text-gray-600">Créez un nouveau centre et attribuez un directeur.</p>
    </div>

    <div class="mx-auto bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <form action="{{ route('admin.centers.store', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('code')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="academy_id" class="block text-sm font-medium text-gray-700">Académie parente <span class="text-red-500">*</span></label>
                    <select name="academy_id" id="academy_id" required
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">-- Sélectionnez une académie --</option>
                        @foreach($academies as $academy)
                            <option value="{{ $academy->id }}" {{ old('academy_id') == $academy->id ? 'selected' : '' }}>
                                {{ $academy->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('academy_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city_id" class="block text-sm font-medium text-gray-700">Ville <span class="text-red-500">*</span></label>
                    <select name="city_id" id="city_id" required>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                    <input type="text" name="address" id="address" value="{{ old('address') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700">Email de contact</label>
                    <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('contact_email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="contact_phone" class="block text-sm font-medium text-gray-700">Téléphone de contact</label>
                    <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    @error('contact_phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="director_id" class="block text-sm font-medium text-gray-700">Directeur</label>
                    <select name="director_id" id="director_id"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">-- Aucun --</option>
                        @foreach($directors as $director)
                            <option value="{{ $director->id }}" {{ old('director_id') == $director->id ? 'selected' : '' }}>
                                {{ $director->first_name }} {{ $director->last_name }} ({{ $director->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('director_id')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center space-x-4">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                    <label for="is_active" class="text-sm text-gray-700">Actif</label>
                </div>

                <div class="flex justify-end space-x-3 pt-5 border-t border-gray-200">
                    <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}"
                        class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Annuler
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Créer le centre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
