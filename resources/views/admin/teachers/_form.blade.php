@csrf
<div class="row">
    {{-- Informations Utilisateur --}}
    <div class="col-md-6">
        <fieldset class="mb-3">
            <legend class="fs-6 fw-bold border-bottom pb-2 mb-3">Informations Personnelles (Utilisateur)</legend>
            <div class="mb-3">
                <label for="first_name" class="form-label">Prénom <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $teacherUser->first_name ?? '') }}" required>
                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="last_name" class="form-label">Nom</label>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $teacherUser->last_name ?? '') }}">
                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $teacherUser->email ?? '') }}" required>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="phone_number" class="form-label">Téléphone</label>
                <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $teacherUser->phone_number ?? '') }}">
                @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Genre <span class="text-danger">*</span></label>
                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                    <option value="">Sélectionner...</option>
                    @foreach($genders as $value => $label)
                        <option value="{{ $value }}" {{ old('gender', $teacherUser->gender ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Adresse de résidence</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="2">{{ old('address', $teacherUser->address ?? '') }}</textarea>
                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            @if(!isset($teacherUser)) {{-- Uniquement pour la création --}}
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            @else {{-- Pour l'édition --}}
            <div class="mb-3">
                <label for="status" class="form-label">Statut du compte <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    @foreach($statuses as $value => $label)
                        <option value="{{ $value }}" {{ old('status', $teacherUser->status ?? '') == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <hr>
            <p class="text-muted small">Laissez les champs de mot de passe vides si vous ne souhaitez pas le modifier.</p>
            <div class="mb-3">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            @endif
        </fieldset>
    </div>

    {{-- Informations Profil Enseignant --}}
    <div class="col-md-6">
        <fieldset class="mb-3">
            <legend class="fs-6 fw-bold border-bottom pb-2 mb-3">Profil Professionnel Enseignant</legend>

            <div class="mb-3">
                <label for="profession" class="form-label">Profession</label>
                <input type="text" class="form-control @error('profession') is-invalid @enderror" id="profession" name="profession" value="{{ old('profession', $teacherUser->teacherProfile->profession ?? '') }}">
                @error('profession') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="salary" class="form-label">Salaire (XAF)</label>
                <input type="number" step="any" class="form-control @error('salary') is-invalid @enderror" id="salary" name="salary" value="{{ old('salary', $teacherUser->teacherProfile->salary ?? '') }}">
                @error('salary') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="academy_id" class="form-label">Académie d'affectation</label>
                <select class="form-select @error('academy_id') is-invalid @enderror" id="academy_id" name="academy_id">
                    <option value="">Sélectionner...</option>
                    @foreach($academies as $id => $name)
                        <option value="{{ $id }}" {{ old('academy_id', $teacherUser->teacherProfile->academy_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('academy_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="department_id" class="form-label">Département d'affectation</label>
                <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                    <option value="">Sélectionner...</option>
                    @foreach($departments as $id => $name)
                        <option value="{{ $id }}" {{ old('department_id', $teacherUser->teacherProfile->department_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('department_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            <div class="mb-3">
                <label for="city_id" class="form-label">Ville d'affectation (Profil)</label>
                <select class="form-select @error('city_id') is-invalid @enderror" id="city_id" name="city_id">
                    <option value="">Sélectionner une ville...</option>
                    @foreach($cities as $id => $name)
                        <option value="{{ $id }}" {{ old('city_id', $teacherUser->teacherProfile->city_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
                @error('city_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            
            @if(!isset($teacherUser)) {{-- Uniquement pour la création --}}
                <div class="mb-3">
                    <label for="matricule" class="form-label">Matricule</label>
                    <input type="text" class="form-control @error('matricule') is-invalid @enderror" id="matricule" name="matricule" value="{{ old('matricule') }}">
                    @error('matricule') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="cni" class="form-label">N° CNI</label>
                    <input type="text" class="form-control @error('cni') is-invalid @enderror" id="cni" name="cni" value="{{ old('cni') }}">
                    @error('cni') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="birthdate" class="form-label">Date de naissance</label>
                    <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate') }}">
                    @error('birthdate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label for="birthplace" class="form-label">Lieu de naissance</label>
                    <input type="text" class="form-control @error('birthplace') is-invalid @enderror" id="birthplace" name="birthplace" value="{{ old('birthplace') }}">
                    @error('birthplace') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                 <div class="mb-3">
                    <label for="center_id" class="form-label">Centre d'affectation principal</label>
                    <select class="form-select @error('center_id') is-invalid @enderror" id="center_id" name="center_id">
                        <option value="">Sélectionner un centre...</option>
                        @foreach($centers as $id => $name)
                            <option value="{{ $id }}" {{ old('center_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('center_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            @else
                {{-- Champs non modifiables du profil affichés en readonly --}}
                @if($teacherUser->teacherProfile->matricule)
                <div class="mb-3">
                    <label class="form-label">Matricule</label>
                    <input type="text" class="form-control" value="{{ $teacherUser->teacherProfile->matricule }}" readonly>
                </div>
                @endif
                 @if($teacherUser->teacherProfile->cni)
                <div class="mb-3">
                    <label class="form-label">N° CNI</label>
                    <input type="text" class="form-control" value="{{ $teacherUser->teacherProfile->cni }}" readonly>
                </div>
                @endif
                @if($teacherUser->teacherProfile->birthdate)
                <div class="mb-3">
                    <label class="form-label">Date de naissance</label>
                    <input type="text" class="form-control" value="{{ $teacherUser->teacherProfile->birthdate->format('d/m/Y') }}" readonly>
                </div>
                @endif
                @if($teacherUser->teacherProfile->birthplace)
                <div class="mb-3">
                    <label class="form-label">Lieu de naissance</label>
                    <input type="text" class="form-control" value="{{ $teacherUser->teacherProfile->birthplace }}" readonly>
                </div>
                @endif
                 @if($teacherUser->teacherProfile->center)
                <div class="mb-3">
                    <label class="form-label">Centre d'affectation principal</label>
                    <input type="text" class="form-control" value="{{ $teacherUser->teacherProfile->center->name ?? 'N/A' }}" readonly>
                </div>
                @endif
            @endif
        </fieldset>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-primary">
        <i class="fas fa-save me-1"></i>
        {{ isset($teacherUser) ? 'Mettre à jour l\'enseignant' : 'Enregistrer l\'enseignant' }}
    </button>
    <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary">
        <i class="fas fa-times me-1"></i>
        Annuler
    </a>
</div>