<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IMA') }} - @yield('title', 'Tableau de Bord')</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

     <!-- Styles -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    <style>
        /* Variables globales */
        :root {
            --primary-color: #007bff;
            --primary-dark: #0056b3;
            --primary-light: #e7f1ff;
            --secondary-color: #f8f9fa;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --dark-color: #343a40;
            --light-color: #ffffff;
            --gray-100: #f8f9fa;
            --gray-200: #e9ecef;
            --gray-300: #dee2e6;
            --gray-400: #ced4da;
            --gray-500: #adb5bd;
            --gray-600: #6c757d;
            --gray-700: #495057;
            --gray-800: #343a40;
            --gray-900: #212529;
            --sidebar-width: 250px;
            --header-height: 60px;
            --box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            --border-radius: 4px;
            --transition-speed: 0.3s;
        }

        /* Reset et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: #f4f7fa;
            color: var(--gray-800);
            line-height: 1.6;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }

        /* Layout principal */
        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--dark-color);
            color: var(--light-color);
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all var(--transition-speed);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 15px 20px;
            background: rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            height: var(--header-height);
        }

        .sidebar-header img {
            height: 40px;
        }

        .sidebar-menu {
            padding: 10px 0;
        }

        .menu-category {
            padding: 10px 20px;
            font-size: 0.8em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            letter-spacing: 1px;
        }

        .menu-item {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s;
        }

        .menu-item:hover, .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--light-color);
            border-left: 4px solid var(--primary-color);
        }

        .menu-item i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
        }

        /* Contenu principal */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: all var(--transition-speed);
        }

        /* Header du contenu */
        .content-header {
            height: var(--header-height);
            background: var(--light-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: var(--box-shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2em;
            color: var(--dark-color);
        }

        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-menu .notification {
            margin-right: 20px;
            position: relative;
            cursor: pointer;
        }

        .notification-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7em;
        }

        .user-info {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        /* Zone de contenu */
        .content {
            padding: 20px;
        }

        .page-title {
            margin-bottom: 25px;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Footer */
        .footer {
            background: var(--light-color);
            padding: 15px 0;
            text-align: center;
            font-size: 0.85em;
            color: var(--gray-600);
            margin-top: 30px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
            }

            .sidebar.active {
                width: var(--sidebar-width);
                padding: initial;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('logo-icorp-white.png') }}" alt="IMA Logo" onerror="this.src='https://via.placeholder.com/200/50'">
            </div>
            <div class="sidebar-menu">
                <div class="menu-category">Principal</div>
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>

                @canany(['user.view.any', 'user.create', 'user.update.any', 'user.delete.any', 'academy.view', 'academy.create', 'academy.update', 'academy.delete', 'department.view', 'department.create', 'department.update', 'department.delete', 'center.view', 'center.create', 'center.update', 'center.delete'])
                <div class="menu-category">Administration</div>
                @endcanany

                @canany(['user.view.any', 'user.create', 'user.update.any', 'user.delete.any'])
                <a href="{{ route('admin.users.index', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Utilisateurs</span>
                </a>
                @endcanany

                @canany(['academy.view', 'academy.create', 'academy.update', 'academy.delete', 'department.view', 'department.create', 'department.update', 'department.delete'])
                <a href="{{ route('admin.academies.index', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('academies.*', 'departments.*') ? 'active' : '' }}">
                    <i class="fas fa-university"></i>
                    <span>Académies & Départements</span>
                </a>
                @endcanany

                @canany(['center.view', 'center.create', 'center.update', 'center.delete'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('centers.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i>
                    <span>Centres</span>
                </a>
                @endcanany

                @canany(['formation.view', 'formation.create', 'formation.update', 'formation.delete'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('formations.*') ? 'active' : '' }}">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Formations</span>
                </a>
                @endcanany

                @canany(['teacher.register.validate', 'teacher.contract.create', 'teacher.contract.view', 'student.view', 'student.register', 'course.view', 'course.create', 'schedule.view', 'schedule.create'])
                <div class="menu-category">Gestion</div>
                @endcanany

                @canany(['teacher.register.validate', 'teacher.contract.create', 'teacher.contract.view', 'teacher.contract.update', 'teacher.assign'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('teachers.*') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Enseignants</span>
                </a>
                @endcanany

                @canany(['student.view', 'student.register', 'student.update', 'student.delete', 'student.contract.create'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('students.*') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate"></i>
                    <span>Élèves</span>
                </a>
                @endcanany

                @canany(['course.view', 'course.create', 'course.update', 'course.teacher.assign'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('classes.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Classes & Groupes</span>
                </a>

                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('planning.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Planification</span>
                </a>
                @endcanany

                @canany(['finance.transaction.view', 'finance.balance.view', 'finance.payment.student.view', 'finance.payment.student.create', 'finance.payment.teacher.calculate', 'finance.payment.teacher.validate', 'finance.expense.create', 'finance.receipt.generate', 'finance.report.view', 'finance.report.generate'])
                <div class="menu-category">Finance</div>

                @canany(['finance.transaction.view', 'finance.balance.view'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('transactions.*') ? 'active' : '' }}">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Transactions</span>
                </a>
                @endcanany

                @canany(['finance.payment.student.view', 'finance.payment.student.create', 'finance.payment.teacher.calculate', 'finance.payment.teacher.validate'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i>
                    <span>Paiements</span>
                </a>
                @endcanany

                @canany(['finance.expense.create'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Dépenses</span>
                </a>
                @endcanany

                @canany(['finance.report.view', 'finance.report.generate'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Rapports</span>
                </a>
                @endcanany
                @endcanany

                @canany(['logistics.order.create', 'logistics.order.view', 'logistics.inventory.view', 'book.catalog.view', 'book.catalog.add', 'document.view', 'document.create'])
                <div class="menu-category">Ressources</div>

                @canany(['document.view', 'document.create', 'document.update', 'document.delete'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('documents.*') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Documents</span>
                </a>
                @endcanany

                @canany(['book.catalog.view', 'book.catalog.add', 'book.catalog.update', 'book.catalog.remove'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('books.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Livres</span>
                </a>
                @endcanany

                @canany(['logistics.inventory.view', 'logistics.inventory.update'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                    <i class="fas fa-boxes"></i>
                    <span>Inventaire</span>
                </a>
                @endcanany
                @endcanany

                @canany(['competition.view', 'competition.create', 'competition.update', 'competition.supervise', 'competition.grade.record', 'competition.results.publish'])
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('contests.*') ? 'active' : '' }}">
                    <i class="fas fa-medal"></i>
                    <span>Concours</span>
                </a>
                @endcanany

                <div class="menu-category">Système</div>
                <a href="{{ route('profile.edit', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <i class="fas fa-user-cog"></i>
                    <span>Mon profil</span>
                </a>

                @can('history.view.own')
                <a href="{{ route('dashboard', ['locale' => app()->getLocale()]) }}" class="menu-item {{ request()->routeIs('history.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>Historique</span>
                </a>
                @endcan

                <form method="POST" action="{{ route('logout', ['locale' => app()->getLocale()]) }}" class="menu-item">
                    @csrf
                    <i class="fas fa-sign-out-alt"></i>
                    <button type="submit" class="bg-transparent border-none text-white cursor-pointer">
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="main-content">
            <div class="content-header">
                <button class="toggle-sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="user-menu">
                    <div class="notification">
                        <i class="fas fa-bell"></i>
                        <div class="notification-count">5</div>
                    </div>
                    <div class="user-info">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->first_name }}" class="user-avatar">
                        <span>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    </div>
                </div>
            </div>

            <div class="content">
                @yield('content')

                <!-- Footer -->
                <div class="footer">
                    <p>&copy; {{ date('Y') }} Institut Maïeutique Avancé (IMA). Tous droits réservés.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Toggle sidebar
        const toggleSidebar = document.querySelector('.toggle-sidebar');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('.main-content');

        toggleSidebar.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });

        // Notifications click event
        const notificationIcon = document.querySelector('.notification');
        notificationIcon.addEventListener('click', () => {
            alert('Vous avez 5 nouvelles notifications');
        });

        // User menu click event
        const userInfo = document.querySelector('.user-info');
        userInfo.addEventListener('click', () => {
            window.location.href = "{{ route('profile.edit') }}";
        });

        // Responsive adjustments
        function handleResponsive() {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('active');
                mainContent.style.marginLeft = '0';
            } else {
                sidebar.classList.add('active');
                mainContent.style.marginLeft = 'var(--sidebar-width)';
            }
        }

        // Call on load and resize
        window.addEventListener('load', handleResponsive);
        window.addEventListener('resize', handleResponsive);
    </script>

    @stack('scripts')
</body>
</html>
