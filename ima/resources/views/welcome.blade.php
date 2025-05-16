<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ICORP - Institut de préparation aux concours et examens au Cameroun">
    <title>{{ config('app.name', 'ICORP') }} - Institut de Formation</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

   <!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


<!-- Styles -->
@if(app()->environment('local') && !app()->runningUnitTests())
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@else
    <link rel="stylesheet" href="{{ vite_asset('css/app.css') }}">
    <script src="{{ vite_asset('js/app.js') }}" defer></script>
@endif
</head>
<body
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
    :class="{ 'dark bg-slate-900 text-gray-100': darkMode, 'bg-gray-50 text-gray-800': !darkMode }"
    class="font-sans antialiased transition-colors duration-300">

<!-- Header -->
<header class="fixed w-full top-0 z-50 transition-colors duration-300"
        :class="{ 'bg-slate-800 shadow-md': darkMode, 'bg-white shadow-sm': !darkMode }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <img src="{{ asset('logo-icorp-white.png') }}" alt="ICORP Logo" class="h-10 mr-3"
                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNTAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCAxNTAgODAiPjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iODAiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSI3NSIgeT0iNDUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIyMCIgZmlsbD0id2hpdGUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGFsaWdubWVudC1iYXNlbGluZT0ibWlkZGxlIj5JQ09SUDwvdGV4dD48L3N2Zz4='" >
                <span class="font-semibold text-xl font-montserrat transition-colors duration-300"
                      :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">ICORP</span>
            </div>

            <div class="hidden lg:flex lg:space-x-8 items-center">
                <a href="#formations" class="transition-colors duration-300 px-3 py-2 text-sm font-medium"
                   :class="{ 'text-gray-300 hover:text-white': darkMode, 'text-gray-600 hover:text-sky-600': !darkMode }">Formations</a>
                <a href="#centres" class="transition-colors duration-300 px-3 py-2 text-sm font-medium"
                   :class="{ 'text-gray-300 hover:text-white': darkMode, 'text-gray-600 hover:text-sky-600': !darkMode }">Nos centres</a>
                <a href="#temoignages" class="transition-colors duration-300 px-3 py-2 text-sm font-medium"
                   :class="{ 'text-gray-300 hover:text-white': darkMode, 'text-gray-600 hover:text-sky-600': !darkMode }">Témoignages</a>
                <a href="#contact" class="transition-colors duration-300 px-3 py-2 text-sm font-medium"
                   :class="{ 'text-gray-300 hover:text-white': darkMode, 'text-gray-600 hover:text-sky-600': !darkMode }">Contact</a>

                <!-- Language Selector pour desktop -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-1 transition-colors duration-300 px-3 py-2 text-sm font-medium"
                            :class="{ 'text-gray-300 hover:text-white': darkMode, 'text-gray-600 hover:text-sky-600': !darkMode }">
                        <span>{{ strtoupper(app()->getLocale()) }}</span>
                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 py-2 w-32 rounded-md shadow-lg transition-colors duration-300"
                         :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">
                        <a href="{{ route('welcome', ['locale' => 'fr']) }}" class="block px-4 py-2 text-sm transition-colors duration-300 flex items-center justify-between"
                           :class="{
             'text-gray-300 hover:bg-slate-600': darkMode,
             'text-gray-700 hover:bg-gray-100': !darkMode,
             'font-bold': '{{ app()->getLocale() }}' === 'fr'
           }">
                            Français
                            @if(app()->getLocale() === 'fr')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </a>
                        <a href="{{ route('welcome', ['locale' => 'en']) }}" class="block px-4 py-2 text-sm transition-colors duration-300 flex items-center justify-between"
                           :class="{
             'text-gray-300 hover:bg-slate-600': darkMode,
             'text-gray-700 hover:bg-gray-100': !darkMode,
             'font-bold': '{{ app()->getLocale() }}' === 'en'
           }">
                            English
                            @if(app()->getLocale() === 'en')
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- Dark/Light mode toggle -->
                <button @click="darkMode = !darkMode" class="p-2 rounded-md transition-colors duration-300"
                        :class="{ 'text-gray-300 hover:text-white': darkMode, 'text-gray-600 hover:text-sky-600': !darkMode }">
                    <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                    <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                    </svg>
                </button>

                @auth
                    <a href="{{ url('/dashboard', ['locale' => app()->getLocale()]) }}" class="bg-sky-600 text-white hover:bg-sky-700 transition-colors duration-300 px-4 py-2 rounded-md text-sm font-medium">Tableau de bord</a>
                @else
                    <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="transition-colors duration-300 px-3 py-2 text-sm font-medium"
                       :class="{ 'text-gray-300 hover:text-white': darkMode, 'text-gray-600 hover:text-sky-600': !darkMode }">Connexion</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register', ['locale' => app()->getLocale()]) }}" class="bg-sky-600 text-white hover:bg-sky-700 transition-colors duration-300 px-4 py-2 rounded-md text-sm font-medium">Inscription</a>
                    @endif
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center lg:hidden">
                <!-- Dark/Light mode toggle -->
                <button @click="darkMode = !darkMode" class="p-2 rounded-md transition-colors duration-300 mr-2"
                        :class="{ 'text-gray-300 hover:text-white': darkMode, 'text-gray-600 hover:text-sky-600': !darkMode }">
                    <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                    </svg>
                    <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                    </svg>
                </button>

                <button type="button" x-data="{ open: false }" @click="open = !open" class="transition-colors duration-300 focus:outline-none"
                        :class="{ 'text-gray-300 hover:text-white': darkMode, 'text-gray-600 hover:text-gray-800': !darkMode }">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <!-- Mobile menu dropdown -->
                    <div x-show="open" @click.away="open = false" class="absolute top-16 right-0 left-0 transition-colors duration-300 shadow-md"
                         :class="{ 'bg-slate-800': darkMode, 'bg-white': !darkMode }">
                        <div class="px-4 py-3 space-y-3">
                            <a href="#formations" class="block transition-colors duration-300 px-3 py-2 text-base font-medium rounded-md"
                               :class="{ 'text-gray-300 hover:bg-slate-700 hover:text-white': darkMode, 'text-gray-600 hover:bg-gray-100 hover:text-sky-600': !darkMode }">
                                Formations
                            </a>
                            <a href="#centres" class="block transition-colors duration-300 px-3 py-2 text-base font-medium rounded-md"
                               :class="{ 'text-gray-300 hover:bg-slate-700 hover:text-white': darkMode, 'text-gray-600 hover:bg-gray-100 hover:text-sky-600': !darkMode }">
                                Nos centres
                            </a>
                            <a href="#temoignages" class="block transition-colors duration-300 px-3 py-2 text-base font-medium rounded-md"
                               :class="{ 'text-gray-300 hover:bg-slate-700 hover:text-white': darkMode, 'text-gray-600 hover:bg-gray-100 hover:text-sky-600': !darkMode }">
                                Témoignages
                            </a>
                            <a href="#contact" class="block transition-colors duration-300 px-3 py-2 text-base font-medium rounded-md"
                               :class="{ 'text-gray-300 hover:bg-slate-700 hover:text-white': darkMode, 'text-gray-600 hover:bg-gray-100 hover:text-sky-600': !darkMode }">
                                Contact
                            </a>

                            <!-- Language options -->
                            <div class="border-t pt-3 mt-3" :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Langue') }}</p>
                                <div class="mt-2 flex space-x-2 px-3">
                                    <a href="{{ route('welcome', ['locale' => 'fr']) }}" class="transition-colors duration-300 px-3 py-1 text-sm font-medium rounded-md flex items-center"
                                       :class="{
             'bg-slate-700 text-white': darkMode,
             'bg-gray-100 text-gray-800': !darkMode,
             'ring-2 ring-sky-500': '{{ app()->getLocale() }}' === 'fr'
           }">
                                        FR
                                        @if(app()->getLocale() === 'fr')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-sky-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </a>
                                    <a href="{{ route('welcome', ['locale' => 'en']) }}" class="transition-colors duration-300 px-3 py-1 text-sm font-medium rounded-md flex items-center"
                                       :class="{
             'bg-slate-700 text-white': darkMode,
             'bg-gray-100 text-gray-800': !darkMode,
             'ring-2 ring-sky-500': '{{ app()->getLocale() }}' === 'en'
           }">
                                        EN
                                        @if(app()->getLocale() === 'en')
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-sky-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </a>
                                </div>
                            </div>

                            <!-- Auth links -->
                            <div class="border-t pt-3 mt-3" :class="{ 'border-gray-700': darkMode, 'border-gray-200': !darkMode }">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="block w-full text-center bg-sky-600 text-white hover:bg-sky-700 transition-colors duration-300 px-4 py-2 rounded-md text-base font-medium">
                                        Tableau de bord
                                    </a>
                                @else
                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="block transition-colors duration-300 px-3 py-2 text-base font-medium rounded-md text-center"
                                           :class="{ 'text-gray-300 hover:bg-slate-700 hover:text-white': darkMode, 'text-gray-600 hover:bg-gray-100 hover:text-sky-600': !darkMode }">
                                            Connexion
                                        </a>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register', ['locale' => app()->getLocale()]) }}" class="block w-full text-center bg-sky-600 text-white hover:bg-sky-700 transition-colors duration-300 px-4 py-2 rounded-md text-base font-medium">
                                                Inscription
                                            </a>
                                        @endif
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Hero section -->
<section class="pt-32 pb-20 lg:pt-40 lg:pb-28 relative transition-colors duration-300"
         :class="{ 'bg-slate-800': darkMode, 'bg-gray-50': !darkMode }">
    <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
        <img src="{{ asset('logo-icorp.png') }}" alt="ICORP Logo Background" class="w-3/4 max-w-2xl blur-sm"
             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1MDAiIGhlaWdodD0iNTAwIiB2aWV3Qm94PSIwIDAgNTAwIDUwMCI+PHJlY3Qgd2lkdGg9IjUwMCIgaGVpZ2h0PSI1MDAiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSIyNTAiIHk9IjI1MCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjgwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPklDT1JQPC90ZXh0Pjwvc3ZnPg=='" >
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="backdrop-blur-sm rounded-xl shadow-lg p-8 md:p-12 max-w-4xl mx-auto transition-colors duration-300"
             :class="{ 'bg-slate-900/90': darkMode, 'bg-white/95': !darkMode }">
            <h1 class="text-3xl md:text-5xl font-bold mb-4 font-montserrat transition-colors duration-300"
                :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">
                {{ __('Préparez votre avenir') }} <span class="text-sky-600">{{ __('avec ICORP') }}</span>
            </h1>
            <p class="text-lg lg:text-xl mb-8 max-w-3xl mx-auto transition-colors duration-300"
               :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                {{ __('Centre de préparation aux concours nationaux et internationaux au Cameroun. Réussissez vos examens et obtenez des bourses d\'études grâce à nos formations intensives et personnalisées.') }}
            </p>

            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="#formations" class="inline-flex items-center justify-center px-6 py-4 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors duration-300">
                    <i class="fas fa-graduation-cap mr-2"></i> {{ __('Découvrir nos formations') }}
                </a>
                <a href="#contact" class="inline-flex items-center justify-center px-6 py-4 border rounded-md shadow-sm text-base font-medium transition-colors duration-300"
                   :class="{ 'border-gray-600 text-white hover:bg-slate-700': darkMode, 'border-gray-300 text-sky-600 bg-white hover:bg-gray-50': !darkMode }">
                    <i class="fas fa-envelope mr-2"></i> {{ __('Nous contacter') }}
                </a>
            </div>

            <div class="mt-12 flex flex-wrap justify-center gap-8">
                <div class="flex items-center">
                    <div class="text-sky-600 mr-3">
                        <i class="fas fa-users text-3xl"></i>
                    </div>
                    <div class="text-left">
                        <div class="text-3xl font-bold transition-colors duration-300"
                             :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">5000+</div>
                        <div class="text-sm transition-colors duration-300"
                             :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">{{ __('Élèves formés') }}</div>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="text-sky-600 mr-3">
                        <i class="fas fa-trophy text-3xl"></i>
                    </div>
                    <div class="text-left">
                        <div class="text-3xl font-bold transition-colors duration-300"
                             :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">92%</div>
                        <div class="text-sm transition-colors duration-300"
                             :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">{{ __('Taux de réussite') }}</div>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class="text-sky-600 mr-3">
                        <i class="fas fa-map-marker-alt text-3xl"></i>
                    </div>
                    <div class="text-left">
                        <div class="text-3xl font-bold transition-colors duration-300"
                             :class="{ 'text-white': darkMode, 'text-gray-800': !darkMode }">10+</div>
                        <div class="text-sm transition-colors duration-300"
                             :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">{{ __('Centres au Cameroun') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Types de formations section -->
