@extends('layouts.app')

@section('title', 'Versements de ' . $student->user->first_name . ' ' . $student->user->last_name)

@section('content')
<div class="finance-dashboard">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}">Finance</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}">Élèves</a>
                <i class="fas fa-chevron-right"></i>
                <span>Versements</span>
            </div>
            <h1 class="page-title">Versements de {{ $student->user->first_name }} {{ $student->user->last_name }}</h1>
            <p class="page-description">Gestion des versements et échéances de paiement</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.finance.students.pending', ['locale' => app()->getLocale()]) }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i>
                <span>Retour aux élèves</span>
            </a>
        </div>
    </div>

    <!-- Informations de l'étudiant -->
    <div class="card student-summary-card">
        <div class="card-body">
            <div class="student-summary">
                <div class="student-avatar-large">
                    <img src="{{ $student->user->profile_photo_url ?? '/default-avatar.png' }}" alt="{{ $student->user->first_name }}" class="avatar-large">
                    <span class="status-indicator-large success">
                        <i class="fas fa-user-check"></i>
                    </span>
                </div>
                <div class="student-details-large">
                    <h2 class="student-name-large">{{ $student->user->first_name }} {{ $student->user->last_name }}</h2>
                    <div class="student-meta">
                        <div class="meta-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $student->user->email }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-phone-alt"></i>
                            <span>{{ $student->phone_number ?? 'Non renseigné' }}</span>
                        </div>
                        @if($student->establishment)
                            <div class="meta-item">
                                <i class="fas fa-school"></i>
                                <span>{{ $student->establishment }}</span>
                            </div>
                        @endif
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Inscrit le {{ $registration->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
                <div class="payment-summary">
                    @php
                        $totalPaid = $registration->installments->sum('amount');
                        $totalAmount = $registration->total_amount ?? 0;
                        $remaining = $totalAmount - $totalPaid;
                        $progressPercent = $totalAmount > 0 ? ($totalPaid / $totalAmount) * 100 : 0;
                    @endphp
                    <div class="summary-card">
                        <div class="summary-icon success">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="summary-content">
                            <h3 class="summary-value">{{ number_format($totalPaid, 0, ',', ' ') }} FCFA</h3>
                            <p class="summary-label">Total versé</p>
                        </div>
                    </div>
                    @if($totalAmount > 0)
                        <div class="summary-card">
                            <div class="summary-icon info">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <div class="summary-content">
                                <h3 class="summary-value">{{ number_format($remaining, 0, ',', ' ') }} FCFA</h3>
                                <p class="summary-label">Restant dû</p>
                            </div>
                        </div>
                        <div class="payment-progress">
                            <div class="progress-info">
                                <span>Progression</span>
                                <span>{{ round($progressPercent, 1) }}%</span>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: {{ $progressPercent }}%"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques des versements -->
    <div class="stats-container">
        <div class="stats-card">
            <div class="stats-icon info">
                <i class="fas fa-list-ol"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-value">{{ $registration->installments->count() }}</h3>
                <p class="stats-label">Nombre de versements</p>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon success">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stats-content">
                <h3 class="stats-value">{{ number_format($totalPaid, 0, ',', ' ') }}</h3>
                <p class="stats-label">Total versé (FCFA)</p>
            </div>
        </div>

        @if($registration->installments->count() > 0)
            <div class="stats-card">
                <div class="stats-icon warning">
                    <i class="fas fa-calculator"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ number_format($registration->installments->avg('amount'), 0, ',', ' ') }}</h3>
                    <p class="stats-label">Versement moyen (FCFA)</p>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon primary">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value">{{ $registration->installments->last()->created_at->diffForHumans() }}</h3>
                    <p class="stats-label">Dernier versement</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Liste des versements -->
    <div class="card data-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-money-check-alt"></i>Historique des versements ({{ $registration->installments->count() }})
            </h2>
            <div class="header-actions">
                <button type="button" onclick="showAddInstallmentModal()"
                    class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter un versement</span>
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            @if($registration->installments->count() > 0)
                <div class="table-responsive">
                    <table class="table installments-table">
                        <thead>
                            <tr>
                                <th>
                                    <span>Montant</span>
                                </th>
                                <th>Date de versement</th>
                                <th>Méthode de paiement</th>
                                <th>Notes</th>
                                <th>Traité par</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($registration->installments->sortByDesc('created_at') as $installment)
                                <tr>
                                    <td>
                                        <div class="amount-info">
                                            <div class="amount-value">{{ number_format($installment->amount, 0, ',', ' ') }} FCFA</div>
                                            <div class="amount-badge">
                                                <span class="badge success-badge">
                                                    <i class="fas fa-check-circle"></i>Versé
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="date-info">
                                            <div class="date-primary">
                                                <i class="far fa-calendar-alt"></i>
                                                {{ $installment->created_at->format('d/m/Y') }}
                                            </div>
                                            <div class="date-secondary">
                                                {{ $installment->created_at->format('H:i') }} •
                                                {{ $installment->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="payment-method-info">
                                            @if($installment->paymentMethod)
                                                <div class="method-primary">
                                                    <i class="fas fa-credit-card"></i>
                                                    {{ $installment->paymentMethod->name }}
                                                </div>
                                            @else
                                                <div class="method-empty">
                                                    <i class="fas fa-question-circle"></i>
                                                    Non spécifié
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="notes-info">
                                            @if($installment->notes)
                                                <div class="notes-content">
                                                    <i class="fas fa-sticky-note"></i>
                                                    <span>{{ Str::limit($installment->notes, 50) }}</span>
                                                    @if(strlen($installment->notes) > 50)
                                                        <button type="button" class="notes-expand"
                                                                onclick="showNotesModal('{{ addslashes($installment->notes) }}')">
                                                            <i class="fas fa-expand-alt"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="notes-empty">
                                                    <i class="fas fa-minus"></i>
                                                    Aucune note
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="processed-by-info">
                                            @if($installment->processedBy)
                                                <div class="processor-info">
                                                    <i class="fas fa-user"></i>
                                                    <span>{{ $installment->processedBy->first_name }} {{ $installment->processedBy->last_name }}</span>
                                                </div>
                                            @else
                                                <div class="processor-empty">
                                                    <i class="fas fa-question-circle"></i>
                                                    Non spécifié
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="btn-action view"
                                                    onclick="showInstallmentDetails({{ $installment->id }})"
                                                    title="Voir les détails">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn-action edit"
                                                    title="Modifier le versement">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-money-check-alt"></i>
                    </div>
                    <h4>Aucun versement enregistré</h4>
                    <p>Cet élève n'a encore effectué aucun versement. Ajoutez le premier versement pour commencer le suivi des paiements.</p>
                    <div class="empty-actions">
                        <button type="button" onclick="showAddInstallmentModal()" class="btn btn-primary">
                            <i class="fas fa-plus"></i>Ajouter le premier versement
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal d'ajout de versement -->
<div id="addInstallmentModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-plus-circle text-success"></i>
                Ajouter un versement
            </h3>
            <button type="button" class="modal-close" onclick="closeAddInstallmentModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('admin.finance.installments.store', ['locale' => app()->getLocale()]) }}" method="POST" id="addInstallmentForm">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">
            <div class="modal-body">
                <div class="form-group">
                    <label for="amount" class="form-label required">
                        <i class="fas fa-coins"></i>Montant du versement
                    </label>
                    <div class="input-with-suffix">
                        <input type="number" id="amount" name="amount"
                               class="form-control"
                               placeholder="0"
                               required min="0" step="0.01">
                        <span class="input-suffix">FCFA</span>
                    </div>
                    <div class="form-help">
                        Saisissez le montant exact versé par l'élève.
                    </div>
                </div>

                <div class="form-group">
                    <label for="payment_method_id" class="form-label">
                        <i class="fas fa-credit-card"></i>Méthode de paiement
                    </label>
                    <div class="select-wrapper">
                        <select id="payment_method_id" name="payment_method_id" class="form-control">
                            <option value="">-- Sélectionner une méthode --</option>
                            @foreach (\App\Models\PaymentMethod::all() as $method)
                                <option value="{{ $method->id }}">{{ $method->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">
                        <i class="fas fa-sticky-note"></i>Notes et commentaires
                    </label>
                    <textarea id="notes" name="notes" rows="3"
                              class="form-control"
                              placeholder="Ajoutez des notes sur ce versement (optionnel)..."
                              maxlength="500"></textarea>
                    <div class="form-help">
                        <span id="notes-counter">0</span>/500 caractères
                    </div>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Information :</strong> Ce versement sera automatiquement enregistré avec votre nom d'utilisateur et l'horodatage actuel.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" onclick="closeAddInstallmentModal()">
                    <i class="fas fa-times"></i>Annuler
                </button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle"></i>Enregistrer le versement
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal des notes complètes -->
<div id="notesModal" class="modal-overlay" style="display: none;">
    <div class="modal-content modal-small">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-sticky-note text-info"></i>
                Notes du versement
            </h3>
            <button type="button" class="modal-close" onclick="closeNotesModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="notes-display" id="notesContent">
                <!-- Le contenu sera injecté par JavaScript -->
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light" onclick="closeNotesModal()">
                <i class="fas fa-times"></i>Fermer
            </button>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Reprendre les styles de base de la vue pending */
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
    --info: #60A5FA;
    --info-light: rgba(96, 165, 250, 0.1);
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
}

body {
    background-color: var(--body-bg);
    color: var(--text-primary);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.finance-dashboard {
    padding: var(--spacing-lg);
    max-width: 1600px;
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
}

.page-description {
    color: var(--text-secondary);
    margin: 0;
}

/* Student summary card */
.student-summary-card {
    margin-bottom: var(--spacing-lg);
}

.student-summary {
    display: flex;
    align-items: flex-start;
    gap: var(--spacing-lg);
}

.student-avatar-large {
    position: relative;
    flex-shrink: 0;
}

.avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--card-bg);
    box-shadow: var(--shadow-md);
}

.status-indicator-large {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    border: 3px solid var(--card-bg);
}

.status-indicator-large.success {
    background-color: var(--success);
    color: white;
}

.student-details-large {
    flex: 1;
}

.student-name-large {
    font-size: 1.5rem;
    font-weight: 700;
    margin: 0 0 var(--spacing-md) 0;
}

.student-meta {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: var(--spacing-sm);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.meta-item i {
    color: var(--primary);
    width: 16px;
}

.payment-summary {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    gap: var(--spacing-md);
    min-width: 200px;
}

.summary-card {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    padding: var(--spacing-sm);
    background-color: var(--section-bg);
    border-radius: var(--border-radius);
}

.summary-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.summary-icon.success {
    background-color: var(--success-light);
    color: var(--success);
}

.summary-icon.info {
    background-color: var(--info-light);
    color: var(--info);
}

.summary-value {
    font-size: 1.125rem;
    font-weight: 700;
    margin: 0;
}

.summary-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin: 0;
}

.payment-progress {
    background-color: var(--section-bg);
    padding: var(--spacing-sm);
    border-radius: var(--border-radius);
}

.progress-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--spacing-sm);
    font-size: 0.75rem;
    font-weight: 600;
}

