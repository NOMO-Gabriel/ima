@extends('layouts.app')

@section('title', 'Profil Enseignant: ' . $teacherUser->full_name)

@section('breadcrumb')
    <div class="flex items-center space-x-2 text-sm"
         x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-home mr-1"></i>
            Tableau de bord
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-chalkboard-teacher mr-1"></i>
            Enseignants
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">Profil: {{ $teacherUser->first_name }}</span>
    </div>
@endsection

@section('page_header')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-user-tie mr-2 text-[#4CA3DD]"></i>
                    Profil de l'Enseignant: <span class="font-semibold">{{ $teacherUser->full_name }}</span>
                </h1>
                <p class="mt-1 text-sm"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Vue détaillée des informations de l'enseignant.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                @can('admin.teacher.update')
                    <a href="{{ route('admin.teachers.edit', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}"
                       class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier le Profil
                    </a>
                @endcan
                <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                   :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
@endsection
@can('admin.teacher.read')
@section('content')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
         class="space-y-8">

        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg border-l-4 border-green-500 shadow-md"
                 :class="{ 'bg-green-900/20 text-green-300': darkMode, 'bg-green-50 text-green-700': !darkMode }">
                <div class="flex items-start">
                    <i class="fas fa-check-circle h-5 w-5 mr-3 mt-0.5 text-green-500"></i>
                    <div>
                        <h3 class="font-medium">Succès</h3>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne de Gauche: Informations de base et compte -->
            <div class="lg:col-span-1 space-y-8">
                <!-- Carte Profil Principal -->
                <div class="rounded-xl shadow-lg border overflow-hidden transition-all duration-300 hover:shadow-2xl"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 text-center">
                        <div class="relative inline-block mb-4">
                            <img src="{{ $teacherUser->profile_photo_url }}" alt="{{ $teacherUser->full_name }}"
                                 class="w-32 h-32 rounded-full object-cover border-4 shadow-md"
                                 :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                            <div class="absolute bottom-1 right-1 w-6 h-6 rounded-full border-2 flex items-center justify-center"
                                 :class="{
                                 'bg-green-500 border-white dark:border-gray-800': '{{ $teacherUser->status }}' === 'active',
                                 'bg-red-500 border-white dark:border-gray-800': '{{ $teacherUser->status }}' === 'suspended',
                                 'bg-yellow-500 border-white dark:border-gray-800': '{{ $teacherUser->status }}' === 'pending_validation',
                                 'bg-gray-500 border-white dark:border-gray-800': '{{ $teacherUser->status }}' === 'inactive'
                             }">
                                @if($teacherUser->status === 'active') <i class="fas fa-check text-xs text-white"></i> @endif
                                @if($teacherUser->status === 'suspended') <i class="fas fa-ban text-xs text-white"></i> @endif
                                @if($teacherUser->status === 'pending_validation') <i class="fas fa-hourglass-half text-xs text-white"></i> @endif
                                @if($teacherUser->status === 'inactive') <i class="fas fa-minus-circle text-xs text-white"></i> @endif
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $teacherUser->full_name }}</h2>
                        <p class="text-sm mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $teacherUser->teacherProfile->profession ?? 'Profession non spécifiée' }}</p>

                        @php
                            $statusConfig = \App\Models\User::getStatusConfig($teacherUser->status); // Assurez-vous que cette méthode existe
                        @endphp
                        <span class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold leading-4 {{ $statusConfig['text_color'] }} {{ $statusConfig['bg_color'] }}"
                              :class="{ '{{ $statusConfig['dark_text_color'] }} {{ $statusConfig['dark_bg_color'] }}': darkMode }">
                        {{ $statusConfig['label'] }}
                    </span>
                    </div>
                    <div class="px-6 py-4 border-t text-center" :class="darkMode ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50'">
                        @forelse($teacherUser->roles as $role)
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full mr-1 mb-1"
                                  :class="darkMode ? 'bg-gray-600 text-gray-200' : 'bg-gray-200 text-gray-700'">
                            {{ ucfirst($role->name) }}
                        </span>
                        @empty
                            <span class="text-xs italic" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">Aucun rôle assigné</span>
                        @endforelse
                    </div>
                </div>

                <!-- Carte Informations du Compte -->
                <div class="rounded-xl shadow-lg border"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 border-b" :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                        <h3 class="text-lg font-semibold flex items-center" :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <i class="fas fa-shield-alt mr-2 text-[#4CA3DD]"></i>Informations du Compte
                        </h3>
                    </div>
                    <div class="p-6 space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Créé le:</span>
                            <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Email vérifié:</span>
                            @if($teacherUser->email_verified_at)
                                <span class="text-green-600 dark:text-green-400 flex items-center">
                                <i class="fas fa-check-circle mr-1"></i> {{ $teacherUser->email_verified_at->format('d/m/Y H:i') }}
                            </span>
                            @else
                                <span class="text-yellow-600 dark:text-yellow-400 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Non vérifié
                            </span>
                            @endif
                        </div>
                        @if($teacherUser->last_login_at)
                            <div class="flex justify-between">
                                <span class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Dernière connexion:</span>
                                <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->last_login_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        @if($teacherUser->validator)
                            <div class="flex justify-between">
                                <span class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Validé par:</span>
                                <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->validator->full_name }} ({{ $teacherUser->validated_at->format('d/m/Y') }})</span>
                            </div>
                        @endif
                        @if($teacherUser->finalizer)
                            <div class="flex justify-between">
                                <span class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Finalisé par:</span>
                                <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->finalizer->full_name }} ({{ $teacherUser->finalized_at->format('d/m/Y') }})</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne de Droite: Détails de l'enseignant -->
            <div class="lg:col-span-2">
                <div class="rounded-xl shadow-lg border"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 border-b" :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                        <h3 class="text-lg font-semibold flex items-center" :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <i class="fas fa-info-circle mr-2 text-[#4CA3DD]"></i>Détails de l'Enseignant
                        </h3>
                    </div>
                    <div class="p-6">
                        <!-- Informations Personnelles (Utilisateur) -->
                        <div class="mb-6">
                            <h4 class="text-md font-semibold mb-3 pb-2 border-b" :class="{ 'text-gray-300 border-gray-700': darkMode, 'text-gray-700 border-gray-200': !darkMode }">
                                <i class="fas fa-id-card mr-2 text-gray-400"></i>Informations Personnelles
                            </h4>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Email:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->email }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Téléphone:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->phone_number ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Genre:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->gender_label ?? 'N/A' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Adresse de résidence:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->address ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Informations Professionnelles (Profil Enseignant) -->
                        <div>
                            <h4 class="text-md font-semibold mb-3 pb-2 border-b" :class="{ 'text-gray-300 border-gray-700': darkMode, 'text-gray-700 border-gray-200': !darkMode }">
                                <i class="fas fa-user-graduate mr-2 text-gray-400"></i>Informations Professionnelles
                            </h4>
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Matricule:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->teacherProfile->matricule ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">N° CNI:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->teacherProfile->cni ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Date de Naissance:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->teacherProfile->birthdate ? ($teacherUser->teacherProfile->birthdate instanceof \Carbon\Carbon ? $teacherUser->teacherProfile->birthdate->format('d/m/Y') : \Carbon\Carbon::parse($teacherUser->teacherProfile->birthdate)->format('d/m/Y')) : 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Lieu de Naissance:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->teacherProfile->birthplace ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Salaire:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->teacherProfile->salary ? number_format($teacherUser->teacherProfile->salary, 0, ',', ' ') . ' XAF' : 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Académie d'affectation:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->teacherProfile->academy->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Département d'affectation:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->teacherProfile->department->name ?? 'N/A' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Ville d'affectation (Profil):</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->teacherProfile->city->name ?? 'N/A' }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Centre Principal:</dt>
                                    <dd :class="darkMode ? 'text-gray-300' : 'text-gray-800'">{{ $teacherUser->teacherProfile->center->name ?? 'N/A' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@endcan

@push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Scripts spécifiques à cette page si nécessaire
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes au chargement
            const cards = document.querySelectorAll('.rounded-xl.shadow-lg');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = `all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) ${index * 0.1}s`;
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50 + (index * 100));
            });
        });
    </script>
@endpush
