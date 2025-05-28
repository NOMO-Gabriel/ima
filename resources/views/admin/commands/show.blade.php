@extends('layouts.app')

@section('content')
<h1>Détails de la commande #{{ $command->id }}</h1>

<p><strong>Date :</strong> {{ $command->date->format('d/m/Y H:i') }}</p>
<p><strong>Quantité totale :</strong> {{ $command->quantity }}</p>
<p><strong>Montant total :</strong> {{ number_format($command->amount, 2, ',', ' ') }} €</p>
<p><strong>Utilisateur :</strong> {{ $command->user->name ?? 'N/A' }}</p>

<h3>Unités</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Matériel</th>
            <th>Quantité</th>
            <th>Montant (€)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($command->commandUnits as $unit)
            <tr>
                <td>{{ $unit->material->name ?? 'N/A' }}</td>
                <td>{{ $unit->quantity }}</td>
                <td>{{ number_format($unit->amount, 2, ',', ' ') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.commands.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">Retour</a>
<a href="{{ route('admin.commands.edit', ['locale' => app()->getLocale(), 'command' => $command->id]) }}" class="btn btn-warning">Modifier</a>
@endsection
