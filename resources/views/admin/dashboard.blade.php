@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')
    <!-- Section de bienvenue -->
    <div class="welcome-section bg-white rounded-lg shadow p-6 mb-6 flex flex-col md:flex-row justify-between items-center">
        <div class="welcome-text mb-4 md:mb-0 text-center md:text-left">
            <h2 class="text-2xl font-bold mb-2">Bienvenue sur IMA Dashboard, {{ Auth::user()->first_name }}</h2>
            <p class="text-gray-600 max-w-2xl">
                Gérez efficacement votre personnel et vos services éducatifs. Suivez vos indicateurs en temps réel
                et optimisez le fonctionnement de votre institution.
            </p>
        </div>
        <div class="welcome-actions flex gap-3 flex-wrap justify-center">
            @can('course.create')
            <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-all transform hover:-translate-y-1">
                <i class="fas fa-calendar-plus mr-2"></i> Planifier un cours
            </a>
            @endcan

            @can('user.create')
            <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-all transform hover:-translate-y-1">
                <i class="fas fa-user-plus mr-2"></i> Ajouter un enseignant
            </a>
            @endcan
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        @can('user.view.any')
        <div class="bg-white p-6 rounded-lg shadow flex items-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl mr-4">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold">{{ $stats['students_count'] ?? '0' }}</h3>
                <p class="text-gray-600">Élèves inscrits</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow flex items-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl mr-4">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold">{{ $stats['teachers_count'] ?? '0' }}</h3>
                <p class="text-gray-600">Enseignants actifs</p>
            </div>
        </div>
        @endcan

        @can('course.view')
        <div class="bg-white p-6 rounded-lg shadow flex items-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 text-xl mr-4">
                <i class="fas fa-calendar-day"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold">{{ $stats['courses_count'] ?? '0' }}</h3>
                <p class="text-gray-600">Cours planifiés aujourd'hui</p>
            </div>
        </div>
        @endcan

        @can('finance.transaction.view')
        <div class="bg-white p-6 rounded-lg shadow flex items-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center text-red-600 text-xl mr-4">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <h3 class="text-2xl font-bold">{{ $stats['revenue'] ?? '0' }}M</h3>
                <p class="text-gray-600">Revenus ce mois (FCFA)</p>
            </div>
        </div>
        @endcan
    </div>

    <!-- Actions rapides -->
    <div class="mb-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Actions rapides</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @can('user.create')
            <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="bg-white p-6 rounded-lg shadow text-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xl mx-auto mb-4">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-1">Ajouter un élève</h4>
                <p class="text-sm text-gray-600">Enregistrer un nouvel élève dans le système</p>
            </a>

            <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="bg-white p-6 rounded-lg shadow text-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-xl mx-auto mb-4">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-1">Ajouter un enseignant</h4>
                <p class="text-sm text-gray-600">Enregistrer un nouvel enseignant</p>
            </a>
            @endcan

            @can('course.create')
            <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="bg-white p-6 rounded-lg shadow text-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 text-xl mx-auto mb-4">
                    <i class="fas fa-calendar-plus"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-1">Planifier un cours</h4>
                <p class="text-sm text-gray-600">Programmer un nouveau cours</p>
            </a>
            @endcan

            @can('finance.report.generate')
            <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="bg-white p-6 rounded-lg shadow text-center transition-all hover:transform hover:-translate-y-1 hover:shadow-lg">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-xl mx-auto mb-4">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <h4 class="font-medium text-gray-900 mb-1">Générer un rapport</h4>
                <p class="text-sm text-gray-600">Créer un rapport personnalisé</p>
            </a>
            @endcan
        </div>
    </div>
@endsection

@push('styles')
<style>
    .welcome-section {
        background-image: linear-gradient(to right, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.9) 100%), url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23007bff' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
</style>
@endpush
