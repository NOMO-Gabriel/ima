@php
    $editMode = $editMode ?? false;
    $user = $teacherUser ?? null; // $teacherUser est l'objet User

    // Définir des booléens pour la lisibilité dans les classes
    $isMatriculeReadonly = $editMode && !empty($user->teacherProfile->matricule);
    $isCniReadonly = $editMode && !empty($user->teacherProfile->cni);
    $isBirthdateReadonly = $editMode && !empty($user->teacherProfile->birthdate);
    $isBirthplaceReadonly = $editMode && !empty($user->teacherProfile->birthplace);
    $isCenterReadonly = $editMode && !empty($user->teacherProfile->center_id);
@endphp

    <!-- Section Informations Personnelles -->
<div class="rounded-xl shadow-lg border transition-colors duration-300 form-section"
     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
    <div class="p-6 border-b transition-colors duration-300"
         :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
        <h2 class="text-xl font-semibold flex items-center"
            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
            <i class="fas fa-user-circle mr-3 text-[#4CA3DD]"></i>
            Informations Personnelles
        </h2>
        {{-- ... (description) ... --}}
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            <!-- Prénom -->
            <div class="form-group">
                <label for="first_name" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Prénom <span class="text-red-500">*</span></label>
                <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name ?? '') }}" required
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('first_name') border-red-500 @enderror"
                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode }"
                       placeholder="Entrez le prénom">
                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Nom -->
            <div class="form-group">
                <label for="last_name" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Nom de famille <span class="text-red-500">*</span></label>
                <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name ?? '') }}" required
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('last_name') border-red-500 @enderror"
                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode }"
                       placeholder="Entrez le nom de famille">
                @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Adresse E-mail <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('email') border-red-500 @enderror"
                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode }"
                       placeholder="exemple@domaine.com">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Téléphone -->
            <div class="form-group">
                <label for="phone_number" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Numéro de Téléphone</label>
                <input type="tel" name="phone_number" id="phone_number" value="{{ old('phone_number', $user->phone_number ?? '') }}"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('phone_number') border-red-500 @enderror"
                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode }"
                       placeholder="+XX XXX XXX XXX">
                @error('phone_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Genre -->
            <div class="form-group">
                <label for="gender" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Genre <span class="text-red-500">*</span></label>
                <select name="gender" id="gender" required
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('gender') border-red-500 @enderror"
                        :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                    <option value="">-- Sélectionner --</option>
                    @foreach($genders ?? [] as $value => $label)
                        <option value="{{ $value }}" {{ old('gender', $user->gender ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Adresse de résidence -->
            <div class="form-group md:col-span-2">
                <label for="address" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Adresse de résidence</label>
                <textarea name="address" id="address" rows="3"
                          class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('address') border-red-500 @enderror"
                          :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode }"
                          placeholder="Entrez l'adresse complète">{{ old('address', $user->address ?? '') }}</textarea>
                @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>

<!-- Section Informations Professionnelles -->
<div class="rounded-xl shadow-lg border transition-colors duration-300 form-section"
     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
    <div class="p-6 border-b transition-colors duration-300"
         :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
        <h2 class="text-xl font-semibold flex items-center"
            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
            <i class="fas fa-briefcase mr-3 text-[#4CA3DD]"></i>
            Profil Professionnel
        </h2>
        {{-- ... (description) ... --}}
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            <!-- Profession -->
            <div class="form-group">
                <label for="profession" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Profession / Titre</label>
                <input type="text" name="profession" id="profession" value="{{ old('profession', $user->teacherProfile->profession ?? '') }}"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('profession') border-red-500 @enderror"
                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode }"
                       placeholder="Ex: Professeur de Mathématiques">
                @error('profession') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Salaire -->
            <div class="form-group">
                <label for="salary" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Salaire (XAF)</label>
                <input type="number" step="any" name="salary" id="salary" value="{{ old('salary', $user->teacherProfile->salary ?? '') }}"
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('salary') border-red-500 @enderror"
                       :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode }"
                       placeholder="Ex: 350000">
                @error('salary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Matricule -->
            <div class="form-group">
                <label for="matricule" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Matricule</label>
                <input type="text" name="matricule" id="matricule" value="{{ old('matricule', $user->teacherProfile->matricule ?? '') }}"
                       @if($isMatriculeReadonly) readonly @endif
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('matricule') border-red-500 @enderror @if($isMatriculeReadonly) cursor-not-allowed @endif"
                       :class="{
                           'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode && !{{ $isMatriculeReadonly ? 'true' : 'false' }},
                           'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode && !{{ $isMatriculeReadonly ? 'true' : 'false' }},
                           'bg-gray-600 border-gray-500 text-gray-300 placeholder-gray-400': darkMode && {{ $isMatriculeReadonly ? 'true' : 'false' }},
                           'bg-gray-100 border-gray-300 text-gray-500 placeholder-gray-400': !darkMode && {{ $isMatriculeReadonly ? 'true' : 'false' }}
                       }"
                       placeholder="Ex: ENS-00123">
                @error('matricule') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- N° CNI -->
            <div class="form-group">
                <label for="cni" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">N° CNI</label>
                <input type="text" name="cni" id="cni" value="{{ old('cni', $user->teacherProfile->cni ?? '') }}"
                       @if($isCniReadonly) readonly @endif
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('cni') border-red-500 @enderror @if($isCniReadonly) cursor-not-allowed @endif"
                       :class="{
                           'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode && !{{ $isCniReadonly ? 'true' : 'false' }},
                           'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode && !{{ $isCniReadonly ? 'true' : 'false' }},
                           'bg-gray-600 border-gray-500 text-gray-300 placeholder-gray-400': darkMode && {{ $isCniReadonly ? 'true' : 'false' }},
                           'bg-gray-100 border-gray-300 text-gray-500 placeholder-gray-400': !darkMode && {{ $isCniReadonly ? 'true' : 'false' }}
                       }"
                       placeholder="Numéro de Carte Nationale d'Identité">
                @error('cni') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Date de naissance (Profil) -->
            <div class="form-group">
                <label for="birthdate" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Date de naissance (Profil)</label>
                <input type="date" name="birthdate" id="birthdate" value="{{ old('birthdate', $user->teacherProfile->birthdate ? ($user->teacherProfile->birthdate instanceof \Carbon\Carbon ? $user->teacherProfile->birthdate->format('Y-m-d') : $user->teacherProfile->birthdate) : '') }}"
                       @if($isBirthdateReadonly) readonly @endif
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('birthdate') border-red-500 @enderror @if($isBirthdateReadonly) cursor-not-allowed @endif"
                       :class="{
                           'bg-gray-700 border-gray-600 text-gray-200': darkMode && !{{ $isBirthdateReadonly ? 'true' : 'false' }},
                           'bg-gray-50 border-gray-300 text-gray-900': !darkMode && !{{ $isBirthdateReadonly ? 'true' : 'false' }},
                           'bg-gray-600 border-gray-500 text-gray-300': darkMode && {{ $isBirthdateReadonly ? 'true' : 'false' }},
                           'bg-gray-100 border-gray-300 text-gray-500': !darkMode && {{ $isBirthdateReadonly ? 'true' : 'false' }},
                           'date-input-dark': darkMode {{-- Pour le style du picker en mode sombre --}}
                       }">
                @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Lieu de naissance (Profil) -->
            <div class="form-group">
                <label for="birthplace" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Lieu de naissance (Profil)</label>
                <input type="text" name="birthplace" id="birthplace" value="{{ old('birthplace', $user->teacherProfile->birthplace ?? '') }}"
                       @if($isBirthplaceReadonly) readonly @endif
                       class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('birthplace') border-red-500 @enderror @if($isBirthplaceReadonly) cursor-not-allowed @endif"
                       :class="{
                           'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode && !{{ $isBirthplaceReadonly ? 'true' : 'false' }},
                           'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode && !{{ $isBirthplaceReadonly ? 'true' : 'false' }},
                           'bg-gray-600 border-gray-500 text-gray-300 placeholder-gray-400': darkMode && {{ $isBirthplaceReadonly ? 'true' : 'false' }},
                           'bg-gray-100 border-gray-300 text-gray-500 placeholder-gray-400': !darkMode && {{ $isBirthplaceReadonly ? 'true' : 'false' }}
                       }"
                       placeholder="Ville de naissance">
                @error('birthplace') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>
