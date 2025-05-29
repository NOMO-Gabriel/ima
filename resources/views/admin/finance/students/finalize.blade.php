@extends('layouts.app')

@section('title', 'Finaliser l\'inscription - ' . $student->full_name)

@section('content')
<div class="finalize-registration-container">
    <!-- En-tête -->
    <div class="page-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}">
                    Inscriptions en attente
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Finaliser l'inscription</span>
            </div>
            <h1 class="page-title">
                <i class="fas fa-user-graduate"></i>
                Finaliser l'inscription de {{ $student->full_name }}
            </h1>
            <p class="page-description">
                Complétez les informations d'inscription et finalisez le processus de validation.
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i>Retour à la liste
            </a>
        </div>
    </div>

    <!-- Informations de l'élève -->
    <div class="student-summary-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-user"></i>Informations de l'élève
            </h2>
            <div class="student-status">
                <span class="status-badge warning">
                    <i class="fas fa-hourglass-half"></i>En attente de validation
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="student-overview">
                <div class="student-photo">
                    <img src="{{ $student->profile_photo_url }}" alt="{{ $student->full_name }}" class="avatar-large">
                </div>
                <div class="student-details">
                    <h3 class="student-name">{{ $student->full_name }}</h3>
                    <div class="student-info-grid">
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $student->email }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-phone-alt"></i>
                            <span>{{ $student->phone_number ?? 'Non renseigné' }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-school"></i>
                            <span>{{ $student->student->establishment ?? 'Non renseigné' }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $student->city ?? 'Non renseigné' }}</span>
                        </div>
                        @if($student->student->parent_phone_number)
                            <div class="info-item">
                                <i class="fas fa-user-friends"></i>
                                <span>Parent: {{ $student->student->parent_phone_number }}</span>
                            </div>
                        @endif
                        <div class="info-item">
                            <i class="far fa-calendar-alt"></i>
                            <span>Inscrit le {{ $student->created_at->format('d/m/Y à H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de finalisation -->
    <form method="POST" action="{{ route('admin.finance.students.process', ['locale' => app()->getLocale(), 'student' => $student]) }}" 
          id="finalizationForm" class="finalization-form">
        @csrf

        <!-- Sélection des formations -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-graduation-cap"></i>Formations choisies
                </h2>
                <div class="card-subtitle">
                    Sélectionnez une ou plusieurs formations pour cet élève
                </div>
            </div>
            <div class="card-body">
                <div class="formations-grid">
                    @foreach($formations as $formation)
                        <div class="formation-card">
                            <label class="formation-label">
                                <input type="checkbox" name="formations[]" value="{{ $formation->id }}" 
                                       class="formation-checkbox" 
                                       {{ in_array($formation->id, old('formations', [])) ? 'checked' : '' }}>
                                <div class="formation-content">
                                    <div class="formation-header">
                                        <h4 class="formation-name">{{ $formation->name }}</h4>
                                        @if($formation->price)
                                            <div class="formation-price">
                                                {{ number_format($formation->price, 0, ',', ' ') }} FCFA
                                            </div>
                                        @endif
                                    </div>
                                    @if($formation->description)
                                        <p class="formation-description">{{ $formation->description }}</p>
                                    @endif
                                    <div class="formation-meta">
                                        @if($formation->hours)
                                            <span class="meta-item">
                                                <i class="fas fa-clock"></i>{{ $formation->hours }}h
                                            </span>
                                        @endif
                                        @if($formation->phase)
                                            <span class="meta-item">
                                                <i class="fas fa-calendar-check"></i>{{ $formation->phase->description }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="formation-checkmark">
                                    <i class="fas fa-check"></i>
                                </div>
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('formations')
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

                <!-- Informations personnelles -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-user-edit"></i>Modifier les informations personnelles
                </h2>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="first_name" class="form-label required"><i class="fas fa-user"></i>Prénom</label>
                        <input type="text" name="first_name" id="first_name" class="form-control"
                            value="{{ old('first_name', $student->first_name) }}" required>
                        @error('first_name') <div class="error-message">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name" class="form-label required"><i class="fas fa-user"></i>Nom</label>
                        <input type="text" name="last_name" id="last_name" class="form-control"
                            value="{{ old('last_name', $student->last_name) }}" required>
                        @error('last_name') <div class="error-message">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label required"><i class="fas fa-envelope"></i>Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ old('email', $student->email) }}" required>
                        @error('email') <div class="error-message">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="form-label required"><i class="fas fa-phone-alt"></i>Téléphone</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control"
                            value="{{ old('phone_number', $student->phone_number) }}" required>
                        @error('phone_number') <div class="error-message">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="parent_phone_number" class="form-label"><i class="fas fa-user-friends"></i>Téléphone du parent (facultatif)</label>
                        <input type="text" name="parent_phone_number" id="parent_phone_number" class="form-control"
                            value="{{ old('parent_phone_number', $student->student->parent_phone_number ?? '') }}">
                        @error('parent_phone_number') <div class="error-message">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group full-width">
                        <label for="establishment" class="form-label required"><i class="fas fa-school"></i>Établissement</label>
                        <input type="text" name="establishment" id="establishment" class="form-control"
                            value="{{ old('establishment', $student->student->establishment ?? '') }}" required>
                        @error('establishment') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>


        <!-- Centre et informations d'inscription -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-building"></i>Centre et informations d'inscription
                </h2>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <!-- Centre d'affectation -->
                    <div class="form-group">
                        <label for="center_id" class="form-label required">
                            <i class="fas fa-building"></i>Centre d'affectation
                        </label>
                        <div class="select-wrapper">
                            <select id="center_id" name="center_id" class="form-control" required>
                                <option value="">Sélectionnez un centre</option>
                                @foreach($centers as $center)
                                    <option value="{{ $center->id }}" 
                                            {{ old('center_id') == $center->id ? 'selected' : '' }}>
                                        {{ $center->name }}
                                        @if($center->location) - {{ $center->location }} @endif
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        @error('center_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Période de formation -->
                    <div class="form-group">
                        <label for="start_date" class="form-label required">
                            <i class="fas fa-calendar-plus"></i>Date de début
                        </label>
                        <input type="date" id="start_date" name="start_date" class="form-control" 
                               value="{{ old('start_date') }}" min="{{ date('Y-m-d') }}" required>
                        @error('start_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end_date" class="form-label required">
                            <i class="fas fa-calendar-minus"></i>Date de fin
                        </label>
                        <input type="date" id="end_date" name="end_date" class="form-control" 
                               value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations financières -->
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-credit-card"></i>Informations financières
                </h2>
                <div class="card-subtitle">
                    Détails du paiement et du contrat
                </div>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <!-- Méthode de paiement -->
                    <div class="form-group">
                        <label for="payment_method_id" class="form-label required">
                            <i class="fas fa-wallet"></i>Méthode de paiement
                        </label>
                        <div class="select-wrapper">
                            <select id="payment_method_id" name="payment_method_id" class="form-control" required>
                                <option value="">Sélectionnez une méthode</option>
                                @foreach($paymentMethods as $method)
                                    <option value="{{ $method->id }}" 
                                            {{ old('payment_method_id') == $method->id ? 'selected' : '' }}>
                                        {{ $method->name }} ({{ $method->label }})
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        @error('payment_method_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Numéro de reçu -->
                    <div class="form-group">
                        <label for="receipt_number" class="form-label required">
                            <i class="fas fa-receipt"></i>Numéro de reçu
                        </label>
                        <input type="text" id="receipt_number" name="receipt_number" class="form-control" 
                               value="{{ old('receipt_number') }}" placeholder="Ex: REC-2025-001" required>
                        @error('receipt_number')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Montant du contrat -->
                    <div class="form-group">
                        <label for="contract_amount" class="form-label required">
                            <i class="fas fa-file-contract"></i>Montant du contrat (FCFA)
                        </label>
                        <input type="number" id="contract_amount" name="contract_amount" class="form-control" 
                               value="{{ old('contract_amount') }}" min="0" step="1000" required>
                        @error('contract_amount')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Montant reçu -->
                    <div class="form-group">
                        <label for="amount_received" class="form-label required">
                            <i class="fas fa-money-bill-wave"></i>Montant reçu (FCFA)
                        </label>
                        <input type="number" id="amount_received" name="amount_received" class="form-control" 
                               value="{{ old('amount_received') }}" min="0" step="1000" required>
                        @error('amount_received')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Planning de paiement -->
                    <div class="form-group">
                        <label for="payment_schedule" class="form-label required">
                            <i class="fas fa-calendar-alt"></i>Planning de paiement
                        </label>
                        <div class="select-wrapper">
                            <select id="payment_schedule" name="payment_schedule" class="form-control" required>
                                <option value="">Sélectionnez un planning</option>
                                <option value="one_time" {{ old('payment_schedule') == 'one_time' ? 'selected' : '' }}>
                                    Paiement unique
                                </option>
                                <option value="monthly" {{ old('payment_schedule') == 'monthly' ? 'selected' : '' }}>
                                    Mensuel
                                </option>
                                <option value="quarterly" {{ old('payment_schedule') == 'quarterly' ? 'selected' : '' }}>
                                    Trimestriel
                                </option>
                                <option value="semester" {{ old('payment_schedule') == 'semester' ? 'selected' : '' }}>
                                    Semestriel
                                </option>
                                <option value="annual" {{ old('payment_schedule') == 'annual' ? 'selected' : '' }}>
                                    Annuel
                                </option>
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        @error('payment_schedule')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Conditions spéciales -->
                    <div class="form-group full-width">
                        <label for="special_conditions" class="form-label">
                            <i class="fas fa-sticky-note"></i>Conditions spéciales (optionnel)
                        </label>
                        <textarea id="special_conditions" name="special_conditions" rows="3" 
                                  class="form-control" maxlength="1000"
                                  placeholder="Notes particulières, réductions accordées, etc.">{{ old('special_conditions') }}</textarea>
                        @error('special_conditions')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Récapitulatif et validation -->
        <div class="card summary-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-clipboard-check"></i>Récapitulatif
                </h2>
            </div>
            <div class="card-body">
                <div class="summary-content" id="summary-content">
                    <p class="summary-instruction">
                        <i class="fas fa-info-circle"></i>
                        Veuillez remplir les informations ci-dessus pour voir le récapitulatif.
                    </p>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}" 
                       class="btn btn-light">
                        <i class="fas fa-times"></i>Annuler
                    </a>
                    <button type="submit" class="btn btn-success" id="submit-btn" disabled>
                        <i class="fas fa-check-circle"></i>Finaliser l'inscription
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
:root {
    --primary: #4CA3DD;
    --primary-dark: #2A7AB8;
    --primary-light: rgba(76, 163, 221, 0.1);
    --body-bg: #F8FAFC;
    --card-bg: #FFFFFF;
    --section-bg: #EEF2F7;
    --text-primary: #1E293B;
    --text-secondary: #64748B;
    --border-color: #E2E8F0;
    --success: #34D399;
    --success-light: rgba(52, 211, 153, 0.1);
    --warning: #FBBF24;
    --warning-light: rgba(251, 191, 36, 0.1);
    --danger: #F87171;
    --danger-light: rgba(248, 113, 113, 0.1);
    --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
    --border-radius: 0.5rem;
    --spacing-sm: 0.5rem;
    --spacing-md: 1rem;
    --spacing-lg: 1.5rem;
    --spacing-xl: 2rem;
}

body {
    background-color: var(--body-bg);
    color: var(--text-primary);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.finalize-registration-container {
    padding: var(--spacing-lg);
    max-width: 1200px;
    margin: 0 auto;
}

/* Page header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--spacing-lg);
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: var(--spacing-sm);
}

.breadcrumb a {
    color: var(--text-secondary);
    text-decoration: none;
}

.breadcrumb a:hover {
    color: var(--primary);
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.page-description {
    color: var(--text-secondary);
    margin: 0;
}

/* Cards */
.card, .student-summary-card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: var(--spacing-lg);
}

.card-header {
    padding: var(--spacing-lg);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
}

.card-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.card-subtitle {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-top: 0.25rem;
}

.card-body {
    padding: var(--spacing-lg);
}

/* Student summary */
.student-overview {
    display: flex;
    gap: var(--spacing-lg);
    align-items: flex-start;
}

.student-photo {
    flex-shrink: 0;
}

.avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--primary-light);
    box-shadow: var(--shadow);
}

.student-name {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 var(--spacing-md) 0;
    color: var(--text-primary);
}

.student-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--spacing-sm);
}

.info-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-size: 0.875rem;
}

.info-item i {
    color: var(--primary);
    width: 18px;
    flex-shrink: 0;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    border-radius: var(--border-radius);
    white-space: nowrap;
}

.status-badge.warning {
    background-color: var(--warning-light);
    color: var(--warning);
}

/* Formations grid */
.formations-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--spacing-md);
}

