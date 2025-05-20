@extends('layouts.app')

@section('title', 'Gestion des Centres')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Gestion des Centres</h1>
        <a href="{{ route('admin.centers.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all">
            <i class="fas fa-plus mr-2"></i> Ajouter un centre
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Académie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nb étudiants</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Directeur</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($centers as $center)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $center->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $center->code ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $center->academy->name ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $center->nb_students }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $center->director->name ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.centers.show', ['locale' => app()->getLocale(), 'center' => $center->id]) }}" class="text-blue-600 hover:text-blue-900 mr-2" title="Voir"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.centers.edit', ['locale' => app()->getLocale(), 'center' => $center->id]) }}" class="text-green-600 hover:text-green-900 mr-2" title="Modifier"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.centers.destroy', ['locale' => app()->getLocale(), 'center' => $center->id]) }}" method="POST" class="inline-block" onsubmit="return confirm('Voulez-vous vraiment supprimer ce centre ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            Aucun centre enregistré
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
