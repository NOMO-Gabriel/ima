@extends('layouts.app')

@section('content')
    <h1>Modifier le Département</h1>

    <form method="POST" action="{{ route('admin.departments.update', ['locale' => app()->getLocale(), 'department' => $department]) }}">
        @csrf
        @method('PUT')

        <label for="name">Nom *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $department->name) }}" required>

        <label for="code">Code</label>
        <input type="text" name="code" id="code" value="{{ old('code', $department->code) }}">

        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description', $department->description) }}</textarea>

        <label for="is_active">Actif ?</label>
        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $department->is_active) ? 'checked' : '' }}>

        <label for="academy_id">Académie *</label>
        <select name="academy_id" id="academy_id" required>
            @foreach ($academies as $academy)
                <option value="{{ $academy->id }}" {{ old('academy_id', $department->academy_id) == $academy->id ? 'selected' : '' }}>
                    {{ $academy->name }}
                </option>
            @endforeach
        </select>

        <label for="head_id">Chef de département</label>
        <select name="head_id" id="head_id">
            <option value="">-- Aucun --</option>
            @foreach ($heads as $head)
                <option value="{{ $head->id }}" {{ old('head_id', $department->head_id) == $head->id ? 'selected' : '' }}>
                    {{ $head->first_name }} {{ $head->last_name }}
                </option>
            @endforeach
        </select>

        <button type="submit">Mettre à jour</button>
    </form>
@endsection
