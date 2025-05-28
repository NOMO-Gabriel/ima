@extends('layouts.app')

@section('content')
<h1>Modifier la commande #{{ $command->id }}</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form action="{{ route('admin.commands.update', ['locale' => app()->getLocale(), 'command' => $command->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div id="units-container">
        @foreach(old('units', $command->commandUnits->toArray()) as $index => $unit)
        <div class="unit-row mb-3 border p-3">
            <input type="hidden" name="units[{{ $index }}][id]" value="{{ $unit['id'] ?? '' }}">
            <div>
                <label>Matériel *</label>
                <select name="units[{{ $index }}][material_id]" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    @foreach($materials as $material)
                        <option value="{{ $material->id }}" {{ ($unit['material_id'] ?? '') == $material->id ? 'selected' : '' }}>{{ $material->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Quantité *</label>
                <input type="number" name="units[{{ $index }}][quantity]" class="form-control" min="0" required value="{{ $unit['quantity'] ?? '' }}">
            </div>
            <button type="button" class="btn btn-danger mt-2 remove-unit-btn">Supprimer</button>
        </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-secondary mb-3" id="add-unit-btn">Ajouter un matériel</button>

    <div>
        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Annuler</a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let unitIndex = {{ count(old('units', $command->commandUnits)) }};

    document.getElementById('add-unit-btn').addEventListener('click', () => {
        const container = document.getElementById('units-container');
        const newUnit = document.querySelector('.unit-row').cloneNode(true);

        newUnit.querySelectorAll('select, input').forEach(el => {
            if(el.name.includes('[id]')) {
                el.value = '';
                return;
            }
            const name = el.getAttribute('name');
            const newName = name.replace(/\d+/, unitIndex);
            el.setAttribute('name', newName);
            if(el.tagName === 'SELECT') el.selectedIndex = 0;
            else el.value = '';
        });

        container.appendChild(newUnit);
        unitIndex++;

        newUnit.querySelector('.remove-unit-btn').addEventListener('click', () => {
            newUnit.remove();
        });
    });

    document.querySelectorAll('.remove-unit-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.target.closest('.unit-row').remove();
        });
    });
});
</script>
@endsection
