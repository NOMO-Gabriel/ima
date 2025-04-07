<!-- resources/views/welcome.blade.php -->
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
    <style>
        /*! Variables CSS et styles de base */
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
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
        }
        
        /* Header */
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo-container img {
            height: 40px;
            margin-right: 1rem;
        }
        
        .logo-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .nav-links {
            display: flex;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            color: rgba(255, 255, 255, 0.8);
        }
        
        .btn {
            display: inline-block;
            padding: 0.6rem 1.2rem;
            border-radius: 4px;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        /* Pour le bouton d'inscription */
        .btn-inscription {
            background-color: white;
            color: #007bff; /* Couleur bleue de IMA-ICORP */
            border: 2px solid white;
            padding: 8px 20px;
            border-radius: 5px;
            font-weight: bold;
        }

      
        .btn-primary {
            background-color: white;
            color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #f0f0f0;
            transform: translateY(-2px);
        }
        
        .btn-outline {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-outline:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        /* Hero section */
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
            color: white;
            padding: 8rem 2rem 6rem;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
            opacity: 0.9;
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        /* Features section */
        .features {
            padding: 5rem 2rem;
            background-color: var(--secondary-color);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            color: var(--primary-color);
            font-size: 2rem;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .feature-card {
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: var(--primary-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            font-size: 1.5rem;
        }
        
        .feature-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            color: #333;
        }
        
        .feature-description {
            color: #666;
            line-height: 1.6;
        }
        
        /* About section */
        .about {
            padding: 5rem 2rem;
            background-color: white;
        }
        
        .about-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }
        
        .about-content p {
            margin-bottom: 1.5rem;
            line-height: 1.7;
            color: #555;
        }
        
        /* Footer */
        .footer {
            background-color: #333;
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: left;
            padding: 0 2rem;
        }
        
        .footer-column h3 {
            color: white;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }
        
        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-column ul li {
            margin-bottom: 0.5rem;
        }
        
        .footer-column a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-column a:hover {
            color: white;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 2rem;
            padding-top: 2rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .social-icons a {
            color: white;
            margin: 0 0.5rem;
            font-size: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .social-icons a:hover {
            transform: translateY(-3px);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .feature-card {
                padding: 1.5rem;
            }
            
            .nav-links .btn {
                display: none;
            }
            
            .hidden-mobile {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
            }
        }
        
        @media (min-width: 769px) {
            .mobile-menu-btn {
                display: none;
            }
        }
    </style>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container header-container">
            <div class="logo-container">
                <img src="{{ asset('logo-icorp-white.png') }}" alt="IMA Logo" 
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNTAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCAxNTAgODAiPjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iODAiIGZpbGw9IiMwMDdiZmYiLz48dGV4dCB4PSI3NSIgeT0iNDUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIyMCIgZmlsbD0id2hpdGUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGFsaWdubWVudC1iYXNlbGluZT0ibWlkZGxlIj5JTUEtSUNPUlA8L3RleHQ+PC9zdmc+'" >
                <span class="logo-text">IMA-ICORP</span>
            </div>
            
            <div class="nav-links">
                <a href="#features" class="hidden-mobile">Fonctionnalités</a>
                <a href="#about" class="hidden-mobile">À propos</a>
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-outline">Tableau de bord</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline">Inscription</a>
                    @endif
                @endauth
            </div>
            
            <button class="mobile-menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Hero section -->
    <section class="hero">
        <div class="container">
            <h1>ICORP Management Application</h1>
            <p>Une solution complète pour la gestion du personnel, des académies et des services de l'entreprise Intelligentsia Corporation.</p>
            
            <div class="cta-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Accéder à mon espace</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline">S'inscrire</a>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    <!-- Features section -->
    <section class="features" id="features">
        <h2 class="section-title">Fonctionnalités</h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="feature-title">Gestion du Personnel</h3>
                <p class="feature-description">Gérez efficacement les enseignants, les élèves et le personnel administratif avec un suivi complet des contrats et des activités.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-university"></i>
                </div>
                <h3 class="feature-title">Gestion des Académies</h3>
                <p class="feature-description">Organisez vos académies, départements et centres de formation avec une structure hiérarchique claire et flexible.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="feature-title">Suivi Financier</h3>
                <p class="feature-description">Suivez en temps réel les paiements, les rémunérations et toutes les transactions financières de votre organisation.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3 class="feature-title">Planification des Cours</h3>
                <p class="feature-description">Planifiez et organisez les cours, les emplois du temps et les affectations des enseignants de manière optimale.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-book"></i>
                </div>
                <h3 class="feature-title">Gestion Documentaire</h3>
                <p class="feature-description">Centralisez et organisez tous vos documents pédagogiques et administratifs pour un accès facile et sécurisé.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h3 class="feature-title">Notifications et Rappels</h3>
                <p class="feature-description">Restez informé des échéances importantes et des événements grâce à un système de notifications personnalisées.</p>
            </div>
        </div>
    </section>

    <!-- About section -->
    <section class="about" id="about">
        <h2 class="section-title">À propos d'IMA-ICORP</h2>
        
        <div class="about-content">
            <p>IMA-ICORP (ICORP Management Application) est une solution développée spécifiquement pour Intelligentsia Corporation afin d'optimiser la gestion de ses ressources humaines et de ses services.</p>
            <p>Notre application centralise toutes les données académiques et financières, automatise les processus administratifs et offre une vision claire de toutes les activités de l'entreprise.</p>
            <p>Développée avec les dernières technologies, IMA-ICORP garantit une expérience utilisateur optimale, une sécurité renforcée et une évolutivité pour s'adapter à la croissance de votre organisation.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>IMA-ICORP</h3>
                    <ul>
                        <li><a href="#about">À propos</a></li>
                        <li><a href="#features">Fonctionnalités</a></li>
                        <li><a href="#">Tarifs</a></li>
                        <li><a href="#">Nous contacter</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Ressources</h3>
                    <ul>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Guide d'utilisation</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Légal</h3>
                    <ul>
                        <li><a href="#">Conditions d'utilisation</a></li>
                        <li><a href="#">Politique de confidentialité</a></li>
                        <li><a href="#">Mentions légales</a></li>
                        <li><a href="#">Cookies</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contact</h3>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Yaoundé, Cameroun</li>
                        <li><i class="fas fa-phone"></i> +237 XXX XXX XXX</li>
                        <li><i class="fas fa-envelope"></i> contact@ima-icorp.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
                <p>&copy; {{ date('Y') }} Intelligentsia Corporation. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
            alert('Menu mobile à implémenter');
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>