.progress-bar-container {
    height: 6px;
    background-color: var(--border-color);
    border-radius: 3px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    background-color: var(--success);
    transition: width 0.3s ease;
}

/* Stats cards */
.stats-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: var(--spacing-md);
    margin-bottom: var(--spacing-lg);
}

.stats-card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    padding: var(--spacing-md);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    transition: transform 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
}

.stats-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.stats-icon.info {
    background-color: var(--info-light);
    color: var(--info);
}

.stats-icon.success {
    background-color: var(--success-light);
    color: var(--success);
}

.stats-icon.warning {
    background-color: var(--warning-light);
    color: var(--warning);
}

.stats-icon.primary {
    background-color: var(--primary-light);
    color: var(--primary);
}

.stats-value {
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
}

.stats-label {
    color: var(--text-secondary);
    font-size: 0.8125rem;
    margin: 0;
}

/* Cards */
.card {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    margin-bottom: var(--spacing-lg);
}

.card-header {
    padding: var(--spacing-md) var(--spacing-lg);
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

.card-body {
    padding: var(--spacing-lg);
}

.card-body.p-0 {
    padding: 0;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: var(--border-radius);
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    font-size: 0.875rem;
    text-decoration: none;
}

.btn-primary {
    background-color: var(--primary);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
}

.btn-light {
    background-color: var(--section-bg);
    color: var(--text-primary);
}

.btn-light:hover {
    background-color: var(--border-color);
}

.btn-success {
    background-color: var(--success);
    color: white;
}

.btn-success:hover {
    background-color: #22c55e;
}

/* Table */
.installments-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.installments-table th {
    text-align: left;
    padding: var(--spacing-sm) var(--spacing-md);
    background-color: var(--section-bg);
    color: var(--text-secondary);
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--border-color);
}

