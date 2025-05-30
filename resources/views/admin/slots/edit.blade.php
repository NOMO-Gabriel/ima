@extends('layouts.app')

@section('title', 'Modifier le créneau')

@section('content')
<div class="planning-dashboard">
    <!-- En-tête de page -->
    <div class="page-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale()]) }}">Planning</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale(), 'center_id' => $center->id, 'formation_id' => $formation->id, 'week_start_date' => $slot->timetable->week_start_date->toDateString()]) }}">
                    {{ $center->name }}
                </a>
                <i class="fas fa-chevron-right"></i>
                <span>Modifier créneau</span>
            </div>
            <h1 class="page-title">Modifier le créneau</h1>
            <p class="page-description">Modification des détails du cours planifié</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale(), 'center_id' => $center->id, 'formation_id' => $formation->id, 'week_start_date' => $slot->timetable->week_start_date->toDateString()]) }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i>
                <span>Retour au planning</span>
            </a>
        </div>
    </div>

    <!-- Informations du créneau -->
    <div class="card info-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-info-circle"></i>Informations du créneau
            </h2>
        </div>
        <div class="card-body">
            <div class="slot-info-grid">
                <div class="info-item">
                    <div class="info-icon center">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Centre</span>
                        <span class="info-value">{{ $center->name }}</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon formation">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Formation</span>
                        <span class="info-value">{{ $formation->name }}</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon room">
                        <i class="fas fa-door-open"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Salle</span>
                        <span class="info-value">{{ $room->name }}</span>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon time">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="info-content">
                        <span class="info-label">Créneau</span>
                        <span class="info-value">
                            {{ ucfirst($slot->week_day) }}
                            {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de modification -->
    <div class="card form-card">
        <div class="card-header">
            <h2 class="card-title">
                <i class="fas fa-edit"></i>Modifier les détails du cours
            </h2>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.slots.update', ['locale' => app()->getLocale(), 'slot' => $slot]) }}" id="slotEditForm">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="form-group">
                        <label for="course_id" class="form-label">
                            <i class="fas fa-book"></i>Cours
                        </label>
                        <div class="select-wrapper">
                            <select name="course_id" id="course_id" class="form-control @error('course_id') is-invalid @enderror">
                                <option value="">-- Aucun cours assigné --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ (old('course_id') ?? $slot->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->title }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        @error('course_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        <div class="form-help">
                            @if($slot->course)
                                Cours actuel : <strong>{{ $slot->course->title }}</strong>
                            @else
                                Aucun cours actuellement assigné
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="teacher_id" class="form-label">
                            <i class="fas fa-chalkboard-teacher"></i>Professeur
                        </label>
                        <div class="select-wrapper">
                            <select name="teacher_id" id="teacher_id" class="form-control @error('teacher_id') is-invalid @enderror">
                                <option value="">-- Aucun professeur assigné --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ (old('teacher_id') ?? $slot->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        @error('teacher_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                        <div class="form-help">
                            @if($slot->teacher)
                                Professeur actuel : <strong>{{ $slot->teacher->first_name }} {{ $slot->teacher->last_name }}</strong>
                            @else
                                Aucun professeur actuellement assigné
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Informations de création -->
                <div class="creation-info">
                    <div class="info-row">
                        <span class="info-label">
                            <i class="fas fa-calendar-plus"></i>Créé le
                        </span>
                        <span class="info-value">{{ $slot->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    @if($slot->updated_at != $slot->created_at)
                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-edit"></i>Dernière modification
                            </span>
                            <span class="info-value">{{ $slot->updated_at->format('d/m/Y à H:i') }}</span>
                        </div>
                    @endif
                </div>

                <div class="form-actions">
                    <div class="action-group">
                        <a href="{{ route('admin.planning.index', ['locale' => app()->getLocale(), 'center_id' => $center->id, 'formation_id' => $formation->id, 'week_start_date' => $slot->timetable->week_start_date->toDateString()]) }}" class="btn btn-light">
                            <i class="fas fa-times"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>Sauvegarder les modifications
                        </button>
                    </div>
                    <div class="action-group">
                        <button type="button" class="btn btn-danger" onclick="showDeleteModal()">
                            <i class="fas fa-trash"></i>Supprimer le créneau
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Aide contextuelle -->
    <div class="card help-card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-lightbulb"></i>Actions possibles
            </h3>
        </div>
        <div class="card-body">
            <div class="help-content">
                <div class="help-item">
                    <h4><i class="fas fa-edit text-primary"></i> Modification</h4>
                    <p>Vous pouvez modifier le cours et/ou le professeur assigné à ce créneau.</p>
                </div>
                <div class="help-item">
                    <h4><i class="fas fa-eraser text-warning"></i> Réinitialisation</h4>
                    <p>Vous pouvez retirer le cours ou le professeur en sélectionnant "Aucun".</p>
                </div>
                <div class="help-item">
                    <h4><i class="fas fa-trash text-danger"></i> Suppression</h4>
                    <p>La suppression du créneau le retirera définitivement du planning.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suppression -->
<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="fas fa-trash text-danger"></i>
                Supprimer le créneau
            </h3>
            <button type="button" class="modal-close" onclick="closeDeleteModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="deleteForm" method="POST" action="{{ route('admin.slots.destroy', ['locale' => app()->getLocale(), 'slot' => $slot]) }}">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Attention :</strong> Cette action est irréversible. Le créneau sera définitivement supprimé du planning.
                </div>
                <p>Êtes-vous sûr de vouloir supprimer ce créneau ?</p>
                <div class="slot-summary-delete">
                    <strong>{{ ucfirst($slot->week_day) }}
                    {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} -
                    {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}</strong><br>
                    <span class="text-muted">
                        {{ $slot->course ? $slot->course->title : 'Aucun cours' }} •
                        {{ $slot->teacher ? $slot->teacher->first_name . ' ' . $slot->teacher->last_name : 'Aucun professeur' }}
                    </span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i>Annuler
                </button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i>Confirmer la suppression
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
/* Variables CSS */
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

.planning-dashboard {
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
}

.page-description {
    color: var(--text-secondary);
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

/* Informations du créneau */
.slot-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--spacing-md);
}

.info-item {
    display: flex;
    align-items: center;
    gap: var(--spacing-md);
    padding: var(--spacing-md);
    background-color: var(--section-bg);
    border-radius: var(--border-radius);
}

.info-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.info-icon.center {
    background-color: var(--primary-light);
    color: var(--primary);
}

.info-icon.formation {
    background-color: var(--success-light);
    color: var(--success);
}

.info-icon.room {
    background-color: var(--warning-light);
    color: var(--warning);
}

.info-icon.time {
    background-color: var(--info-light);
    color: var(--info);
}

.info-content {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 0.95rem;
    font-weight: 500;
    color: var(--text-primary);
}

/* Formulaire */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--spacing-lg);
    margin-bottom: var(--spacing-lg);
}

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

.form-control.is-invalid {
    border-color: var(--danger);
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

.form-error {
    color: var(--danger);
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-help {
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin-top: 0.25rem;
}

/* Informations de création */
.creation-info {
    background-color: var(--section-bg);
    padding: var(--spacing-md);
    border-radius: var(--border-radius);
    margin-bottom: var(--spacing-lg);
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.info-row:last-child {
    margin-bottom: 0;
}

.info-row .info-label {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8125rem;
    font-weight: 500;
    color: var(--text-secondary);
}

.info-row .info-value {
    font-size: 0.8125rem;
    color: var(--text-primary);
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

.btn-danger {
    background-color: var(--danger);
    color: white;
}

.btn-danger:hover {
    background-color: #dc2626;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: var(--spacing-lg);
    border-top: 1px solid var(--border-color);
}

.action-group {
    display: flex;
    gap: var(--spacing-md);
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
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
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

.alert-warning {
    background-color: var(--warning-light);
    color: var(--warning);
    border: 1px solid var(--warning);
}

.slot-summary-delete {
    background-color: var(--section-bg);
    padding: var(--spacing-md);
    border-radius: var(--border-radius);
    margin-top: var(--spacing-md);
    text-align: center;
}

/* Aide contextuelle */
.help-content {
    display: grid;
    gap: var(--spacing-md);
}

.help-item h4 {
    font-size: 0.875rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.help-item p {
    font-size: 0.8125rem;
    color: var(--text-secondary);
    margin: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .planning-dashboard {
        padding: var(--spacing-md);
    }

    .page-header {
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .form-grid {
        grid-template-columns: 1fr;
    }

    .slot-info-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .action-group {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-focus sur le premier champ
    const courseSelect = document.getElementById('course_id');
    if (courseSelect) {
        courseSelect.focus();
    }

    // Animation des select au changement
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function() {
            if (this.value) {
                this.style.borderColor = 'var(--success)';
                setTimeout(() => {
                    this.style.borderColor = '';
                }, 1000);
            }
        });
    });
});

// Fonctions pour le modal de suppression
function showDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'flex';
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.style.display = 'none';
}

// Fermer le modal en cliquant à l'extérieur
document.addEventListener('click', function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        closeDeleteModal();
    }
});

// Fermer le modal avec Escape
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endpush
@endsection
