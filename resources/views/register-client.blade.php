@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="{{ $theme }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - TAG Eventos</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .register-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        }
        
        .dark .glass-card {
            background: rgba(17, 24, 39, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }
        
        .input-group {
            position: relative;
        }
        
        .input-field {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }
        
        .dark .input-field {
            background: rgba(17, 24, 39, 0.8);
            border-color: rgba(75, 85, 99, 0.5);
        }
        
        .dark .input-field:focus {
            border-color: #3b82f6;
            background: rgba(17, 24, 39, 0.9);
        }
        
        .btn-register {
            background: linear-gradient(135deg, #10b981, #059669);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }
        
        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-register:hover::before {
            left: 100%;
        }
        
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }
        
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 10%;
            left: 15%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 70%;
            right: 15%;
            animation-delay: 2s;
        }
        
        .shape:nth-child(3) {
            width: 80px;
            height: 80px;
            bottom: 10%;
            left: 25%;
            animation-delay: 4s;
        }
        
        .shape:nth-child(4) {
            width: 60px;
            height: 60px;
            top: 40%;
            right: 25%;
            animation-delay: 1s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .logo-glow {
            filter: drop-shadow(0 4px 20px rgba(16, 185, 129, 0.3));
        }
        
        .password-strength {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .strength-weak { background: #ef4444; width: 25%; }
        .strength-fair { background: #f59e0b; width: 50%; }
        .strength-good { background: #10b981; width: 75%; }
        .strength-strong { background: #059669; width: 100%; }
    </style>
</head>

<body class="min-h-screen register-gradient relative overflow-hidden">
    <!-- Floating Shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <!-- Back to Home Button -->
    <div class="absolute top-6 left-6 z-20">
        <a href="{{ url('/') }}" class="flex items-center text-white hover:text-green-200 transition-all duration-300 group">
            <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform duration-300"></i>
            <span class="font-medium">Volver al inicio</span>
        </a>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4 py-8 relative z-10">
        <div class="w-full max-w-2xl fade-in">
            <!-- Logo -->
            <div class="text-center mb-8">
                <img src="https://res.cloudinary.com/dg2ugi96k/image/upload/v1721204281/LOGOTAG-a1fb86e0_nb8n4l.png" 
                     class="h-16 mx-auto logo-glow" alt="TAG Logo" />
                <h1 class="text-3xl font-bold text-white mt-4 mb-2">¡Únete a TAG Eventos!</h1>
                <p class="text-green-100">Crea tu cuenta y accede a eventos exclusivos</p>
            </div>

            <!-- Register Form -->
            <div class="glass-card rounded-3xl p-8">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <span class="text-red-700 dark:text-red-300 font-medium">Errores en el formulario</span>
                        </div>
                        <ul class="mt-2 text-sm text-red-600 dark:text-red-400">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register-client.store') }}" class="space-y-6">
                    @csrf
                    
                    <!-- Personal Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name Field -->
                        <div class="input-group">
                            <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-user mr-2 text-green-500"></i>Nombre
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name" 
                                   value="{{ old('name') }}"
                                   class="input-field w-full px-4 py-3 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none" 
                                   placeholder="Tu nombre" 
                                   required>
                        </div>

                        <!-- Last Name Field -->
                        <div class="input-group">
                            <label for="last_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-user mr-2 text-green-500"></i>Apellido
                            </label>
                            <input type="text" 
                                   name="last_name" 
                                   id="last_name" 
                                   value="{{ old('last_name') }}"
                                   class="input-field w-full px-4 py-3 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none" 
                                   placeholder="Tu apellido" 
                                   required>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Email Field -->
                        <div class="input-group">
                            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-envelope mr-2 text-green-500"></i>Correo Electrónico
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   value="{{ old('email') }}"
                                   class="input-field w-full px-4 py-3 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none" 
                                   placeholder="tu@email.com" 
                                   required>
                        </div>

                        <!-- Phone Field -->
                        <div class="input-group">
                            <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-phone mr-2 text-green-500"></i>Teléfono
                            </label>
                            <input type="tel" 
                                   name="phone" 
                                   id="phone" 
                                   value="{{ old('phone') }}"
                                   class="input-field w-full px-4 py-3 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none" 
                                   placeholder="70123456" 
                                   required>
                        </div>
                    </div>

                    <!-- Gender Field -->
                    <div class="input-group">
                        <label for="gender" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-venus-mars mr-2 text-green-500"></i>Género
                        </label>
                        <select name="gender" 
                                id="gender" 
                                class="input-field w-full px-4 py-3 rounded-xl text-gray-900 dark:text-white focus:outline-none" 
                                required>
                            <option value="">Selecciona tu género</option>
                            <option value="Masculino" {{ old('gender') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('gender') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('gender') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <!-- Password Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password Field -->
                        <div class="input-group">
                            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-lock mr-2 text-green-500"></i>Contraseña
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="password" 
                                       id="password" 
                                       class="input-field w-full px-4 py-3 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none pr-12" 
                                       placeholder="••••••••" 
                                       required
                                       onkeyup="checkPasswordStrength()">
                                <button type="button" 
                                        onclick="togglePassword('password', 'toggleIcon1')" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                                    <i class="fas fa-eye" id="toggleIcon1"></i>
                                </button>
                            </div>
                            <!-- Password Strength Indicator -->
                            <div class="mt-2">
                                <div class="bg-gray-200 dark:bg-gray-700 rounded-full h-1">
                                    <div id="passwordStrength" class="password-strength"></div>
                                </div>
                                <p id="strengthText" class="text-xs mt-1 text-gray-500 dark:text-gray-400"></p>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="input-group">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                <i class="fas fa-lock mr-2 text-green-500"></i>Confirmar Contraseña
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="password_confirmation" 
                                       class="input-field w-full px-4 py-3 rounded-xl text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none pr-12" 
                                       placeholder="••••••••" 
                                       required>
                                <button type="button" 
                                        onclick="togglePassword('password_confirmation', 'toggleIcon2')" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">
                                    <i class="fas fa-eye" id="toggleIcon2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="flex items-start">
                        <input type="checkbox" 
                               name="terms" 
                               id="terms"
                               class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 mt-1" 
                               required>
                        <label for="terms" class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                            Acepto los 
                            <a href="#" class="text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300 font-medium">
                                términos y condiciones
                            </a> 
                            y la 
                            <a href="#" class="text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300 font-medium">
                                política de privacidad
                            </a>
                        </label>
                    </div>

                    <!-- Register Button -->
                    <button type="submit" 
                            class="btn-register w-full text-white font-bold py-4 rounded-xl transition-all duration-300 relative overflow-hidden">
                        <span class="relative z-10">
                            <i class="fas fa-user-plus mr-2"></i>Crear Cuenta
                        </span>
                    </button>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400">o</span>
                        </div>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center">
                        <p class="text-gray-600 dark:text-gray-400">
                            ¿Ya tienes una cuenta? 
                            <a href="{{ route('login-client') }}" 
                               class="text-green-600 hover:text-green-500 dark:text-green-400 dark:hover:text-green-300 font-semibold transition-colors">
                                Inicia sesión aquí
                            </a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8">
                <p class="text-green-100 text-sm">
                    © 2024 TAG Eventos. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId, iconId) {
            const passwordField = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBar = document.getElementById('passwordStrength');
            const strengthText = document.getElementById('strengthText');
            
            let strength = 0;
            let text = '';
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            strengthBar.className = 'password-strength';
            
            switch (strength) {
                case 0:
                case 1:
                    strengthBar.classList.add('strength-weak');
                    text = 'Muy débil';
                    break;
                case 2:
                    strengthBar.classList.add('strength-fair');
                    text = 'Débil';
                    break;
                case 3:
                case 4:
                    strengthBar.classList.add('strength-good');
                    text = 'Buena';
                    break;
                case 5:
                    strengthBar.classList.add('strength-strong');
                    text = 'Muy fuerte';
                    break;
            }
            
            strengthText.textContent = text;
        }
    </script>
</body>
</html>
