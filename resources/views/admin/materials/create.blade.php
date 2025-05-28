@extends('layouts.app')

@section('content')
<h1>Ajouter un matériel</h1>

<form action="{{ route('admin.materials.store', ['locale' => app()->getLocale()]) }}" method="POST">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nom *</label>
        <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="unit" class="form-label">Unité *</label>
        <select name="unit" id="unit" class="form-control" required>
            @foreach($units as $value => $label)
                <option value="{{ $value }}" {{ old('unit') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="quantity" class="form-label">Quantité *</label>
        <input type="number" name="quantity" id="quantity" class="form-control" required min="0" value="{{ old('quantity', 0) }}">
    </div>

    <button class="btn btn-success">Enregistrer</button>
    <a href="{{ route('admin.materials.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Annuler</a>
</form>
@endsection