.formation-card {
    position: relative;
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
}

.formation-label {
    display: block;
    cursor: pointer;
    position: relative;
}

.formation-checkbox {
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
}

.formation-content {
    padding: var(--spacing-lg);
    border: 2px solid var(--border-color);
    border-radius: var(--border-radius);
    transition: all 0.3s ease;
    position: relative;
}

.formation-checkbox:checked + .formation-content {
    border-color: var(--primary);
    background-color: var(--primary-light);
    box-shadow: var(--shadow-md);
}

.formation-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--spacing-sm);
}

.formation-name {
    font-size: 1rem;
    font-weight: 600;
    margin: 0;
    color: var(--text-primary);
}

.formation-price {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--primary);
    background-color: var(--primary-light);
    padding: 0.25rem 0.5rem;
    border-radius: var(--border-radius);
}

.formation-description {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0 0 var(--spacing-sm) 0;
    line-height: 1.4;
}

.formation-meta {
    display: flex;
    gap: var(--spacing-md);
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.meta-item i {
    color: var(--primary);
}

.formation-checkmark {
    position: absolute;
    top: var(--spacing-sm);
    right: var(--spacing-sm);
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    opacity: 0;
    transform: scale(0);
    transition: all 0.3s ease;
}

.formation-checkbox:checked ~ .formation-checkmark {
    opacity: 1;
    transform: scale(1);
}

/* Form elements */
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-lg);
}