.installments-table td {
    padding: var(--spacing-md);
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.installments-table tr:hover td {
    background-color: var(--primary-light);
}

/* Amount info */
.amount-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.amount-value {
    font-weight: 600;
    font-size: 0.95rem;
    color: var(--success);
}

.amount-badge .badge {
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.125rem 0.5rem;
    font-size: 0.6875rem;
    font-weight: 600;
    border-radius: var(--border-radius);
}

.success-badge {
    background-color: var(--success-light);
    color: var(--success);
}

/* Date info */
.date-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.date-primary {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    font-weight: 500;
    font-size: 0.875rem;
}

.date-secondary {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

/* Payment method info */
.payment-method-info, .notes-info, .processed-by-info {
    font-size: 0.875rem;
}

.method-primary, .processor-info {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.method-primary i, .processor-info i {
    color: var(--primary);
    width: 16px;
}

.method-empty, .notes-empty, .processor-empty {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
    color: var(--text-secondary);
    font-style: italic;
}

.method-empty i, .notes-empty i, .processor-empty i {
    width: 16px;
}

/* Notes info */
.notes-content {
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.notes-content i {
    color: var(--warning);
    width: 16px;
}

.notes-expand {
    background: transparent;
    border: none;
    color: var(--primary);
    cursor: pointer;
    padding: 0.125rem;
    margin-left: var(--spacing-sm);
    border-radius: 0.25rem;
}

.notes-expand:hover {
    background-color: var(--primary-light);
}

/* Action buttons */
.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 0.25rem;
}

.btn-action {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: var(--border-radius);
    border: none;
    background-color: var(--section-bg);
    color: var(--text-secondary);
    cursor: pointer;
    transition: all 0.2s;
}

.btn-action:hover {
    transform: translateY(-2px);
}

.btn-action.view:hover {
    background-color: var(--info-light);
    color: var(--info);
}

.btn-action.edit:hover {
    background-color: var(--warning-light);
    color: var(--warning);
}

/* Empty state */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-lg);
    text-align: center;
}

.empty-icon {
    font-size: 3rem;
    color: var(--text-secondary);
    opacity: 0.3;
    margin-bottom: var(--spacing-md);
}

.empty-state h4 {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0 0 var(--spacing-sm) 0;
}

.empty-state p {
    color: var(--text-secondary);
    margin: 0 0 var(--spacing-lg) 0;
    max-width: 400px;
}

.empty-actions {
    display: flex;
    gap: var(--spacing-md);
}

/* Form elements */
.form-group {
    margin-bottom: var(--spacing-md);
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
    padding: 0.5rem 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    background-color: var(--card-bg);
    color: var(--text-primary);
    font-size: 0.875rem;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-light);
}

