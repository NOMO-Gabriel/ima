@extends('layouts.app')

@section('content')
    <h1>Créer un Département</h1>

    <form method="POST" action="{{ route('admin.departments.store', app()->getLocale()) }}">
        @csrf

        <label for="name">Nom *</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required>

        <label for="code">Code</label>
        <input type="text" name="code" id="code" value="{{ old('code') }}">

        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description') }}</textarea>

        <label for="is_active">Actif ?</label>
        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>

        <label for="academy_id">Académie *</label>
        <select name="academy_id" id="academy_id" required>
            @foreach ($academies as $academy)
                <option value="{{ $academy->id }}" {{ old('academy_id') == $academy->id ? 'selected' : '' }}>
                    {{ $academy->name }}
                </option>
            @endforeach
        </select>

        <label for="head_id">Chef de département</label>
        <select name="head_id" id="head_id">
            <option value="">-- Aucun --</option>
            @foreach ($heads as $head)
                <option value="{{ $head->id }}" {{ old('head_id') == $head->id ? 'selected' : '' }}>
                    {{ $head->first_name }} {{ $head->last_name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Enregistrer</button>
    </form>
@endsection
