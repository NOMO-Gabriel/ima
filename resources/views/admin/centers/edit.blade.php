@extends('layouts.app')

@section('title', 'Modifier le Centre')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Modifier le Centre</h1>

    <form action="{{ route('admin.centers.update', ['locale' => app()->getLocale(), 'center' => $center->id]) }}" method="POST" class="max-w-lg">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block font-medium text-gray-700">Nom <span class="text-red-500">*</span></label>
            <input type="text" id="name" name="name" value="{{ old('name', $center->name) }}" required class="mt-1 block w-full border-gray-300 rounded-md" />
            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="code" class="block font-medium text-gray-700">Code</label>
            <input type="text" id="code" name="code" value="{{ old('code', $center->code) }}" class="mt-1 block w-full border-gray-300 rounded-md" />
            @error('code') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="academy_id" class="block font-medium text-gray-700">Académie <span class="text-red-500">*</span></label>
            <select id="academy_id" name="academy_id" required class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">-- Sélectionner une académie --</option>
                @foreach($academies as $academy)
                    <option value="{{ $academy->id }}" {{ old('academy_id', $center->academy_id) == $academy->id ? 'selected' : '' }}>{{ $academy->name }}</option>
                @endforeach
            </select>
            @error('academy_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="director_id" class="block font-medium text-gray-700">Directeur</label>
            <select id="director_id" name="director_id" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">-- Sélectionner un directeur --</option>
                @foreach($directors as $director)
                    <option value="{{ $director->id }}" {{ old('director_id', $center->director_id) == $director->id ? 'selected' : '' }}>
                        {{ $director->first_name }} {{ $director->last_name }} ({{ $director->email }})
                    </option>
                @endforeach
            </select>
            @error('director_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="city_id" class="block font-medium text-gray-700">Ville</label>
            <select id="city_id" name="city_id" class="mt-1 block w-full border-gray-300 rounded-md">
                <option value="">-- Sélectionner une ville --</option>
                @foreach($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id', $center->city_id) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                @endforeach
            </select>
            @error('city_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="address" class="block font-medium text-gray-700">Adresse</label>
            <input type="text" id="address" name="address" value="{{ old('address', $center->address) }}" class="mt-1 block w-full border-gray-300 rounded-md" />
            @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="contact_email" class="block font-medium text-gray-700">Email de contact</label>
            <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', $center->contact_email) }}" class="mt-1 block w-full border-gray-300 rounded-md" />
            @error('contact_email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="contact_phone" class="block font-medium text-gray-700">Téléphone de contact</label>
            <input type="text" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $center->contact_phone) }}" class="mt-1 block w-full border-gray-300 rounded-md" />
            @error('contact_phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="is_active" class="inline-flex items-center">
                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $center->is_active) ? 'checked' : '' }} class="mr-2" />
                Centre actif
            </label>
            @error('is_active') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-all">Mettre à jour</button>
        <a href="{{ route('admin.centers.index', ['locale' => app()->getLocale()]) }}" class="ml-4 text-gray-600 hover:underline">Annuler</a>
    </form>
@endsection
