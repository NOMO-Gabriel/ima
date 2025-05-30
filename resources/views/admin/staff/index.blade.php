<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Moderne - Utilisateurs & Personnel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Design System Variables */
        :root {
            /* Colors */
            --primary-50: #eff6ff;
            --primary-100: #dbeafe;
            --primary-200: #bfdbfe;
            --primary-300: #93c5fd;
            --primary-400: #60a5fa;
            --primary-500: #3b82f6;
            --primary-600: #2563eb;
            --primary-700: #1d4ed8;
            --primary-800: #1e40af;
            --primary-900: #1e3a8a;

            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;

            --success-50: #f0fdf4;
            --success-500: #22c55e;
            --success-600: #16a34a;

            --warning-50: #fffbeb;
            --warning-500: #f59e0b;
            --warning-600: #d97706;

            --danger-50: #fef2f2;
            --danger-500: #ef4444;
            --danger-600: #dc2626;

            --info-50: #eff6ff;
            --info-500: #3b82f6;
            --info-600: #2563eb;

            /* Spacing */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;
            --space-16: 4rem;

            /* Border Radius */
            --radius-sm: 0.375rem;
            --radius: 0.5rem;
            --radius-md: 0.75rem;
            --radius-lg: 1rem;
            --radius-xl: 1.25rem;
            --radius-2xl: 1.5rem;

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);

            /* Typography */
            --font-sans: ui-sans-serif, system-ui, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            --text-xs: 0.75rem;
            --text-sm: 0.875rem;
            --text-base: 1rem;
            --text-lg: 1.125rem;
            --text-xl: 1.25rem;
            --text-2xl: 1.5rem;
            --text-3xl: 1.875rem;

            /* Animation */
            --transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-sans);
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--primary-50) 100%);
            color: var(--gray-900);
            line-height: 1.6;
            min-height: 100vh;
        }

        /* Layout */
        .dashboard {
            padding: var(--space-6);
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header */
        .page-header {
            margin-bottom: var(--space-8);
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            margin-bottom: var(--space-4);
            font-size: var(--text-sm);
            color: var(--gray-500);
        }

        .breadcrumb a {
            color: var(--gray-500);
            text-decoration: none;
            transition: var(--transition);
        }

        .breadcrumb a:hover {
            color: var(--primary-600);
        }

        .page-title {
            font-size: var(--text-3xl);
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: var(--space-2);
            background: linear-gradient(135deg, var(--gray-900) 0%, var(--primary-600) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-description {
            font-size: var(--text-lg);
            color: var(--gray-600);
            margin-bottom: var(--space-6);
        }

        /* Modern Button */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: var(--space-2);
            padding: var(--space-3) var(--space-5);
            border: none;
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: var(--text-sm);
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-700) 100%);
            color: white;
            box-shadow: var(--shadow-lg);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-xl);
        }

        .btn-secondary {
            background: var(--gray-100);
            color: var(--gray-700);
            border: 1px solid var(--gray-200);
        }

        .btn-secondary:hover {
            background: var(--gray-200);
            transform: translateY(-1px);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: var(--space-6);
            margin-bottom: var(--space-8);
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-2xl);
            padding: var(--space-6);
            position: relative;
            overflow: hidden;
            transition: var(--transition);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-500), var(--primary-600));
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: var(--space-4);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: var(--text-xl);
            color: white;
        }

        .stat-icon.primary { background: linear-gradient(135deg, var(--primary-500), var(--primary-600)); }
        .stat-icon.success { background: linear-gradient(135deg, var(--success-500), var(--success-600)); }
        .stat-icon.warning { background: linear-gradient(135deg, var(--warning-500), var(--warning-600)); }
        .stat-icon.info { background: linear-gradient(135deg, var(--info-500), var(--info-600)); }

        .stat-value {
            font-size: var(--text-3xl);
            font-weight: 800;
            color: var(--gray-900);
            margin-bottom: var(--space-1);
        }

        .stat-label {
            font-size: var(--text-sm);
            color: var(--gray-600);
            font-weight: 500;
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            margin-top: var(--space-3);
        }

        .trend-indicator {
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius);
            font-size: var(--text-xs);
            font-weight: 600;
        }

        .trend-indicator.up {
            background: var(--success-50);
            color: var(--success-600);
        }

        .trend-indicator.down {
            background: var(--danger-50);
            color: var(--danger-600);
        }

        /* Modern Card */
        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            margin-bottom: var(--space-8);
        }

        .card-header {
            padding: var(--space-6);
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: var(--text-xl);
            font-weight: 700;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            gap: var(--space-3);
        }

        .card-body {
            padding: var(--space-6);
        }

        /* Filter Section */
        .filter-section {
            background: linear-gradient(135deg, rgba(255,255,255,0.9) 0%, rgba(255,255,255,0.7) 100%);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: var(--radius-2xl);
            padding: var(--space-6);
            margin-bottom: var(--space-8);
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: var(--space-6);
            margin-bottom: var(--space-6);
        }

        .form-group {
            position: relative;
        }

        .form-label {
            display: block;
            font-size: var(--text-sm);
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: var(--space-2);
        }

        .form-input {
            width: 100%;
            padding: var(--space-3) var(--space-4);
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-lg);
            font-size: var(--text-base);
            transition: var(--transition);
            background: rgba(255, 255, 255, 0.8);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-500);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
        }

        .search-input {
            position: relative;
        }

        .search-input::before {
            content: '\f002';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: var(--space-4);
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            z-index: 1;
        }

        .search-input input {
            padding-left: var(--space-10);
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--space-4);
            flex-wrap: wrap;
        }

        .view-toggle {
            display: flex;
            background: var(--gray-100);
            border-radius: var(--radius-lg);
            padding: var(--space-1);
        }

        .view-btn {
            padding: var(--space-2) var(--space-4);
            border: none;
            background: transparent;
            border-radius: var(--radius);
            cursor: pointer;
            transition: var(--transition);
            color: var(--gray-600);
        }

        .view-btn.active {
            background: white;
            color: var(--primary-600);
            box-shadow: var(--shadow-sm);
        }

        /* Table */
        .table-container {
            background: white;
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
            padding: var(--space-4) var(--space-6);
            text-align: left;
            font-weight: 600;
            color: var(--gray-700);
            font-size: var(--text-sm);
            border-bottom: 1px solid var(--gray-200);
        }

        .table td {
            padding: var(--space-4) var(--space-6);
            border-bottom: 1px solid var(--gray-100);
            vertical-align: middle;
        }

        .table tr:hover td {
            background: var(--primary-50);
        }

        /* User Info */
        .user-info {
            display: flex;
            align-items: center;
            gap: var(--space-4);
        }

        .user-avatar {
            position: relative;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-xl);
            object-fit: cover;
            border: 3px solid white;
            box-shadow: var(--shadow);
        }

        .status-dot {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid white;
        }

        .status-dot.online { background: var(--success-500); }
        .status-dot.offline { background: var(--gray-400); }

        .user-details h4 {
            font-size: var(--text-base);
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: var(--space-1);
        }

        .user-meta {
            font-size: var(--text-sm);
            color: var(--gray-500);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: var(--space-1);
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius);
            font-size: var(--text-xs);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge.primary { background: var(--primary-100); color: var(--primary-700); }
        .badge.success { background: var(--success-50); color: var(--success-600); }
        .badge.warning { background: var(--warning-50); color: var(--warning-600); }
        .badge.danger { background: var(--danger-50); color: var(--danger-600); }
        .badge.secondary { background: var(--gray-100); color: var(--gray-600); }

        /* Role badges with glassmorphism */
        .role-badge {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: var(--space-1) var(--space-3);
            border-radius: var(--radius-lg);
            font-size: var(--text-xs);
            font-weight: 600;
            margin-right: var(--space-2);
            margin-bottom: var(--space-1);
            display: inline-block;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: var(--space-2);
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition);
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .action-btn:hover {
            transform: translateY(-2px) scale(1.05);
        }

        .action-btn.view:hover { background: var(--info-100); color: var(--info-600); }
        .action-btn.edit:hover { background: var(--success-100); color: var(--success-600); }
        .action-btn.delete:hover { background: var(--danger-100); color: var(--danger-600); }

        /* Card View */
        .user-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: var(--space-6);
        }

        .user-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-2xl);
            padding: var(--space-6);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .user-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-500), var(--primary-600));
        }

        .user-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-xl);
        }

        .user-card-header {
            display: flex;
            align-items: center;
            gap: var(--space-4);
            margin-bottom: var(--space-4);
        }

        .user-card-avatar .avatar {
            width: 64px;
            height: 64px;
        }

        .user-card-body {
            margin-bottom: var(--space-4);
        }

        .user-card-detail {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            margin-bottom: var(--space-3);
            font-size: var(--text-sm);
            color: var(--gray-600);
        }

        .user-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: var(--space-4);
            border-top: 1px solid var(--gray-200);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: var(--space-16) var(--space-8);
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--gray-300);
            margin-bottom: var(--space-6);
        }

        .empty-title {
            font-size: var(--text-2xl);
            font-weight: 700;
            color: var(--gray-700);
            margin-bottom: var(--space-3);
        }

        .empty-description {
            font-size: var(--text-lg);
            color: var(--gray-500);
            margin-bottom: var(--space-8);
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: var(--space-2);
            margin-top: var(--space-8);
        }

        .pagination-btn {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: var(--radius-lg);
            background: white;
            color: var(--gray-600);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .pagination-btn:hover {
            background: var(--primary-50);
            color: var(--primary-600);
        }

        .pagination-btn.active {
            background: var(--primary-600);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard { padding: var(--space-4); }
            .stats-grid { grid-template-columns: 1fr; }
            .filter-grid { grid-template-columns: 1fr; }
            .action-bar { flex-direction: column; align-items: stretch; }
            .user-cards { grid-template-columns: 1fr; }
        }

        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            :root {
                --gray-50: #0f172a;
                --gray-100: #1e293b;
                --gray-200: #334155;
                --gray-300: #475569;
                --gray-400: #64748b;
                --gray-500: #94a3b8;
                --gray-600: #cbd5e1;
                --gray-700: #e2e8f0;
                --gray-800: #f1f5f9;
                --gray-900: #f8fafc;
            }

            body {
                background: linear-gradient(135deg, var(--gray-900) 0%, var(--gray-800) 100%);
            }
        }

        /* Animation utilities */
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        .slide-up {
            animation: slideUp 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: var(--radius);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: var(--radius);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gray-400);
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Header -->
        <div class="page-header fade-in">
            <div class="breadcrumb">
                <a href="#"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right"></i>
                <a href="#">Administration</a>
                <i class="fas fa-chevron-right"></i>
                <span>Gestion des Utilisateurs</span>
            </div>
            <h1 class="page-title">Gestion des Utilisateurs</h1>
            <p class="page-description">Gérez tous les utilisateurs du système avec leurs rôles et permissions dans une interface moderne et intuitive.</p>
            <button class="btn btn-primary">
                <i class="fas fa-user-plus"></i>
                Ajouter un utilisateur
            </button>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid slide-up">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon primary">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="stat-value">2,847</div>
                <div class="stat-label">Total Utilisateurs</div>
                <div class="stat-trend">
                    <span class="trend-indicator up">
                        <i class="fas fa-arrow-up"></i> +12%
                    </span>
                    <span style="font-size: var(--text-xs); color: var(--gray-500);">vs mois dernier</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon success">
                        <i class="fas fa-user-check"></i>
                    </div>
                </div>
                <div class="stat-value">2,456</div>
                <div class="stat-label">Utilisateurs Actifs</div>
                <div class="stat-trend">
                    <span class="trend-indicator up">
                        <i class="fas fa-arrow-up"></i> +8%
                    </span>
                    <span style="font-size: var(--text-xs); color: var(--gray-500);">vs mois dernier</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon warning">
                        <i class="fas fa-user-clock"></i>
                    </div>
                </div>
                <div class="stat-value">156</div>
                <div class="stat-label">En Attente</div>
                <div class="stat-trend">
                    <span class="trend-indicator down">
                        <i class="fas fa-arrow-down"></i> -5%
                    </span>
                    <span style="font-size: var(--text-xs); color: var(--gray-500);">vs mois dernier</span>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon info">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                </div>
                <div class="stat-value">8</div>
                <div class="stat-label">Types de Rôles</div>
                <div class="stat-trend">
                    <span class="trend-indicator up">
                        <i class="fas fa-arrow-up"></i> +2
                    </span>
                    <span style="font-size: var(--text-xs); color: var(--gray-500);">nouveaux rôles</span>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section slide-up">
            <div class="filter-grid">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user-tag" style="margin-right: var(--space-2);"></i>
                        Rôle
                    </label>
                    <select class="form-input">
                        <option>Tous les rôles</option>
                        <option>Administrateur</option>
                        <option>Enseignant</option>
                        <option>Étudiant</option>
                        <option>Parent</option>
                        <option>Personnel</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user-shield" style="margin-right: var(--space-2);"></i>
                        Statut
                    </label>
                    <select class="form-input">
                        <option>Tous les statuts</option>
                        <option>Actif</option>
                        <option>En attente de validation</option>
                        <option>En attente de finalisation</option>
                        <option>Suspendu</option>
                        <option>Rejeté</option>
                        <option>Archivé</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-search" style="margin-right: var(--space-2);"></i>
                        Recherche
                    </label>
                    <div class="search-input">
                        <input type="text" class="form-input" placeholder="Nom, email ou téléphone...">
                    </div>
                </div>
            </div>

            <div class="action-bar">
                <div style="display: flex; gap: var(--space-3);">
                    <button class="btn btn-primary">
                        <i class="fas fa-filter"></i>
                        Appliquer les filtres
                    </button>
                    <button class="btn btn-secondary">
                        <i class="fas fa-redo-alt"></i>
                        Réinitialiser
                    </button>
                </div>

                <div class="view-toggle">
                    <button class="view-btn active" id="tableView">
                        <i class="fas fa-list"></i>
                    </button>
                    <button class="view-btn" id="cardView">
                        <i class="fas fa-th-large"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="card slide-up">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-users"></i>
                    Liste des utilisateurs
                </h2>
                <div style="display: flex; gap: var(--space-3);">
                    <button class="btn btn-secondary">
                        <i class="fas fa-download"></i>
                        Exporter
                    </button>
                </div>
            </div>

            <div class="card-body" style="padding: 0;">
                <!-- Table View -->
                <div id="tableContent" class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Contact</th>
                                <th>Rôles</th>
                                <th>Statut</th>
                                <th>Dernière connexion</th>
                                <th style="text-align: center;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face" alt="Avatar" class="avatar">
                                            <div class="status-dot online"></div>
                                        </div>
                                        <div class="user-details">
                                            <h4>Alexandre Martin</h4>
                                            <div class="user-meta">Créé le 15/03/2024</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: var(--space-1);">
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="fas fa-envelope" style="color: var(--gray-400);"></i>
                                            alexandre.martin@example.com
                                        </div>
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="fas fa-phone" style="color: var(--gray-400);"></i>
                                            +33 6 12 34 56 78
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-wrap: wrap; gap: var(--space-1);">
                                        <span class="role-badge" style="background: var(--primary-100); color: var(--primary-700);">Administrateur</span>
                                        <span class="role-badge" style="background: var(--success-100); color: var(--success-700);">Enseignant</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge success">
                                        <i class="fas fa-check-circle"></i>
                                        Actif
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: var(--space-1);">
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="far fa-clock" style="color: var(--gray-400);"></i>
                                            Il y a 2 heures
                                        </div>
                                        <span style="font-size: var(--text-xs); color: var(--success-600); font-weight: 600;">Récent</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <button class="action-btn view">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b8ac?w=150&h=150&fit=crop&crop=face" alt="Avatar" class="avatar">
                                            <div class="status-dot online"></div>
                                        </div>
                                        <div class="user-details">
                                            <h4>Sophie Dubois</h4>
                                            <div class="user-meta">Créé le 12/03/2024</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: var(--space-1);">
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="fas fa-envelope" style="color: var(--gray-400);"></i>
                                            sophie.dubois@example.com
                                        </div>
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="fas fa-phone" style="color: var(--gray-400);"></i>
                                            +33 6 98 76 54 32
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-wrap: wrap; gap: var(--space-1);">
                                        <span class="role-badge" style="background: var(--info-100); color: var(--info-700);">Enseignant</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge success">
                                        <i class="fas fa-check-circle"></i>
                                        Actif
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: var(--space-1);">
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="far fa-clock" style="color: var(--gray-400);"></i>
                                            Il y a 5 heures
                                        </div>
                                        <span style="font-size: var(--text-xs); color: var(--success-600); font-weight: 600;">Récent</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <button class="action-btn view">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face" alt="Avatar" class="avatar">
                                            <div class="status-dot offline"></div>
                                        </div>
                                        <div class="user-details">
                                            <h4>Thomas Lefebvre</h4>
                                            <div class="user-meta">Créé le 10/03/2024</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: var(--space-1);">
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="fas fa-envelope" style="color: var(--gray-400);"></i>
                                            thomas.lefebvre@example.com
                                        </div>
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="fas fa-phone" style="color: var(--gray-400);"></i>
                                            +33 6 11 22 33 44
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-wrap: wrap; gap: var(--space-1);">
                                        <span class="role-badge" style="background: var(--warning-100); color: var(--warning-700);">Étudiant</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge warning">
                                        <i class="fas fa-hourglass-half"></i>
                                        En attente
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: var(--space-1);">
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="far fa-clock" style="color: var(--gray-400);"></i>
                                            Il y a 2 jours
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <button class="action-btn view">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face" alt="Avatar" class="avatar">
                                            <div class="status-dot online"></div>
                                        </div>
                                        <div class="user-details">
                                            <h4>Marie Rousseau</h4>
                                            <div class="user-meta">Créé le 08/03/2024</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: var(--space-1);">
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="fas fa-envelope" style="color: var(--gray-400);"></i>
                                            marie.rousseau@example.com
                                        </div>
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="fas fa-phone" style="color: var(--gray-400);"></i>
                                            +33 6 55 66 77 88
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="display: flex; flex-wrap: wrap; gap: var(--space-1);">
                                        <span class="role-badge" style="background: var(--purple-100, #f3e8ff); color: var(--purple-700, #7c3aed);">Parent</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge success">
                                        <i class="fas fa-check-circle"></i>
                                        Actif
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; flex-direction: column; gap: var(--space-1);">
                                        <div style="display: flex; align-items: center; gap: var(--space-2); font-size: var(--text-sm);">
                                            <i class="far fa-clock" style="color: var(--gray-400);"></i>
                                            Il y a 1 heure
                                        </div>
                                        <span style="font-size: var(--text-xs); color: var(--success-600); font-weight: 600;">Récent</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons" style="justify-content: center;">
                                        <button class="action-btn view">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="action-btn edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="action-btn delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Card View -->
                <div id="cardContent" class="user-cards" style="display: none; padding: var(--space-6);">
                    <div class="user-card">
                        <div class="user-card-header">
                            <div class="user-avatar">
                                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face" alt="Avatar" class="avatar">
                                <div class="status-dot online"></div>
                            </div>
                            <div style="flex: 1;">
                                <h3 style="font-size: var(--text-lg); font-weight: 700; margin-bottom: var(--space-1);">Alexandre Martin</h3>
                                <div style="display: flex; flex-wrap: wrap; gap: var(--space-1);">
                                    <span class="role-badge" style="background: var(--primary-100); color: var(--primary-700);">Administrateur</span>
                                    <span class="role-badge" style="background: var(--success-100); color: var(--success-700);">Enseignant</span>
                                </div>
                            </div>
                            <span class="badge success">
                                <i class="fas fa-check-circle"></i>
                                Actif
                            </span>
                        </div>
                        <div class="user-card-body">
                            <div class="user-card-detail">
                                <i class="fas fa-envelope"></i>
                                alexandre.martin@example.com
                            </div>
                            <div class="user-card-detail">
                                <i class="fas fa-phone"></i>
                                +33 6 12 34 56 78
                            </div>
                            <div class="user-card-detail">
                                <i class="far fa-calendar-alt"></i>
                                Créé le 15/03/2024
                            </div>
                            <div class="user-card-detail">
                                <i class="far fa-clock"></i>
                                Dernière connexion il y a 2 heures
                            </div>
                        </div>
                        <div class="user-card-footer">
                            <div style="display: flex; align-items: center; gap: var(--space-2);">
                                <span style="font-size: var(--text-xs); color: var(--success-600); font-weight: 600;">
                                    <i class="fas fa-circle" style="font-size: 6px; margin-right: var(--space-1);"></i>
                                    Récemment actif
                                </span>
                            </div>
                            <div class="action-buttons">
                                <button class="action-btn view">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="user-card">
                        <div class="user-card-header">
                            <div class="user-avatar">
                                <img src="https://images.unsplash.com/photo-1494790108755-2616b612b8ac?w=150&h=150&fit=crop&crop=face" alt="Avatar" class="avatar">
                                <div class="status-dot online"></div>
                            </div>
                            <div style="flex: 1;">
                                <h3 style="font-size: var(--text-lg); font-weight: 700; margin-bottom: var(--space-1);">Sophie Dubois</h3>
                                <div style="display: flex; flex-wrap: wrap; gap: var(--space-1);">
                                    <span class="role-badge" style="background: var(--info-100); color: var(--info-700);">Enseignant</span>
                                </div>
                            </div>
                            <span class="badge success">
                                <i class="fas fa-check-circle"></i>
                                Actif
                            </span>
                        </div>
                        <div class="user-card-body">
                            <div class="user-card-detail">
                                <i class="fas fa-envelope"></i>
                                sophie.dubois@example.com
                            </div>
                            <div class="user-card-detail">
                                <i class="fas fa-phone"></i>
                                +33 6 98 76 54 32
                            </div>
                            <div class="user-card-detail">
                                <i class="far fa-calendar-alt"></i>
                                Créé le 12/03/2024
                            </div>
                            <div class="user-card-detail">
                                <i class="far fa-clock"></i>
                                Dernière connexion il y a 5 heures
                            </div>
                        </div>
                        <div class="user-card-footer">
                            <div style="display: flex; align-items: center; gap: var(--space-2);">
                                <span style="font-size: var(--text-xs); color: var(--success-600); font-weight: 600;">
                                    <i class="fas fa-circle" style="font-size: 6px; margin-right: var(--space-1);"></i>
                                    Récemment actif
                                </span>
                            </div>
                            <div class="action-buttons">
                                <button class="action-btn view">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="user-card">
                        <div class="user-card-header">
                            <div class="user-avatar">
                                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face" alt="Avatar" class="avatar">
                                <div class="status-dot offline"></div>
                            </div>
                            <div style="flex: 1;">
                                <h3 style="font-size: var(--text-lg); font-weight: 700; margin-bottom: var(--space-1);">Thomas Lefebvre</h3>
                                <div style="display: flex; flex-wrap: wrap; gap: var(--space-1);">
                                    <span class="role-badge" style="background: var(--warning-100); color: var(--warning-700);">Étudiant</span>
                                </div>
                            </div>
                            <span class="badge warning">
                                <i class="fas fa-hourglass-half"></i>
                                En attente
                            </span>
                        </div>
                        <div class="user-card-body">
                            <div class="user-card-detail">
                                <i class="fas fa-envelope"></i>
                                thomas.lefebvre@example.com
                            </div>
                            <div class="user-card-detail">
                                <i class="fas fa-phone"></i>
                                +33 6 11 22 33 44
                            </div>
                            <div class="user-card-detail">
                                <i class="far fa-calendar-alt"></i>
                                Créé le 10/03/2024
                            </div>
                            <div class="user-card-detail">
                                <i class="far fa-clock"></i>
                                Dernière connexion il y a 2 jours
                            </div>
                        </div>
                        <div class="user-card-footer">
                            <div style="display: flex; align-items: center; gap: var(--space-2);">
                                <span style="font-size: var(--text-xs); color: var(--warning-600); font-weight: 600;">
                                    <i class="fas fa-clock" style="font-size: 8px; margin-right: var(--space-1);"></i>
                                    En attente de validation
                                </span>
                            </div>
                            <div class="action-buttons">
                                <button class="action-btn view">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="user-card">
                        <div class="user-card-header">
                            <div class="user-avatar">
                                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face" alt="Avatar" class="avatar">
                                <div class="status-dot online"></div>
                            </div>
                            <div style="flex: 1;">
                                <h3 style="font-size: var(--text-lg); font-weight: 700; margin-bottom: var(--space-1);">Marie Rousseau</h3>
                                <div style="display: flex; flex-wrap: wrap; gap: var(--space-1);">
                                    <span class="role-badge" style="background: var(--purple-100, #f3e8ff); color: var(--purple-700, #7c3aed);">Parent</span>
                                </div>
                            </div>
                            <span class="badge success">
                                <i class="fas fa-check-circle"></i>
                                Actif
                            </span>
                        </div>
                        <div class="user-card-body">
                            <div class="user-card-detail">
                                <i class="fas fa-envelope"></i>
                                marie.rousseau@example.com
                            </div>
                            <div class="user-card-detail">
                                <i class="fas fa-phone"></i>
                                +33 6 55 66 77 88
                            </div>
                            <div class="user-card-detail">
                                <i class="far fa-calendar-alt"></i>
                                Créé le 08/03/2024
                            </div>
                            <div class="user-card-detail">
                                <i class="far fa-clock"></i>
                                Dernière connexion il y a 1 heure
                            </div>
                        </div>
                        <div class="user-card-footer">
                            <div style="display: flex; align-items: center; gap: var(--space-2);">
                                <span style="font-size: var(--text-xs); color: var(--success-600); font-weight: 600;">
                                    <i class="fas fa-circle" style="font-size: 6px; margin-right: var(--space-1);"></i>
                                    Récemment actif
                                </span>
                            </div>
                            <div class="action-buttons">
                                <button class="action-btn view">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="action-btn edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="pagination slide-up">
            <button class="pagination-btn">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="pagination-btn">1</button>
            <button class="pagination-btn active">2</button>
            <button class="pagination-btn">3</button>
            <button class="pagination-btn">4</button>
            <button class="pagination-btn">5</button>
            <button class="pagination-btn">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <script>
        // View toggle functionality
        document.getElementById('tableView').addEventListener('click', function() {
            document.getElementById('tableContent').style.display = 'block';
            document.getElementById('cardContent').style.display = 'none';
            this.classList.add('active');
            document.getElementById('cardView').classList.remove('active');
        });

        document.getElementById('cardView').addEventListener('click', function() {
            document.getElementById('tableContent').style.display = 'none';
            document.getElementById('cardContent').style.display = 'block';
            this.classList.add('active');
            document.getElementById('tableView').classList.remove('active');
        });

        // Add smooth animations on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        // Observe all animatable elements
        document.querySelectorAll('.slide-up').forEach(el => {
            observer.observe(el);
        });

        // Add hover effects and interactions
        document.querySelectorAll('.action-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                // Add ripple effect
                const ripple = document.createElement('div');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.6);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Add CSS for ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            .btn:active {
                transform: scale(0.95);
            }
            
            .stat-card:hover .stat-icon {
                transform: scale(1.1);
                transition: transform 0.3s ease;
            }
            
            .user-card:hover .avatar {
                transform: scale(1.05);
                transition: transform 0.3s ease;
            }
            
            .table tr:hover {
                transform: scale(1.01);
                transition: transform 0.2s ease;
            }
            
            .pagination-btn:hover {
                transform: translateY(-2px) scale(1.05);
            }
            
            .form-input:focus {
                transform: scale(1.02);
            }
            
            /* Loading states */
            .loading {
                position: relative;
                overflow: hidden;
            }
            
            .loading::after {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
                animation: loading 1.5s infinite;
            }
            
            @keyframes loading {
                0% { left: -100%; }
                100% { left: 100%; }
            }
            
            /* Micro-interactions */
            .badge {
                transition: all 0.2s ease;
            }
            
            .badge:hover {
                transform: scale(1.05);
                box-shadow: var(--shadow-md);
            }
            
            .role-badge {
                transition: all 0.2s ease;
            }
            
            .role-badge:hover {
                transform: translateY(-1px);
                box-shadow: var(--shadow-sm);
            }
            
            /* Focus states for accessibility */
            .btn:focus,
            .action-btn:focus,
            .pagination-btn:focus {
                outline: 3px solid rgba(59, 130, 246, 0.5);
                outline-offset: 2px;
            }
            
            .form-input:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }
            
            /* Dark mode support */
            @media (prefers-color-scheme: dark) {
                .card,
                .stat-card,
                .filter-section,
                .user-card {
                    background: rgba(30, 41, 59, 0.9);
                    border-color: rgba(71, 85, 105, 0.3);
                }
                
                .table th {
                    background: linear-gradient(135deg, var(--gray-800) 0%, var(--gray-700) 100%);
                }
                
                .form-input {
                    background: rgba(30, 41, 59, 0.8);
                    border-color: var(--gray-600);
                    color: var(--gray-100);
                }
                
                .role-badge {
                    background: rgba(30, 41, 59, 0.8);
                    border-color: rgba(71, 85, 105, 0.3);
                }
            }
            
            /* Mobile optimizations */
            @media (max-width: 768px) {
                .table-container {
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }
                
                .table th:nth-child(n+4),
                .table td:nth-child(n+4) {
                    display: none;
                }
                
                .action-buttons {
                    flex-direction: column;
                    gap: var(--space-1);
                }
                
                .user-cards {
                    grid-template-columns: 1fr;
                }
                
                .filter-grid {
                    grid-template-columns: 1fr;
                }
                
                .stats-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
                
                .page-title {
                    font-size: var(--text-2xl);
                }
            }
            
            @media (max-width: 480px) {
                .stats-grid {
                    grid-template-columns: 1fr;
                }
                
                .action-bar {
                    flex-direction: column;
                    align-items: stretch;
                }
                
                .btn {
                    justify-content: center;
                }
            }
            
            /* Print styles */
            @media print {
                .action-buttons,
                .pagination,
                .filter-section,
                .view-toggle,
                .btn {
                    display: none !important;
                }
                
                .card,
                .stat-card,
                .user-card {
                    background: white !important;
                    box-shadow: none !important;
                    border: 1px solid #ccc !important;
                }
                
                body {
                    background: white !important;
                }
            }
            
            /* Reduced motion support */
            @media (prefers-reduced-motion: reduce) {
                *,
                *::before,
                *::after {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                    scroll-behavior: auto !important;
                }
            }
        `;
        document.head.appendChild(style);

        // Enhanced search functionality
        const searchInput = document.querySelector('.search-input input');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    // Simulate search with loading state
                    const tableBody = document.querySelector('.table tbody');
                    if (tableBody) {
                        tableBody.classList.add('loading');
                        setTimeout(() => {
                            tableBody.classList.remove('loading');
                        }, 1000);
                    }
                }, 300);
            });
        }

        // Enhanced filter functionality
        const filterSelects = document.querySelectorAll('.filter-section select');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                // Add visual feedback
                this.style.background = 'var(--primary-50)';
                setTimeout(() => {
                    this.style.background = '';
                }, 200);
            });
        });

        // Toast notification system
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? 'var(--success-500)' : 'var(--danger-500)'};
                color: white;
                padding: var(--space-4) var(--space-6);
                border-radius: var(--radius-lg);
                box-shadow: var(--shadow-xl);
                z-index: 1000;
                transform: translateX(100%);
                transition: transform 0.3s ease;
                max-width: 300px;
                backdrop-filter: blur(10px);
            `;
            toast.innerHTML = `
                <div style="display: flex; align-items: center; gap: var(--space-2);">
                    <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
            }, 100);
            
            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Simulate some actions with toast notifications
        document.querySelectorAll('.action-btn.delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                    showToast('Utilisateur supprimé avec succès', 'success');
                }
            });
        });

        document.querySelectorAll('.btn-primary').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (this.textContent.includes('Appliquer')) {
                    e.preventDefault();
                    showToast('Filtres appliqués avec succès', 'success');
                }
            });
        });

        // Lazy loading for avatars
        const avatars = document.querySelectorAll('.avatar');
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.style.opacity = '0';
                    img.onload = () => {
                        img.style.transition = 'opacity 0.3s ease';
                        img.style.opacity = '1';
                    };
                    imageObserver.unobserve(img);
                }
            });
        });

        avatars.forEach(avatar => {
            imageObserver.observe(avatar);
        });

        // Enhanced keyboard navigation
        document.addEventListener('keydown', function(e) {
            // Escape key to close any open dropdowns or modals
            if (e.key === 'Escape') {
                // Close any dropdowns or modals
                console.log('Escape pressed - close modals');
            }
            
            // Ctrl/Cmd + K to focus search
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                searchInput?.focus();
            }
        });

        // Performance optimization: Virtualization for large lists
        const table = document.querySelector('.table tbody');
        if (table && table.children.length > 50) {
            // Implement virtual scrolling for performance
            console.log('Virtual scrolling would be implemented here for large datasets');
        }

        // Add status indicators animation
        document.querySelectorAll('.status-dot.online').forEach(dot => {
            setInterval(() => {
                dot.style.animation = 'pulse 2s infinite';
            }, 3000);
        });

        // Add final style for pulse animation
        const pulseStyle = document.createElement('style');
        pulseStyle.textContent = `
            @keyframes pulse {
                0% { opacity: 1; }
                50% { opacity: 0.5; }
                100% { opacity: 1; }
            }
        `;
        document.head.appendChild(pulseStyle);

        console.log('🎉 Modern dashboard interface loaded successfully!');
    </script>
</body>
</html>