<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'IMA')); ?> - <?php echo $__env->yieldContent('title', 'Tableau de Bord'); ?></title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        :root {
            /* Couleurs principales */
            --primary: #4CA3DD;
            --primary-dark: #2A7AB8;

            /* Mode clair */
            --bg-light: #F8FAFC;
            --bg-light-secondary: #EEF2F7;
            --text-light-primary: #1E293B;
            --text-light-secondary: #64748B;

            /* Mode sombre */
            --bg-dark: #1E293B;
            --bg-dark-secondary: #2C3E50;
            --text-dark-primary: #F1F5F9;
            --text-dark-secondary: #94A3B8;

            /* Notifications */
            --success: #34D399;
            --info: #60A5FA;
            --warning: #FBBF24;
            --danger: #F87171;

            /* Autres variables */
            --sidebar-width: 260px;
            --sidebar-width-collapsed: 70px;
            --header-height: 70px;
            --transition-speed: 0.3s;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --border-radius: 0.5rem;
        }

        /* Mode sombre */
        html.dark {
            color-scheme: dark;
        }

        html.dark body {
            background-color: var(--bg-dark);
            color: var(--text-dark-primary);
        }

        html.dark .sidebar {
            background-color: var(--bg-dark-secondary);
            box-shadow: 1px 0 5px rgba(0, 0, 0, 0.2);
        }

        html.dark .content-header {
            background-color: var(--bg-dark);
            border-bottom: 1px solid rgba(75, 85, 99, 0.3);
        }

        html.dark .card {
            background-color: var(--bg-dark-secondary);
            border: 1px solid rgba(75, 85, 99, 0.2);
        }

        html.dark .menu-item {
            color: var(--text-dark-secondary);
        }

        html.dark .menu-item:hover,
        html.dark .menu-item.active {
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--text-dark-primary);
        }

        html.dark .menu-header,
        html.dark .menu-category {
            color: var(--text-dark-secondary);
        }

        html.dark .toggle-theme i {
            color: var(--text-dark-primary);
        }

        html.dark .dropdown-menu {
            background-color: var(--bg-dark-secondary);
            border: 1px solid rgba(75, 85, 99, 0.2);
        }

        html.dark .dropdown-item {
            color: var(--text-dark-primary);
        }

        html.dark .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }

        html.dark .footer {
            border-top: 1px solid rgba(75, 85, 99, 0.2);
        }

        /* Reset et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-light-primary);
            line-height: 1.6;
            height: 100vh;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        /* Layout */
        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background-color: white;
            box-shadow: var(--shadow);
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            transition: all var(--transition-speed);
            z-index: 30;
            padding: 0.5rem;
            display: flex;
            flex-direction: column;
        }

        .sidebar.collapsed {
            width: var(--sidebar-width-collapsed);
        }

        .sidebar-header {
            padding: 1.25rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: var(--header-height);
            border-bottom: 1px solid var(--bg-light-secondary);
        }

        .sidebar-header .logo {
            display: flex;
            align-items: center;
        }

        .sidebar-header .logo img {
            height: 38px;
            transition: margin var(--transition-speed);
        }

        .sidebar-header .logo-text {
            margin-left: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-dark);
            white-space: nowrap;
            opacity: 1;
            transition: opacity var(--transition-speed);
        }

        .sidebar.collapsed .logo-text {
            opacity: 0;
            width: 0;
            margin-left: 0;
        }

        .toggle-sidebar {
            background: transparent;
            border: none;
            color: var(--text-light-secondary);
            cursor: pointer;
            font-size: 1.25rem;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all var(--transition-speed);
        }

        .toggle-sidebar:hover {
            background-color: var(--bg-light-secondary);
            color: var(--primary);
        }

        /* Sidebar Navigation */
        .sidebar-menu {
            padding: 1rem 0.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .menu-header {
            padding: 0.75rem 0.75rem 0.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-light-secondary);
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            opacity: 1;
            transition: opacity var(--transition-speed), padding var(--transition-speed);
        }

        .sidebar.collapsed .menu-header {
            opacity: 0;
            padding: 0;
            height: 0;
        }

        .menu-category {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-light-secondary);
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: var(--border-radius);
            margin-bottom: 0.25rem;
            user-select: none;
            transition: background-color var(--transition-speed);
        }

        .menu-category:hover {
            background-color: var(--bg-light-secondary);
        }

        .menu-category-text {
            white-space: nowrap;
            overflow: hidden;
            transition: opacity var(--transition-speed);
            opacity: 1;
        }

        .sidebar.collapsed .menu-category-text {
            opacity: 0;
            width: 0;
        }

        .menu-category i.toggle-icon {
            transition: transform var(--transition-speed);
            font-size: 0.75rem;
        }

        .menu-category.collapsed i.toggle-icon {
            transform: rotate(-90deg);
        }

        .sidebar.collapsed .menu-category i.toggle-icon {
            opacity: 0;
            width: 0;
        }

        .menu-group {
            overflow: hidden;
            max-height: 1000px;
            transition: max-height var(--transition-speed);
            margin-left: 0.5rem;
        }

        .menu-group.collapsed {
            max-height: 0;
        }

        .sidebar.collapsed .menu-group:not(.collapsed) {
            position: absolute;
            left: var(--sidebar-width-collapsed);
            top: 0;
            background-color: white;
            width: 230px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            max-height: auto;
            padding: 0.5rem 0;
        }

        html.dark .sidebar.collapsed .menu-group:not(.collapsed) {
            background-color: var(--bg-dark-secondary);
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--text-light-secondary);
            text-decoration: none;
            border-radius: var(--border-radius);
            margin-bottom: 0.25rem;
            transition: all var(--transition-speed);
            position: relative;
            white-space: nowrap;
        }

        .menu-item:hover {
            background-color: var(--bg-light-secondary);
            color: var(--primary-dark);
        }

        .menu-item.active {
            background-color: rgba(76, 163, 221, 0.1);
            color: var(--primary);
            font-weight: 500;
        }

        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 30%;
            height: 40%;
            width: 4px;
            background-color: var(--primary);
            border-radius: 0 4px 4px 0;
        }

        .menu-item i {
            min-width: 1.5rem;
            font-size: 1.125rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.75rem;
            transition: margin var(--transition-speed);
        }

        .sidebar.collapsed .menu-item span {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .menu-item i {
            margin-right: 0;
        }

        .sidebar.collapsed .menu-group:not(.collapsed) .menu-item span {
            opacity: 1;
            width: auto;
        }

        .sidebar.collapsed .menu-group:not(.collapsed) .menu-item i {
            margin-right: 0.75rem;
        }

        /* Logout button at bottom */
        .logout-container {
            margin-top: auto;
            padding: 0.75rem 0.5rem;
            border-top: 1px solid var(--bg-light-secondary);
        }

        html.dark .logout-container {
            border-top: 1px solid rgba(75, 85, 99, 0.2);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: var(--danger);
            background-color: rgba(248, 113, 113, 0.1);
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: all var(--transition-speed);
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
        }

        .logout-btn:hover {
            background-color: rgba(248, 113, 113, 0.2);
        }

        .logout-btn i {
            min-width: 1.5rem;
            font-size: 1.125rem;
            margin-right: 0.75rem;
            transition: margin var(--transition-speed);
        }

        .logout-text {
            white-space: nowrap;
            overflow: hidden;
            transition: opacity var(--transition-speed);
            opacity: 1;
        }

        .sidebar.collapsed .logout-text {
            opacity: 0;
            width: 0;
        }

        .sidebar.collapsed .logout-btn i {
            margin-right: 0;
        }

        /* Contenu principal */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: margin-left var(--transition-speed);
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: var(--sidebar-width-collapsed);
        }

        /* Header du contenu */
        .content-header {
            height: var(--header-height);
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .page-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-light-primary);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .toggle-theme {
            background: transparent;
            border: none;
            cursor: pointer;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color var(--transition-speed);
        }

        .toggle-theme:hover {
            background-color: var(--bg-light-secondary);
        }

        .toggle-theme i {
            font-size: 1.25rem;
            color: var(--text-light-primary);
        }

        /* Notifications */
        .notification-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            position: relative;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color var(--transition-speed);
        }

        .notification-btn:hover {
            background-color: var(--bg-light-secondary);
        }

        .notification-btn i {
            font-size: 1.25rem;
            color: var(--text-light-secondary);
        }

        .notification-count {
            position: absolute;
            top: 0.25rem;
            right: 0.25rem;
            background-color: var(--danger);
            color: white;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        /* Dropdown Notifications */
        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            min-width: 300px;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--bg-light-secondary);
            z-index: 50;
            display: none;
            overflow: hidden;
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown-header {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--bg-light-secondary);
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dropdown-header .badge {
            background-color: var(--primary);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            font-size: 0.75rem;
        }

        .dropdown-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            border-bottom: 1px solid var(--bg-light-secondary);
            transition: background-color var(--transition-speed);
            text-decoration: none;
            color: var(--text-light-primary);
        }

        .dropdown-item:hover {
            background-color: var(--bg-light-secondary);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item .icon {
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--info);
            color: white;
            flex-shrink: 0;
        }

        .dropdown-item .icon.success {
            background-color: var(--success);
        }

        .dropdown-item .icon.warning {
            background-color: var(--warning);
        }

        .dropdown-item .icon.danger {
            background-color: var(--danger);
        }

        .dropdown-item .content {
            flex: 1;
        }

        .dropdown-item .title {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .dropdown-item .desc {
            font-size: 0.875rem;
            color: var(--text-light-secondary);
        }

        .dropdown-item .time {
            font-size: 0.75rem;
            color: var(--text-light-secondary);
            margin-top: 0.25rem;
        }

        .dropdown-footer {
            padding: 0.75rem 1rem;
            text-align: center;
            border-top: 1px solid var(--bg-light-secondary);
        }

        .dropdown-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: color var(--transition-speed);
        }

        .dropdown-footer a:hover {
            color: var(--primary-dark);
        }

        /* Language Selector */
        .language-selector {
            position: relative;
        }

        .language-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: var(--border-radius);
            transition: background-color var(--transition-speed);
        }

        .language-btn:hover {
            background-color: var(--bg-light-secondary);
        }

        .language-btn img {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .language-btn span {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-light-secondary);
        }

        .language-dropdown {
            min-width: 180px;
            padding: 0.5rem 0;
        }

        .language-item {
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .language-item:hover {
            background-color: var(--bg-light-secondary);
        }

        .language-item img {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .language-item.active {
            font-weight: 500;
            color: var(--primary);
        }

        /* User Menu */
        .user-menu {
            position: relative;
        }

        .user-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem;
            border-radius: var(--border-radius);
            transition: background-color var(--transition-speed);
        }

        .user-btn:hover {
            background-color: var(--bg-light-secondary);
        }

        .user-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: var(--shadow-sm);
        }

        .user-info {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-light-primary);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-light-secondary);
        }

        .user-btn i {
            color: var(--text-light-secondary);
            font-size: 0.875rem;
        }

        .user-dropdown {
            min-width: 220px;
            padding: 0.5rem 0;
        }

        .user-profile {
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-bottom: 1px solid var(--bg-light-secondary);
        }

        .user-profile .avatar {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-profile .info {
            display: flex;
            flex-direction: column;
        }

        .user-profile .name {
            font-weight: 600;
            color: var(--text-light-primary);
        }

        .user-profile .email {
            font-size: 0.875rem;
            color: var(--text-light-secondary);
        }

        .user-links {
            padding: 0.5rem 0;
        }

        .user-link {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            color: var(--text-light-primary);
            text-decoration: none;
            transition: background-color var(--transition-speed);
        }

        .user-link:hover {
            background-color: var(--bg-light-secondary);
        }

        .user-link i {
            min-width: 1.5rem;
            font-size: 1.125rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Zone de contenu */
        .content {
            padding: 1.5rem;
        }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
            color: var(--text-light-secondary);
            font-size: 0.875rem;
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: '/';
            margin: 0 0.5rem;
            color: var(--text-light-secondary);
        }

        .breadcrumb-item.active {
            color: var(--text-light-primary);
            font-weight: 500;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .page-title-wrapper h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-light-primary);
        }

        .page-title-wrapper .actions {
            display: flex;
            gap: 0.5rem;
        }

        .page-description {
            color: var(--text-light-secondary);
            margin-bottom: 1rem;
        }

        /* Cards & Components */
        .card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--bg-light-secondary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-light-primary);
            margin: 0;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--bg-light-secondary);
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all var(--transition-speed);
            text-decoration: none;
            border: none;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.813rem;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: var(--bg-light-secondary);
            color: var(--text-light-primary);
        }

        .btn-secondary:hover {
            background-color: var(--text-light-secondary);
            color: white;
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            background-color: #2ebb89;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: #e05252;
        }

        .btn-warning {
            background-color: var(--warning);
            color: #7c2d12;
        }

        .btn-warning:hover {
            background-color: #f59e0b;
        }

        .btn-info {
            background-color: var(--info);
            color: white;
        }

        .btn-info:hover {
            background-color: #3b82f6;
        }

        .btn-light {
            background-color: white;
            color: var(--text-light-primary);
            border: 1px solid var(--bg-light-secondary);
        }

        .btn-light:hover {
            background-color: var(--bg-light-secondary);
        }

        .btn-dark {
            background-color: var(--text-light-primary);
            color: white;
        }

        .btn-dark:hover {
            background-color: black;
        }

        .btn-link {
            background-color: transparent;
            color: var(--primary);
            padding: 0;
        }

        .btn-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .btn-icon {
            width: 2.5rem;
            height: 2.5rem;
            padding: 0;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-icon.btn-sm {
            width: 2rem;
            height: 2rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            border-left: 4px solid transparent;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }

        .alert-success {
            background-color: rgba(52, 211, 153, 0.1);
            border-left-color: var(--success);
            color: #0f766e;
        }

        .alert-info {
            background-color: rgba(96, 165, 250, 0.1);
            border-left-color: var(--info);
            color: #1e40af;
        }

        .alert-warning {
            background-color: rgba(251, 191, 36, 0.1);
            border-left-color: var(--warning);
            color: #92400e;
        }

        .alert-danger {
            background-color: rgba(248, 113, 113, 0.1);
            border-left-color: var(--danger);
            color: #b91c1c;
        }

        .alert-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .alert-content {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .alert-message {
            color: inherit;
            opacity: 0.9;
        }

        .alert-close {
            background: transparent;
            border: none;
            color: inherit;
            font-size: 1.25rem;
            cursor: pointer;
            opacity: 0.5;
            transition: opacity var(--transition-speed);
            flex-shrink: 0;
        }

        .alert-close:hover {
            opacity: 1;
        }

        /* Footer */
        .footer {
            padding: 1.5rem;
            text-align: center;
            color: var(--text-light-secondary);
            font-size: 0.875rem;
            border-top: 1px solid var(--bg-light-secondary);
            margin-top: 2rem;
        }

        html.dark .footer {
            border-top-color: rgba(75, 85, 99, 0.2);
            color: var(--text-dark-secondary);
        }

        /* Utilities */
        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .justify-content-end {
            justify-content: flex-end;
        }

        .flex-column {
            flex-direction: column;
        }

        .gap-1 {
            gap: 0.25rem;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-3 {
            gap: 0.75rem;
        }

        .gap-4 {
            gap: 1rem;
        }

        .me-1 {
            margin-right: 0.25rem;
        }

        .me-2 {
            margin-right: 0.5rem;
        }

        .me-3 {
            margin-right: 0.75rem;
        }

        .me-auto {
            margin-right: auto;
        }

        .ms-auto {
            margin-left: auto;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-1 {
            margin-bottom: 0.25rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .mb-3 {
            margin-bottom: 0.75rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-5 {
            margin-bottom: 1.5rem;
        }

        .mt-auto {
            margin-top: auto;
        }

        .p-0 {
            padding: 0;
        }

        .p-3 {
            padding: 0.75rem;
        }

        .p-4 {
            padding: 1rem;
        }

        .py-2 {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .px-3 {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .text-primary {
            color: var(--primary);
        }

        .text-success {
            color: var(--success);
        }

        .text-danger {
            color: var(--danger);
        }

        .text-warning {
            color: var(--warning);
        }

        .text-info {
            color: var(--info);
        }

        .text-muted {
            color: var(--text-light-secondary);
        }

        html.dark .text-muted {
            color: var(--text-dark-secondary);
        }

        .bg-primary {
            background-color: var(--primary);
        }

        .bg-success {
            background-color: var(--success);
        }

        .bg-danger {
            background-color: var(--danger);
        }

        .bg-warning {
            background-color: var(--warning);
        }

        .bg-info {
            background-color: var(--info);
        }

        .rounded {
            border-radius: var(--border-radius);
        }

        .rounded-circle {
            border-radius: 50%;
        }

        .shadow {
            box-shadow: var(--shadow);
        }

        .shadow-sm {
            box-shadow: var(--shadow-sm);
        }

        .shadow-md {
            box-shadow: var(--shadow-md);
        }

        .border {
            border: 1px solid var(--bg-light-secondary);
        }

        html.dark .border {
            border-color: rgba(75, 85, 99, 0.2);
        }

        .border-top {
            border-top: 1px solid var(--bg-light-secondary);
        }

        html.dark .border-top {
            border-top-color: rgba(75, 85, 99, 0.2);
        }

        .border-bottom {
            border-bottom: 1px solid var(--bg-light-secondary);
        }

        html.dark .border-bottom {
            border-bottom-color: rgba(75, 85, 99, 0.2);
        }

        .w-100 {
            width: 100%;
        }

        .h-100 {
            height: 100%;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 40;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 35;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .content-header {
                padding: 0 1rem;
            }

            .content {
                padding: 1rem;
            }

            .page-title {
                font-size: 1.125rem;
            }

            .user-info {
                display: none;
            }
        }

        @media (max-width: 640px) {
            .language-btn span {
                display: none;
            }

            .header-actions {
                gap: 0.5rem;
            }

            .toggle-theme,
            .notification-btn {
                width: 2rem;
                height: 2rem;
            }
        }

        /* Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }
    </style>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<div class="sidebar-overlay"></div>
<div class="container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <img src="<?php echo e(asset('logo-icorp-white.png')); ?>" alt="IMA Logo" onerror="this.src='https://via.placeholder.com/40x40'">
                <span class="logo-text">IMA</span>
            </div>
            <button class="toggle-sidebar" aria-label="Toggle sidebar">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>

        <div class="sidebar-menu">
            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                <i class="fas fa-th-large"></i>
                <span>Tableau de bord</span>
            </a>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user.view.any', 'user.create', 'user.update.any', 'user.delete.any', 'academy.view', 'academy.create', 'academy.update', 'academy.delete', 'department.view', 'department.create', 'department.update', 'department.delete', 'center.view', 'center.create', 'center.update', 'center.delete'])): ?>
                <div class="menu-category" data-category="administration">
                    <i class="fas fa-dashboard"></i>
                    <div class="menu-category-text">Administration</div>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
                <div class="menu-group" id="group-administration">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['user.view.any', 'user.create', 'user.update.any', 'user.delete.any'])): ?>
                        <a href="<?php echo e(route('admin.users.index', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>">
                            <i class="fas fa-users"></i>
                            <span>Utilisateurs</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['academy.view', 'academy.create', 'academy.update', 'academy.delete', 'department.view', 'department.create', 'department.update', 'department.delete'])): ?>
                        <a href="<?php echo e(route('admin.academies.index', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('admin.academies.*', 'admin.departments.*') ? 'active' : ''); ?>">
                            <i class="fas fa-university"></i>
                            <span>Académies & Départements</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['center.view', 'center.create', 'center.update', 'center.delete'])): ?>
                        <a href="<?php echo e(route('admin.centers.index', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('admin.centers.*') ? 'active' : ''); ?>">
                            <i class="fas fa-building"></i>
                            <span>Centres</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['formation.view', 'formation.create', 'formation.update', 'formation.delete'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('admin.formations.*') ? 'active' : ''); ?>">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Formations</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['teacher.register.validate', 'teacher.contract.create', 'teacher.contract.view', 'student.view', 'student.register', 'course.view', 'course.create', 'schedule.view', 'schedule.create'])): ?>
                <div class="menu-category" data-category="gestion">
                    <i class="fas fa-person-chalkboard"></i>
                    <div class="menu-category-text">Gestion</div>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
                <div class="menu-group" id="group-gestion">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['teacher.register.validate', 'teacher.contract.create', 'teacher.contract.view', 'teacher.contract.update', 'teacher.assign'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('teachers.*') ? 'active' : ''); ?>">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Enseignants</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['student.view', 'student.register', 'student.update', 'student.delete', 'student.contract.create'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('students.*') ? 'active' : ''); ?>">
                            <i class="fas fa-user-graduate"></i>
                            <span>Élèves</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['course.view', 'course.create', 'course.update', 'course.teacher.assign'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('classes.*') ? 'active' : ''); ?>">
                            <i class="fas fa-users-class"></i>
                            <span>Classes & Groupes</span>
                        </a>

                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('planning.*') ? 'active' : ''); ?>">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Planification</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['finance.transaction.view', 'finance.balance.view', 'finance.payment.student.view', 'finance.payment.student.create', 'finance.payment.teacher.calculate', 'finance.payment.teacher.validate', 'finance.expense.create', 'finance.receipt.generate', 'finance.report.view', 'finance.report.generate'])): ?>
                <div class="menu-category" data-category="finance">
                    <i class="fas fa-money-bill-transfer"></i>
                    <div class="menu-category-text">Finance</div>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
                <div class="menu-group" id="group-finance">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['finance.transaction.view', 'finance.balance.view'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('finance.transactions.*') ? 'active' : ''); ?>">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Transactions</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['finance.payment.student.view', 'finance.payment.student.create', 'finance.payment.teacher.calculate', 'finance.payment.teacher.validate'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('finance.payments.*') ? 'active' : ''); ?>">
                            <i class="fas fa-credit-card"></i>
                            <span>Paiements</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['finance.expense.create'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('finance.expenses.*') ? 'active' : ''); ?>">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <span>Dépenses</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['finance.report.view', 'finance.report.generate'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('finance.reports.*') ? 'active' : ''); ?>">
                            <i class="fas fa-chart-line"></i>
                            <span>Rapports</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['logistics.order.create', 'logistics.order.view', 'logistics.inventory.view', 'book.catalog.view', 'book.catalog.add', 'document.view', 'document.create'])): ?>
                <div class="menu-category" data-category="ressources">
                    <i class="fas fa-tools"></i>
                    <div class="menu-category-text">Ressources</div>
                    <i class="fas fa-chevron-down toggle-icon"></i>
                </div>
                <div class="menu-group" id="group-ressources">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['document.view', 'document.create', 'document.update', 'document.delete'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('resources.documents.*') ? 'active' : ''); ?>">
                            <i class="fas fa-file-alt"></i>
                            <span>Documents</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['book.catalog.view', 'book.catalog.add', 'book.catalog.update', 'book.catalog.remove'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('resources.books.*') ? 'active' : ''); ?>">
                            <i class="fas fa-book"></i>
                            <span>Livres</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['logistics.inventory.view', 'logistics.inventory.update'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('resources.inventory.*') ? 'active' : ''); ?>">
                            <i class="fas fa-boxes"></i>
                            <span>Inventaire</span>
                        </a>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any(['competition.view', 'competition.create', 'competition.update', 'competition.supervise', 'competition.grade.record', 'competition.results.publish'])): ?>
                        <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('resources.contests.*') ? 'active' : ''); ?>">
                            <i class="fas fa-medal"></i>
                            <span>Concours</span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="menu-header">Personnel</div>
            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>">
                <i class="fas fa-user-cog"></i>
                <span>Mon profil</span>
            </a>

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->any('history.view.own')): ?>
                <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="menu-item <?php echo e(request()->routeIs('history.*') ? 'active' : ''); ?>">
                    <i class="fas fa-history"></i>
                    <span>Historique</span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Logout button -->
        <div class="logout-container">
            <form method="POST" action="<?php echo e(route('logout', ['locale' => app()->getLocale()])); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="logout-text">Déconnexion</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <header class="content-header">
            <div class="d-flex align-items-center">
                <button class="toggle-theme me-3 d-lg-none" id="mobile-menu-toggle" aria-label="Toggle menu">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title"><?php echo $__env->yieldContent('page_title', 'Tableau de bord'); ?></h1>
            </div>

            <div class="header-actions">
                <button class="toggle-theme" id="theme-toggle" aria-label="Toggle theme">
                    <i class="fas fa-moon"></i>
                </button>

                <div class="dropdown">
                    <button class="notification-btn" id="notification-toggle" aria-label="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="notification-count">5</span>
                    </button>
                    <div class="dropdown-menu" id="notification-dropdown">
                        <div class="dropdown-header">
                            <span>Notifications</span>
                            <span class="badge">5 nouvelles</span>
                        </div>
                        <div class="dropdown-footer">
                            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>">Voir toutes les notifications</a>
                        </div>
                    </div>
                </div>

                <div class="dropdown">
                    <button class="language-btn" id="language-toggle">

                        <span><?php echo e(strtoupper(app()->getLocale())); ?></span>
                    </button>
                    <div class="dropdown-menu language-dropdown" id="language-dropdown">
                        
                    </div>
                </div>

                <div class="dropdown">
                    <button class="user-btn" id="user-toggle">
                        <img src="<?php echo e(Auth::user()->profile_photo_url); ?>" alt="<?php echo e(Auth::user()->first_name); ?>" class="user-avatar">
                        <div class="user-info">
                            <span class="user-name"><?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?></span>
                            <span class="user-role"><?php echo e(Auth::user()->role); ?></span>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu user-dropdown" id="user-dropdown">
                        <div class="user-profile">
                            <img src="<?php echo e(Auth::user()->profile_photo_url); ?>" alt="<?php echo e(Auth::user()->first_name); ?>" class="avatar">
                            <div class="info">
                                <div class="name"><?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?></div>
                                <div class="email"><?php echo e(Auth::user()->email); ?></div>
                            </div>
                        </div>
                        <div class="user-links">
                            <a href="<?php echo e(route('profile.edit', ['locale' => app()->getLocale()])); ?>" class="user-link">
                                <i class="fas fa-user-cog"></i>
                                <span>Mon profil</span>
                            </a>
                            <a href="<?php echo e(route('dashboard', ['locale' => app()->getLocale()])); ?>" class="user-link">
                                <i class="fas fa-cog"></i>
                                <span>Paramètres</span>
                            </a>
                            <form method="POST" action="<?php echo e(route('logout', ['locale' => app()->getLocale()])); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="user-link text-danger">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="content">
            <!-- Display flash messages -->
            <?php if (isset($component)) { $__componentOriginalbb0843bd48625210e6e530f88101357e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb0843bd48625210e6e530f88101357e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.flash-message','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flash-message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb0843bd48625210e6e530f88101357e)): ?>
<?php $attributes = $__attributesOriginalbb0843bd48625210e6e530f88101357e; ?>
<?php unset($__attributesOriginalbb0843bd48625210e6e530f88101357e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb0843bd48625210e6e530f88101357e)): ?>
<?php $component = $__componentOriginalbb0843bd48625210e6e530f88101357e; ?>
<?php unset($__componentOriginalbb0843bd48625210e6e530f88101357e); ?>
<?php endif; ?>

            <!-- Page header with breadcrumb -->
            <?php if (! empty(trim($__env->yieldContent('breadcrumb')))): ?>
                <div class="breadcrumb">
                    <?php echo $__env->yieldContent('breadcrumb'); ?>
                </div>
            <?php endif; ?>

            <!-- Page header with action buttons -->
            <?php if (! empty(trim($__env->yieldContent('page_header')))): ?>
                <div class="page-header">
                    <?php echo $__env->yieldContent('page_header'); ?>
                </div>
            <?php endif; ?>

            <!-- Main Content -->
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> Institut Maïeutique Avancé (IMA). Tous droits réservés.</p>
        </footer>
    </div>
</div>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle sidebar collapse
        const toggleSidebar = document.querySelector('.toggle-sidebar');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        toggleSidebar.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');

            // Change toggle icon
            const toggleIcon = this.querySelector('i');
            if (sidebar.classList.contains('collapsed')) {
                toggleIcon.classList.remove('fa-chevron-left');
                toggleIcon.classList.add('fa-chevron-right');
            } else {
                toggleIcon.classList.remove('fa-chevron-right');
                toggleIcon.classList.add('fa-chevron-left');
            }
        });

        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        const sidebarOverlay = document.querySelector('.sidebar-overlay');

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.add('show');
                sidebarOverlay.classList.add('show');
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            });
        }

        // Toggle menu categories
        const menuCategories = document.querySelectorAll('.menu-category');

        menuCategories.forEach(category => {
            if (category.dataset.category) {
                category.addEventListener('click', function() {
                    const groupId = 'group-' + category.dataset.category;
                    const group = document.getElementById(groupId);

                    if (group) {
                        group.classList.toggle('collapsed');
                        category.classList.toggle('collapsed');
                    }
                });
            }
        });

        // Toggle theme
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;

        // Check saved theme preference
        const savedTheme = localStorage.getItem('theme') || 'light';
        htmlElement.classList.toggle('dark', savedTheme === 'dark');
        updateThemeIcon();

        themeToggle.addEventListener('click', function() {
            htmlElement.classList.toggle('dark');
            localStorage.setItem('theme', htmlElement.classList.contains('dark') ? 'dark' : 'light');
            updateThemeIcon();
        });

        function updateThemeIcon() {
            const icon = themeToggle.querySelector('i');
            if (htmlElement.classList.contains('dark')) {
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            } else {
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
            }
        }

        // Auto-expand active menu group
        const activeMenuItem = document.querySelector('.menu-item.active');
        if (activeMenuItem) {
            const parentGroup = activeMenuItem.closest('.menu-group');
            if (parentGroup) {
                parentGroup.classList.remove('collapsed');

                // Also expand the category
                const categoryId = parentGroup.id.replace('group-', '');
                const category = document.querySelector(`.menu-category[data-category="${categoryId}"]`);
                if (category) {
                    category.classList.remove('collapsed');
                }
            }
        }

        // Dropdown handling
        const dropdownToggles = {
            'notification-toggle': 'notification-dropdown',
            'language-toggle': 'language-dropdown',
            'user-toggle': 'user-dropdown'
        };

        Object.keys(dropdownToggles).forEach(toggleId => {
            const toggle = document.getElementById(toggleId);
            const dropdown = document.getElementById(dropdownToggles[toggleId]);

            if (toggle && dropdown) {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();

                    // Close all other dropdowns
                    Object.values(dropdownToggles).forEach(id => {
                        if (id !== dropdownToggles[toggleId]) {
                            document.getElementById(id).classList.remove('show');
                        }
                    });

                    dropdown.classList.toggle('show');
                });
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            Object.values(dropdownToggles).forEach(id => {
                const dropdown = document.getElementById(id);
                if (dropdown && dropdown.classList.contains('show')) {
                    dropdown.classList.remove('show');
                }
            });
        });

        // Close alert messages
        const alertCloseButtons = document.querySelectorAll('.alert-close');
        alertCloseButtons.forEach(button => {
            button.addEventListener('click', function() {
                const alert = this.closest('.alert');
                if (alert) {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
</script>

<?php echo $__env->yieldPushContent('scripts'); ?>

</body>
</html>
<?php /**PATH /home/jordan/PROJECTS/ima/ima/resources/views/layouts/app.blade.php ENDPATH**/ ?>