.input-with-suffix {
    position: relative;
}

.input-with-suffix input {
    padding-right: 4rem;
}

.input-suffix {
    position: absolute;
    top: 50%;
    right: 0.75rem;
    transform: translateY(-50%);
    color: var(--text-secondary);
    font-size: 0.875rem;
    font-weight: 500;
}

.select-wrapper {
    position: relative;
}

.select-wrapper select {
    appearance: none;
    padding-right: 2rem;
}

.select-wrapper i {
    position: absolute;
    top: 50%;
    right: 0.75rem;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--text-secondary);
}

.form-help {
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin-top: 0.25rem;
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background-color: var(--card-bg);
    border-radius: var(--border-radius);
    box-shadow: var(--shadow-md);
    width: 90%;
    max-width: 600px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-content.modal-small {
    max-width: 400px;
}

.modal-header {
    padding: var(--spacing-lg);
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: var(--spacing-sm);
}

.modal-close {
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--text-secondary);
    font-size: 1.25rem;
}

.modal-body {
    padding: var(--spacing-lg);
}

.modal-footer {
    padding: var(--spacing-lg);
    border-top: 1px solid var(--border-color);
    display: flex;
    justify-content: flex-end;
    gap: var(--spacing-sm);
}

.alert {
    padding: var(--spacing-md);
    border-radius: var(--border-radius);
    margin-bottom: var(--spacing-md);
    display: flex;
    align-items: flex-start;
    gap: var(--spacing-sm);
}

