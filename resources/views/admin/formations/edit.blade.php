@extends('layouts.app')

@section('title', 'Modifier la Formation')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Modifier la Formation</h1>

    <form action="{{ route('admin.formations.update', ['locale' => app()->getLocale(), 'formation' => $formation]) }}" method="POST" class="bg-white rounded-lg shadow p-6 space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" name="name" id="name" value="{{ old('name', $formation->name) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            @error('name')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="descript
