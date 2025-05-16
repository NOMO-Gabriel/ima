<?php $__env->startSection('title', 'Gestion des Utilisateurs'); ?>

<?php $__env->startSection('content'); ?>
    <div class="users-dashboard">
        <!-- En-tête de page avec actions principales -->
        <div class="page-header">
            <div class="header-content">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>">
                        <i class="fas fa-home"></i>
                    </a>
                    <i class="fas fa-chevron-right"></i>
                    <a href="<?php echo e(route('admin.users.index', ['locale' => app()->getLocale()])); ?>">
                        Administration
                    </a>
                    <i class="fas fa-chevron-right"></i>
                    <span>Utilisateurs</span>
                </div>
                <h1 class="page-title">Gestion des Utilisateurs</h1>
                <p class="page-description">Gérez tous les utilisateurs du système avec leurs rôles et permissions.</p>
            </div>
            <div class="header-actions">
                <a href="<?php echo e(route('admin.users.create', ['locale' => app()->getLocale()])); ?>" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    <span>Ajouter un utilisateur</span>
                </a>
            </div>
        </div>

        <!-- Statistiques en une seule ligne -->
        <div class="stats-container">
            <div class="stats-card">
                <div class="stats-icon primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value"><?php echo e($usersCount ?? $users->total()); ?></h3>
                    <p class="stats-label">Total Utilisateurs</p>
                </div>
                <div class="stats-trend">
                    <div class="progress-bar primary" style="width: 100%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon success">
                    <i class="fas fa-user-check"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value"><?php echo e($activeUsersCount ?? $users->where('status', 'active')->count()); ?></h3>
                    <p class="stats-label">Utilisateurs Actifs</p>
                </div>
                <div class="stats-trend">
                    <?php
                        $activePercentage = ($users->total() > 0) ? ($users->where('status', 'active')->count() / $users->total()) * 100 : 0;
                    ?>
                    <div class="progress-bar success" style="width: <?php echo e($activePercentage); ?>%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon warning">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value"><?php echo e($pendingUsersCount ?? $users->whereIn('status', ['pending_validation', 'pending_finalization'])->count()); ?></h3>
                    <p class="stats-label">En Attente</p>
                </div>
                <div class="stats-trend">
                    <?php
                        $pendingPercentage = ($users->total() > 0) ? ($users->whereIn('status', ['pending_validation', 'pending_finalization'])->count() / $users->total()) * 100 : 0;
                    ?>
                    <div class="progress-bar warning" style="width: <?php echo e($pendingPercentage); ?>%"></div>
                </div>
            </div>

            <div class="stats-card">
                <div class="stats-icon info">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <div class="stats-content">
                    <h3 class="stats-value"><?php echo e($rolesCount ?? $roles->count()); ?></h3>
                    <p class="stats-label">Types de rôles</p>
                </div>
                <div class="stats-trend">
                    <div class="progress-bar info" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Filtres avancés -->
        <div class="card filter-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-filter"></i>Filtres
                </h2>
                <button class="btn btn-icon filter-toggle" type="button">
                    <i class="fas fa-chevron-up"></i>
                </button>
            </div>
            <div class="card-body filter-body">
                <form action="<?php echo e(route('admin.users.index', ['locale' => app()->getLocale()])); ?>" method="GET" id="filterForm">
                    <div class="filter-grid">
                        <div class="form-group">
                            <label for="role">
                                <i class="fas fa-user-tag"></i>Rôle
                            </label>
                            <div class="select-wrapper">
                                <select id="role" name="role" class="form-control">
                                    <option value="">Tous les rôles</option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($role->name); ?>" <?php echo e(request('role') == $role->name ? 'selected' : ''); ?>>
                                            <?php echo e($role->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status">
                                <i class="fas fa-user-shield"></i>Statut
                            </label>
                            <div class="select-wrapper">
                                <select id="status" name="status" class="form-control">
                                    <option value="">Tous les statuts</option>
                                    <option value="pending_validation" <?php echo e(request('status') == 'pending_validation' ? 'selected' : ''); ?>>En attente de validation</option>
                                    <option value="pending_finalization" <?php echo e(request('status') == 'pending_finalization' ? 'selected' : ''); ?>>En attente de finalisation</option>
                                    <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Actif</option>
                                    <option value="suspended" <?php echo e(request('status') == 'suspended' ? 'selected' : ''); ?>>Suspendu</option>
                                    <option value="rejected" <?php echo e(request('status') == 'rejected' ? 'selected' : ''); ?>>Rejeté</option>
                                    <option value="archived" <?php echo e(request('status') == 'archived' ? 'selected' : ''); ?>>Archivé</option>
                                </select>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="search">
                                <i class="fas fa-search"></i>Recherche
                            </label>
                            <div class="search-wrapper">
                                <input type="text" id="search" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="Nom, email ou téléphone...">
                                <button type="button" class="search-clear" <?php echo e(request('search') ? '' : 'style=display:none'); ?>>
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="filter-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Appliquer les filtres
                        </button>
                        <a href="<?php echo e(route('admin.users.index', ['locale' => app()->getLocale()])); ?>" class="btn btn-light">
                            <i class="fas fa-redo-alt"></i> Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des utilisateurs -->
        <div class="card data-card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-users"></i>Liste des utilisateurs
                </h2>
                <div class="view-actions">
                    <div class="view-switcher">
                        <button type="button" class="btn btn-icon active" id="tableViewBtn" title="Vue tableau">
                            <i class="fas fa-list"></i>
                        </button>
                        <button type="button" class="btn btn-icon" id="cardViewBtn" title="Vue cartes">
                            <i class="fas fa-th-large"></i>
                        </button>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-download"></i> Exporter
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-csv text-primary"></i>CSV</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-excel text-success"></i>Excel</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-file-pdf text-danger"></i>PDF</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <!-- Vue tableau -->
                <div class="table-view">
                    <div class="table-responsive">
                        <table class="table users-table">
                            <thead>
                            <tr>
                                <th class="sortable" data-sort="name">
                                    <span>Utilisateur</span>
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th>Contact</th>
                                <th>Rôles</th>
                                <th class="sortable" data-sort="status">
                                    <span>Statut</span>
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th class="sortable" data-sort="last_login">
                                    <span>Dernière connexion</span>
                                    <i class="fas fa-sort"></i>
                                </th>
                                <th class="text-end">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <img src="<?php echo e($user->profile_photo_url); ?>" alt="<?php echo e($user->first_name); ?>" class="avatar">
                                                <span class="user-status <?php echo e($user->is_online ? 'online' : 'offline'); ?>"></span>
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></div>
                                                <div class="user-date">
                                                    <span class="badge date-badge">
                                                        <i class="far fa-calendar-alt"></i><?php echo e($user->created_at->format('d/m/Y')); ?>

                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-contact">
                                            <div class="contact-item">
                                                <i class="fas fa-envelope"></i>
                                                <span><?php echo e($user->email); ?></span>
                                            </div>
                                            <div class="contact-item">
                                                <i class="fas fa-phone-alt"></i>
                                                <span><?php echo e($user->phone_number ?? 'Non renseigné'); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="role-badges">
                                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $roleColors = [
                                                        'admin' => 'purple',
                                                        'teacher' => 'blue',
                                                        'student' => 'teal',
                                                        'parent' => 'indigo',
                                                        'staff' => 'green'
                                                    ];
                                                    $roleColor = $roleColors[$role->name] ?? 'primary';
                                                ?>
                                                <span class="role-badge <?php echo e($roleColor); ?>"><?php echo e($role->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                            $statusInfo = [
                                                'pending_validation' => [
                                                    'class' => 'warning',
                                                    'icon' => 'hourglass-start',
                                                    'text' => 'En attente de validation'
                                                ],
                                                'pending_finalization' => [
                                                    'class' => 'info',
                                                    'icon' => 'hourglass-half',
                                                    'text' => 'En attente de finalisation'
                                                ],
                                                'active' => [
                                                    'class' => 'success',
                                                    'icon' => 'check-circle',
                                                    'text' => 'Actif'
                                                ],
                                                'suspended' => [
                                                    'class' => 'danger',
                                                    'icon' => 'ban',
                                                    'text' => 'Suspendu'
                                                ],
                                                'rejected' => [
                                                    'class' => 'secondary',
                                                    'icon' => 'times-circle',
                                                    'text' => 'Rejeté'
                                                ],
                                                'archived' => [
                                                    'class' => 'dark',
                                                    'icon' => 'archive',
                                                    'text' => 'Archivé'
                                                ]
                                            ];
                                            $status = $statusInfo[$user->status];
                                        ?>
                                        <div class="status-badge <?php echo e($status['class']); ?>">
                                            <i class="fas fa-<?php echo e($status['icon']); ?>"></i>
                                            <span><?php echo e($status['text']); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="login-info">
                                            <?php if($user->last_login_at): ?>
                                                <div class="login-time">
                                                    <i class="far fa-clock"></i>
                                                    <?php echo e($user->last_login_at->format('d/m/Y H:i')); ?>

                                                </div>
                                                <?php if($user->last_login_at->diffInDays() < 7): ?>
                                                    <span class="recent-badge">récent</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="login-time never">
                                                    <i class="fas fa-ban"></i>
                                                    Jamais connecté
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?php echo e(route('admin.users.show', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>" class="btn-action view" title="Voir le profil">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.users.edit', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>" class="btn-action edit" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <div class="dropdown d-inline-block">
                                                <button class="btn-action more" type="button" data-bs-toggle="dropdown" title="Plus d'options">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fas fa-user-shield text-primary"></i>Détails de sécurité
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="<?php echo e(route('dashboard', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>">
                                                            <i class="fas fa-key text-primary"></i>Permissions
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="<?php echo e(route('dashboard', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>">
                                                            <i class="fas fa-history text-primary"></i>Historique d'activité
                                                        </a>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <?php if($user->status === 'active'): ?>
                                                        <li>
                                                            <form action="<?php echo e(route('dashboard', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>" method="POST" class="dropdown-form">
                                                                <?php echo csrf_field(); ?>
                                                                <button type="submit" class="dropdown-item text-warning">
                                                                    <i class="fas fa-ban"></i>Suspendre
                                                                </button>
                                                            </form>
                                                        </li>
                                                    <?php elseif($user->status === 'suspended'): ?>
                                                        <li>
                                                            <form action="<?php echo e(route('dashboard', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>" method="POST" class="dropdown-form">
                                                                <?php echo csrf_field(); ?>
                                                                <button type="submit" class="dropdown-item text-success">
                                                                    <i class="fas fa-check-circle"></i>Réactiver
                                                                </button>
                                                            </form>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if(auth()->id() !== $user->id): ?>
                                                        <li>
                                                            <form action="<?php echo e(route('admin.users.destroy', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>" method="POST" class="dropdown-form delete-form">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                                <button type="submit" class="dropdown-item text-danger">
                                                                    <i class="fas fa-trash"></i>Supprimer
                                                                </button>
                                                            </form>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state">
                                            <div class="empty-icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <h4>Aucun utilisateur trouvé</h4>
                                            <p>Essayez de modifier vos filtres ou d'ajouter un nouvel utilisateur.</p>
                                            <div class="empty-actions">
                                                <a href="<?php echo e(route('admin.users.index', ['locale' => app()->getLocale()])); ?>" class="btn btn-light">
                                                    <i class="fas fa-filter"></i>Réinitialiser les filtres
                                                </a>
                                                <a href="<?php echo e(route('admin.users.create', ['locale' => app()->getLocale()])); ?>" class="btn btn-primary">
                                                    <i class="fas fa-user-plus"></i>Ajouter un utilisateur
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Vue cartes -->
                <div class="card-view" style="display: none;">
                    <div class="user-cards">
                        <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="user-card">
                                <div class="user-card-header">
                                    <div class="user-card-avatar">
                                        <img src="<?php echo e($user->profile_photo_url); ?>" alt="<?php echo e($user->first_name); ?>">
                                        <span class="user-status <?php echo e($user->is_online ? 'online' : 'offline'); ?>"></span>
                                    </div>
                                    <div class="user-card-info">
                                        <h3 class="user-card-name"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></h3>
                                        <div class="user-card-roles">
                                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $roleColors = [
                                                        'admin' => 'purple',
                                                        'teacher' => 'blue',
                                                        'student' => 'teal',
                                                        'parent' => 'indigo',
                                                        'staff' => 'green'
                                                    ];
                                                    $roleColor = $roleColors[$role->name] ?? 'primary';
                                                ?>
                                                <span class="role-badge small <?php echo e($roleColor); ?>"><?php echo e($role->name); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                    <div class="user-card-status">
                                        <?php
                                            $status = $statusInfo[$user->status];
                                        ?>
                                        <span class="status-indicator <?php echo e($status['class']); ?>">
                                        <i class="fas fa-<?php echo e($status['icon']); ?>"></i>
                                    </span>
                                    </div>
                                </div>
                                <div class="user-card-body">
                                    <div class="user-card-detail">
                                        <i class="fas fa-envelope"></i>
                                        <span><?php echo e($user->email); ?></span>
                                    </div>
                                    <div class="user-card-detail">
                                        <i class="fas fa-phone-alt"></i>
                                        <span><?php echo e($user->phone_number ?? 'Non renseigné'); ?></span>
                                    </div>
                                    <div class="user-card-detail">
                                        <i class="far fa-calendar-alt"></i>
                                        <span>Créé le <?php echo e($user->created_at->format('d/m/Y')); ?></span>
                                    </div>
                                    <div class="user-card-detail">
                                        <i class="far fa-clock"></i>
                                        <span>
                                        <?php if($user->last_login_at): ?>
                                                Dernière connexion le <?php echo e($user->last_login_at->format('d/m/Y H:i')); ?>

                                                <?php if($user->last_login_at->diffInDays() < 7): ?>
                                                    <span class="recent-badge small">récent</span>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                Jamais connecté
                                            <?php endif; ?>
                                    </span>
                                    </div>
                                </div>
                                <div class="user-card-footer">
                                    <a href="<?php echo e(route('admin.users.show', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>" class="user-card-btn view" title="Voir le profil">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('admin.users.edit', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>" class="user-card-btn edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="user-card-btn more" type="button" data-bs-toggle="dropdown" title="Plus d'options">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <!-- Mêmes options que dans la vue tableau -->
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-user-shield text-primary"></i>Détails de sécurité
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('dashboard', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>">
                                                    <i class="fas fa-key text-primary"></i>Permissions
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('dashboard', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>">
                                                    <i class="fas fa-history text-primary"></i>Historique d'activité
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <?php if($user->status === 'active'): ?>
                                                <li>
                                                    <form action="<?php echo e(route('dashboard', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>" method="POST" class="dropdown-form">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="dropdown-item text-warning">
                                                            <i class="fas fa-ban"></i>Suspendre
                                                        </button>
                                                    </form>
                                                </li>
                                            <?php elseif($user->status === 'suspended'): ?>
                                                <li>
                                                    <form action="<?php echo e(route('admin.users.activate', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>" method="POST" class="dropdown-form">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="dropdown-item text-success">
                                                            <i class="fas fa-check-circle"></i>Réactiver
                                                        </button>
                                                    </form>
                                                </li>
                                            <?php endif; ?>
                                            <?php if(auth()->id() !== $user->id): ?>
                                                <li>
                                                    <form action="<?php echo e(route('admin.users.destroy', ['locale' => app()->getLocale(), 'user' => $user->id])); ?>" method="POST" class="dropdown-form delete-form">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash"></i>Supprimer
                                                        </button>
                                                    </form>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4>Aucun utilisateur trouvé</h4>
                                <p>Essayez de modifier vos filtres ou d'ajouter un nouvel utilisateur.</p>
                                <div class="empty-actions">
                                    <a href="<?php echo e(route('admin.users.index', ['locale' => app()->getLocale()])); ?>" class="btn btn-light">
                                        <i class="fas fa-filter"></i>Réinitialiser les filtres
                                    </a>
                                    <a href="<?php echo e(route('admin.users.create', ['locale' => app()->getLocale()])); ?>" class="btn btn-primary">
                                        <i class="fas fa-user-plus"></i>Ajouter un utilisateur
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php if($users->hasPages()): ?>
                <div class="card-footer">
                    <div class="pagination-info">
                        Affichage de <span><?php echo e($users->firstItem() ?? 0); ?></span> à <span><?php echo e($users->lastItem() ?? 0); ?></span> sur <span><?php echo e($users->total()); ?></span> utilisateurs
                    </div>
                    <div class="pagination-controls">
                        <ul class="pagination">
                            
                            <?php if($users->onFirstPage()): ?>
                                <li class="disabled">
                                    <span><i class="fas fa-chevron-left"></i></span>
                                </li>
                            <?php else: ?>
                                <li>
                                    <a href="<?php echo e($users->previousPageUrl()); ?>" rel="prev">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            
                            <?php
                                $currentPage = $users->currentPage();
                                $lastPage = $users->lastPage();
                                $window = 2; // Nombre de pages à afficher autour de la page courante

                                $start = max(1, $currentPage - $window);
                                $end = min($lastPage, $currentPage + $window);

                                // Ajuster les valeurs pour toujours afficher 5 pages (si possible)
                                if ($end - $start + 1 < 5 && $lastPage >= 5) {
                                    if ($start === 1) {
                                        $end = min($lastPage, 5);
                                    } elseif ($end === $lastPage) {
                                        $start = max(1, $lastPage - 4);
                                    }
                                }
                            ?>

                            
                            <?php if($start > 1): ?>
                                <li>
                                    <a href="<?php echo e($users->url(1)); ?>">1</a>
                                </li>
                                <?php if($start > 2): ?>
                                    <li class="dots">
                                        <span>...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>

                            
                            <?php for($i = $start; $i <= $end; $i++): ?>
                                <li class="<?php echo e($i == $currentPage ? 'active' : ''); ?>">
                                    <a href="<?php echo e($users->url($i)); ?>"><?php echo e($i); ?></a>
                                </li>
                            <?php endfor; ?>

                            
                            <?php if($end < $lastPage): ?>
                                <?php if($end < $lastPage - 1): ?>
                                    <li class="dots">
                                        <span>...</span>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a href="<?php echo e($users->url($lastPage)); ?>"><?php echo e($lastPage); ?></a>
                                </li>
                            <?php endif; ?>

                            
                            <?php if($users->hasMorePages()): ?>
                                <li>
                                    <a href="<?php echo e($users->nextPageUrl()); ?>" rel="next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="disabled">
                                    <span><i class="fas fa-chevron-right"></i></span>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Variables de couleurs basées sur la charte fournie */
        :root {
            /* Couleurs principales */
            --primary: #4CA3DD;
            --primary-dark: #2A7AB8;
            --primary-light: rgba(76, 163, 221, 0.1);

            /* Mode clair */
            --body-bg: #F8FAFC;
            --card-bg: #FFFFFF;
            --section-bg: #EEF2F7;
            --text-primary: #1E293B;
            --text-secondary: #64748B;
            --border-color: #E2E8F0;

            /* Notifications par type */
            --success: #34D399;
            --success-light: rgba(52, 211, 153, 0.1);
            --info: #60A5FA;
            --info-light: rgba(96, 165, 250, 0.1);
            --warning: #FBBF24;
            --warning-light: rgba(251, 191, 36, 0.1);
            --danger: #F87171;
            --danger-light: rgba(248, 113, 113, 0.1);
            --secondary: #64748B;
            --secondary-light: rgba(100, 116, 139, 0.1);

            /* Variables d'espacement */
            --spacing-xs: 0.25rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
            --spacing-xl: 2rem;

            /* Variables de bordures */
            --border-radius-sm: 0.25rem;
            --border-radius: 0.5rem;
            --border-radius-lg: 0.75rem;
            --border-radius-xl: 1rem;

            /* Variables d'ombres */
            /* Variables d'ombres */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
        }

        /* Dark mode variables */
        .dark-mode {
            --body-bg: #1E293B;
            --card-bg: #2C3E50;
            --section-bg: #334155;
            --text-primary: #F1F5F9;
            --text-secondary: #94A3B8;
            --border-color: #475569;
        }

        /* Global styles */
        body {
            background-color: var(--body-bg);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Layout */
        .users-dashboard {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-lg);
            padding: var(--spacing-lg);
            max-width: 1600px;
            margin: 0 auto;
        }

        /* Page header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: var(--spacing-md);
        }

        .header-content {
            flex: 1;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin-bottom: var(--spacing-sm);
        }

        .breadcrumb a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb a:hover {
            color: var(--primary);
        }

        .breadcrumb i {
            font-size: 0.75rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 var(--spacing-xs) 0;
            color: var(--text-primary);
        }

        .page-description {
            color: var(--text-secondary);
            margin: 0;
            font-size: 0.95rem;
        }

        .header-actions {
            display: flex;
            gap: var(--spacing-md);
        }

        /* Boutons */
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
        }

        .btn i {
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            box-shadow: var(--shadow-md);
        }

        .btn-light {
            background-color: var(--section-bg);
            color: var(--text-primary);
        }

        .btn-light:hover {
            background-color: var(--border-color);
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--border-radius);
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
            display: flex;
            flex-direction: column;
            box-shadow: var(--shadow);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stats-card-inner {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: var(--spacing-sm);
        }

        .stats-icon.primary {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .stats-icon.success {
            background-color: var(--success-light);
            color: var(--success);
        }

        .stats-icon.warning {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .stats-icon.info {
            background-color: var(--info-light);
            color: var(--info);
        }

        .stats-content {
            flex: 1;
        }

        .stats-value {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0 0 var(--spacing-xs) 0;
            line-height: 1;
        }

        .stats-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin: 0;
        }

        .stats-trend {
            margin-top: auto;
            padding-top: var(--spacing-sm);
        }

        .progress-bar {
            height: 4px;
            border-radius: 2px;
            background-color: var(--primary-light);
            overflow: hidden;
            position: relative;
        }

        .progress-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            border-radius: 2px;
            background-color: var(--primary);
        }

        .progress-bar.primary::before {
            background-color: var(--primary);
        }

        .progress-bar.success::before {
            background-color: var(--success);
        }

        .progress-bar.warning::before {
            background-color: var(--warning);
        }

        .progress-bar.info::before {
            background-color: var(--info);
        }

        /* Cards génériques */
        .card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
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

        .card-footer {
            padding: var(--spacing-md) var(--spacing-lg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid var(--border-color);
        }

        /* Filter card */
        .filter-card {
            background-color: var(--card-bg);
        }

        .filter-toggle {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.2s;
        }

        .filter-toggle:hover {
            color: var(--primary);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: var(--spacing-md);
        }

        .form-group {
            margin-bottom: var(--spacing-md);
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            margin-bottom: var(--spacing-xs);
            font-weight: 500;
            color: var(--text-secondary);
        }

        .form-group label i {
            color: var(--primary);
        }

        .form-control {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            background-color: var(--card-bg);
            color: var(--text-primary);
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        /* Select wrapper */
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

        .filter-actions {
            display: flex;
            gap: var(--spacing-md);
            margin-top: var(--spacing-md);
            justify-content: flex-end;
        }

        .filter-actions .btn {
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .filter-actions .btn-primary {
            background-color: var(--primary);
            color: white;
            border: 1px solid var(--primary);
        }

        .filter-actions .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            box-shadow: var(--shadow-md);
        }

        .filter-actions .btn-light {
            background-color: var(--section-bg);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .filter-actions .btn-light:hover {
            background-color: var(--border-color);
        }

        /* Search wrapper */
        .search-wrapper {
            position: relative;
        }

        .search-wrapper input {
            padding-right: 4rem;
        }

        .search-clear {
            position: absolute;
            top: 50%;
            right: 2.5rem;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.2s;
        }

        .search-clear:hover {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .search-button {
            position: absolute;
            top: 50%;
            right: 0.5rem;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--primary);
            cursor: pointer;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Data card and view actions */
        .data-card {
            background-color: var(--card-bg);
        }

        .view-actions {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }

        .view-switcher {
            display: flex;
            border-radius: var(--border-radius);
            overflow: hidden;
            margin-right: var(--spacing-sm);
        }

        .view-switcher .btn {
            border-radius: 0;
            background-color: var(--section-bg);
        }

        .view-switcher .btn.active {
            background-color: var(--primary);
            color: white;
        }

        /* Table style */
        .users-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .users-table th {
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

        .users-table th.sortable {
            cursor: pointer;
            user-select: none;
        }

        .users-table th.sortable:hover {
            background-color: var(--primary-light);
        }

        .users-table th.sortable span {
            margin-right: var(--spacing-xs);
        }

        .users-table td {
            padding: var(--spacing-md);
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .users-table tr:last-child td {
            border-bottom: none;
        }

        .users-table tr:hover td {
            background-color: var(--primary-light);
        }

        /* User info */
        .user-info {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }

        .user-avatar {
            position: relative;
            flex-shrink: 0;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--card-bg);
            box-shadow: var(--shadow-sm);
        }

        .user-status {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid var(--card-bg);
        }

        .user-status.online {
            background-color: var(--success);
        }

        .user-status.offline {
            background-color: var(--text-secondary);
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: var(--spacing-xs);
        }

        .user-date {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
        }

        .date-badge {
            display: inline-flex;
            align-items: center;
            font-size: 0.75rem;
            padding: 0.125rem 0.5rem;
            border-radius: var(--border-radius-sm);
            background-color: var(--section-bg);
            color: var(--text-secondary);
        }

        .date-badge i {
            margin-right: var(--spacing-xs);
            font-size: 0.75rem;
        }

        /* Contact info */
        .user-contact {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-xs);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            font-size: 0.875rem;
        }

        .contact-item i {
            color: var(--text-secondary);
            width: 16px;
        }

        /* Role badges */
        .role-badges {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-xs);
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            height: 24px;
            padding: 0 0.625rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 12px;
            white-space: nowrap;
        }

        .role-badge.primary {
            background-color: var(--primary-light);
            color: var(--primary);
        }

        .role-badge.purple {
            background-color: rgba(147, 51, 234, 0.1);
            color: rgb(126, 34, 206);
        }

        .role-badge.blue {
            background-color: rgba(59, 130, 246, 0.1);
            color: rgb(37, 99, 235);
        }

        .role-badge.teal {
            background-color: rgba(20, 184, 166, 0.1);
            color: rgb(13, 148, 136);
        }

        .role-badge.indigo {
            background-color: rgba(99, 102, 241, 0.1);
            color: rgb(79, 70, 229);
        }

        .role-badge.green {
            background-color: rgba(34, 197, 94, 0.1);
            color: rgb(22, 163, 74);
        }

        .role-badge.small {
            height: 20px;
            font-size: 0.7rem;
            padding: 0 0.375rem;
        }

        /* Status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            height: 26px;
            padding: 0 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 13px;
            white-space: nowrap;
        }

        .status-badge.success {
            background-color: var(--success-light);
            color: var(--success);
        }

        .status-badge.warning {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .status-badge.info {
            background-color: var(--info-light);
            color: var(--info);
        }

        .status-badge.danger {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .status-badge.secondary {
            background-color: var(--secondary-light);
            color: var(--secondary);
        }

        .status-badge.dark {
            background-color: rgba(30, 41, 59, 0.1);
            color: rgb(71, 85, 105);
        }

        .status-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            font-size: 0.75rem;
        }

        .status-indicator.success {
            background-color: var(--success-light);
            color: var(--success);
        }

        .status-indicator.warning {
            background-color: var(--warning-light);
            color: var(--warning);
        }

        .status-indicator.info {
            background-color: var(--info-light);
            color: var(--info);
        }

        .status-indicator.danger {
            background-color: var(--danger-light);
            color: var(--danger);
        }

        .status-indicator.secondary {
            background-color: var(--secondary-light);
            color: var(--secondary);
        }

        .status-indicator.dark {
            background-color: rgba(30, 41, 59, 0.1);
            color: rgb(71, 85, 105);
        }

        /* Login info */
        .login-info {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-xs);
        }

        .login-time {
            display: flex;
            align-items: center;
            gap: var(--spacing-xs);
            font-size: 0.875rem;
        }

        .login-time i {
            color: var(--text-secondary);
        }

        .login-time.never {
            color: var(--text-secondary);
        }

        .recent-badge {
            display: inline-flex;
            align-items: center;
            height: 18px;
            padding: 0 0.375rem;
            font-size: 0.7rem;
            font-weight: 600;
            border-radius: 9px;
            background-color: var(--success-light);
            color: var(--success);
        }

        .recent-badge.small {
            height: 16px;
            font-size: 0.625rem;
            padding: 0 0.25rem;
        }

        /* Action buttons */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: var(--spacing-xs);
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
            background-color: var(--success-light);
            color: var(--success);
        }

        .btn-action.more:hover {
            background-color: var(--secondary-light);
        }

        /* Card view */
        .user-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: var(--spacing-md);
            padding: var(--spacing-md);
        }

        .user-card {
            background-color: var(--card-bg);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            border: 1px solid var(--border-color);
        }

        .user-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .user-card-header {
            padding: var(--spacing-md);
            display: flex;
            position: relative;
            border-bottom: 1px solid var(--border-color);
        }

        .user-card-avatar {
            position: relative;
            margin-right: var(--spacing-md);
        }

        .user-card-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--card-bg);
            box-shadow: var(--shadow-sm);
        }

        .user-card-info {
            flex: 1;
        }

        .user-card-name {
            font-size: 1rem;
            font-weight: 600;
            margin: 0 0 var(--spacing-xs) 0;
        }

        .user-card-roles {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-xs);
        }

        .user-card-status {
            position: absolute;
            top: var(--spacing-md);
            right: var(--spacing-md);
        }

        .user-card-body {
            padding: var(--spacing-md);
        }

        .user-card-detail {
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-sm);
            font-size: 0.875rem;
        }

        .user-card-detail i {
            width: 16px;
            margin-right: var(--spacing-md);
            color: var(--text-secondary);
        }

        .user-card-footer {
            padding: var(--spacing-sm);
            display: flex;
            justify-content: flex-end;
            gap: var(--spacing-sm);
            background-color: var(--section-bg);
        }

        .user-card-btn {
            width: 36px;
            height: 36px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--card-bg);
            color: var(--text-secondary);
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .user-card-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .user-card-btn.view:hover {
            background-color: var(--info-light);
            color: var(--info);
        }

        .user-card-btn.edit:hover {
            background-color: var(--success-light);
            color: var(--success);
        }

        /* Empty state */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: var(--spacing-xl) var(--spacing-lg);
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

        /* Style pour le conteneur de pagination */
        .card-footer {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
        }

        /* Style pour l'info de pagination */
        .pagination-info {
            font-size: 0.875rem;
            color: #64748B;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .pagination-info span {
            font-weight: 600;
            color: #1E293B;
        }

        /* Theme sombre pour l'info de pagination */
        .dark-mode .pagination-info {
            color: #94A3B8;
        }

        .dark-mode .pagination-info span {
            color: #F1F5F9;
        }

        /* Style pour les contrôles de pagination */
        .pagination-controls {
            display: flex;
            justify-content: center;
            width: 100%;
        }

        /* Style pour la pagination de Laravel */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 0.5rem;
            justify-content: center;
        }

        .pagination li {
            margin: 0;
        }

        .pagination li > * {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            font-size: 0.875rem;
            font-weight: 500;
            border-radius: 50%; /* Forme circulaire */
            text-decoration: none;
            transition: all 0.2s ease;
        }

        /* Style pour le mode clair */
        .pagination li > * {
            color: #1E293B;
            background-color: #FFFFFF;
            border: 1px solid #E2E8F0;
        }

        .pagination li.active > * {
            color: #FFFFFF;
            background-color: #4CA3DD;
            border-color: #4CA3DD;
            box-shadow: 0 2px 4px rgba(76, 163, 221, 0.3);
        }

        .pagination li.disabled > * {
            color: #94A3B8;
            background-color: #F8FAFC;
            border-color: #E2E8F0;
            pointer-events: none;
            opacity: 0.6;
        }

        .pagination li > *:hover:not(.active):not(.disabled) {
            color: #4CA3DD;
            border-color: #4CA3DD;
            background-color: rgba(76, 163, 221, 0.1);
            transform: translateY(-2px);
        }

        /* Style pour le mode sombre */
        .dark-mode .pagination li > * {
            color: #F1F5F9;
            background-color: #334155;
            border-color: #475569;
        }

        .dark-mode .pagination li.active > * {
            color: #FFFFFF;
            background-color: #4CA3DD;
            border-color: #2A7AB8;
            box-shadow: 0 2px 4px rgba(42, 122, 184, 0.3);
        }

        .dark-mode .pagination li.disabled > * {
            color: #64748B;
            background-color: #1E293B;
            border-color: #334155;
            opacity: 0.6;
        }

        .dark-mode .pagination li > *:hover:not(.active):not(.disabled) {
            color: #4CA3DD;
            border-color: #4CA3DD;
            background-color: rgba(76, 163, 221, 0.15);
            transform: translateY(-2px);
        }

        /* Style spécifique pour les chevrons de navigation */
        .pagination svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
        }

        /* Animation et feedback au clic */
        .pagination li > *:active {
            transform: translateY(1px);
        }

        /* Style pour les points de suspension */
        .pagination .dots {
            display: flex;
            align-items: center;
            justify-content: center;
            width: auto;
            padding: 0 8px;
            border: none;
            background: none;
        }

        /* Pagination responsive */
        @media (max-width: 576px) {
            .page-item .page-link,
            .page-item .page-text {
                min-width: 34px;
                height: 34px;
                padding: 0 0.5rem;
                font-size: 0.8125rem;
            }

            /* Cacher certains numéros de page sur mobile */
            .pagination-extended-numbers {
                display: none;
            }
        }

        /* Responsive adaptations */
        @media (max-width: 1200px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .user-cards {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .filter-actions {
                flex-direction: column;
                width: 100%;
            }

            .filter-actions .btn {
                width: 100%;
            }

            .card-footer {
                padding: 0.75rem;
            }

            .pagination li > * {
                width: 36px;
                height: 36px;
                font-size: 0.8125rem;
            }

            .page-header {
                flex-direction: column;
            }

            .header-actions {
                margin-top: var(--spacing-md);
                width: 100%;
                justify-content: flex-start;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .view-actions {
                margin-top: var(--spacing-md);
                width: 100%;
                justify-content: space-between;
            }

            .user-cards {
                grid-template-columns: 1fr;
            }

            .card-footer {
                flex-direction: column;
                gap: var(--spacing-md);
            }
        }

        @media (max-width: 576px) {
            .pagination li > * {
                width: 32px;
                height: 32px;
                font-size: 0.75rem;
            }

            /* Sur mobile, on garde seulement certains éléments pour économiser l'espace */
            .pagination li:not(:first-child):not(:last-child):not(.active) {
                display: none;
            }

            .pagination li:nth-child(2):not(.active),
            .pagination li:nth-last-child(2):not(.active) {
                display: block;
            }

            .users-dashboard {
                padding: var(--spacing-sm);
            }

            .users-table th:nth-child(3),
            .users-table td:nth-child(3),
            .users-table th:nth-child(4),
            .users-table td:nth-child(4) {
                display: none;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Vue tableau/cartes toggle
            const tableViewBtn = document.getElementById('tableViewBtn');
            const cardViewBtn = document.getElementById('cardViewBtn');
            const tableView = document.querySelector('.table-view');
            const cardView = document.querySelector('.card-view');

            if (tableViewBtn && cardViewBtn && tableView && cardView) {
                tableViewBtn.addEventListener('click', function() {
                    tableView.style.display = 'block';
                    cardView.style.display = 'none';
                    tableViewBtn.classList.add('active');
                    cardViewBtn.classList.remove('active');
                    localStorage.setItem('users-view', 'table');
                });

                cardViewBtn.addEventListener('click', function() {
                    tableView.style.display = 'none';
                    cardView.style.display = 'block';
                    cardViewBtn.classList.add('active');
                    tableViewBtn.classList.remove('active');
                    localStorage.setItem('users-view', 'card');
                });

                // Restaurer la préférence d'affichage
                const savedView = localStorage.getItem('users-view');
                if (savedView === 'card') {
                    cardViewBtn.click();
                }
            }

            // Toggle des filtres
            const filterToggle = document.querySelector('.filter-toggle');
            const filterBody = document.querySelector('.filter-body');

            if (filterToggle && filterBody) {
                filterToggle.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (icon.classList.contains('fa-chevron-up')) {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    } else {
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    }

                    if (filterBody.style.display === 'none') {
                        filterBody.style.display = 'block';
                        localStorage.setItem('users-filter-visible', 'true');
                    } else {
                        filterBody.style.display = 'none';
                        localStorage.setItem('users-filter-visible', 'false');
                    }
                });

                // Restaurer l'état des filtres
                const filtersVisible = localStorage.getItem('users-filter-visible');
                if (filtersVisible === 'false') {
                    filterBody.style.display = 'none';
                    const icon = filterToggle.querySelector('i');
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            }

            // Gestion du bouton d'effacement de la recherche
            const searchInput = document.getElementById('search');
            const searchClear = document.querySelector('.search-clear');

            if (searchInput && searchClear) {
                searchInput.addEventListener('input', function() {
                    if (this.value) {
                        searchClear.style.display = 'flex';
                    } else {
                        searchClear.style.display = 'none';
                    }
                });

                searchClear.addEventListener('click', function() {
                    searchInput.value = '';
                    searchClear.style.display = 'none';
                    // Focus l'input après le nettoyage
                    searchInput.focus();
                });
            }

            // Gestion des confirmations de suppression
            const deleteForms = document.querySelectorAll('.delete-form');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Utiliser SweetAlert2 si disponible, sinon confirmation standard
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Êtes-vous sûr?',
                            text: "Cette action est irréversible!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#f87171',
                            cancelButtonColor: '#64748b',
                            confirmButtonText: 'Oui, supprimer',
                            cancelButtonText: 'Annuler'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    } else {
                        if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                            this.submit();
                        }
                    }
                });
            });

            // Gestion du tri des colonnes
            const sortableColumns = document.querySelectorAll('th.sortable');
            sortableColumns.forEach(column => {
                column.addEventListener('click', function() {
                    const sortField = this.dataset.sort;
                    let sortDirection = 'asc';

                    // Vérifier la direction de tri actuelle
                    const icon = this.querySelector('i');
                    if (icon.classList.contains('fa-sort-up')) {
                        sortDirection = 'desc';
                        icon.classList.remove('fa-sort', 'fa-sort-up');
                        icon.classList.add('fa-sort-down');
                    } else if (icon.classList.contains('fa-sort-down')) {
                        sortDirection = '';
                        icon.classList.remove('fa-sort-down');
                        icon.classList.add('fa-sort');
                    } else {
                        icon.classList.remove('fa-sort');
                        icon.classList.add('fa-sort-up');
                    }

                    // Réinitialiser les autres icônes
                    sortableColumns.forEach(otherColumn => {
                        if (otherColumn !== column) {
                            const otherIcon = otherColumn.querySelector('i');
                            otherIcon.className = 'fas fa-sort';
                        }
                    });

                    // Construire l'URL avec les paramètres de tri
                    const currentUrl = new URL(window.location);
                    if (sortDirection) {
                        currentUrl.searchParams.set('sort', sortField);
                        currentUrl.searchParams.set('direction', sortDirection);
                    } else {
                        currentUrl.searchParams.delete('sort');
                        currentUrl.searchParams.delete('direction');
                    }

                    // Rediriger vers la nouvelle URL
                    window.location.href = currentUrl.toString();
                });
            });

            // Initialiser les icônes de tri en fonction des paramètres actuels de l'URL
            const urlParams = new URLSearchParams(window.location.search);
            const sortField = urlParams.get('sort');
            const sortDirection = urlParams.get('direction');

            if (sortField && sortDirection) {
                const column = document.querySelector(`th.sortable[data-sort="${sortField}"]`);
                if (column) {
                    const icon = column.querySelector('i');
                    icon.classList.remove('fa-sort');

                    if (sortDirection === 'asc') {
                        icon.classList.add('fa-sort-up');
                    } else {
                        icon.classList.add('fa-sort-down');
                    }
                }
            }

            // Gestion du thème clair/sombre
            const themeSwitcher = document.getElementById('theme-switcher');
            if (themeSwitcher) {
                themeSwitcher.addEventListener('click', function() {
                    document.body.classList.toggle('dark-mode');

                    const isDarkMode = document.body.classList.contains('dark-mode');
                    localStorage.setItem('dark-mode', isDarkMode ? 'true' : 'false');

                    // Mettre à jour l'icône
                    const icon = this.querySelector('i');
                    if (isDarkMode) {
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    } else {
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                    }
                });

                // Appliquer le thème sauvegardé
                const savedTheme = localStorage.getItem('dark-mode');
                if (savedTheme === 'true') {
                    document.body.classList.add('dark-mode');
                    const icon = themeSwitcher.querySelector('i');
                    if (icon) {
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                    }
                }
            }

            // Initialisation des tooltips Bootstrap si disponible
            if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        boundary: document.body
                    });
                });
            }

            // Animations lors du chargement
            const animateElements = document.querySelectorAll('.animate-on-load');
            if (animateElements.length > 0) {
                setTimeout(() => {
                    animateElements.forEach((el, index) => {
                        setTimeout(() => {
                            el.classList.add('animate-complete');
                        }, index * 100);
                    });
                }, 300);
            }

            // Afficher une notification de toast après une action réussie
            const showToast = (message, type = 'success') => {
                // Vérifier si la div des toasts existe, sinon la créer
                let toastContainer = document.getElementById('toast-container');
                if (!toastContainer) {
                    toastContainer = document.createElement('div');
                    toastContainer.id = 'toast-container';
                    toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                    document.body.appendChild(toastContainer);
                }

                // Créer un nouvel élément toast
                const toast = document.createElement('div');
                toast.className = `toast ${type} show`;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');

                // Ajouter l'icône appropriée
                let icon = 'check-circle';
                if (type === 'error') icon = 'exclamation-circle';
                if (type === 'warning') icon = 'exclamation-triangle';
                if (type === 'info') icon = 'info-circle';

                // Construire le HTML du toast
                toast.innerHTML = `
                <div class="toast-header">
                    <i class="fas fa-${icon} me-2"></i>
                    <strong class="me-auto">Notification</strong>
                    <small>À l'instant</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            `;

                // Ajouter le toast au conteneur
                toastContainer.appendChild(toast);

                // Gérer la fermeture manuelle
                const closeBtn = toast.querySelector('.btn-close');
                closeBtn.addEventListener('click', () => {
                    toast.classList.remove('show');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                });

                // Fermer automatiquement après 5 secondes
                setTimeout(() => {
                    toast.classList.remove('show');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }, 5000);
            };

            // Vérifier s'il y a un message flash dans la session
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                const message = flashMessage.getAttribute('data-message');
                const type = flashMessage.getAttribute('data-type') || 'success';
                if (message) {
                    showToast(message, type);
                }
            }

            // Gestion de la réinitialisation des filtres
            const filterResetBtn = document.querySelector('.filter-actions .btn-light');
            if (filterResetBtn) {
                filterResetBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Réinitialiser tous les champs de formulaire
                    const roleSelect = document.getElementById('role');
                    const statusSelect = document.getElementById('status');
                    const searchInput = document.getElementById('search');

                    if (roleSelect) roleSelect.value = '';
                    if (statusSelect) statusSelect.value = '';
                    if (searchInput) {
                        searchInput.value = '';
                        const searchClear = document.querySelector('.search-clear');
                        if (searchClear) searchClear.style.display = 'none';
                    }

                    // Rediriger vers la page sans paramètres
                    window.location.href = this.getAttribute('href');
                });
            }

            // Validation du formulaire avant soumission
            const filterForm = document.getElementById('filterForm');
            if (filterForm) {
                filterForm.addEventListener('submit', function(e) {
                    // Supprimer les champs vides pour éviter d'avoir des paramètres vides dans l'URL
                    const inputs = this.querySelectorAll('input, select');
                    let hasFilters = false;

                    inputs.forEach(input => {
                        if (input.value.trim() === '') {
                            input.disabled = true;
                        } else {
                            hasFilters = true;
                        }
                    });

                    // Si aucun filtre n'est appliqué, rediriger simplement vers la page sans paramètres
                    if (!hasFilters) {
                        e.preventDefault();
                        window.location.href = "<?php echo e(route('admin.users.index', ['locale' => app()->getLocale()])); ?>";
                    }
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/gabriel/Documents/projects/bussiness/ima-icorp/code-ima-icorp/prod/ima/resources/views/admin/users/index.blade.php ENDPATH**/ ?>