.alert-info {
    background-color: var(--info-light);
    color: var(--info);
    border: 1px solid var(--info);
}

.notes-display {
    background-color: var(--section-bg);
    padding: var(--spacing-md);
    border-radius: var(--border-radius);
    white-space: pre-wrap;
    font-size: 0.875rem;
    line-height: 1.5;
}

/* Responsive */
@media (max-width: 768px) {
    .finance-dashboard {
        padding: var(--spacing-md);
    }

    .student-summary {
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .student-meta {
        grid-template-columns: 1fr;
    }

    .payment-summary {
        min-width: auto;
        width: 100%;
    }

    .stats-container {
        grid-template-columns: repeat(2, 1fr);
    }

    .page-header {
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .header-actions {
        width: 100%;
    }
}

@media (max-width: 576px) {
    .stats-container {
        grid-template-columns: 1fr;
    }

    .installments-table th:nth-child(3),
    .installments-table td:nth-child(3),
    .installments-table th:nth-child(5),
    .installments-table td:nth-child(5) {
        display: none;
    }

    .modal-content {
        margin: var(--spacing-sm);
        width: calc(100% - 2 * var(--spacing-sm));
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Compteur de caractères pour les notes
    const notesTextarea = document.getElementById('notes');
    const notesCounter = document.getElementById('notes-counter');

    if (notesTextarea && notesCounter) {
        notesTextarea.addEventListener('input', function() {
            notesCounter.textContent = this.value.length;
        });
    }

    // Auto-focus sur le montant quand le modal s'ouvre
    const amountInput = document.getElementById('amount');
    if (amountInput) {
        const modal = document.getElementById('addInstallmentModal');
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    if (modal.style.display !== 'none') {
                        setTimeout(() => amountInput.focus(), 100);
                    }
                }
            });
        });
        observer.observe(modal, { attributes: true });
    }
});

// Fonctions pour le modal d'ajout de versement
function showAddInstallmentModal() {
    const modal = document.getElementById('addInstallmentModal');
    modal.style.display = 'flex';

    // Reset du formulaire
    const form = document.getElementById('addInstallmentForm');
    form.reset();

    // Reset du compteur
    const notesCounter = document.getElementById('notes-counter');
    if (notesCounter) {
        notesCounter.textContent = '0';
    }
}

function closeAddInstallmentModal() {
    const modal = document.getElementById('addInstallmentModal');
    modal.style.display = 'none';
}

// Fonctions pour le modal des notes
function showNotesModal(notes) {
    const modal = document.getElementById('notesModal');
    const content = document.getElementById('notesContent');
    content.textContent = notes;
    modal.style.display = 'flex';
}

function closeNotesModal() {
    const modal = document.getElementById('notesModal');
    modal.style.display = 'none';
}

// Fonction pour les détails d'un versement (à implémenter selon vos besoins)
function showInstallmentDetails(installmentId) {
    // Vous pouvez implémenter une redirection ou un modal avec plus de détails
    console.log('Voir détails du versement:', installmentId);
}

// Fermer les modals en cliquant à l'extérieur
document.addEventListener('click', function(event) {
    const addModal = document.getElementById('addInstallmentModal');
    const notesModal = document.getElementById('notesModal');

    if (event.target === addModal) {
        closeAddInstallmentModal();
    }

    if (event.target === notesModal) {
        closeNotesModal();
    }
});

// Fermer les modals avec Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeAddInstallmentModal();
        closeNotesModal();
    }
});

// Validation du formulaire
document.getElementById('addInstallmentForm').addEventListener('submit', function(e) {
    const amount = document.getElementById('amount').value;

    if (!amount || parseFloat(amount) <= 0) {
        e.preventDefault();
        alert('Veuillez saisir un montant valide.');
        document.getElementById('amount').focus();
        return false;
    }
});
</script>
@endpush
@endsection
