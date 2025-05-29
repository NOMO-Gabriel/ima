@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le département</h1>

    <form action="{{ route('admin.departments.update', ['locale' => app()->getLocale(), 'department' => $department]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom *</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $department->name) }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $department->code) }}">
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $department->description) }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" value="1" name="is_active" id="is_active" class="form-check-input" {{ old('is_active', $department->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Actif</label>
            @error('is_active') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="academy_id" class="form-label">Académie</label>
            <select name="academy_id" id="academy_id" class="form-select">
                <option value="">-- Aucun --</option>
                @foreach($academies as $academy)
                    <option value="{{ $academy->id }}" {{ old('academy_id', $department->academy_id) == $academy->id ? 'selected' : '' }}>{{ $academy->name }}</option>
                @endforeach
            </select>
            @error('academy_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="head_id" class="form-label">Responsable</label>
            <select name="head_id" id="head_id" class="form-select">
                <option value="">-- Aucun --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('head_id', $department->head_id) == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
                @endforeach
            </select>
            @error('head_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