.form-group {
    margin-bottom: var(--spacing-md);
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: var(--text-secondary);
}

.form-label.required::after {
    content: '*';
    color: var(--danger);
    margin-left: 0.25rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    background-color: var(--card-bg);
    color: var(--text-primary);
    font-size: 0.875rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.select-wrapper {
    position: relative;
}

.select-wrapper select {
    appearance: none;
    padding-right: 2.5rem;
}

.select-wrapper i {
    position: absolute;
    top: 50%;
    right: 0.75rem;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--text-secondary);
}

.error-message {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-top: 0.25rem;
    font-size: 0.75rem;
    color: var(--danger);
}

/* Summary card */
.summary-card {
    border: 2px solid var(--primary);
    background: linear-gradient(135deg, var(--card-bg) 0%, var(--primary-light) 100%);
}

.summary-content {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    padding: var(--spacing-lg);
    margin-bottom: var(--spacing-lg);
}

.summary-instruction {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    color: var(--text-secondary);
    margin: 0;
    font-style: italic;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-md);
}

.summary-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.summary-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-secondary);
}

.summary-value {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-primary);
}

.summary-highlight {
    background-color: var(--success-light);
    color: var(--success);
    padding: 0.25rem 0.5rem;
    border-radius: var(--border-radius);
    font-weight: 600;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius);
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
    text-decoration: none;
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-light {
    background-color: var(--section-bg);
    color: var(--text-primary);
}

