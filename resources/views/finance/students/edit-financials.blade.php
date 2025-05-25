@extends('layouts.app')

@section('title', 'Modifier Infos Financières - ' . $student->full_name)
@section('page_title', 'Modifier ' . $student->full_name)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">Tableau de Bord</a></li>
    <li class="breadcrumb-item"><a href="{{ route('finance.students.index', ['locale' => app()->getLocale()]) }}">Élèves (Finances)</a></li>
    <li class="breadcrumb-item active" aria-current="page">Modifier {{ $student->first_name }}</li>
@endsection

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('finance.students.updateFinancials', ['locale' => app()->getLocale(), 'student' => $student->id]) }}" id="editStudentFinancialsForm">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-7 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-edit me-2"></i>Informations Personnelles de l'Élève</h3>
                    </div>
                    <div class="card-body">
                        {{-- Les champs ici sont conditionnés par $canEditDetails (qui est true pour PCA) --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">Prénom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $student->first_name) }}" required {{ $canEditDetails ? '' : 'readonly' }}>
                                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $student->last_name) }}" required {{ $canEditDetails ? '' : 'readonly' }}>
                                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Genre <span class="text-danger">*</span></label>
                            <select id="gender" name="gender" class="form-select @error('gender') is-invalid @enderror" required {{ $canEditDetails ? '' : 'disabled' }}>
                                <option value="">Sélectionnez le genre</option>
                                <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Masculin</option>
                                <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Féminin</option>
                            </select>
                            @if(!$canEditDetails && $student->gender) <input type="hidden" name="gender" value="{{ $student->gender }}"> @endif
                            @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $student->email) }}" required {{ $canEditDetails ? '' : 'readonly' }}>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label">Téléphone Élève <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $student->phone_number) }}" required {{ $canEditDetails ? '' : 'readonly' }}>
                                @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="parent_phone_number" class="form-label">Téléphone Parent</label>
                                <input type="tel" class="form-control @error('parent_phone_number') is-invalid @enderror" id="parent_phone_number" name="parent_phone_number" value="{{ old('parent_phone_number', $student->parent_phone_number) }}" {{ $canEditDetails ? '' : 'readonly' }}>
                                @error('parent_phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                         <div class="mb-3">
                            <label for="address" class="form-label">Adresse <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $student->address) }}" required {{ $canEditDetails ? '' : 'readonly' }}>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="establishment" class="form-label">Établissement d'origine <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('establishment') is-invalid @enderror" id="establishment" name="establishment" value="{{ old('establishment', $student->establishment) }}" required {{ $canEditDetails ? '' : 'readonly' }}>
                            @error('establishment') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city_id_form" class="form-label">Ville <span class="text-danger">*</span></label>
                                <select id="city_id_form" name="city_id" class="form-select @error('city_id') is-invalid @enderror" required {{ $canEditDetails ? '' : 'disabled' }}>
                                    <option value="">Sélectionnez une ville</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $student->city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if(!$canEditDetails && $student->city_id) <input type="hidden" name="city_id" value="{{ $student->city_id }}"> @endif
                                @error('city_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="center_id_form" class="form-label">Centre</label>
                                <select id="center_id_form" name="center_id" class="form-select @error('center_id') is-invalid @enderror" {{ $canEditDetails ? '' : 'disabled' }}>
                                    <option value="">Sélectionnez un centre</option>
                                     @foreach($allCenters as $center)
                                        <option value="{{ $center->id }}" data-city="{{ $center->city_id }}" {{ old('center_id', $student->center_id) == $center->id ? 'selected' : '' }}>
                                            {{ $center->name }} ({{ $center->city->name ?? 'Ville N/A'}})
                                        </option>
                                    @endforeach
                                </select>
                                @if(!$canEditDetails && $student->center_id) <input type="hidden" name="center_id" value="{{ $student->center_id }}"> @endif
                                @error('center_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-invoice-dollar me-2"></i>Contrat & Concours</h3>
                    </div>
                    <div class="card-body">
                        @if(!$canEditContract && $student->status === \App\Models\User::STATUS_PENDING_VALIDATION && !Auth::user()->hasRole('pca'))
                             <div class="alert alert-info small">
                                Les informations de contrat et concours ne sont pas modifiables par vous à ce stade ou pour cet élève.
                            </div>
                        @endif
                        {{-- Les champs ici sont conditionnés par $canEditContract (qui est true pour PCA) --}}
                        <div class="mb-3">
                            <label class="form-label">Concours Préparés <span class="text-danger">*</span></label>
                            @foreach($entranceExams as $exam)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="entrance_exams[]" value="{{ $exam->id }}" id="exam_{{ $exam->id }}"
                                    {{ in_array($exam->id, old('entrance_exams', $studentExamsIds)) ? 'checked' : '' }} {{ $canEditContract ? '' : 'disabled' }}>
                                <label class="form-check-label" for="exam_{{ $exam->id }}">{{ $exam->name }}</label>
                            </div>
                            @endforeach
                            @error('entrance_exams') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            @error('entrance_exams.*') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="formation_id" class="form-label">Formation Principale (Contrat) <span class="text-danger">*</span></label>
                            <select id="formation_id" name="formation_id" class="form-select @error('formation_id') is-invalid @enderror" {{ $canEditContract ? '' : 'disabled' }}>
                                <option value="">Sélectionnez la formation</option>
                                @foreach($formations as $formation)
                                <option value="{{ $formation->id }}" {{ old('formation_id', $studentFormationId) == $formation->id ? 'selected' : '' }}>
                                    {{ $formation->name }}
                                </option>
                                @endforeach
                            </select>
                            @if(!$canEditContract && $studentFormationId) <input type="hidden" name="formation_id" value="{{ $studentFormationId }}"> @endif
                            @error('formation_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contract_amount" class="form-label">Montant Total Contrat (FCFA) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('contract_amount') is-invalid @enderror" id="contract_amount" name="contract_amount" value="{{ old('contract_amount', $contractAmount) }}" min="0" {{ $canEditContract ? '' : 'readonly' }}>
                            @error('contract_amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="payment_schedule" class="form-label">Modalité de Paiement</label>
                            <select id="payment_schedule" name="payment_schedule" class="form-select @error('payment_schedule') is-invalid @enderror" {{ $canEditContract ? '' : 'disabled' }}>
                                <option value="">Sélectionner...</option>
                                <option value="monthly" {{ old('payment_schedule', $paymentSchedule) == 'monthly' ? 'selected' : '' }}>Mensuel</option>
                                <option value="quarterly" {{ old('payment_schedule', $paymentSchedule) == 'quarterly' ? 'selected' : '' }}>Trimestriel</option>
                                <option value="semester" {{ old('payment_schedule', $paymentSchedule) == 'semester' ? 'selected' : '' }}>Semestriel</option>
                                <option value="annual" {{ old('payment_schedule', $paymentSchedule) == 'annual' ? 'selected' : '' }}>Annuel</option>
                            </select>
                             @if(!$canEditContract && $paymentSchedule) <input type="hidden" name="payment_schedule" value="{{ $paymentSchedule }}"> @endif
                            @error('payment_schedule') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Date Début Contrat</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $contractStartDate ? \Carbon\Carbon::parse($contractStartDate)->format('Y-m-d') : '') }}" {{ $canEditContract ? '' : 'readonly' }}>
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Date Fin Contrat</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $contractEndDate ? \Carbon\Carbon::parse($contractEndDate)->format('Y-m-d') : '') }}" {{ $canEditContract ? '' : 'readonly' }}>
                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="special_conditions" class="form-label">Conditions Spéciales</label>
                            <textarea class="form-control @error('special_conditions') is-invalid @enderror" id="special_conditions" name="special_conditions" rows="3" {{ $canEditContract ? '' : 'readonly' }}>{{ old('special_conditions', $specialConditions) }}</textarea>
                            @error('special_conditions') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-user-cog me-2"></i>Statut & Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="status" class="form-label">Statut du compte <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required {{ $canEditDetails ? '' : 'disabled' }}>
                                @foreach($statuses as $key => $value)
                                <option value="{{ $key }}" {{ old('status', $student->status) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                            @if(!$canEditDetails && $student->status) <input type="hidden" name="status" value="{{ $student->status }}"> @endif
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        @if($student->status === \App\Models\User::STATUS_REJECTED && ($canEditDetails || Auth::user()->hasRole('pca')) && Auth::user()->can('finance.student.reject'))
                            <div class="mb-3">
                                <label for="rejection_reason" class="form-label">Raison du Rejet (si applicable)</label>
                                <textarea class="form-control @error('rejection_reason') is-invalid @enderror" id="rejection_reason" name="rejection_reason" rows="2">{{ old('rejection_reason', $student->rejection_reason) }}</textarea>
                                @error('rejection_reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        @elseif($student->rejection_reason)
                             <p class="text-muted small">Raison du rejet: {{ $student->rejection_reason }}</p>
                        @endif
                        <hr>
                        <p class="text-muted small">
                            Matricule: {{ $student->student_data['matricule'] ?? 'Non assigné' }}<br>
                            Inscrit le: {{ $student->created_at->isoFormat('D MMMM YYYY [à] HH:mm') }}<br>
                            @if($student->financialValidator) Validé par: {{ $student->financialValidator->full_name }} ({{ $student->financial_validation_date?->isoFormat('D MMM YYYY') }})<br>@endif
                            @if($student->finalizedBy) Finalisé par: {{ $student->finalizedBy->full_name }} ({{ $student->finalized_at?->isoFormat('D MMM YYYY') }}) @endif
                        </p>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('finance.students.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary me-2">Annuler</a>
                        @if($canEditDetails || $canEditContract)
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i> Enregistrer les modifications</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    select:disabled, input[readonly], textarea[readonly] {
        background-color: #e9ecef;
        opacity: 1;
        cursor: not-allowed;
    }
    .form-check-input:disabled + .form-check-label {
        color: #6c757d;
        cursor: not-allowed;
    }
    .form-check-input:disabled {
        cursor: not-allowed;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const citySelectForm = document.getElementById('city_id_form');
    const centerSelectForm = document.getElementById('center_id_form');
    
    if (citySelectForm && centerSelectForm) {
        // Conserver une copie des options originales du select de centre
        const allCenterOptionsOriginalForm = Array.from(centerSelectForm.options).filter(opt => opt.value !== "");

        function updateCenterOptionsForm() {
            // Ne rien faire si le select de ville est désactivé (car l'utilisateur ne peut pas le changer)
            if (citySelectForm.disabled) return;

            const selectedCityId = citySelectForm.value;
            const currentCenterValue = centerSelectForm.value;

            while (centerSelectForm.options.length > 1) {
                centerSelectForm.remove(1);
            }
            centerSelectForm.value = "";

            if (selectedCityId) {
                allCenterOptionsOriginalForm.forEach(optionNode => {
                    if (optionNode.dataset.city === selectedCityId) {
                        centerSelectForm.appendChild(optionNode.cloneNode(true));
                    }
                });
            } else {
                allCenterOptionsOriginalForm.forEach(optionNode => {
                    centerSelectForm.appendChild(optionNode.cloneNode(true));
                });
            }
            // Restaurer la sélection si possible et valide
            if (centerSelectForm.querySelector(`option[value="${currentCenterValue}"]`)) {
                centerSelectForm.value = currentCenterValue;
            }
        }

        citySelectForm.addEventListener('change', updateCenterOptionsForm);
        updateCenterOptionsForm(); // Appel initial pour configurer correctement
        
        // Gérer la valeur old() pour le centre
        const oldCenterId = "{{ old('center_id', $student->center_id) }}";
        if(oldCenterId && centerSelectForm.querySelector(`option[value="${oldCenterId}"]`)) {
            centerSelectForm.value = oldCenterId;
        }
    }
});
</script>
@endpush