<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IMA - ICORP Management App</title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <!-- Header -->
    <header class="bg-white shadow-sm fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <img src="{{ asset('logo-icorp-white.png') }}" alt="IMA Logo" class="h-10 mr-3"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNTAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCAxNTAgODAiPjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iODAiIGZpbGw9IiMzNDgyZjYiLz48dGV4dCB4PSI3NSIgeT0iNDUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIyMCIgZmlsbD0id2hpdGUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGFsaWdubWVudC1iYXNlbGluZT0ibWlkZGxlIj5JTUEtSUNPUlA8L3RleHQ+PC9zdmc+'" >
                    <span class="font-semibold text-xl text-gray-800 font-montserrat">IMA-ICORP</span>
                </div>
                
                <div class="hidden sm:flex sm:space-x-8 items-center">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 transition px-3 py-2 text-sm font-medium">Fonctionnalités</a>
                    <a href="#about" class="text-gray-600 hover:text-blue-600 transition px-3 py-2 text-sm font-medium">À propos</a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-blue-600 text-white hover:bg-blue-700 transition px-4 py-2 rounded-md text-sm font-medium">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition px-3 py-2 text-sm font-medium">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white hover:bg-blue-700 transition px-4 py-2 rounded-md text-sm font-medium">Inscription</a>
                        @endif
                    @endauth
                </div>
                
                <div class="sm:hidden">
                    <button type="button" id="mobile-menu-button" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu, show/hide based on menu state -->
        <div id="mobile-menu" class="sm:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="#features" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-md">Fonctionnalités</a>
                <a href="#about" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-md">À propos</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="block px-3 py-2 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-blue-600 hover:bg-gray-50 rounded-md">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md">Inscription</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <!-- Hero section -->
    <section class="pt-24 pb-16 md:pb-20 bg-gray-50 relative">
        <!-- Logo en arrière-plan -->
        <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
            <img src="{{ asset('logo-icorp-white.png') }}" alt="IMA Logo Background" class="w-3/4 max-w-2xl blur-sm"
                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIiB2aWV3Qm94PSIwIDAgNTAwIDUwMCI+PHJlY3Qgd2lkdGg9IjUwMCIgaGVpZ2h0PSI1MDAiIGZpbGw9IiMzNDgyZjYiLz48dGV4dCB4PSIyNTAiIHk9IjI1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjgwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPklNQS1JQ09SUDwvdGV4dD48L3N2Zz4='" >
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-lg p-8 md:p-12 max-w-3xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 font-montserrat">ICORP Management Application</h1>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                    Une solution complète pour la gestion du personnel, des académies et des services de l'entreprise Intelligentsia Corporation.
                </p>
                
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition">
                            <i class="fas fa-tachometer-alt mr-2"></i> Accéder à mon espace
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition">
                            <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-md shadow-sm text-base font-medium text-blue-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400 transition">
                                <i class="fas fa-user-plus mr-2"></i> S'inscrire
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Features section -->
    <section id="features" class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 font-montserrat">Fonctionnalités</h2>
                <div class="w-16 h-1 bg-blue-600 mx-auto mt-4"></div>
                <p class="mt-4 text-xl text-gray-600 max-w-3xl mx-auto">
                    Découvrez les outils puissants qui vous aideront à optimiser la gestion de votre organisation.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-6">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gestion du Personnel</h3>
                    <p class="text-gray-600">
                        Gérez efficacement les enseignants, les élèves et le personnel administratif avec un suivi complet des contrats et des activités.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-6">
                        <i class="fas fa-university text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gestion des Académies</h3>
                    <p class="text-gray-600">
                        Organisez vos académies, départements et centres de formation avec une structure hiérarchique claire et flexible.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-6">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Suivi Financier</h3>
                    <p class="text-gray-600">
                        Suivez en temps réel les paiements, les rémunérations et toutes les transactions financières de votre organisation.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-6">
                        <i class="fas fa-calendar-alt text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Planification des Cours</h3>
                    <p class="text-gray-600">
                        Planifiez et organisez les cours, les emplois du temps et les affectations des enseignants de manière optimale.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-6">
                        <i class="fas fa-book text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gestion Documentaire</h3>
                    <p class="text-gray-600">
                        Centralisez et organisez tous vos documents pédagogiques et administratifs pour un accès facile et sécurisé.
                    </p>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300 transform hover:-translate-y-1">
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 mb-6">
                        <i class="fas fa-bell text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Notifications et Rappels</h3>
                    <p class="text-gray-600">
                        Restez informé des échéances importantes et des événements grâce à un système de notifications personnalisées.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About section -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 font-montserrat">À propos d'IMA-ICORP</h2>
                <div class="w-16 h-1 bg-blue-600 mx-auto mt-4"></div>
            </div>
            
            <div class="bg-white rounded-lg shadow-lg p-8 max-w-3xl mx-auto">
                <p class="text-gray-600 mb-6 leading-relaxed">
                    IMA-ICORP (ICORP Management Application) est une solution développée spécifiquement pour Intelligentsia Corporation afin d'optimiser la gestion de ses ressources humaines et de ses services.
                </p>
                <p class="text-gray-600 mb-6 leading-relaxed">
                    Notre application centralise toutes les données académiques et financières, automatise les processus administratifs et offre une vision claire de toutes les activités de l'entreprise.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Développée avec les dernières technologies, IMA-ICORP garantit une expérience utilisateur optimale, une sécurité renforcée et une évolutivité pour s'adapter à la croissance de votre organisation.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">IMA-ICORP</h3>
                    <ul class="space-y-2">
                        <li><a href="#about" class="text-gray-300 hover:text-white transition">À propos</a></li>
                        <li><a href="#features" class="text-gray-300 hover:text-white transition">Fonctionnalités</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Tarifs</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Nous contacter</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Ressources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Documentation</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Guide d'utilisation</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Blog</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Légal</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Conditions d'utilisation</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Politique de confidentialité</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Mentions légales</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition">Cookies</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-300"><i class="fas fa-map-marker-alt w-5 text-gray-500 mr-2"></i> Yaoundé, Cameroun</li>
                        <li class="flex items-center text-gray-300"><i class="fas fa-phone w-5 text-gray-500 mr-2"></i> +237 XXX XXX XXX</li>
                        <li class="flex items-center text-gray-300"><i class="fas fa-envelope w-5 text-gray-500 mr-2"></i> contact@ima-icorp.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-12 pt-8 border-t border-gray-700">
                <div class="flex justify-center space-x-6 mb-6">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
                <p class="text-center text-gray-400 text-sm">
                    &copy; {{ date('Y') }} Intelligentsia Corporation. Tous droits réservés.
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80, // Adjust for header height
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobile-menu');
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            });
        });
    </script>
</body>
</html>