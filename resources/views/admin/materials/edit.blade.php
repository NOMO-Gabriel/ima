@extends('layouts.app')

@section('content')
<h1>Modifier le matériel</h1>

<form action="{{ route('admin.materials.update', ['locale' => app()->getLocale(), 'material' => $material->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="name" class="form-label">Nom *</label>
        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $material->name) }}">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description', $material->description) }}</textarea>
    </div>

    <div class="mb-3">
        <label for="unit" class="form-label">Unité *</label>
        <select name="unit" id="unit" class="form-control" required>
            @foreach($units as $value => $label)
                <option value="{{ $value }}" {{ old('unit', $material->unit) === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="quantity" class="form-label">Quantité *</label>
        <input type="number" name="quantity" id="quantity" class="form-control" required min="0" value="{{ old('quantity', $material->quantity) }}">
    </div>

    <button class="btn btn-primary">Mettre à jour</button>
    <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection