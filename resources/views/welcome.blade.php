@props(['theme' => 'light'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>TAG - Eventos Profesionales</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .hero-overlay {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.2));
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .event-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        
        .event-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        
        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }
        
        .event-card:hover::before {
            opacity: 1;
        }
        
        .promotion-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            color: white;
            font-weight: 700;
            font-size: 0.75rem;
            padding: 8px 16px;
            border-radius: 25px;
            z-index: 10;
            animation: pulse-glow 2s infinite;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }
        
        .price-display {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .original-price {
            text-decoration: line-through;
            color: #9ca3af;
            font-size: 0.9rem;
            opacity: 0.7;
        }
        
        .discounted-price {
            color: #059669;
            font-weight: 800;
            font-size: 1.2rem;
            text-shadow: 0 1px 2px rgba(5, 150, 105, 0.2);
        }
        
        @keyframes pulse-glow {
            0%, 100% { 
                opacity: 1; 
                box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
            }
            50% { 
                opacity: 0.8; 
                box-shadow: 0 4px 25px rgba(255, 107, 107, 0.6);
            }
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s ease;
            border-radius: 20px;
        }
        
        .feature-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        
        .navbar-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(25px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .dark .navbar-glass {
            background: rgba(17, 24, 39, 0.95);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
        }
        
        .navbar-link {
            position: relative;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 16px;
            border-radius: 12px;
            color: #374151;
        }
        
        .dark .navbar-link {
            color: #d1d5db;
        }
        
        .navbar-link:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            transform: translateY(-1px);
        }
        
        .navbar-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .navbar-link:hover::after {
            width: 80%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
            opacity: 0.95;
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-weight: 600;
            padding: 12px 24px;
            border-radius: 25px;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }
        
        .event-image {
            transition: transform 0.4s ease;
        }
        
        .event-card:hover .event-image {
            transform: scale(1.1);
        }
        
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }
        
        .mobile-menu.active {
            transform: translateX(0);
        }
        
        .event-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 0;
            transition: all 0.2s ease;
        }
        
        .event-info-item:hover {
            color: #3b82f6;
            transform: translateX(4px);
        }
        
        .event-info-item i {
            width: 16px;
            text-align: center;
            opacity: 0.7;
        }
        
        .stats-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 24px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
        }
        
        .no-events-container {
            text-align: center;
            padding: 80px 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            border: 2px dashed rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body class="font-sans antialiased {{ $theme == 'dark' ? 'dark:bg-gray-900 dark:text-white' : 'bg-white text-gray-900' }}">

    <!-- Navbar -->
    <nav class="navbar-glass fixed w-full top-0 left-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3 group">
                    <img src="https://res.cloudinary.com/dg2ugi96k/image/upload/v1721204281/LOGOTAG-a1fb86e0_nb8n4l.png" 
                         class="h-10 transition-transform group-hover:scale-110" alt="Logo" />
                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        TAG
                    </span>
                </a>
                
                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="#hero" class="navbar-link">
                        <i class="fas fa-home mr-2"></i>Inicio
                    </a>
                    <a href="#about" class="navbar-link">
                        <i class="fas fa-info-circle mr-2"></i>Nosotros
                    </a>
                    <a href="#events" class="navbar-link">
                        <i class="fas fa-calendar-alt mr-2"></i>Eventos
                    </a>
                    <a href="#contact" class="navbar-link">
                        <i class="fas fa-envelope mr-2"></i>Contacto
                    </a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @if (Route::has('login-client'))
                        @auth
                            @if (Auth::user()->role->nombre == 'Usuario')
                                <a href="{{ route('dashboard') }}" class="btn-primary">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                            @else
                                <a href="{{ url('/dashboard') }}" class="btn-primary" style="background: linear-gradient(135deg, #8b5cf6, #ec4899);">
                                    <i class="fas fa-cog mr-2"></i>Admin
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login-client') }}" class="navbar-link">
                                <i class="fas fa-sign-in-alt mr-2"></i>Ingresar
                            </a>
                            @if (Route::has('register-client'))
                                <a href="{{ route('register-client') }}" class="btn-primary">
                                    <i class="fas fa-user-plus mr-2"></i>Registrarse
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" 
                        onclick="toggleMobileMenu()">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div id="mobileMenu" class="mobile-menu md:hidden fixed top-0 right-0 h-full w-80 bg-white dark:bg-gray-900 shadow-2xl z-50">
            <div class="p-6">
                <div class="flex justify-between items-center mb-8">
                    <span class="text-xl font-bold">Menú</span>
                    <button onclick="toggleMobileMenu()" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <a href="#hero" class="block navbar-link" onclick="toggleMobileMenu()">
                        <i class="fas fa-home mr-3"></i>Inicio
                    </a>
                    <a href="#about" class="block navbar-link" onclick="toggleMobileMenu()">
                        <i class="fas fa-info-circle mr-3"></i>Nosotros
                    </a>
                    <a href="#events" class="block navbar-link" onclick="toggleMobileMenu()">
                        <i class="fas fa-calendar-alt mr-3"></i>Eventos
                    </a>
                    <a href="#contact" class="block navbar-link" onclick="toggleMobileMenu()">
                        <i class="fas fa-envelope mr-3"></i>Contacto
                    </a>
                    
                    <hr class="my-6 border-gray-200 dark:border-gray-700">
                    
                    @if (Route::has('login-client'))
                        @auth
                            @if (Auth::user()->role->nombre == 'Usuario')
                                <a href="{{ route('dashboard') }}" class="block btn-primary text-center">
                                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                </a>
                            @else
                                <a href="{{ url('/dashboard') }}" class="block btn-primary text-center" style="background: linear-gradient(135deg, #8b5cf6, #ec4899);">
                                    <i class="fas fa-cog mr-2"></i>Admin
                                </a>
                            @endif
                        @else
                            <a href="{{ route('login-client') }}" class="block navbar-link">
                                <i class="fas fa-sign-in-alt mr-3"></i>Ingresar
                            </a>
                            @if (Route::has('register-client'))
                                <a href="{{ route('register-client') }}" class="block btn-primary text-center mt-4">
                                    <i class="fas fa-user-plus mr-2"></i>Registrarse
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero-gradient min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="hero-overlay absolute inset-0"></div>
        
        <!-- Background Animation -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl animate-bounce"></div>
            <div class="absolute top-10 right-10 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl animate-bounce animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl animate-bounce animation-delay-4000"></div>
        </div>
        
        <div class="relative z-10 text-center max-w-6xl mx-auto px-6 fade-in">
            <h1 class="text-6xl md:text-8xl font-bold text-white mb-6">
                Eventos que
                <span class="bg-gradient-to-r from-yellow-400 to-orange-400 bg-clip-text text-transparent">Inspiran</span>
            </h1>
            <p class="text-xl md:text-2xl text-white/90 mb-8 max-w-3xl mx-auto leading-relaxed">
                Descubre experiencias únicas, conecta con profesionales destacados y participa en eventos que transformarán tu perspectiva.
            </p>
            
            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-16">
                <a href="#events" class="btn-secondary">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Explorar Eventos
                </a>
                <a href="#about" class="btn-primary" style="background: white; color: #1f2937;">
                    <i class="fas fa-info-circle mr-2"></i>
                    Conocer Más
                </a>
            </div>
            
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="stats-card">
                    <div class="text-4xl font-bold text-white mb-2">{{ $eventsCount ?? '0' }}+</div>
                    <div class="text-white/80 font-medium">Eventos Realizados</div>
                </div>
                <div class="stats-card">
                    <div class="text-4xl font-bold text-white mb-2">{{ $activePromotions ?? '0' }}</div>
                    <div class="text-white/80 font-medium">Promociones Activas</div>
                </div>
                <div class="stats-card">
                    <div class="text-4xl font-bold text-white mb-2">95%</div>
                    <div class="text-white/80 font-medium">Satisfacción</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-24 {{ $theme === 'dark' ? 'bg-gray-800' : 'bg-gray-50' }}">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 fade-in">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                    ¿Por qué elegir <span class="bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">TAG</span>?
                </h2>
                <p class="text-xl {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }} max-w-3xl mx-auto">
                    Somos líderes en la organización de eventos profesionales que conectan, inspiran y transforman industrias completas.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card p-8 text-center fade-in">
                    <div class="text-5xl mb-6">🎯</div>
                    <h3 class="text-2xl font-bold mb-4 {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">Experiencias Únicas</h3>
                    <p class="{{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }}">
                        Cada evento está diseñado para ofrecer valor real y conexiones significativas.
                    </p>
                </div>
                <div class="feature-card p-8 text-center fade-in" style="animation-delay: 0.2s;">
                    <div class="text-5xl mb-6">🌟</div>
                    <h3 class="text-2xl font-bold mb-4 {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">Speakers de Clase Mundial</h3>
                    <p class="{{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }}">
                        Acceso directo a los líderes más influyentes de cada industria.
                    </p>
                </div>
                <div class="feature-card p-8 text-center fade-in" style="animation-delay: 0.4s;">
                    <div class="text-5xl mb-6">🚀</div>
                    <h3 class="text-2xl font-bold mb-4 {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">Networking Premium</h3>
                    <p class="{{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }}">
                        Oportunidades exclusivas para conectar con profesionales destacados.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Events Section -->
    <section id="events" class="py-24 {{ $theme === 'dark' ? 'bg-gray-900' : 'bg-white' }}">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 fade-in">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                    Próximos Eventos
                </h2>
                <p class="text-xl {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }} max-w-3xl mx-auto">
                    Descubre las mejores oportunidades de aprendizaje y networking. ¡Aprovecha nuestras promociones especiales!
                </p>
            </div>
            
            @if($events && $events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $index => $event)
                    <div class="event-card {{ $theme === 'dark' ? 'bg-gray-800' : 'bg-white' }} fade-in" style="animation-delay: {{ $index * 0.1 }}s;">
                        @if($event->promotion)
                            <div class="promotion-badge">
                                <i class="fas fa-fire mr-1"></i>-{{ $event->promotion->descuento }}% OFF
                            </div>
                        @endif
                        
                        <div class="relative overflow-hidden">
                            <img src="{{ $event->imagen ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' }}" 
                                 alt="{{ $event->nombre }}" 
                                 class="event-image w-full h-48 object-cover">
                            <div class="absolute top-4 left-4">
                                <span class="bg-blue-600 text-white text-xs font-bold px-3 py-2 rounded-full shadow-lg">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ \Carbon\Carbon::parse($event->fecha)->format('d M') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-6 relative z-10">
                            <h3 class="text-xl font-bold mb-3 {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }} line-clamp-2">
                                {{ $event->nombre }}
                            </h3>
                            <p class="text-sm {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }} mb-4 line-clamp-2">
                                {{ $event->descripcion }}
                            </p>
                            
                            <div class="space-y-3 mb-6">
                                <div class="event-info-item text-sm {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }}">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ \Carbon\Carbon::parse($event->fecha)->format('d/m/Y') }} - {{ $event->hora }}</span>
                                </div>
                                <div class="event-info-item text-sm {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }}">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $event->ubicacion }}</span>
                                </div>
                                <div class="event-info-item text-sm {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }}">
                                    <i class="fas fa-users"></i>
                                    <span>{{ $event->capacidad }} asistentes</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="price-display">
                                    @if($event->promotion && $event->promotion->descuento > 0)
                                        <span class="original-price">${{ number_format($event->precio_entrada, 2) }}</span>
                                        <span class="discounted-price">
                                            ${{ number_format($event->precio_entrada * (1 - $event->promotion->descuento / 100), 2) }}
                                        </span>
                                    @else
                                        <span class="text-2xl font-bold {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                                            ${{ number_format($event->precio_entrada, 2) }}
                                        </span>
                                    @endif
                                </div>
                                
                                @auth
                                    <a href="{{ route('events.show', $event->id) }}" 
                                       class="btn-primary text-sm">
                                        <i class="fas fa-eye mr-1"></i>Ver Detalles
                                    </a>
                                @else
                                    <a href="{{ route('login-client') }}" 
                                       class="btn-primary text-sm">
                                        <i class="fas fa-user-plus mr-1"></i>Registrarse
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="no-events-container fade-in">
                    <div class="text-6xl mb-6">📅</div>
                    <h3 class="text-3xl font-bold mb-4 {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                        Próximamente nuevos eventos
                    </h3>
                    <p class="text-lg {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }} mb-8">
                        Estamos preparando experiencias increíbles para ti. ¡Mantente al día!
                    </p>
                    <a href="#contact" class="btn-primary">
                        <i class="fas fa-bell mr-2"></i>Notificarme
                    </a>
                </div>
            @endif
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-24 {{ $theme === 'dark' ? 'bg-gray-800' : 'bg-gray-50' }}">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center mb-16 fade-in">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                    ¿Listo para unirte?
                </h2>
                <p class="text-xl {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }}">
                    Contáctanos y descubre cómo nuestros eventos pueden transformar tu carrera profesional.
                </p>
            </div>
            
            <div class="{{ $theme === 'dark' ? 'bg-gray-900' : 'bg-white' }} rounded-2xl shadow-xl p-8 fade-in">
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-700' }} mb-2">
                                <i class="fas fa-user mr-2"></i>Nombre completo
                            </label>
                            <input type="text" id="name" name="name" 
                                   class="w-full px-4 py-3 rounded-lg border {{ $theme === 'dark' ? 'bg-gray-800 border-gray-600 text-white' : 'bg-gray-50 border-gray-300' }} focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                                   placeholder="Tu nombre" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-700' }} mb-2">
                                <i class="fas fa-envelope mr-2"></i>Email
                            </label>
                            <input type="email" id="email" name="email" 
                                   class="w-full px-4 py-3 rounded-lg border {{ $theme === 'dark' ? 'bg-gray-800 border-gray-600 text-white' : 'bg-gray-50 border-gray-300' }} focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                                   placeholder="tu@email.com" required>
                        </div>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-700' }} mb-2">
                            <i class="fas fa-comment mr-2"></i>Mensaje
                        </label>
                        <textarea id="message" name="message" rows="4" 
                                  class="w-full px-4 py-3 rounded-lg border {{ $theme === 'dark' ? 'bg-gray-800 border-gray-600 text-white' : 'bg-gray-50 border-gray-300' }} focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors" 
                                  placeholder="Cuéntanos sobre tu interés en nuestros eventos..." required></textarea>
                    </div>
                    <button type="submit" class="w-full btn-primary py-4 text-lg">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar Mensaje
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="{{ $theme === 'dark' ? 'bg-gray-900' : 'bg-gray-900' }} text-white py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <div class="flex items-center space-x-3 mb-6">
                        <img src="https://res.cloudinary.com/dg2ugi96k/image/upload/v1721204281/LOGOTAG-a1fb86e0_nb8n4l.png" class="h-8" alt="Logo" />
                        <span class="text-xl font-bold">TAG</span>
                    </div>
                    <p class="text-gray-400">
                        Creando experiencias profesionales que inspiran y transforman carreras.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Navegación</h3>
                    <ul class="space-y-2">
                        <li><a href="#hero" class="text-gray-400 hover:text-white transition-colors">Inicio</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition-colors">Nosotros</a></li>
                        <li><a href="#events" class="text-gray-400 hover:text-white transition-colors">Eventos</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Contacto</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Servicios</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Eventos Corporativos</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Conferencias</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Workshops</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Networking</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contacto</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-400">
                            <i class="fas fa-envelope mr-2"></i>
                            info@tag-eventos.com
                        </li>
                        <li class="text-gray-400">
                            <i class="fas fa-phone mr-2"></i>
                            +591 123 456 789
                        </li>
                        <li class="text-gray-400">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            La Paz, Bolivia
                        </li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-8 border-gray-700">
            
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © 2024 TAG Eventos. Todos los derechos reservados.
                </p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @livewireScripts
    
    <script>
        // Mobile menu toggle
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('active');
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const menuButton = event.target.closest('button');
            
            if (!mobileMenu.contains(event.target) && !menuButton) {
                mobileMenu.classList.remove('active');
            }
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-glass');
            if (window.scrollY > 50) {
                navbar.style.background = '{{ $theme === "dark" ? "rgba(17, 24, 39, 0.98)" : "rgba(255, 255, 255, 0.98)" }}';
                navbar.style.boxShadow = '0 8px 32px rgba(0,0,0,0.12)';
            } else {
                navbar.style.background = '{{ $theme === "dark" ? "rgba(17, 24, 39, 0.95)" : "rgba(255, 255, 255, 0.98)" }}';
                navbar.style.boxShadow = '0 4px 20px rgba(0,0,0,0.08)';
            }
        });
        
        // Intersection Observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);
        
        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    </script>
</body>
</html>
