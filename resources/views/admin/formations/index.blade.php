@extends('layouts.app')

@section('title', 'Gestion des Formations')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Gestion des Formations</h1>
        <a href="{{ route('admin.formations.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
            <i class="fas fa-plus mr-2"></i> Ajouter une formation
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <p><i class="fas fa-check-circle mr-2"></i> {{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phase</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($formations as $formation)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $formation->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ Str::limit($formation->description, 50) ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $formation->phase->name ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.formations.show', ['locale' => app()->getLocale(), 'formation' => $formation->id]) }}" class="text-blue-600 hover:text-blue-900 mr-2" title="Voir"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.formations.edit', ['locale' => app()->getLocale(), 'formation' => $formation->id]) }}" class="text-green-600 hover:text-green-900 mr-2" title="Modifier"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.formations.destroy', ['locale' => app()->getLocale(), 'formation' => $formation->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer cette formation ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-6 text-gray-500">
                            Aucune formation enregistrée
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
