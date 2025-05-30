@extends('layouts.app')

@section('title', 'Gestion des Enseignants')

@push('styles')
<style>
    .filter-card .card-body { display: block; }
    .status-badge { padding: 0.3em 0.6em; border-radius: 0.25rem; font-size: 0.85em; font-weight: 600; color: #fff; text-align: center; }
    .status-badge.success { background-color: #28a745; }
    .status-badge.warning { background-color: #ffc107; color: #212529; }
    .status-badge.danger { background-color: #dc3545; }
    .status-badge.secondary { background-color: #6c757d; }
    .teachers-table th i.fas.fa-sort { margin-left: 5px; color: #ccc; }
    .teachers-table th.sortable:hover { cursor: pointer; background-color: #f8f9fa; }
    .action-buttons .btn-action { border-radius: 50%; width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; margin: 0 2px; border: 1px solid transparent; transition: all 0.2s ease-in-out; }
    .action-buttons .btn-action.view { color: #17a2b8; border-color: #17a2b8; }
    .action-buttons .btn-action.view:hover { background-color: #17a2b8; color: white; }
    .action-buttons .btn-action.edit { color: #28a745; border-color: #28a745; }
    .action-buttons .btn-action.edit:hover { background-color: #28a745; color: white; }
    .action-buttons .btn-action.delete { color: #dc3545; border-color: #dc3545; }
    .action-buttons .btn-action.delete:hover { background-color: #dc3545; color: white; }
    .teacher-cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem; padding: 1rem 0;}
    .teacher-card { background-color: #fff; border: 1px solid #e3e6f0; border-radius: .35rem; box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15); }
    .teacher-card-header { padding: .75rem 1.25rem; border-bottom: 1px solid #e3e6f0; display: flex; align-items: center;}
    .teacher-card-avatar img { width: 40px; height: 40px; border-radius: 50%; margin-right: .75rem; }
    .teacher-card-name { font-weight: bold; margin-bottom: .1rem; }
    .teacher-card-matricule { font-size: .8em; color: #858796; }
    .teacher-card-body { padding: 1.25rem; }
    .teacher-card-body p { margin-bottom: .5rem; font-size: .9em; }
    .teacher-card-body i { margin-right: .5em; color: #858796; width:16px; text-align:center;}
    .teacher-card-footer { padding: .75rem 1.25rem; background-color: #f8f9fc; border-top: 1px solid #e3e6f0; text-align: right; }
</style>
@endpush

@section('content')
    <div class="teachers-dashboard container-fluid">
        <div class="page-header mb-4">
            <div class="header-content">
                <h1 class="page-title h3">Gestion des Enseignants</h1>
                <p class="page-description text-muted">Gérez tous les enseignants du système.</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.teachers.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i> Ajouter un enseignant
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Enseignants</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] ?? 0 }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Enseignants Actifs</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] ?? 0 }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-user-check fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4 filter-card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-filter me-1"></i>Filtres</h6>
                 <button class="btn btn-sm btn-light filter-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="true" aria-controls="filterCollapse">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
            <div class="collapse show" id="filterCollapse">
                <div class="card-body">
                    <form action="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="search" class="form-label">Recherche générale</label>
                                <input type="text" id="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Nom, email, matricule...">
                            </div>
                            <div class="col-md-2">
                                <label for="matricule_filter" class="form-label">Matricule Spécifique</label>
                                <input type="text" id="matricule_filter" name="matricule_filter" value="{{ request('matricule_filter') }}" class="form-control form-control-sm" placeholder="Filtrer par matricule">
                            </div>
                            <div class="col-md-2">
                                <label for="status" class="form-label">Statut Compte</label>
                                <select id="status" name="status" class="form-select form-select-sm">
                                    <option value="">Tous</option>
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="gender" class="form-label">Genre (Utilisateur)</label>
                                <select id="gender" name="gender" class="form-select form-select-sm">
                                    <option value="">Tous</option>
                                    @foreach($genders as $value => $label)
                                        <option value="{{ $value }}" {{ request('gender') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="city_id" class="form-label">Ville (Profil Ens.)</label>
                                <select id="city_id" name="city_id" class="form-select form-select-sm">
                                    <option value="">Toutes</option>
                                    @foreach($cities as $id => $name)
                                        <option value="{{ $id }}" {{ request('city_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="academy_id" class="form-label">Académie</label>
                                <select id="academy_id" name="academy_id" class="form-select form-select-sm">
                                    <option value="">Toutes</option>
                                    @foreach($academies as $id => $name)
                                        <option value="{{ $id }}" {{ request('academy_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="department_id" class="form-label">Département</label>
                                <select id="department_id" name="department_id" class="form-select form-select-sm">
                                    <option value="">Tous</option>
                                    @foreach($departments as $id => $name)
                                        <option value="{{ $id }}" {{ request('department_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 text-end mt-3">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter me-1"></i>Appliquer</button>
                                <a href="{{ route('admin.teachers.index', ['locale' => app()->getLocale()]) }}" class="btn btn-secondary btn-sm"><i class="fas fa-redo-alt me-1"></i>Réinitialiser</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-list me-1"></i>Liste des Enseignants ({{ $teacherUsers->total() }})</h6>
                <div class="view-switcher">
                    <button type="button" class="btn btn-sm btn-outline-secondary view-btn active" data-view="table" title="Vue Tableau"><i class="fas fa-table"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary view-btn" data-view="grid" title="Vue Grille"><i class="fas fa-th-large"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-view">
                    <div class="table-responsive">
                        <table class="table table-hover teachers-table">
                            <thead>
                            <tr>
                                <th class="sortable" data-sort="first_name">Enseignant</th>
                                <th>Contact (Utilisateur)</th>
                                <th>Profil (Acad., Dép., Ville Ens.)</th>
                                <th class="sortable" data-sort="status">Statut Compte</th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($teacherUsers as $teacherUser)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $teacherUser->profile_photo_url }}" alt="{{ $teacherUser->full_name }}" class="rounded-circle me-2" width="40" height="40">
                                            <div>
                                                <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="fw-bold text-dark">
                                                    {{ $teacherUser->full_name }}
                                                </a>
                                                @if($teacherUser->teacherProfile && $teacherUser->teacherProfile->matricule)
                                                    <div class="text-muted small">Mat: {{ $teacherUser->teacherProfile->matricule }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small">
                                            <div><i class="fas fa-envelope fa-fw me-1 text-muted"></i>{{ $teacherUser->email }}</div>
                                            @if($teacherUser->phone_number)
                                            <div><i class="fas fa-phone fa-fw me-1 text-muted"></i>{{ $teacherUser->phone_number }}</div>
                                            @endif
                                            @if($teacherUser->gender_label)
                                            <div><i class="fas fa-venus-mars fa-fw me-1 text-muted"></i>{{ $teacherUser->gender_label }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    {{-- Section corrigée pour la vue teachers/index.blade.php --}}
<td>
    @if($teacherUser->teacherProfile)
        <div class="small">
            {{-- Academy relation --}}
            @if($teacherUser->teacherProfile->academy)
                <div><i class="fas fa-graduation-cap fa-fw me-1 text-muted"></i>{{ $teacherUser->teacherProfile->academy->name }}</div>
            @endif
            
            {{-- Department - vérifier si c'est un objet ou une string --}}
            @if($teacherUser->teacherProfile->department_id && $teacherUser->teacherProfile->department)
                <div><i class="fas fa-building fa-fw me-1 text-muted"></i>{{ $teacherUser->teacherProfile->department}}</div>
            @elseif($teacherUser->teacherProfile->department && is_string($teacherUser->teacherProfile->department))
                <div><i class="fas fa-building fa-fw me-1 text-muted"></i>{{ $teacherUser->teacherProfile->department }}</div>
            @endif
            
            {{-- City relation --}}
            @if($teacherUser->teacherProfile->city_id && $teacherUser->teacherProfile->city)
                <div><i class="fas fa-city fa-fw me-1 text-muted"></i>{{ $teacherUser->teacherProfile->city->name }}</div>
            @endif
            
            {{-- Profession --}}
            @if($teacherUser->teacherProfile->profession)
                <div><i class="fas fa-briefcase fa-fw me-1 text-muted"></i>{{ $teacherUser->teacherProfile->profession }}</div>
            @endif
        </div>
    @else
        <span class="text-muted small">Profil incomplet</span>
    @endif
</td>
                                    <td>
                                        <span class="status-badge {{ $teacherUser->status === 'active' ? 'success' : ($teacherUser->status === 'suspended' ? 'danger' : 'secondary') }}">
                                            {{ $teacherUser->status_label }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="btn-action view" title="Voir"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('admin.teachers.edit', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="btn-action edit" title="Modifier"><i class="fas fa-edit"></i></a>
                                            @if(Auth::id() !== $teacherUser->id)
                                            <form action="{{ route('admin.teachers.destroy', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action delete" title="Supprimer"><i class="fas fa-trash"></i></button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-4"><i class="fas fa-exclamation-circle fa-3x text-muted mb-2"></i><p class="text-muted">Aucun enseignant trouvé.</p></td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="grid-view" style="display: none;">
                    <div class="teacher-cards">
                        @forelse ($teacherUsers as $teacherUser)
                            <div class="teacher-card">
                                <div class="teacher-card-header">
                                    <div class="teacher-card-avatar"><img src="{{ $teacherUser->profile_photo_url }}" alt="{{ $teacherUser->full_name }}"></div>
                                    <div>
                                        <h5 class="teacher-card-name mb-0"><a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="text-dark">{{ $teacherUser->full_name }}</a></h5>
                                        @if($teacherUser->teacherProfile && $teacherUser->teacherProfile->matricule)
                                            <p class="teacher-card-matricule mb-0">Mat: {{ $teacherUser->teacherProfile->matricule }}</p>
                                        @endif
                                    </div>
                                    <span class="ms-auto status-badge {{ $teacherUser->status === 'active' ? 'success' : ($teacherUser->status === 'suspended' ? 'danger' : 'secondary') }}">{{ $teacherUser->status_label }}</span>
                                </div>
                                <div class="teacher-card-body">
                                    <p><i class="fas fa-envelope"></i>{{ $teacherUser->email }}</p>
                                    @if($teacherUser->phone_number) <p><i class="fas fa-phone"></i>{{ $teacherUser->phone_number }}</p> @endif
                                    @if($teacherUser->gender_label) <p><i class="fas fa-venus-mars"></i>{{ $teacherUser->gender_label }}</p> @endif
                                    @if($teacherUser->teacherProfile)
                                        @if($teacherUser->teacherProfile->city) <p><i class="fas fa-city"></i>Ville (Profil): {{ $teacherUser->teacherProfile->city->name }}</p> @endif
                                        @if($teacherUser->teacherProfile->profession) <p><i class="fas fa-briefcase"></i>{{ $teacherUser->teacherProfile->profession }}</p> @endif
                                        @if($teacherUser->teacherProfile->academy) <p><i class="fas fa-graduation-cap"></i>{{ $teacherUser->teacherProfile->academy->name }}</p> @endif
                                        @if($teacherUser->teacherProfile->department) <p><i class="fas fa-building"></i>{{ $teacherUser->teacherProfile->department}}</p> @endif
                                        @if($teacherUser->teacherProfile->salary) <p><i class="fas fa-money-bill-wave"></i>{{ number_format($teacherUser->teacherProfile->salary, 0, ',', ' ') }} XAF</p> @endif
                                    @endif
                                </div>
                                <div class="teacher-card-footer">
                                    <a href="{{ route('admin.teachers.show', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.teachers.edit', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" class="btn btn-sm btn-outline-success ms-1"><i class="fas fa-edit"></i></a>
                                    @if(Auth::id() !== $teacherUser->id)
                                    <form action="{{ route('admin.teachers.destroy', ['locale' => app()->getLocale(), 'teacherUser' => $teacherUser->id]) }}" method="POST" class="d-inline delete-form ms-1">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5"><i class="fas fa-exclamation-circle fa-3x text-muted mb-2"></i><p class="text-muted">Aucun enseignant.</p></div>
                        @endforelse
                    </div>
                </div>
                @if($teacherUsers->hasPages()) <div class="mt-4 d-flex justify-content-center">{{ $teacherUsers->links() }}</div> @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterToggle = document.querySelector('.filter-toggle');
    const filterCollapse = document.getElementById('filterCollapse');
    if (filterToggle && filterCollapse) {
        filterToggle.addEventListener('click', function () {
            const icon = this.querySelector('i');
            if (filterCollapse.classList.contains('show')) {
                icon.classList.remove('fa-chevron-up'); icon.classList.add('fa-chevron-down');
            } else {
                icon.classList.remove('fa-chevron-down'); icon.classList.add('fa-chevron-up');
            }
        });
        if (!filterCollapse.classList.contains('show')) {
            filterToggle.querySelector('i').classList.remove('fa-chevron-up'); filterToggle.querySelector('i').classList.add('fa-chevron-down');
        }
    }

    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const view = this.dataset.view;
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.querySelector('.table-view').style.display = view === 'table' ? 'block' : 'none';
            document.querySelector('.grid-view').style.display = view === 'grid' ? 'block' : 'none';
            localStorage.setItem('teachers-view-preference', view);
        });
    });

    const savedView = localStorage.getItem('teachers-view-preference');
    const tableView = document.querySelector('.table-view');
    const gridView = document.querySelector('.grid-view');
    const tableButton = document.querySelector('.view-btn[data-view="table"]');
    const gridButton = document.querySelector('.view-btn[data-view="grid"]');

    if (tableView && gridView && tableButton && gridButton) {
        if (savedView === 'grid') {
            tableView.style.display = 'none'; gridView.style.display = 'block';
            tableButton.classList.remove('active'); gridButton.classList.add('active');
        } else {
            tableView.style.display = 'block'; gridView.style.display = 'none';
            gridButton.classList.remove('active'); tableButton.classList.add('active');
        }
    }

    document.querySelectorAll('.teachers-table .sortable').forEach(header => {
        header.addEventListener('click', function() {
            const sortBy = this.dataset.sort;
            const currentUrl = new URL(window.location);
            const currentSort = currentUrl.searchParams.get('sort');
            const currentDirection = currentUrl.searchParams.get('direction');
            let newDirection = 'asc';
            if (currentSort === sortBy && currentDirection === 'asc') newDirection = 'desc';
            currentUrl.searchParams.set('sort', sortBy);
            currentUrl.searchParams.set('direction', newDirection);
            window.location = currentUrl.toString();
        });
    });

    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?')) e.preventDefault();
        });
    });
});
</script>
@endpush