</div>

<!-- Section Affectation -->
<div class="rounded-xl shadow-lg border transition-colors duration-300 form-section"
     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
    <div class="p-6 border-b transition-colors duration-300"
         :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
        <h2 class="text-xl font-semibold flex items-center"
            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
            <i class="fas fa-school mr-3 text-[#4CA3DD]"></i>
            Affectation
        </h2>
        {{-- ... (description) ... --}}
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-6">
            <!-- Académie -->
            <div class="form-group">
                <label for="academy_id" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Académie d'affectation</label>
                <select name="academy_id" id="academy_id"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('academy_id') border-red-500 @enderror"
                        :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                    <option value="">-- Sélectionner une académie --</option>
                    @foreach ($academies ?? [] as $id => $name)
                        <option value="{{ $id }}" {{ old('academy_id', $user->teacherProfile->academy_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('academy_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Département -->
            <div class="form-group">
                <label for="department_id" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Département d'affectation</label>
                <select name="department_id" id="department_id"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('department_id') border-red-500 @enderror"
                        :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                    <option value="">-- Sélectionner un département --</option>
                    @foreach ($departments ?? [] as $id => $name)
                        <option value="{{ $id }}" {{ old('department_id', $user->teacherProfile->department_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('department_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Ville d'affectation (Profil) -->
            <div class="form-group">
                <label for="city_id" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Ville d'affectation (Profil)</label>
                <select name="city_id" id="city_id"
                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('city_id') border-red-500 @enderror"
                        :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                    <option value="">-- Sélectionner une ville --</option>
                    @foreach ($cities ?? [] as $id => $name)
                        <option value="{{ $id }}" {{ old('city_id', $user->teacherProfile->city_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('city_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Centre d'affectation principal -->
            <div class="form-group">
                <label for="center_id" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Centre d'affectation principal</label>
                @if($isCenterReadonly)
                    <input type="text" value="{{ $user->teacherProfile->center->name ?? 'N/A' }}" readonly
                           class="w-full px-4 py-3 border rounded-lg transition-all duration-300 cursor-not-allowed"
                           :class="{ 'bg-gray-600 border-gray-500 text-gray-300': darkMode, 'bg-gray-100 border-gray-300 text-gray-500': !darkMode }">
                    <input type="hidden" name="center_id" value="{{ $user->teacherProfile->center_id }}">
                    <p class="text-xs mt-1" :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">Le centre principal ne peut être modifié ici. Contactez un administrateur.</p>
                @else
                    <select name="center_id" id="center_id"
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('center_id') border-red-500 @enderror"
                            :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                        <option value="">-- Sélectionner un centre --</option>
                        @foreach ($centers ?? [] as $id => $name)
                            <option value="{{ $id }}" {{ old('center_id', $user->teacherProfile->center_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('center_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Section Compte Utilisateur -->
<div class="rounded-xl shadow-lg border transition-colors duration-300 form-section"
     :class="{ 'bg-gray-800 border-gray-700': darkMode, 'bg-white border-gray-200': !darkMode }">
    <div class="p-6 border-b transition-colors duration-300"
         :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
        <h2 class="text-xl font-semibold flex items-center"
            :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
            <i class="fas fa-user-cog mr-3 text-[#4CA3DD]"></i>
            Gestion du Compte
        </h2>
        {{-- ... (description) ... --}}
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-6">
            @if($editMode)
                <!-- Statut du compte (Édition seulement) -->
                <div class="form-group">
                    <label for="status" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Statut du compte <span class="text-red-500">*</span></label>
                    <select name="status" id="status" required
                            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('status') border-red-500 @enderror"
                            :class="{ 'bg-gray-700 border-gray-600 text-gray-200': darkMode, 'bg-gray-50 border-gray-300 text-gray-900': !darkMode }">
                        @foreach($statuses ?? [] as $value => $label)
                            <option value="{{ $value }}" {{ old('status', $user->status ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="form-group md:col-span-2">
                    <p class="text-sm p-3 rounded-md" :class="{ 'bg-blue-900/30 text-blue-300': darkMode, 'bg-blue-50 text-blue-700': !darkMode }">
                        <i class="fas fa-info-circle mr-2"></i>
                        La modification du mot de passe n'est pas gérée depuis ce formulaire.
                    </p>
                </div>
            @else
                <!-- Mot de passe (Création seulement) -->
                <div class="form-group">
                    <label for="password" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Mot de passe <span class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300 @error('password') border-red-500 @enderror"
                           :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode }"
                           placeholder="••••••••">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Confirmation du mot de passe (Création seulement) -->
                <div class="form-group">
                    <label for="password_confirmation" class="block text-sm font-medium mb-2" :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">Confirmer le mot de passe <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-[#4CA3DD] focus:border-[#4CA3DD] transition-all duration-300"
                           :class="{ 'bg-gray-700 border-gray-600 text-gray-200 placeholder-gray-400': darkMode, 'bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-500': !darkMode }"
                           placeholder="••••••••">
                </div>
            @endif
        </div>
    </div>
</div>
