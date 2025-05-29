@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un département</h1>

    <form action="{{ route('admin.departments.store', ['locale' => app()->getLocale()]) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom *</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}">
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_active" value="1" id="is_active" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
            <label for="is_active" class="form-check-label">Actif</label>
            @error('is_active') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="academy_id" class="form-label">Académie</label>
            <select name="academy_id" id="academy_id" class="form-select">
                <option value="">-- Aucun --</option>
                @foreach($academies as $academy)
                    <option value="{{ $academy->id }}" {{ old('academy_id') == $academy->id ? 'selected' : '' }}>{{ $academy->name }}</option>
                @endforeach
            </select>
            @error('academy_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="head_id" class="form-label">Responsable</label>
            <select name="head_id" id="head_id" class="form-select">
                <option value="">-- Aucun --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('head_id') == $user->id ? 'selected' : '' }}>{{ $user->first_name }} {{ $user->last_name }}</option>
                @endforeach
            </select>
            @error('head_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('admin.departments.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
