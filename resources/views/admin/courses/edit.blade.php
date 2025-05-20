@extends('layouts.app')

@section('title', 'Modifier un Cours')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Modifier un Cours</h1>

    @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.courses.update', ['locale' => app()->getLocale(), 'course' => $course->id]) }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div>
            <label for="code" class="block text-gray-700 font-medium mb-1">Code</label>
            <input type="text" name="code" id="code" value="{{ old('code', $course->code) }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="title" class="block text-gray-700 font-medium mb-1">Titre</label>
            <input type="text" name="title" id="title" value="{{ old('title', $course->title) }}" required
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
        </div>

        <div>
            <label for="description" class="block text-gray-700 font-medium mb-1">Description</label>
            <textarea name="description" id="description" rows="4"
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $course->description) }}</textarea>
        </div>

        <div>
            <label for="formations" class="block text-gray-700 font-medium mb-1">Formations associées</label>
            <select name="formations[]" id="formations" multiple
                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach ($formations as $formation)
                    <option value="{{ $formation->id }}"
                        {{ in_array($formation->id, old('formations', $course->formations->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $formation->name ?? $formation->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Enregistrer</button>
            <a href="{{ route('admin.courses.index', ['locale' => app()->getLocale()]) }}"
                class="ml-4 px-6 py-2 border border-gray-300 rounded hover:bg-gray-100 transition">Annuler</a>
        </div>
    </form>
@endsection