<section id="formations" class="py-16 transition-colors duration-300"
         :class="{ 'bg-slate-900': darkMode, 'bg-white': !darkMode }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-2xl md:text-3xl font-bold font-montserrat transition-colors duration-300"
                :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Nos Programmes de Formation') }}</h2>
            <div class="w-16 h-1 bg-sky-600 mx-auto mt-3"></div>
            <p class="mt-3 text-base md:text-lg max-w-2xl mx-auto transition-colors duration-300"
               :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                {{ __('Programmes adaptés pour vous préparer aux concours nationaux et internationaux') }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- Concours Administratifs -->
            <div class="rounded-md shadow-sm hover:shadow-md transition duration-300 overflow-hidden"
                 :class="{ 'bg-slate-800': darkMode, 'bg-white': !darkMode }">
                <div class="relative h-40 overflow-hidden">
                    <img src="{{ asset('images/concours-administratifs.jpg') }}" alt="Concours Administratifs"
                         class="w-full h-full object-cover"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMjQwIiB2aWV3Qm94PSIwIDAgNDAwIDI0MCI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNDAiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSIyMDAiIHk9IjEyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjIwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPkNvbmNvdXJzIEFkbWluaXN0cmF0aWZzPC90ZXh0Pjwvc3ZnPg=='">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <h3 class="text-lg font-bold text-white">{{ __('Concours Administratifs') }}</h3>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-sky-600 text-white text-xs rounded-sm">
                            {{ __('Concours Nationaux') }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-sm transition-colors duration-300 mb-3 line-clamp-2"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        {{ __('Préparation: ENAM, IRIC, ISSEA, Police, Gendarmerie') }}
                    </p>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium transition-colors duration-300"
                              :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <span class="text-sky-600 font-semibold">75 000 FCFA</span>
                        </span>
                        <span class="transition-colors duration-300"
                              :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('3-6 mois') }}
                        </span>
                    </div>
                    <a href="#contact" class="mt-3 block text-center py-2 rounded text-sm font-medium transition-colors duration-300"
                       :class="{ 'bg-slate-700 text-white hover:bg-slate-600': darkMode, 'bg-sky-100 text-sky-700 hover:bg-sky-200': !darkMode }">
                        {{ __('En savoir plus') }}
                    </a>
                </div>
            </div>

            <!-- Grandes Écoles -->
            <div class="rounded-md shadow-sm hover:shadow-md transition duration-300 overflow-hidden"
                 :class="{ 'bg-slate-800': darkMode, 'bg-white': !darkMode }">
                <div class="relative h-40 overflow-hidden">
                    <img src="{{ asset('images/grandes-ecoles.jpg') }}" alt="Grandes Écoles"
                         class="w-full h-full object-cover"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMjQwIiB2aWV3Qm94PSIwIDAgNDAwIDI0MCI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNDAiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSIyMDAiIHk9IjEyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjIwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPkdyYW5kZXMgw4ljb2xlczwvdGV4dD48L3N2Zz4='">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <h3 class="text-lg font-bold text-white">{{ __('Grandes Écoles') }}</h3>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-sky-600 text-white text-xs rounded-sm">
                            {{ __('Écoles d\'Ingénieurs et Commerce') }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-sm transition-colors duration-300 mb-3 line-clamp-2"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        {{ __('Préparation: Polytechnique, ENSTP, ESSEC, UCAC, ENSP') }}
                    </p>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium transition-colors duration-300"
                              :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <span class="text-sky-600 font-semibold">90 000 FCFA</span>
                        </span>
                        <span class="transition-colors duration-300"
                              :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('4-8 mois') }}
                        </span>
                    </div>
                    <a href="#contact" class="mt-3 block text-center py-2 rounded text-sm font-medium transition-colors duration-300"
                       :class="{ 'bg-slate-700 text-white hover:bg-slate-600': darkMode, 'bg-sky-100 text-sky-700 hover:bg-sky-200': !darkMode }">
                        {{ __('En savoir plus') }}
                    </a>
                </div>
            </div>

            <!-- Bourses Internationales -->
            <div class="rounded-md shadow-sm hover:shadow-md transition duration-300 overflow-hidden"
                 :class="{ 'bg-slate-800': darkMode, 'bg-white': !darkMode }">
                <div class="relative h-40 overflow-hidden">
                    <img src="{{ asset('images/bourses-internationales.jpg') }}" alt="Bourses Internationales"
                         class="w-full h-full object-cover"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMjQwIiB2aWV3Qm94PSIwIDAgNDAwIDI0MCI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNDAiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSIyMDAiIHk9IjEyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjIwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPkJvdXJzZXMgSW50ZXJuYXRpb25hbGVzPC90ZXh0Pjwvc3ZnPg=='">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <h3 class="text-lg font-bold text-white">{{ __('Bourses Internationales') }}</h3>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-sky-600 text-white text-xs rounded-sm">
                            {{ __('Études à l\'étranger') }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-sm transition-colors duration-300 mb-3 line-clamp-2"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        {{ __('Dossiers: DAAD, Fulbright, Chevening, Campus France') }}
                    </p>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium transition-colors duration-300"
                              :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <span class="text-sky-600 font-semibold">120 000 FCFA</span>
                        </span>
                        <span class="transition-colors duration-300"
                              :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('2-4 mois') }}
                        </span>
                    </div>
                    <a href="#contact" class="mt-3 block text-center py-2 rounded text-sm font-medium transition-colors duration-300"
                       :class="{ 'bg-slate-700 text-white hover:bg-slate-600': darkMode, 'bg-sky-100 text-sky-700 hover:bg-sky-200': !darkMode }">
                        {{ __('En savoir plus') }}
                    </a>
                </div>
            </div>

            <!-- Examens Officiels -->
            <div class="rounded-md shadow-sm hover:shadow-md transition duration-300 overflow-hidden"
                 :class="{ 'bg-slate-800': darkMode, 'bg-white': !darkMode }">
                <div class="relative h-40 overflow-hidden">
                    <img src="{{ asset('images/examens-officiels.jpg') }}" alt="Examens Officiels"
                         class="w-full h-full object-cover"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMjQwIiB2aWV3Qm94PSIwIDAgNDAwIDI0MCI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNDAiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSIyMDAiIHk9IjEyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjIwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPkV4YW1lbnMgT2ZmaWNpZWxzPC90ZXh0Pjwvc3ZnPg=='">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <h3 class="text-lg font-bold text-white">{{ __('Examens Officiels') }}</h3>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-sky-600 text-white text-xs rounded-sm">
                            {{ __('Diplômes Nationaux') }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-sm transition-colors duration-300 mb-3 line-clamp-2"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        {{ __('Préparation: BEPC, Probatoire, Baccalauréat, BTS') }}
                    </p>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium transition-colors duration-300"
                              :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <span class="text-sky-600 font-semibold">50 000 FCFA</span>
                        </span>
                        <span class="transition-colors duration-300"
                              :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('3-9 mois') }}
                        </span>
                    </div>
                    <a href="#contact" class="mt-3 block text-center py-2 rounded text-sm font-medium transition-colors duration-300"
                       :class="{ 'bg-slate-700 text-white hover:bg-slate-600': darkMode, 'bg-sky-100 text-sky-700 hover:bg-sky-200': !darkMode }">
                        {{ __('En savoir plus') }}
                    </a>
                </div>
            </div>

            <!-- Tests Internationaux -->
            <div class="rounded-md shadow-sm hover:shadow-md transition duration-300 overflow-hidden"
                 :class="{ 'bg-slate-800': darkMode, 'bg-white': !darkMode }">
                <div class="relative h-40 overflow-hidden">
                    <img src="{{ asset('images/tests-internationaux.jpg') }}" alt="Tests Internationaux"
                         class="w-full h-full object-cover"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMjQwIiB2aWV3Qm94PSIwIDAgNDAwIDI0MCI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNDAiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSIyMDAiIHk9IjEyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjIwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPlRlc3RzIEludGVybmF0aW9uYXV4PC90ZXh0Pjwvc3ZnPg=='">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <h3 class="text-lg font-bold text-white">{{ __('Tests Internationaux') }}</h3>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-sky-600 text-white text-xs rounded-sm">
                            {{ __('Certifications Internationales') }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-sm transition-colors duration-300 mb-3 line-clamp-2"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        {{ __('Préparation: TOEFL, IELTS, SAT, GRE, GMAT, TCF, TEF') }}
                    </p>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium transition-colors duration-300"
                              :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <span class="text-sky-600 font-semibold">100 000 FCFA</span>
                        </span>
                        <span class="transition-colors duration-300"
                              :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('1-3 mois') }}
                        </span>
                    </div>
                    <a href="#contact" class="mt-3 block text-center py-2 rounded text-sm font-medium transition-colors duration-300"
                       :class="{ 'bg-slate-700 text-white hover:bg-slate-600': darkMode, 'bg-sky-100 text-sky-700 hover:bg-sky-200': !darkMode }">
                        {{ __('En savoir plus') }}
                    </a>
                </div>
            </div>

            <!-- Formations Spéciales -->
            <div class="rounded-md shadow-sm hover:shadow-md transition duration-300 overflow-hidden"
                 :class="{ 'bg-slate-800': darkMode, 'bg-white': !darkMode }">
                <div class="relative h-40 overflow-hidden">
                    <img src="{{ asset('images/formations-speciales.jpg') }}" alt="Formations Spéciales"
                         class="w-full h-full object-cover"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMjQwIiB2aWV3Qm94PSIwIDAgNDAwIDI0MCI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyNDAiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSIyMDAiIHk9IjEyMCIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjIwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPkZvcm1hdGlvbnMgU3DDqWNpYWxlczwvdGV4dD48L3N2Zz4='">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3">
                        <h3 class="text-lg font-bold text-white">{{ __('Formations Spéciales') }}</h3>
                        <span class="inline-block mt-1 px-2 py-0.5 bg-sky-600 text-white text-xs rounded-sm">
                            {{ __('Formations Personnalisées') }}
                        </span>
                    </div>
                </div>
                <div class="p-4">
                    <p class="text-sm transition-colors duration-300 mb-3 line-clamp-2"
                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        {{ __('Cours intensifs et coaching personnalisé') }}
                    </p>
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-medium transition-colors duration-300"
                              :class="{ 'text-gray-200': darkMode, 'text-gray-800': !darkMode }">
                            <span class="text-sky-600 font-semibold">150 000 FCFA</span>
                        </span>
                        <span class="transition-colors duration-300"
                              :class="{ 'text-gray-300': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('Variable') }}
                        </span>
                    </div>
                    <a href="#contact" class="mt-3 block text-center py-2 rounded text-sm font-medium transition-colors duration-300"
                       :class="{ 'bg-slate-700 text-white hover:bg-slate-600': darkMode, 'bg-sky-100 text-sky-700 hover:bg-sky-200': !darkMode }">
                        {{ __('En savoir plus') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-10 text-center">
            <a href="#contact" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors duration-300">
                {{ __('Demander plus d\'informations') }}
            </a>
        </div>
    </div>
</section>

<!-- Notre méthode section -->
<section class="py-20 transition-colors duration-300"
         :class="{ 'bg-slate-800': darkMode, 'bg-gray-50': !darkMode }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold font-montserrat transition-colors duration-300"
                :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Notre Méthode d\'Enseignement') }}</h2>
            <div class="w-16 h-1 bg-sky-600 mx-auto mt-4"></div>
            <p class="mt-4 text-xl max-w-3xl mx-auto transition-colors duration-300"
               :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                {{ __('Une approche pédagogique efficace pour un taux de réussite élevé') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-sky-600 flex items-center justify-center text-white text-2xl mx-auto mb-4">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 transition-colors duration-300"
                    :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Cours Structurés') }}</h3>
                <p class="transition-colors duration-300"
                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                    {{ __('Cours méthodiques avec des supports pédagogiques complets et adaptés à chaque programme.') }}
                </p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-sky-600 flex items-center justify-center text-white text-2xl mx-auto mb-4">
                    <i class="fas fa-users"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 transition-colors duration-300"
                    :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Petits Groupes') }}</h3>
                <p class="transition-colors duration-300"
                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                    {{ __('Classes limitées à 15-20 élèves pour garantir une attention personnalisée et un meilleur suivi.') }}
                </p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-sky-600 flex items-center justify-center text-white text-2xl mx-auto mb-4">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 transition-colors duration-300"
                    :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Évaluations Régulières') }}</h3>
                <p class="transition-colors duration-300"
                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                    {{ __('Tests hebdomadaires et examens blancs pour mesurer les progrès et identifier les points à améliorer.') }}
                </p>
            </div>

            <div class="text-center">
                <div class="w-20 h-20 rounded-full bg-sky-600 flex items-center justify-center text-white text-2xl mx-auto mb-4">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 transition-colors duration-300"
                    :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Enseignants Qualifiés') }}</h3>
                <p class="transition-colors duration-300"
                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                    {{ __('Professeurs expérimentés, souvent membres des jurys d\'examens et spécialistes dans leurs domaines.') }}
                </p>
            </div>
        </div>

        <div class="mt-16 bg-gradient-to-r from-sky-600 to-sky-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-8 md:p-12 lg:flex items-center">
                <div class="lg:w-3/5 lg:pr-8 mb-8 lg:mb-0">
                    <h3 class="text-2xl font-bold text-white mb-4">{{ __('Pourquoi choisir ICORP?') }}</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <span class="text-white mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-white">{{ __('Taux de réussite supérieur à 92% dans tous nos programmes') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-white mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-white">{{ __('Plus de 15 ans d\'expérience dans la préparation aux concours') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-white mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-white">{{ __('Suivi personnalisé et soutien académique continu') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-white mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-white">{{ __('Réseau d\'anciens élèves actifs et entraide communautaire') }}</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-white mr-2"><i class="fas fa-check-circle"></i></span>
                            <span class="text-white">{{ __('Environnement d\'apprentissage moderne et stimulant') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="lg:w-2/5 lg:border-l lg:border-white/30 lg:pl-8">
                    <div class="text-center">
                        <p class="text-xl text-white mb-6">{{ __('Inscrivez-vous dès maintenant pour bénéficier de notre offre spéciale') }}</p>
                        <div class="bg-white rounded-lg p-4 text-center">
                            <p class="text-sky-800 font-semibold mb-2">{{ __('Réduction de 15%') }}</p>
                            <p class="text-gray-600 text-sm mb-4">{{ __('Pour toute inscription avant le 30 du mois') }}</p>
                            <a href="#contact" class="inline-block px-6 py-3 bg-sky-700 text-white rounded-md hover:bg-sky-800 transition-colors duration-300">
                                {{ __('J\'en profite maintenant') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Centres section -->
<section id="centres" class="py-16 transition-colors duration-300"
         :class="{ 'bg-slate-900': darkMode, 'bg-white': !darkMode }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-2xl md:text-3xl font-bold font-montserrat transition-colors duration-300"
                :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Nos Centres de Formation') }}</h2>
            <div class="w-16 h-1 bg-sky-600 mx-auto mt-3"></div>
            <p class="mt-4 text-base md:text-lg max-w-2xl mx-auto transition-colors duration-300"
               :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                {{ __('Présents dans les principales villes du Cameroun pour être plus proche de vous') }}
            </p>
        </div>

        <!-- Featured centers with map-style design -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-10">
            <div class="lg:col-span-5 flex flex-col gap-4">
                <!-- Yaoundé Centre -->
                <div class="rounded-lg overflow-hidden transition-colors duration-300 border"
                     :class="{ 'bg-slate-800 border-slate-700 hover:border-sky-600': darkMode, 'bg-white border-gray-100 shadow-sm hover:border-sky-600 hover:shadow-md': !darkMode }">
                    <div class="flex flex-col sm:flex-row">
                        <div class="sm:w-1/3 h-40 sm:h-auto relative overflow-hidden">
                            <div class="absolute inset-0 bg-sky-600 bg-opacity-10 z-10"></div>
                            <img src="{{ asset('images/yaounde-centre.jpg') }}" alt="Yaoundé Centre"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMjI0IiB2aWV3Qm94PSIwIDAgNDAwIDIyNCI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyMjQiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSIyMDAiIHk9IjExMiIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjIwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPllhb3VuZMOpIENlbnRyZTwvdGV4dD48L3N2Zz4='">
                            <div class="absolute top-0 left-0 py-1 px-3 m-2 bg-sky-600 text-white text-xs rounded-full font-medium z-20">
                                {{ __('Centre Principal') }}
                            </div>
                        </div>
                        <div class="sm:w-2/3 p-4">
                            <h3 class="text-lg font-bold mb-2 transition-colors duration-300 flex items-center"
                                :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">
                                <i class="fas fa-building text-sky-600 mr-2"></i>
                                {{ __('Yaoundé') }}
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt mt-1 mr-2 text-sky-600 w-4 text-center"></i>
                                    <p class="transition-colors duration-300 flex-1"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                        Avenue Kennedy, Face Immeuble CNPS, Yaoundé
                                    </p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-phone-alt mt-1 mr-2 text-sky-600 w-4 text-center"></i>
                                    <p class="transition-colors duration-300 flex-1"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                        +237 222 222 222
                                    </p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-clock mt-1 mr-2 text-sky-600 w-4 text-center"></i>
                                    <p class="transition-colors duration-300 flex-1"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                        Lun-Sam: 8h-18h
                                    </p>
                                </div>
                            </div>
                            <div class="mt-3 pt-2 border-t" :class="{ 'border-slate-700': darkMode, 'border-gray-100': !darkMode }">
                                <a href="#contact" class="text-sky-600 hover:text-sky-700 text-sm font-medium flex items-center transition-colors duration-300">
                                    <i class="fas fa-info-circle mr-1"></i> {{ __('Demander des informations') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Douala -->
                <div class="rounded-lg overflow-hidden transition-colors duration-300 border"
                     :class="{ 'bg-slate-800 border-slate-700 hover:border-sky-600': darkMode, 'bg-white border-gray-100 shadow-sm hover:border-sky-600 hover:shadow-md': !darkMode }">
                    <div class="flex flex-col sm:flex-row">
                        <div class="sm:w-1/3 h-40 sm:h-auto relative overflow-hidden">
                            <div class="absolute inset-0 bg-sky-600 bg-opacity-10 z-10"></div>
                            <img src="{{ asset('images/douala.jpg') }}" alt="Douala"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMjI0IiB2aWV3Qm94PSIwIDAgNDAwIDIyNCI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyMjQiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSIyMDAiIHk9IjExMiIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjIwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPkRvdWFsYTwvdGV4dD48L3N2Zz4='">
                        </div>
                        <div class="sm:w-2/3 p-4">
                            <h3 class="text-lg font-bold mb-2 transition-colors duration-300 flex items-center"
                                :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">
                                <i class="fas fa-building text-sky-600 mr-2"></i>
                                {{ __('Douala') }}
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt mt-1 mr-2 text-sky-600 w-4 text-center"></i>
                                    <p class="transition-colors duration-300 flex-1"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                        Quartier Akwa, Près de la Poste Centrale, Douala
                                    </p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-phone-alt mt-1 mr-2 text-sky-600 w-4 text-center"></i>
                                    <p class="transition-colors duration-300 flex-1"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                        +237 233 333 333
                                    </p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-clock mt-1 mr-2 text-sky-600 w-4 text-center"></i>
                                    <p class="transition-colors duration-300 flex-1"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                        Lun-Sam: 8h-18h
                                    </p>
                                </div>
                            </div>
                            <div class="mt-3 pt-2 border-t" :class="{ 'border-slate-700': darkMode, 'border-gray-100': !darkMode }">
                                <a href="#contact" class="text-sky-600 hover:text-sky-700 text-sm font-medium flex items-center transition-colors duration-300">
                                    <i class="fas fa-info-circle mr-1"></i> {{ __('Demander des informations') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bafoussam -->
                <div class="rounded-lg overflow-hidden transition-colors duration-300 border"
                     :class="{ 'bg-slate-800 border-slate-700 hover:border-sky-600': darkMode, 'bg-white border-gray-100 shadow-sm hover:border-sky-600 hover:shadow-md': !darkMode }">
                    <div class="flex flex-col sm:flex-row">
                        <div class="sm:w-1/3 h-40 sm:h-auto relative overflow-hidden">
                            <div class="absolute inset-0 bg-sky-600 bg-opacity-10 z-10"></div>
                            <img src="{{ asset('images/bafoussam.jpg') }}" alt="Bafoussam"
                                 class="w-full h-full object-cover"
                                 onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MDAiIGhlaWdodD0iMjI0IiB2aWV3Qm94PSIwIDAgNDAwIDIyNCI+PHJlY3Qgd2lkdGg9IjQwMCIgaGVpZ2h0PSIyMjQiIGZpbGw9IiM0Q0EzREQiLz48dGV4dCB4PSIyMDAiIHk9IjExMiIgZm9udC1mYW1pbHk9IkFyaWFsIiBmb250LXNpemU9IjIwIiBmaWxsPSJ3aGl0ZSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgYWxpZ25tZW50LWJhc2VsaW5lPSJtaWRkbGUiPkJhZm91c3NhbTwvdGV4dD48L3N2Zz4='">
                        </div>
                        <div class="sm:w-2/3 p-4">
                            <h3 class="text-lg font-bold mb-2 transition-colors duration-300 flex items-center"
                                :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">
                                <i class="fas fa-building text-sky-600 mr-2"></i>
                                {{ __('Bafoussam') }}
                            </h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt mt-1 mr-2 text-sky-600 w-4 text-center"></i>
                                    <p class="transition-colors duration-300 flex-1"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                        Quartier Banengo, Face Marché A, Bafoussam
                                    </p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-phone-alt mt-1 mr-2 text-sky-600 w-4 text-center"></i>
                                    <p class="transition-colors duration-300 flex-1"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                        +237 244 444 444
                                    </p>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-clock mt-1 mr-2 text-sky-600 w-4 text-center"></i>
                                    <p class="transition-colors duration-300 flex-1"
                                       :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                        Lun-Ven: 8h-17h, Sam: 9h-15h
                                    </p>
                                </div>
                            </div>
                            <div class="mt-3 pt-2 border-t" :class="{ 'border-slate-700': darkMode, 'border-gray-100': !darkMode }">
                                <a href="#contact" class="text-sky-600 hover:text-sky-700 text-sm font-medium flex items-center transition-colors duration-300">
                                    <i class="fas fa-info-circle mr-1"></i> {{ __('Demander des informations') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map visualization -->
            <div class="lg:col-span-7 rounded-lg overflow-hidden transition-colors duration-300 border h-auto min-h-[300px] md:min-h-[380px]"
                 :class="{ 'bg-slate-800 border-slate-700': darkMode, 'bg-white border-gray-100 shadow-sm': !darkMode }">
                <div class="h-full w-full relative">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1990.2662869628398!2d11.516124877632302!3d3.866337098124757!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x108bcfb8c3139b05%3A0xd0a4f30ee3701365!2sYaound%C3%A9%2C%20Cameroon!5e0!3m2!1sen!2sus!4v1717241647909!5m2!1sen!2sus"
                        style="border:0; width:100%; height:100%;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                </div>
            </div>
        </div>

        <!-- Additional Centers -->
        <div class="transition-colors duration-300 rounded-lg p-5 mb-10"
             :class="{ 'bg-slate-800': darkMode, 'bg-gray-50': !darkMode }">
            <h3 class="text-lg font-bold mb-4 transition-colors duration-300"
                :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">
                <i class="fas fa-globe-africa text-sky-600 mr-2"></i> {{ __('Autres centres au Cameroun') }}
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Bamenda -->
                <div class="p-3 rounded transition-colors duration-300 flex items-center"
                     :class="{ 'bg-slate-700 hover:bg-slate-600': darkMode, 'bg-white shadow-sm hover:shadow': !darkMode }">
                    <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-3 flex-shrink-0">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Bamenda</h4>
                        <p class="text-xs transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('Nord-Ouest') }}
                        </p>
                    </div>
                </div>

                <!-- Buea -->
                <div class="p-3 rounded transition-colors duration-300 flex items-center"
                     :class="{ 'bg-slate-700 hover:bg-slate-600': darkMode, 'bg-white shadow-sm hover:shadow': !darkMode }">
                    <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-3 flex-shrink-0">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Buea</h4>
                        <p class="text-xs transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('Sud-Ouest') }}
                        </p>
                    </div>
                </div>

                <!-- Garoua -->
                <div class="p-3 rounded transition-colors duration-300 flex items-center"
                     :class="{ 'bg-slate-700 hover:bg-slate-600': darkMode, 'bg-white shadow-sm hover:shadow': !darkMode }">
                    <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-3 flex-shrink-0">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Garoua</h4>
                        <p class="text-xs transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('Nord') }}
                        </p>
                    </div>
                </div>

                <!-- Limbé -->
                <div class="p-3 rounded transition-colors duration-300 flex items-center"
                     :class="{ 'bg-slate-700 hover:bg-slate-600': darkMode, 'bg-white shadow-sm hover:shadow': !darkMode }">
                    <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-3 flex-shrink-0">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Limbé</h4>
                        <p class="text-xs transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('Sud-Ouest') }}
                        </p>
                    </div>
                </div>

                <!-- Maroua -->
                <div class="p-3 rounded transition-colors duration-300 flex items-center"
                     :class="{ 'bg-slate-700 hover:bg-slate-600': darkMode, 'bg-white shadow-sm hover:shadow': !darkMode }">
                    <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-3 flex-shrink-0">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Maroua</h4>
                        <p class="text-xs transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('Extrême-Nord') }}
                        </p>
                    </div>
                </div>

                <!-- Ngaoundéré -->
                <div class="p-3 rounded transition-colors duration-300 flex items-center"
                     :class="{ 'bg-slate-700 hover:bg-slate-600': darkMode, 'bg-white shadow-sm hover:shadow': !darkMode }">
                    <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-3 flex-shrink-0">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Ngaoundéré</h4>
                        <p class="text-xs transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('Adamaoua') }}
                        </p>
                    </div>
                </div>

                <!-- Bertoua -->
                <div class="p-3 rounded transition-colors duration-300 flex items-center"
                     :class="{ 'bg-slate-700 hover:bg-slate-600': darkMode, 'bg-white shadow-sm hover:shadow': !darkMode }">
                    <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-3 flex-shrink-0">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Bertoua</h4>
                        <p class="text-xs transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('Est') }}
                        </p>
                    </div>
                </div>

                <!-- Ebolowa -->
                <div class="p-3 rounded transition-colors duration-300 flex items-center"
                     :class="{ 'bg-slate-700 hover:bg-slate-600': darkMode, 'bg-white shadow-sm hover:shadow': !darkMode }">
                    <div class="w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-3 flex-shrink-0">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <h4 class="font-medium transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Ebolowa</h4>
                        <p class="text-xs transition-colors duration-300"
                           :class="{ 'text-gray-400': darkMode, 'text-gray-500': !darkMode }">
                            {{ __('Sud') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA -->
        <div class="text-center">
            <a href="#contact" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-sky-600 hover:bg-sky-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-500 transition-colors duration-300">
                <i class="fas fa-map-marked-alt mr-2"></i> {{ __('Trouver un centre près de chez vous') }}
            </a>
        </div>
    </div>
</section>

<!-- Témoignages section -->
<section id="temoignages" class="py-20 transition-colors duration-300"
         :class="{ 'bg-slate-800': darkMode, 'bg-gray-50': !darkMode }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold font-montserrat transition-colors duration-300"
                :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Témoignages d\'Étudiants') }}</h2>
            <div class="w-16 h-1 bg-sky-600 mx-auto mt-4"></div>
            <p class="mt-4 text-xl max-w-3xl mx-auto transition-colors duration-300"
               :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                {{ __('Ce que disent nos étudiants qui ont réussi leurs concours') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Témoignage 1 -->
            <div class="rounded-lg shadow-md p-6 transition-colors duration-300"
                 :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-4">
                        <span class="text-xl font-bold">AS</span>
                    </div>
                    <div>
                        <h4 class="font-bold transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Ange Solange</h4>
                        <p class="text-sm transition-colors duration-300"
                           :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                            Admise à l'ENAM - Promotion 2023
                        </p>
                    </div>
                </div>
                <p class="transition-colors duration-300 italic"
                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                    "Après deux échecs à l'ENAM, j'ai intégré ICORP pour ma préparation. La méthode d'enseignement, les cours intensifs et le soutien des professeurs ont fait toute la différence. J'ai été admise au premier tour cette année!"
                </p>
                <div class="mt-4 flex text-yellow-500">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>

            <!-- Témoignage 2 -->
            <div class="rounded-lg shadow-md p-6 transition-colors duration-300"
                 :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-4">
                        <span class="text-xl font-bold">JC</span>
                    </div>
                    <div>
                        <h4 class="font-bold transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Jean Claude</h4>
                        <p class="text-sm transition-colors duration-300"
                           :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                            Admis à Polytechnique - Promotion 2023
                        </p>
                    </div>
                </div>
                <p class="transition-colors duration-300 italic"
                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                    "Les cours à ICORP sont d'un niveau exceptionnel. Les professeurs, tous expérimentés, connaissent parfaitement les exigences des concours. Les examens blancs réguliers m'ont permis de me préparer efficacement et d'être classé parmi les 10 premiers."
                </p>
                <div class="mt-4 flex text-yellow-500">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>

            <!-- Témoignage 3 -->
            <div class="rounded-lg shadow-md p-6 transition-colors duration-300"
                 :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">
                <div class="flex items-center mb-6">
                    <div class="w-14 h-14 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-4">
                        <span class="text-xl font-bold">CM</span>
                    </div>
                    <div>
                        <h4 class="font-bold transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">Carole Mbarga</h4>
                        <p class="text-sm transition-colors duration-300"
                           :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                            Bourse Fulbright obtenue en 2024
                        </p>
                    </div>
                </div>
                <p class="transition-colors duration-300 italic"
                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                    "La préparation au TOEFL et l'aide à la constitution de mon dossier par ICORP ont été déterminantes. J'ai obtenu un score de 107/120 au TOEFL et j'ai décroché la bourse Fulbright pour poursuivre mes études aux États-Unis."
                </p>
                <div class="mt-4 flex text-yellow-500">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
            </div>
        </div>

        <div class="mt-16 text-center max-w-3xl mx-auto">
            <div class="p-8 rounded-lg shadow-md transition-colors duration-300"
                 :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">
                <div class="text-sky-600 text-5xl mb-6">
                    <i class="fas fa-quote-left"></i>
                </div>
                <blockquote class="text-xl italic font-medium mb-6 transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-700': !darkMode }">
                    "ICORP ne se contente pas de préparer aux concours, ils vous préparent à réussir dans la vie. La qualité de l'enseignement, le professionnalisme des formateurs et l'encadrement personnalisé font toute la différence."
                </blockquote>
                <div class="flex items-center justify-center">
                    <div class="w-16 h-16 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 mr-4">
                        <span class="text-xl font-bold">PM</span>
                    </div>
                    <div class="text-left">
                        <p class="font-bold transition-colors duration-300"
                           :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">
                            Prof. Martin Nguemeni
                        </p>
                        <p class="transition-colors duration-300"
                           :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                            Directeur des études à l'Université de Yaoundé I
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact section -->
<section id="contact" class="py-20 transition-colors duration-300"
         :class="{ 'bg-slate-900': darkMode, 'bg-white': !darkMode }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold font-montserrat transition-colors duration-300"
                :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Contactez-nous') }}</h2>
            <div class="w-16 h-1 bg-sky-600 mx-auto mt-4"></div>
            <p class="mt-4 text-xl max-w-3xl mx-auto transition-colors duration-300"
               :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                {{ __('Prenez contact avec nous pour plus d\'informations sur nos formations') }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="rounded-lg shadow-md overflow-hidden transition-colors duration-300"
                 :class="{ 'bg-slate-800': darkMode, 'bg-white': !darkMode }">
                <div class="p-8">
                    <h3 class="text-xl font-bold mb-6 transition-colors duration-300"
                        :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Envoyez-nous un message') }}</h3>

                    <form action="{{ route('contact.store', ['locale' => app()->getLocale()]) }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">{{ __('Nom complet') }}</label>
                            <input type="text" name="name" id="name" required
                                   class="w-full px-4 py-3 rounded-md border transition-colors duration-300"
                                   :class="{ 'bg-slate-700 border-slate-600 text-white focus:border-sky-500': darkMode, 'border-gray-300 focus:border-sky-500 focus:ring-sky-500': !darkMode }">
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">{{ __('Email') }}</label>
                            <input type="email" name="email" id="email" required
                                   class="w-full px-4 py-3 rounded-md border transition-colors duration-300"
                                   :class="{ 'bg-slate-700 border-slate-600 text-white focus:border-sky-500': darkMode, 'border-gray-300 focus:border-sky-500 focus:ring-sky-500': !darkMode }">
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">{{ __('Téléphone') }}</label>
                            <input type="tel" name="phone" id="phone"
                                   class="w-full px-4 py-3 rounded-md border transition-colors duration-300"
                                   :class="{ 'bg-slate-700 border-slate-600 text-white focus:border-sky-500': darkMode, 'border-gray-300 focus:border-sky-500 focus:ring-sky-500': !darkMode }">
                        </div>

                        <div>
                            <label for="formation" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">{{ __('Formation souhaitée') }}</label>
                            <select name="formation" id="formation"
                                    class="w-full px-4 py-3 rounded-md border transition-colors duration-300"
                                    :class="{ 'bg-slate-700 border-slate-600 text-white focus:border-sky-500': darkMode, 'border-gray-300 focus:border-sky-500 focus:ring-sky-500': !darkMode }">
                                <option value="" :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">{{ __('Sélectionner une formation') }}</option>
                                <option value="concours_administratifs" :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">{{ __('Concours Administratifs') }}</option>
                                <option value="grandes_ecoles" :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">{{ __('Grandes Écoles') }}</option>
                                <option value="bourses_internationales" :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">{{ __('Bourses Internationales') }}</option>
                                <option value="examens_officiels" :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">{{ __('Examens Officiels') }}</option>
                                <option value="tests_internationaux" :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">{{ __('Tests Internationaux') }}</option>
                                <option value="formations_speciales" :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">{{ __('Formations Spéciales') }}</option>
                            </select>
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium mb-2 transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-700': !darkMode }">{{ __('Message') }}</label>
                            <textarea name="message" id="message" rows="4"
                                      class="w-full px-4 py-3 rounded-md border transition-colors duration-300"
                                      :class="{ 'bg-slate-700 border-slate-600 text-white focus:border-sky-500': darkMode, 'border-gray-300 focus:border-sky-500 focus:ring-sky-500': !darkMode }"></textarea>
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-sky-600 text-white rounded-md shadow-md hover:bg-sky-700 transition-colors duration-300">
                            {{ __('Envoyer') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="space-y-8">
                <div class="rounded-lg shadow-md p-6 transition-colors duration-300"
                     :class="{ 'bg-slate-800': darkMode, 'bg-white': !darkMode }">
                    <h3 class="text-xl font-bold mb-4 transition-colors duration-300"
                        :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Coordonnées') }}</h3>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="mt-1 mr-4 w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold transition-colors duration-300"
                                    :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Adresse principale') }}</h4>
                                <p class="transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                    Avenue Kennedy, Face Immeuble CNPS, Yaoundé, Cameroun
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="mt-1 mr-4 w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold transition-colors duration-300"
                                    :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Téléphone') }}</h4>
                                <p class="transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                    +237 222 222 222<br>
                                    +237 677 777 777
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="mt-1 mr-4 w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold transition-colors duration-300"
                                    :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Email') }}</h4>
                                <p class="transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                    info@icorp-education.cm<br>
                                    contact@icorp-education.cm
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="mt-1 mr-4 w-10 h-10 rounded-full bg-sky-100 flex items-center justify-center text-sky-600">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold transition-colors duration-300"
                                    :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Heures d\'ouverture') }}</h4>
                                <p class="transition-colors duration-300"
                                   :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                                    {{ __('Lundi - Vendredi') }}: 8h - 18h<br>
                                    {{ __('Samedi') }}: 9h - 16h<br>
                                    {{ __('Dimanche') }}: {{ __('Fermé') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg shadow-md p-6 transition-colors duration-300"
                     :class="{ 'bg-slate-800': darkMode, 'bg-white': !darkMode }">
                    <h3 class="text-xl font-bold mb-4 transition-colors duration-300"
                        :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Suivez-nous') }}</h3>

                    <div class="flex space-x-4">
                        <a href="#" class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 hover:bg-sky-200 transition-colors duration-300">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 hover:bg-sky-200 transition-colors duration-300">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 hover:bg-sky-200 transition-colors duration-300">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 hover:bg-sky-200 transition-colors duration-300">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                        <a href="#" class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center text-sky-600 hover:bg-sky-200 transition-colors duration-300">
                            <i class="fab fa-youtube text-lg"></i>
                        </a>
                    </div>
                </div>

                <div class="rounded-lg shadow-md overflow-hidden h-80 relative">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31894.37428525262!2d11.497909865165172!3d3.866559970979641!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x108bcf7a309a54a9%3A0xd171739d99e1b0a1!2sYaound%C3%A9!5e0!3m2!1sen!2scm!4v1708123456789!5m2!1sen!2scm"
                        width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-20 transition-colors duration-300"
         :class="{ 'bg-slate-800': darkMode, 'bg-gray-50': !darkMode }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold font-montserrat transition-colors duration-300"
                :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">{{ __('Questions Fréquentes') }}</h2>
            <div class="w-16 h-1 bg-sky-600 mx-auto mt-4"></div>
            <p class="mt-4 text-xl max-w-3xl mx-auto transition-colors duration-300"
               :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                {{ __('Trouvez des réponses aux questions les plus courantes sur nos formations') }}
            </p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div x-data="{ activeTab: 0 }" class="space-y-4">
                <!-- Question 1 -->
                <div class="rounded-lg shadow-md overflow-hidden transition-colors duration-300"
                     :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">
                    <button @click="activeTab = activeTab === 0 ? null : 0" class="w-full px-6 py-4 text-left flex justify-between items-center transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">
                        <span class="font-medium">{{ __('Comment s\'inscrire à une formation à ICORP?') }}</span>
                        <svg class="h-5 w-5 transition-transform" :class="{ 'transform rotate-180': activeTab === 0 }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="activeTab === 0" x-collapse class="px-6 pb-4 transition-colors duration-300"
                         :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        <p>{{ __('Pour vous inscrire à une formation, vous pouvez:') }}</p>
                        <ul class="list-disc pl-5 mt-2 space-y-1">
                            <li>{{ __('Visiter l\'un de nos centres et vous inscrire directement sur place') }}</li>
                            <li>{{ __('Remplir le formulaire de contact sur notre site web') }}</li>
                            <li>{{ __('Nous appeler aux numéros indiqués') }}</li>
                            <li>{{ __('Nous envoyer un email à info@icorp-education.cm') }}</li>
                        </ul>
                        <p class="mt-2">{{ __('Après votre préinscription, un conseiller pédagogique vous contactera pour finaliser votre inscription et vous fournir toutes les informations nécessaires.') }}</p>
                    </div>
                </div>

                <!-- Question 2 -->
                <div class="rounded-lg shadow-md overflow-hidden transition-colors duration-300"
                     :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">
                    <button @click="activeTab = activeTab === 1 ? null : 1" class="w-full px-6 py-4 text-left flex justify-between items-center transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">
                        <span class="font-medium">{{ __('Quels sont les modes de paiement acceptés?') }}</span>
                        <svg class="h-5 w-5 transition-transform" :class="{ 'transform rotate-180': activeTab === 1 }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="activeTab === 1" x-collapse class="px-6 pb-4 transition-colors duration-300"
                         :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        <p>{{ __('Nous acceptons plusieurs modes de paiement pour faciliter votre inscription:') }}</p>
                        <ul class="list-disc pl-5 mt-2 space-y-1">
                            <li>{{ __('Paiement en espèces dans nos centres') }}</li>
                            <li>{{ __('Paiement par Mobile Money (Orange Money, MTN Mobile Money, etc.)') }}</li>
                            <li>{{ __('Virement bancaire') }}</li>
                            <li>{{ __('Paiement échelonné (selon les formations)') }}</li>
                        </ul>
                        <p class="mt-2">{{ __('Des facilités de paiement peuvent être accordées en fonction de votre situation. N\'hésitez pas à nous contacter pour en discuter.') }}</p>
                    </div>
                </div>

                <!-- Question 3 -->
                <div class="rounded-lg shadow-md overflow-hidden transition-colors duration-300"
                     :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">
                    <button @click="activeTab = activeTab === 2 ? null : 2" class="w-full px-6 py-4 text-left flex justify-between items-center transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">
                        <span class="font-medium">{{ __('Quels documents faut-il fournir pour s\'inscrire?') }}</span>
                        <svg class="h-5 w-5 transition-transform" :class="{ 'transform rotate-180': activeTab === 2 }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="activeTab === 2" x-collapse class="px-6 pb-4 transition-colors duration-300"
                         :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        <p>{{ __('Les documents à fournir varient selon la formation choisie, mais généralement vous devez présenter:') }}</p>
                        <ul class="list-disc pl-5 mt-2 space-y-1">
                            <li>{{ __('Une copie de votre pièce d\'identité ou acte de naissance') }}</li>
                            <li>{{ __('Une copie de votre dernier diplôme obtenu') }}</li>
                            <li>{{ __('2 photos d\'identité récentes (format 4x4)') }}</li>
                            <li>{{ __('Un dossier d\'inscription dûment rempli (disponible dans nos centres ou téléchargeable sur notre site)') }}</li>
                        </ul>
                        <p class="mt-2">{{ __('Des documents supplémentaires peuvent être demandés selon le type de formation ou de concours visé.') }}</p>
                    </div>
                </div>

                <!-- Question 4 -->
                <div class="rounded-lg shadow-md overflow-hidden transition-colors duration-300"
                     :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">
                    <button @click="activeTab = activeTab === 3 ? null : 3" class="w-full px-6 py-4 text-left flex justify-between items-center transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">
                        <span class="font-medium">{{ __('Proposez-vous des formations à distance?') }}</span>
                        <svg class="h-5 w-5 transition-transform" :class="{ 'transform rotate-180': activeTab === 3 }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="activeTab === 3" x-collapse class="px-6 pb-4 transition-colors duration-300"
                         :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        <p>{{ __('Oui, ICORP propose des formations à distance pour la plupart de ses programmes:') }}</p>
                        <ul class="list-disc pl-5 mt-2 space-y-1">
                            <li>{{ __('Cours en ligne via notre plateforme d\'apprentissage') }}</li>
                            <li>{{ __('Cours par visioconférence en direct avec nos formateurs') }}</li>
                            <li>{{ __('Supports de cours numériques et exercices interactifs') }}</li>
                            <li>{{ __('Suivi et tutorat personnalisés à distance') }}</li>
                        </ul>
                        <p class="mt-2">{{ __('Nos formations à distance sont conçues pour être aussi complètes et efficaces que nos formations en présentiel, avec un accompagnement régulier et des évaluations fréquentes.') }}</p>
                    </div>
                </div>

                <!-- Question 5 -->
                <div class="rounded-lg shadow-md overflow-hidden transition-colors duration-300"
                     :class="{ 'bg-slate-700': darkMode, 'bg-white': !darkMode }">
                    <button @click="activeTab = activeTab === 4 ? null : 4" class="w-full px-6 py-4 text-left flex justify-between items-center transition-colors duration-300"
                            :class="{ 'text-white': darkMode, 'text-gray-900': !darkMode }">
                        <span class="font-medium">{{ __('Quelles sont les dates de début des formations?') }}</span>
                        <svg class="h-5 w-5 transition-transform" :class="{ 'transform rotate-180': activeTab === 4 }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="activeTab === 4" x-collapse class="px-6 pb-4 transition-colors duration-300"
                         :class="{ 'text-gray-300': darkMode, 'text-gray-600': !darkMode }">
                        <p>{{ __('Les dates de début de nos formations sont flexibles et s\'adaptent au calendrier des concours et examens:') }}</p>
                        <ul class="list-disc pl-5 mt-2 space-y-1">
                            <li>{{ __('Pour les concours administratifs: généralement de septembre à janvier') }}</li>
                            <li>{{ __('Pour les grandes écoles: d\'octobre à mars') }}</li>
                            <li>{{ __('Pour les examens officiels: tout au long de l\'année académique') }}</li>
                            <li>{{ __('Pour les formations aux tests internationaux: sessions mensuelles') }}</li>
                        </ul>
                        <p class="mt-2">{{ __('Nous organisons également des sessions de formation intensives pendant les vacances scolaires. Contactez-nous pour connaître les dates précises des prochaines sessions de la formation qui vous intéresse.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-12 transition-colors duration-300"
         :class="{ 'bg-slate-900': darkMode, 'bg-white': !darkMode }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-r from-sky-600 to-sky-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-8 md:p-12 flex flex-col md:flex-row items-center justify-between">
                <div class="mb-8 md:mb-0 md:pr-8 max-w-3xl">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-4">{{ __('Prêt à réussir vos concours et examens?') }}</h2>
                    <p class="text-white/90 text-lg">
                        {{ __('Rejoignez les milliers d\'étudiants qui ont fait confiance à ICORP pour leur préparation. Nos formateurs qualifiés et notre méthode éprouvée vous aideront à atteindre vos objectifs.') }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#contact" class="px-6 py-4 bg-white text-sky-700 rounded-md shadow-md hover:bg-gray-100 transition-colors duration-300 text-center font-medium">
                        {{ __('Nous contacter') }}
                    </a>
                    <a href="#formations" class="px-6 py-4 bg-transparent border border-white text-white rounded-md hover:bg-white/10 transition-colors duration-300 text-center font-medium">
                        {{ __('Voir nos formations') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="py-12 transition-colors duration-300"
        :class="{ 'bg-slate-800 text-white': darkMode, 'bg-gray-800 text-white': !darkMode }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <div>
                <div class="flex items-center mb-6">
                    <img src="{{ asset('logo-icorp-white.png') }}" alt="ICORP Logo" class="h-10 mr-3"
                         onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNTAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCAxNTAgODAiPjxyZWN0IHdpZHRoPSIxNTAiIGhlaWdodD0iODAiIGZpbGw9IiMzNDgyZjYiLz48dGV4dCB4PSI3NSIgeT0iNDUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIyMCIgZmlsbD0id2hpdGUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGFsaWdubWVudC1iYXNlbGluZT0ibWlkZGxlIj5JQ09SUDwvdGV4dD48L3N2Zz4='" >
                    <span class="font-semibold text-xl text-white font-montserrat">ICORP</span>
                </div>
                <p class="text-gray-400 mb-6">
                    {{ __('ICORP est le leader camerounais de la préparation aux concours et examens avec plus de 15 ans d\'expérience et un taux de réussite exceptionnel.') }}
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors duration-300">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-6">{{ __('Contact') }}</h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-gray-400"></i>
                        <span class="text-gray-400">
                                Avenue Kennedy, Face Immeuble CNPS, Yaoundé, Cameroun
                            </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone-alt mt-1 mr-3 text-gray-400"></i>
                        <span class="text-gray-400">
                                +237 222 222 222<br>
                                +237 677 777 777
                            </span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-envelope mt-1 mr-3 text-gray-400"></i>
                        <span class="text-gray-400">
                                info@icorp-education.cm<br>
                                contact@icorp-education.cm
                            </span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 pt-8">
            <div class="flex flex-col md:flex-row md:justify-between items-center">
                <p class="text-gray-400 text-sm mb-4 md:mb-0">
                    &copy; {{ date('Y') }} ICORP - Institut de préparation aux concours. {{ __('Tous droits réservés.') }}
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-300">{{ __('Politique de confidentialité') }}</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-300">{{ __('Mentions légales') }}</a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors duration-300">{{ __('CGU') }}</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Scroll to top button -->
<button
    id="scrollToTopBtn"
    class="fixed bottom-6 right-6 p-3 rounded-full shadow-lg transition-all duration-300 transform scale-0 opacity-0 focus:outline-none z-50"
    :class="{ 'bg-slate-700 hover:bg-slate-600': darkMode, 'bg-sky-600 hover:bg-sky-700': !darkMode }"
    onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
    </svg>
</button>
</body>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    // Display scroll to top button when user scrolls down
    window.addEventListener('scroll', function() {
        const scrollToTopBtn = document.getElementById('scrollToTopBtn');
        if (window.pageYOffset > 300) {
            scrollToTopBtn.classList.remove('scale-0', 'opacity-0');
            scrollToTopBtn.classList.add('scale-100', 'opacity-100');
        } else {
            scrollToTopBtn.classList.remove('scale-100', 'opacity-100');
            scrollToTopBtn.classList.add('scale-0', 'opacity-0');
        }
    });
</script>
