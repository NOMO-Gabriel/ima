@extends('layouts.app')

@section('title', 'Profil Étudiant: ' . $studentUser->full_name)

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
        <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}"
           class="inline-flex items-center transition-colors"
           :class="darkMode ? 'text-gray-400 hover:text-white' : 'text-gray-600 hover:text-[#4CA3DD]'">
            <i class="fas fa-user-graduate mr-1"></i>
            Étudiants
        </a>
        <span :class="darkMode ? 'text-gray-500' : 'text-gray-400'">/</span>
        <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">Profil: {{ $studentUser->first_name }}</span>
    </div>
@endsection

@section('page_header')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-id-card mr-2 text-[#4CA3DD]"></i>
                    Profil de l'Étudiant: <span class="font-semibold">{{ $studentUser->full_name }}</span>
                </h1>
                <p class="mt-1 text-sm"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Vue détaillée des informations et inscriptions de l'étudiant.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                @can('admin.student.update')
                    <a href="{{ route('admin.students.edit', ['locale' => app()->getLocale(), 'studentUser' => $studentUser->id]) }}"
                       class="inline-flex items-center px-4 py-2 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Modifier le Profil
                    </a>
                @endcan
                <a href="{{ route('admin.students.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                   :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>
        </div>
    </div>
@endsection

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

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Colonne de Gauche: Informations de base et compte -->
            <div class="lg:col-span-4 space-y-8">
                <!-- Carte Profil Principal -->
                <div class="rounded-xl shadow-lg border overflow-hidden transition-all duration-300 hover:shadow-2xl"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 text-center">
                        <div class="relative inline-block mb-4">
                            <img src="{{ $studentUser->profile_photo_url }}" alt="{{ $studentUser->full_name }}"
                                 class="w-32 h-32 rounded-full object-cover border-4 shadow-md"
                                 :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                            @php $statusConfigAvatar = \App\Models\User::getStatusConfig($studentUser->status); @endphp
                            <div class="absolute bottom-1 right-1 w-6 h-6 rounded-full border-2 flex items-center justify-center {{ $statusConfigAvatar['bg_color'] }} {{ $statusConfigAvatar['dark_bg_color'] }}"
                                 :class="{ 'border-white': !darkMode, 'border-gray-800': darkMode }">
                                <i class="{{ $statusConfigAvatar['icon'] }} text-xs {{ $statusConfigAvatar['text_color'] }} {{ $statusConfigAvatar['dark_text_color'] }}"></i>
                            </div>
                        </div>
                        <h2 class="text-2xl font-bold" :class="darkMode ? 'text-white' : 'text-gray-900'">{{ $studentUser->full_name }}</h2>
                        <p class="text-sm mt-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">{{ $studentUser->account_type_label ?? 'Étudiant' }}</p>

                        @php $statusConfigBadge = \App\Models\User::getStatusConfig($studentUser->status); @endphp
                        <span class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold leading-4 {{ $statusConfigBadge['bg_color'] }} {{ $statusConfigBadge['text_color'] }}"
                              :class="{ '{{ str_replace(':', '\:', $statusConfigBadge['dark_bg_color']) }} {{ str_replace(':', '\:', $statusConfigBadge['dark_text_color']) }}': darkMode }">
                        <i class="{{ $statusConfigBadge['icon'] }} mr-1.5 text-xs"></i>
                        {{ $statusConfigBadge['label'] }}
                    </span>
                    </div>
                    <div class="px-6 py-4 border-t divide-y" :class="darkMode ? 'border-gray-700 divide-gray-700 bg-gray-750' : 'border-gray-200 divide-gray-200 bg-gray-50'">
                        <div class="py-3 flex items-center text-sm">
                            <i class="fas fa-envelope fa-fw mr-3 w-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'"></i>
                            <span :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->email }}</span>
                        </div>
                        @if($studentUser->phone_number)
                            <div class="py-3 flex items-center text-sm">
                                <i class="fas fa-phone fa-fw mr-3 w-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'"></i>
                                <span :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->phone_number }}</span>
                            </div>
                        @endif
                        @if($studentUser->gender_label)
                            <div class="py-3 flex items-center text-sm">
                                <i class="fas fa-venus-mars fa-fw mr-3 w-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'"></i>
                                <span :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->gender_label }}</span>
                            </div>
                        @endif
                        <div class="py-3 flex items-center text-sm">
                            <i class="fas fa-city fa-fw mr-3 w-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'"></i>
                            <span :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->city->name ?? ($studentUser->city ?? 'N/A') }}</span>
                        </div>
                        <div class="py-3 flex items-center text-sm">
                            <i class="fas fa-map-marker-alt fa-fw mr-3 w-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'"></i>
                            <span :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->address ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                @if($studentUser->student)
                    <div class="rounded-xl shadow-lg border" :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                        <div class="p-6 border-b" :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                            <h3 class="text-lg font-semibold flex items-center" :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                                <i class="fas fa-user-graduate mr-2 text-[#4CA3DD]"></i>Informations Étudiant (Profil)
                            </h3>
                        </div>
                        <div class="px-6 py-4 divide-y" :class="darkMode ? 'divide-gray-700' : 'divide-gray-200'">
                            @if($studentUser->student->parent_phone_number)
                                <div class="py-3 flex items-center text-sm">
                                    <i class="fas fa-user-friends fa-fw mr-3 w-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'"></i>
                                    <span class="font-medium mr-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Tel. Parent:</span>
                                    <span :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->student->parent_phone_number }}</span>
                                </div>
                            @endif
                            @if($studentUser->student->establishment)
                                <div class="py-3 flex items-center text-sm">
                                    <i class="fas fa-school fa-fw mr-3 w-4" :class="darkMode ? 'text-gray-400' : 'text-gray-500'"></i>
                                    <span class="font-medium mr-1" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Établissement:</span>
                                    <span :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->student->establishment }}</span>
                                </div>
                            @endif
                            {{-- Ajoutez d'autres champs du modèle Student ici --}}
                        </div>
                    </div>
                @endif

                <!-- Carte Historique du Compte -->
                <div class="rounded-xl shadow-lg border" :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 border-b" :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                        <h3 class="text-lg font-semibold flex items-center" :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <i class="fas fa-history mr-2 text-[#4CA3DD]"></i>Historique du Compte
                        </h3>
                    </div>
                    <div class="px-6 py-4 divide-y text-sm" :class="darkMode ? 'divide-gray-700' : 'divide-gray-200'">
                        <div class="py-3">
                            <span class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Inscrit le:</span>
                            <span class="block" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($studentUser->last_login_at)
                            <div class="py-3">
                                <span class="font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">Dernière connexion:</span>
                                <span class="block" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->last_login_at->format('d/m/Y H:i') }}</span>
                            </div>
                        @endif
                        @if($studentUser->validated_by && $studentUser->validated_at)
                            <div class="py-3">
                        <span class="font-medium flex items-center" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            <i class="fas fa-check-circle mr-2 text-green-500"></i>Validé par:
                        </span>
                                <span class="block" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->validator->full_name ?? 'N/A' }}
                            <small class="block" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">le {{ $studentUser->validated_at->format('d/m/Y H:i') }}</small>
                        </span>
                            </div>
                        @endif
                        @if($studentUser->finalized_by && $studentUser->finalized_at)
                            <div class="py-3">
                        <span class="font-medium flex items-center" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            <i class="fas fa-flag-checkered mr-2 text-blue-500"></i>Finalisé par:
                        </span>
                                <span class="block" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->finalizer->full_name ?? 'N/A' }}
                            <small class="block" :class="darkMode ? 'text-gray-500' : 'text-gray-400'">le {{ $studentUser->finalized_at->format('d/m/Y H:i') }}</small>
                        </span>
                            </div>
                        @endif
                        @if($studentUser->status === \App\Models\User::STATUS_REJECTED && $studentUser->rejection_reason)
                            <div class="py-3">
                        <span class="font-medium flex items-center" :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                            <i class="fas fa-times-circle mr-2 text-red-500"></i>Motif du rejet:
                        </span>
                                <p class="mt-1 text-xs" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">{{ $studentUser->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Colonne de Droite: Inscriptions et autres détails -->
            <div class="lg:col-span-8">
                <div class="rounded-xl shadow-lg border"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 border-b" :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                        <h3 class="text-lg font-semibold flex items-center" :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <i class="fas fa-book-reader mr-2 text-[#4CA3DD]"></i>Inscriptions Actives
                        </h3>
                    </div>
                    <div class="p-6">
                        @if($studentUser->student && $studentUser->student->enrollments->isNotEmpty())
                            <div class="space-y-6">
                                @foreach($studentUser->student->enrollments as $enrollment)
                                    <div class="p-4 rounded-lg border transition-all duration-200 hover:shadow-md"
                                         :class="{ 'bg-gray-750 border-gray-600 hover:border-gray-500': darkMode, 'bg-gray-50 border-gray-200 hover:border-gray-300': !darkMode }">
                                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-2">
                                            <h4 class="text-md font-semibold" :class="darkMode ? 'text-blue-400' : 'text-blue-600'">
                                                {{ $enrollment->formation->name ?? 'Formation non spécifiée' }}
                                            </h4>
                                            <span class="text-xs px-2 py-0.5 rounded-full mt-1 sm:mt-0"
                                                  :class="darkMode ? 'bg-gray-600 text-gray-300' : 'bg-gray-200 text-gray-600'">
                                        N° Reçu: {{ $enrollment->receipt_number }}
                                    </span>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                            <p :class="darkMode ? 'text-gray-300' : 'text-gray-700'"><strong :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Centre:</strong> {{ $enrollment->center->name ?? 'N/A' }}</p>
                                            <p :class="darkMode ? 'text-gray-300' : 'text-gray-700'"><strong :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Date:</strong> {{ $enrollment->created_at->format('d/m/Y') }}</p>
                                            <p class="md:col-span-2" :class="darkMode ? 'text-gray-300' : 'text-gray-700'"><strong :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Montant Contrat:</strong> {{ number_format($enrollment->contract, 0, ',', ' ') }} XAF</p>
                                        </div>
                                        @if($enrollment->special_conditions)
                                            <div class="mt-3 pt-3 border-t" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                                                <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Conditions spéciales:</p>
                                                <p class="text-xs whitespace-pre-line" :class="darkMode ? 'text-gray-300' : 'text-gray-600'}">{{ $enrollment->special_conditions }}</p>
                                            </div>
                                        @endif

                                        @if(method_exists($enrollment, 'additionalFormations') && $enrollment->additionalFormations->isNotEmpty())
                                            <div class="mt-3 pt-3 border-t" :class="darkMode ? 'border-gray-600' : 'border-gray-200'">
                                                <p class="text-sm font-medium" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">Formations additionnelles :</p>
                                                <ul class="list-disc list-inside pl-1 text-xs" :class="darkMode ? 'text-gray-300' : 'text-gray-600'}">
                                                    @foreach($enrollment->additionalFormations as $addFormation)
                                                        <li>{{ $addFormation->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 px-4 rounded-lg" :class="darkMode ? 'bg-gray-750' : 'bg-gray-50'">
                                <i class="fas fa-info-circle text-3xl mb-3" :class="darkMode ? 'text-gray-500' : 'text-gray-400'"></i>
                                <p class="text-md font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Cet étudiant n'a aucune inscription pour le moment.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Vous pouvez ajouter d'autres sections ici : notes, paiements, etc. --}}
                <!--
            <div class="mt-8 rounded-xl shadow-lg border" :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                <div class="p-6 border-b" :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                    <h3 class="text-lg font-semibold flex items-center" :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                        <i class="fas fa-money-check-alt mr-2 text-[#4CA3DD]"></i>Historique des Paiements
                    </h3>
                </div>
                <div class="p-6">
                    <div class="text-center py-8 px-4 rounded-lg" :class="darkMode ? 'bg-gray-750' : 'bg-gray-50'">
                        <i class="fas fa-search-dollar text-3xl mb-3" :class="darkMode ? 'text-gray-500' : 'text-gray-400'"></i>
                        <p class="text-md font-medium" :class="darkMode ? 'text-gray-300' : 'text-gray-700'">Aucun paiement enregistré pour le moment.</p>
                    </div>
                </div>
            </div>
            -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes au chargement
            const cards = document.querySelectorAll('.rounded-xl.shadow-lg');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = `all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94) ${index * 0.07}s`;
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50 + (index * 70));
            });
        });
    </script>
@endpush
