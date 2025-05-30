@extends('layouts.app')

@section('title', 'Modifier l\'Enseignant: ' . $teacherUser->full_name)

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
        <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">Modifier: {{ $teacherUser->first_name }}</span>
    </div>
@endsection

@section('page_header')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-edit mr-2 text-[#4CA3DD]"></i>
                    Modifier l'Enseignant: <span class="font-semibold">{{ $teacherUser->full_name }}</span>
                </h1>
                <p class="mt-1 text-sm"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Mettez à jour les informations du profil de l'enseignant.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                   :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Annuler et Retour
                </a>
                @can('admin.teacher.view')
                    <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacher' => $teacherUser->id]) }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-[#4CA3DD] focus:ring-offset-2"
                       :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                        <i class="fas fa-eye mr-2"></i>
                        Voir le Profil
                    </a>
                @endcan
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">

        @can('admin.teacher.update')
            <!-- Messages Flash -->
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
            @if(session('error'))
                <div class="mb-6 p-4 rounded-lg border-l-4 border-red-500 shadow-md"
                     :class="{ 'bg-red-900/20 text-red-300': darkMode, 'bg-red-50 text-red-700': !darkMode }">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle h-5 w-5 mr-3 mt-0.5 text-red-500"></i>
                        <div>
                            <h3 class="font-medium">Erreur</h3>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-6 rounded-xl border-l-4 border-red-500 shadow-lg transition-colors duration-300"
                     :class="{ 'bg-red-900/20 text-red-300': darkMode, 'bg-red-50 text-red-700': !darkMode }">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-triangle h-6 w-6 mr-3 flex-shrink-0 text-red-500"></i>
                        <div>
                            <h3 class="font-medium mb-2">Des erreurs de validation ont été détectées :</h3>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.teachers.update', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" method="POST" class="space-y-8">
                @method('PUT')
                @csrf

                {{-- Inclusion du formulaire partagé.
                     Assurez-vous que _form.blade.php utilise old('field_name', $teacherUser->field_name ?? '')
                     pour pré-remplir les champs.
                     La variable $editMode = true peut être utilisée dans _form.blade.php pour des logiques spécifiques à l'édition (ex: champ mot de passe).
                --}}
                @include('admin.teachers._form', ['teacherUser' => $teacherUser, 'editMode' => true])

                <!-- Boutons d'action -->
                <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6">
                    <a href="{{ route('admin.teachers.index', app()->getLocale()) }}"
                       class="inline-flex items-center justify-center px-6 py-3 border-2 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md order-2 sm:order-1"
                       :class="{ 'border-gray-600 text-gray-300 bg-gray-700 hover:bg-gray-600': darkMode, 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50': !darkMode }">
                        <i class="fas fa-times mr-2"></i>
                        Annuler
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-3 bg-[#4CA3DD] hover:bg-[#3d8bc0] text-white font-medium rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 order-1 sm:order-2">
                        <i class="fas fa-save mr-2"></i>
                        Mettre à Jour l'Enseignant
                    </button>
                </div>
            </form>
        @else
            <!-- Accès non autorisé -->
            <div class="shadow-md rounded-xl p-8 text-center transition-colors duration-300"
                 :class="{ 'bg-gray-800': darkMode, 'bg-white': !darkMode }">
                <i class="fas fa-lock h-16 w-16 mx-auto mb-4"
                   :class="{ 'text-gray-500': darkMode, 'text-gray-400': !darkMode }"></i>
                <h3 class="text-lg font-medium mb-2"
                    :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                    Accès non autorisé
                </h3>
                <p :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                    Vous n'avez pas les permissions nécessaires pour modifier cet enseignant.
                </p>
            </div>
        @endcan
    </div>
@endsection

@push('styles')
    {{-- Les styles sont identiques à ceux de la page de création --}}
    <style>
        .form-group {
            opacity: 0;
            animation: fadeInUp 0.5s ease forwards;
        }
        /* Décalage pour l'animation des champs */
        @for ($i = 1; $i <= 20; $i++) /* Supposons un maximum de 20 champs pour l'animation */
        .form-group:nth-child({{ $i }}) { animation-delay: {{ $i * 0.05 }}s; }
        @endfor

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        input:focus, textarea:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(76, 163, 221, 0.2);
        }
        .dark input:focus, .dark textarea:focus, .dark select:focus {
            box-shadow: 0 0 0 3px rgba(76, 163, 221, 0.3);
        }

        .form-group label { transition: all 0.2s ease; }
        .form-group:focus-within label, .form-group:hover label {
            color: #4CA3DD;
        }

        .rounded-xl[class*="shadow-lg"] {
            position: relative;
            overflow: hidden;
        }
        .rounded-xl[class*="shadow-lg"]::before {
            content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(76, 163, 221, 0.07), transparent);
            transition: left 0.7s ease; z-index: 0;
        }
        .rounded-xl[class*="shadow-lg"]:hover::before { left: 100%; }
        .rounded-xl[class*="shadow-lg"] > * { position: relative; z-index: 1; }


        .btn-loading { position: relative; color: transparent !important; }
        .btn-loading::after {
            content: ''; position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 20px; height: 20px; border: 2px solid #ffffff;
            border-radius: 50%; border-top-color: transparent;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin { to { transform: translate(-50%, -50%) rotate(360deg); } }

        /* Style pour les date inputs en mode sombre */
        .date-input-dark::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
    </style>
@endpush

@push('scripts')
    {{-- Les scripts sont identiques à ceux de la page de création --}}
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation progressive des sections principales
            const sections = document.querySelectorAll('.rounded-xl[class*="shadow-lg"]');
            sections.forEach((section, index) => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(25px)';
                section.style.transition = `all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) ${index * 0.1}s`;
                setTimeout(() => {
                    section.style.opacity = '1';
                    section.style.transform = 'translateY(0)';
                }, 50 + (index * 100));
            });

            const form = document.querySelector('form');
            if (form) {
                const inputs = form.querySelectorAll('input, textarea, select');

                // Validation en temps réel (simple feedback visuel)
                inputs.forEach(input => {
                    // Animation de soumission du formulaire
                    form.addEventListener('submit', function(e) {
                        const submitBtn = this.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.classList.add('btn-loading');
                            submitBtn.disabled = true;
                        }
                        // Pour éviter le message "beforeunload" lors d'une soumission normale
                        form.dataset.submitted = 'true';
                    });

                    // Amélioration UX pour les selects
                    const selects = form.querySelectorAll('select');
                    selects.forEach(select => {
                        function updateSelectStyle() {
                            if (select.value) {
                                select.style.fontWeight = '500';
                            } else {
                                select.style.fontWeight = 'normal';
                            }
                        }
                        select.addEventListener('change', updateSelectStyle);
                        updateSelectStyle(); // Initial call
                    });

                    // Confirmation avant de quitter la page avec des données non sauvegardées
                    let formChanged = false;
                    inputs.forEach(input => {
                        // Pour les champs pré-remplis, on stocke la valeur initiale
                        const initialValue = input.type === 'checkbox' ? input.checked : input.value;
                        input.addEventListener('input', () => {
                            const currentValue = input.type === 'checkbox' ? input.checked : input.value;
                            if (currentValue !== initialValue) {
                                formChanged = true;
                            }
                        });
                        input.addEventListener('change', () => { // Pour selects, date pickers, checkboxes
                            const currentValue = input.type === 'checkbox' ? input.checked : input.value;
                            if (currentValue !== initialValue) {
                                formChanged = true;
                            }
                        });
                    });

                    window.addEventListener('beforeunload', function(e) {
                        if (formChanged && !form.dataset.submitted) { // Check if form was not submitted
                            e.preventDefault();
                            e.returnValue = 'Vous avez des modifications non enregistrées. Êtes-vous sûr de vouloir quitter ?';
                        }
                    });
                });
            }
        });
    </script>
@endpush
