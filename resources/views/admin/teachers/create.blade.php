@extends('layouts.app')

@section('title', 'Ajouter un Enseignant')

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
        <span :class="darkMode ? 'text-gray-300' : 'text-gray-800'">Ajouter un enseignant</span>
    </div>
@endsection

@section('page_header')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    <i class="fas fa-user-plus mr-2 text-[#4CA3DD]"></i>
                    Ajouter un Nouvel Enseignant
                </h1>
                <p class="mt-1 text-sm"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                    Remplissez les informations ci-dessous pour créer un nouveau profil enseignant.
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}"
                   class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2"
                   :class="darkMode ? 'bg-gray-700 hover:bg-gray-600 text-gray-200 border border-gray-600' : 'bg-white hover:bg-gray-50 text-gray-700 border border-gray-300'">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Annuler et Retour
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
         x-init="$watch('darkMode', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">

        @can('admin.teacher.create')
            <!-- Messages Flash -->
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

            <form action="{{ route('admin.teachers.store', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-8">
                @csrf

                <!-- Section Informations Personnelles -->
                <div class="rounded-xl shadow-lg border transition-colors duration-300"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 border-b transition-colors duration-300"
                         :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                        <h2 class="text-xl font-semibold flex items-center"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <i class="fas fa-user-circle mr-3 text-[#4CA3DD]"></i>
                            Informations Personnelles
                        </h2>
                        <p class="text-sm mt-1"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                            Détails de base de l'enseignant.
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                            <!-- Prénom -->
                            <div class="form-group">
                                <label for="first_name" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Prénom <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('first_name') border-red-500 @enderror"
                                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }"
                                       placeholder="Entrez le prénom">
                                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Nom -->
                            <div class="form-group">
                                <label for="last_name" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Nom de famille <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('last_name') border-red-500 @enderror"
                                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }"
                                       placeholder="Entrez le nom de famille">
                                @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Adresse E-mail <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('email') border-red-500 @enderror"
                                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }"
                                       placeholder="exemple@domaine.com">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Téléphone -->
                            <div class="form-group">
                                <label for="phone_number" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Numéro de Téléphone
                                </label>
                                <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number') }}"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('phone_number') border-red-500 @enderror"
                                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }"
                                       placeholder="+237 6XX XXX XXX">
                                @error('phone_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Genre -->
                            <div class="form-group">
                                <label for="gender" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Genre
                                </label>
                                <select name="gender" id="gender"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('gender') border-red-500 @enderror"
                                        :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Homme</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Femme</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Autre</option>
                                </select>
                                @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Date de Naissance -->
                            <div class="form-group">
                                <label for="date_of_birth" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Date de Naissance
                                </label>
                                <input type="date" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('date_of_birth') border-red-500 @enderror"
                                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 date-input-dark': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                                @error('date_of_birth') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Informations Professionnelles -->
                <div class="rounded-xl shadow-lg border transition-colors duration-300"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 border-b transition-colors duration-300"
                         :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                        <h2 class="text-xl font-semibold flex items-center"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <i class="fas fa-briefcase mr-3 text-[#4CA3DD]"></i>
                            Informations Professionnelles
                        </h2>
                        <p class="text-sm mt-1"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                            Détails relatifs à la carrière de l'enseignant.
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                            <!-- Matricule -->
                            <div class="form-group">
                                <label for="matricule" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Matricule
                                </label>
                                <input type="text" name="matricule" id="matricule" value="{{ old('matricule') }}"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('matricule') border-red-500 @enderror"
                                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }"
                                       placeholder="Ex: ENS-00123">
                                @error('matricule') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Profession/Titre -->
                            <div class="form-group">
                                <label for="profession" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Profession / Titre
                                </label>
                                <input type="text" name="profession" id="profession" value="{{ old('profession') }}"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('profession') border-red-500 @enderror"
                                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }"
                                       placeholder="Ex: Professeur de Mathématiques">
                                @error('profession') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Date d'embauche -->
                            <div class="form-group">
                                <label for="hire_date" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Date d'embauche
                                </label>
                                <input type="date" name="hire_date" id="hire_date" value="{{ old('hire_date') }}"
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('hire_date') border-red-500 @enderror"
                                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 date-input-dark': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                                @error('hire_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Statut de l'enseignant -->
                            <div class="form-group">
                                <label for="status" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Statut <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" required
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('status') border-red-500 @enderror"
                                        :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Actif</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                                    <option value="pending_validation" {{ old('status') == 'pending_validation' ? 'selected' : '' }}>En attente de validation</option>
                                    <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspendu</option>
                                </select>
                                @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Affectation (Optionnel, si vous avez ces données) -->
                @if(isset($departments) || isset($centers))
                    <div class="rounded-xl shadow-lg border transition-colors duration-300"
                         :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                        <div class="p-6 border-b transition-colors duration-300"
                             :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                            <h2 class="text-xl font-semibold flex items-center"
                                :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                                <i class="fas fa-school mr-3 text-[#4CA3DD]"></i>
                                Affectation
                            </h2>
                            <p class="text-sm mt-1"
                               :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                                Lieu d'affectation principal de l'enseignant.
                            </p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-6">
                                @if(isset($academies))
                                    <div class="form-group">
                                        <label for="academy_id" class="block text-sm font-medium mb-2"
                                               :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                            Académie
                                        </label>
                                        <select name="academy_id" id="academy_id"
                                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('academy_id') border-red-500 @enderror"
                                                :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                                            <option value="">-- Sélectionner une académie --</option>
                                            @foreach ($academies as $id => $name)
                                                <option value="{{ $id }}" {{ old('academy_id') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('academy_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                @endif

                                @if(isset($departments))
                                    <div class="form-group">
                                        <label for="department_id" class="block text-sm font-medium mb-2"
                                               :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                            Département
                                        </label>
                                        <select name="department_id" id="department_id"
                                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('department_id') border-red-500 @enderror"
                                                :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                                            <option value="">-- Sélectionner un département --</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $id }}" {{ old('department_id') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('department_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                @endif

                                @if(isset($centers))
                                    <div class="form-group">
                                        <label for="center_id" class="block text-sm font-medium mb-2"
                                               :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                            Centre
                                        </label>
                                        <select name="center_id" id="center_id"
                                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('center_id') border-red-500 @enderror"
                                                :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                                            <option value="">-- Sélectionner un centre --</option>
                                            @foreach ($centers as $center)
                                                <option value="{{ $id }}" {{ old('center_id') == $id ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('center_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Section Compte Utilisateur -->
                <div class="rounded-xl shadow-lg border transition-colors duration-300"
                     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
                    <div class="p-6 border-b transition-colors duration-300"
                         :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                        <h2 class="text-xl font-semibold flex items-center"
                            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <i class="fas fa-key mr-3 text-[#4CA3DD]"></i>
                            Compte Utilisateur
                        </h2>
                        <p class="text-sm mt-1"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-600': !darkMode }">
                            Identifiants de connexion pour l'enseignant.
                        </p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
                            <!-- Mot de passe -->
                            <div class="form-group">
                                <label for="password" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Mot de passe <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password" id="password" required
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('password') border-red-500 @enderror"
                                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }"
                                       placeholder="••••••••">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Confirmation du mot de passe -->
                            <div class="form-group">
                                <label for="password_confirmation" class="block text-sm font-medium mb-2"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">
                                    Confirmer le mot de passe <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300"
                                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }"
                                       placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>

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
                        Enregistrer l'Enseignant
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
                    Vous n'avez pas les permissions nécessaires pour ajouter un enseignant.
                </p>
            </div>
        @endcan
    </div>
@endsection

@push('styles')
    <style>
        .form-group {
            opacity: 0;
            animation: fadeInUp 0.5s ease forwards;
        }
        /* Décalage pour l'animation des champs */
        @for ($i = 1; $i <= 20; $i++)
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

        .date-input-dark::-webkit-calendar-picker-indicator {
            filter: invert(1);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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

                inputs.forEach(input => {
                    form.addEventListener('submit', function(e) {
                        const submitBtn = this.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            submitBtn.classList.add('btn-loading');
                            submitBtn.disabled = true;
                        }
                        // Pour éviter le message "beforeunload" lors d'une soumission normale
                        form.dataset.submitted = 'true';
                    });

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
                        updateSelectStyle();
                    });

                    let formChanged = false;
                    inputs.forEach(input => {
                        input.addEventListener('input', () => { formChanged = true; });
                        input.addEventListener('change', () => { formChanged = true; });
                    });

                    window.addEventListener('beforeunload', function(e) {
                        if (formChanged && !form.dataset.submitted) {
                            e.preventDefault();
                            e.returnValue = 'Vous avez des modifications non enregistrées. Êtes-vous sûr de vouloir quitter ?';
                        }
                    });
                });

            }
        })
    </script>
@endpush
