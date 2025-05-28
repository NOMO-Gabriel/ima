@extends('layouts.app')

@section('content')
<h1>Créer une commande</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<form action="{{ route('admin.commands.store', ['locale' => app()->getLocale()]) }}" method="POST">
    @csrf
    <div id="units-container">
        <div class="unit-row mb-3 border p-3">
            <div>
                <label>Matériel *</label>
                <select name="units[0][material_id]" class="form-select" required>
                    <option value="">-- Choisir --</option>
                    @foreach($materials as $material)
                        <option value="{{ $material->id }}">{{ $material->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Quantité *</label>
                <input type="number" name="units[0][quantity]" class="form-control" min="0" required>
            </div>
            <button type="button" class="btn btn-danger mt-2 remove-unit-btn">Supprimer</button>
        </div>
    </div>

    <button type="button" class="btn btn-secondary mb-3" id="add-unit-btn">Ajouter un matériel</button>

    <div>
        <button class="btn btn-primary">Enregistrer</button>
        <a href="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Annuler</a>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let unitIndex = 1;

    document.getElementById('add-unit-btn').addEventListener('click', () => {
        const container = document.getElementById('units-container');
        const newUnit = document.querySelector('.unit-row').cloneNode(true);

        newUnit.querySelectorAll('select, input').forEach(el => {
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
