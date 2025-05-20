@extends('layouts.app')

@section('title', 'Gestion des Centres')

@section('content')
    <!-- Fil d'Ariane -->
    <nav class="flex mb-5" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-[#4CA3DD]">
                    <i class="fas fa-home mr-2"></i>
                    Tableau de bord
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right mx-2 text-gray-400 text-xs"></i>
                    <span class="text-sm font-medium text-gray-500">Gestion des Centres</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Conteneur principal avec fond blanc -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <!-- En-tête avec titre et bouton d'ajout -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 flex items-center mb-4 md:mb-0">
                <i class="fas fa-building mr-2 text-[#4CA3DD]"></i> Gestion des Centres
            </h1>
            <a href="{{ route('admin.centers.create', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] text-white rounded-md hover:bg-[#2A7AB8] transition-all">
                <i class="fas fa-plus mr-2"></i> Ajouter un centre
            </a>
        </div>

        <!-- Message de succès -->
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded flex items-start" role="alert">
                <i class="fas fa-check-circle mt-1 mr-3"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        <!-- Tableau des centres -->
        <div class="overflow-x-auto border border-gray-200 rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Code</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Académie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Nb étudiants</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Directeur</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($centers as $center)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $center->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $center->code ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $center->academy->name ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $center->nb_students }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $center->director->name ?? '—' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-2">
                            <a href="{{ route('admin.centers.show', ['locale' => app()->getLocale(), 'center' => $center->id]) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-100 text-[#4CA3DD] hover:bg-blue-200">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.centers.edit', ['locale' => app()->getLocale(), 'center' => $center->id]) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-full bg-green-100 text-green-600 hover:bg-green-200">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.centers.destroy', ['locale' => app()->getLocale(), 'center' => $center->id]) }}"
                                  method="POST"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Voulez-vous vraiment supprimer ce centre ?');"
                                        class="w-8 h-8 flex items-center justify-center rounded-full bg-red-100 text-red-600 hover:bg-red-200">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-10">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-2xl mb-4">
                                    <i class="fas fa-building"></i>
                                </div>
                                <p class="text-lg font-medium">Aucun centre enregistré</p>
                                <p class="text-sm text-gray-500 mt-1">Commencez par ajouter un centre en utilisant le bouton ci-dessus</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Statistiques sous forme de cartes -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow flex items-center">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-[#4CA3DD] text-xl mr-4">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Total étudiants</p>
                <h4 class="text-2xl font-bold">{{ $centers->sum('nb_students') ?? 0 }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl mr-4">
                <i class="fas fa-building"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Centres actifs</p>
                <h4 class="text-2xl font-bold">{{ $centers->where('is_active', true)->count() ?? 0 }}</h4>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center">
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 text-xl mr-4">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
                <p class="text-gray-600 text-sm">Moyenne par centre</p>
                <h4 class="text-2xl font-bold">{{ $centers->count() > 0 ? round($centers->sum('nb_students') / $centers->count()) : 0 }}</h4>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Animation pour faire disparaitre le message de succès après 5 secondes
        document.addEventListener('DOMContentLoaded', function() {
            const alertSuccess = document.querySelector('.bg-green-100');
            if (alertSuccess) {
                setTimeout(() => {
                    alertSuccess.classList.add('opacity-0', 'transform', 'transition-all', 'duration-500');
                    setTimeout(() => {
                        alertSuccess.remove();
                    }, 500);
                }, 5000);
            }
        });
    </script>
@endpush
