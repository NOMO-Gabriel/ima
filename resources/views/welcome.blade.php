<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IMA - ICORP Management App</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity:1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity:1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:0.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:0.25rem}.mt-2{margin-top:0.5rem}.mr-2{margin-right:0.5rem}.ml-2{margin-left:0.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow:0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity:1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity:1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity:1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:0.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity:1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity:1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity:1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        
        /* Custom IMA-ICORP styles */
        :root {
            --primary-color: #007bff;
            --secondary-color: #f8f9fa;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --background-color: #ffffff;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--background-color);
            color: #333;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
        }
        
        .header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .logo-container img {
            height: 80px;
            margin-right: 1rem;
        }
        
        .logo-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 2rem;
        }
        
        .hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, #0056b3 100%);
            color: white;
            padding: 4rem 2rem;
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
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            font-weight: 500;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background-color: white;
            color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #f0f0f0;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }
        
        .features {
            padding: 4rem 2rem;
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
            transition: transform 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            background-color: var(--primary-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
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
        
        .about {
            padding: 4rem 2rem;
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
        
        .footer {
            background-color: #333;
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .footer p {
            margin: 0;
        }
        
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
        }
    </style>
</head>
<body class="antialiased">
    <header class="header">
        <div class="logo-container">
            <img src="{{ asset('images/logo.png') }}" alt="IMA Logo" onerror="this.src='https://via.placeholder.com/80x80?text=IMA'">
            <span class="logo-text">IMA-ICORP</span>
        </div>
        
        <div class="relative sm:flex sm:justify-center sm:items-center">
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 btn btn-secondary">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <section class="hero">
        <h1>ICORP Management Application</h1>
        <p>Une solution complète pour la gestion du personnel, des académies et des services de l'entreprise Intelligentsia Corporation.</p>
        
        <div class="cta-buttons">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Accéder à mon espace</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-secondary">S'inscrire</a>
                @endif
            @endauth
        </div>
    </section>

    <section class="features">
        <h2 class="section-title">Fonctionnalités</h2>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3 class="feature-title">Gestion du Personnel</h3>
                <p class="feature-description">Gérez efficacement les enseignants, les élèves et le personnel administratif avec un suivi complet des contrats et des activités.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🏫</div>
                <h3 class="feature-title">Gestion des Académies</h3>
                <p class="feature-description">Organisez vos académies, départements et centres de formation avec une structure hiérarchique claire et flexible.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3 class="feature-title">Suivi Financier</h3>
                <p class="feature-description">Suivez en temps réel les paiements, les rémunérations et toutes les transactions financières de votre organisation.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📝</div>
                <h3 class="feature-title">Planification des Cours</h3>
                <p class="feature-description">Planifiez et organisez les cours, les emplois du temps et les affectations des enseignants de manière optimale.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h3 class="feature-title">Gestion Documentaire</h3>
                <p class="feature-description">Centralisez et organisez tous vos documents pédagogiques et administratifs pour un accès facile et sécurisé.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🔔</div>
                <h3 class="feature-title">Notifications et Rappels</h3>
                <p class="feature-description">Restez informé des échéances importantes et des événements grâce à un système de notifications personnalisées.</p>
            </div>
        </div>
    </section>

    <section class="about">
        <h2 class="section-title">À propos d'IMA-ICORP</h2>
        
        <div class="about-content">
            <p>IMA-ICORP (ICORP Management Application) est une solution développée spécifiquement pour Intelligentsia Corporation afin d'optimiser la gestion de ses ressources humaines et de ses services.</p>
            <p>Notre application centralise toutes les données académiques et financières, automatise les processus administratifs et offre une vision claire de toutes les activités de l'entreprise.</p>
            <p>Développée avec les dernières technologies, IMA-ICORP garantit une expérience utilisateur optimale, une sécurité renforcée et une évolutivité pour s'adapter à la croissance de votre organisation.</p>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} Intelligentsia Corporation. Tous droits réservés.</p>
    </footer>
</body>
</html>