.btn-light:hover:not(:disabled) {
    background-color: var(--border-color);
}

.btn-success {
    background-color: var(--success);
    color: white;
}

.btn-success:hover:not(:disabled) {
    background-color: #22c55e;
    box-shadow: var(--shadow-md);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: var(--spacing-md);
}

/* Responsive */
@media (max-width: 768px) {
    .finalize-registration-container {
        padding: var(--spacing-md);
    }
    
    .page-header {
        flex-direction: column;
        gap: var(--spacing-md);
    }
    
    .header-actions {
        width: 100%;
    }
    
    .student-overview {
        flex-direction: column;
        text-align: center;
    }
    
    .formations-grid {
        grid-template-columns: 1fr;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .student-info-grid {
        grid-template-columns: 1fr;
    }
    
    .formation-header {
        flex-direction: column;
        gap: var(--spacing-sm);
    }
    
    .formation-price {
        align-self: flex-start;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('finalizationForm');
    const submitBtn = document.getElementById('submit-btn');
    const summaryContent = document.getElementById('summary-content');
    
    // Éléments du formulaire
    const formationsCheckboxes = document.querySelectorAll('input[name="formations[]"]');
    const centerSelect = document.getElementById('center_id');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const paymentMethodSelect = document.getElementById('payment_method_id');
    const receiptNumberInput = document.getElementById('receipt_number');
    const contractAmountInput = document.getElementById('contract_amount');
    const amountReceivedInput = document.getElementById('amount_received');
    const paymentScheduleSelect = document.getElementById('payment_schedule');
    
    // Mettre à jour la date de fin automatiquement
    startDateInput.addEventListener('change', function() {
        if (this.value) {
            const startDate = new Date(this.value);
            const endDate = new Date(startDate);
            endDate.setFullYear(startDate.getFullYear() + 1);
            endDateInput.value = endDate.toISOString().split('T')[0];
            endDateInput.min = this.value;
            updateSummary();
        }
    });
    
    // Calculer le total des formations sélectionnées
    function calculateFormationsTotal() {
        let total = 0;
        formationsCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const card = checkbox.closest('.formation-card');
                const priceElement = card.querySelector('.formation-price');
                if (priceElement) {
                    const price = parseInt(priceElement.textContent.replace(/[^\d]/g, ''));
                    total += price;
                }
            }
        });
        return total;
    }
    
    // Mettre à jour le montant du contrat basé sur les formations
    function updateContractAmount() {
        const total = calculateFormationsTotal();
        if (total > 0 && !contractAmountInput.value) {
            contractAmountInput.value = total;
        }
    }
    
    // Event listeners pour les formations
    formationsCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateContractAmount();
            updateSummary();
        });
    });
    
    // Event listeners pour tous les champs
    [centerSelect, paymentMethodSelect, receiptNumberInput, contractAmountInput, 
     amountReceivedInput, paymentScheduleSelect].forEach(element => {
        element.addEventListener('change', updateSummary);
        if (element.tagName === 'INPUT') {
            element.addEventListener('input', updateSummary);
        }
    });
    
    // Fonction pour mettre à jour le récapitulatif
    function updateSummary() {
        const selectedFormations = Array.from(formationsCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => {
                const card = cb.closest('.formation-card');
                return card.querySelector('.formation-name').textContent;
            });
        
        const center = centerSelect.options[centerSelect.selectedIndex]?.text || '';
        const paymentMethod = paymentMethodSelect.options[paymentMethodSelect.selectedIndex]?.text || '';
        const contractAmount = contractAmountInput.value;
        const amountReceived = amountReceivedInput.value;
        const paymentSchedule = paymentScheduleSelect.options[paymentScheduleSelect.selectedIndex]?.text || '';
        const receiptNumber = receiptNumberInput.value;
        
        // Vérifier si tous les champs requis sont remplis
        const isFormValid = selectedFormations.length > 0 && 
                           centerSelect.value && 
                           paymentMethodSelect.value && 
                           receiptNumber && 
                           contractAmount && 
                           amountReceived && 
                           paymentScheduleSelect.value &&
                           startDateInput.value &&
                           endDateInput.value;
        
        submitBtn.disabled = !isFormValid;
        
        if (isFormValid) {
            const remainingAmount = parseInt(contractAmount) - parseInt(amountReceived);
            
            summaryContent.innerHTML = `
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="summary-label">Formations sélectionnées</div>
                        <div class="summary-value">${selectedFormations.join(', ')}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Centre d'affectation</div>
                        <div class="summary-value">${center}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Période</div>
                        <div class="summary-value">
                            Du ${new Date(startDateInput.value).toLocaleDateString('fr-FR')} 
                            au ${new Date(endDateInput.value).toLocaleDateString('fr-FR')}
                        </div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Méthode de paiement</div>
                        <div class="summary-value">${paymentMethod}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Numéro de reçu</div>
                        <div class="summary-value">${receiptNumber}</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Montant du contrat</div>
                        <div class="summary-value summary-highlight">
                            ${parseInt(contractAmount).toLocaleString('fr-FR')} FCFA
                        </div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Montant reçu</div>
                        <div class="summary-value">${parseInt(amountReceived).toLocaleString('fr-FR')} FCFA</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Montant restant</div>
                        <div class="summary-value ${remainingAmount > 0 ? '' : 'summary-highlight'}">
                            ${remainingAmount.toLocaleString('fr-FR')} FCFA
                        </div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-label">Planning de paiement</div>
                        <div class="summary-value">${paymentSchedule}</div>
                    </div>
                </div>
            `;
        } else {
            summaryContent.innerHTML = `
                <p class="summary-instruction">
                    <i class="fas fa-info-circle"></i>
                    Veuillez remplir tous les champs requis pour voir le récapitulatif.
                </p>
            `;
        }
    }
    
    // Validation du formulaire avant soumission
    form.addEventListener('submit', function(e) {
        const selectedFormations = Array.from(formationsCheckboxes).filter(cb => cb.checked);
        
        if (selectedFormations.length === 0) {
            e.preventDefault();
            alert('Veuillez sélectionner au moins une formation.');
            return false;
        }
        
        const contractAmount = parseInt(contractAmountInput.value);
        const amountReceived = parseInt(amountReceivedInput.value);
        
        if (amountReceived > contractAmount) {
            e.preventDefault();
            alert('Le montant reçu ne peut pas être supérieur au montant du contrat.');
            return false;
        }
        
        // Confirmation finale
        const confirmMessage = `Êtes-vous sûr de vouloir finaliser l'inscription de {{ $student->full_name }} ?
        
Cette action va :
- Activer le compte de l'élève
- Créer son dossier d'inscription
- Enregistrer le paiement initial
        
Cette action est irréversible.`;
        
        if (!confirm(confirmMessage)) {
            e.preventDefault();
            return false;
        }
    });
    
    // Initialiser le récapitulatif
    updateSummary();
});
</script>
@endpush
@endsection