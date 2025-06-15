@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light';
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl {{ $theme === 'dark' ? 'text-white' : 'text-gray-800' }} leading-tight">
                {{ __('Configuración del Perfil') }}
            </h2>
            <div class="flex items-center space-x-2">
                <svg class="w-6 h-6 {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-sm {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-600' }}">Gestiona tu información personal</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12 {{ $theme === 'dark' ? 'bg-gray-900' : 'bg-gray-50' }} min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Profile Header -->
            <div class="{{ $theme === 'dark' ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200' }} border rounded-2xl shadow-lg p-8 mb-8">
                <div class="flex items-center space-x-6">
                    <div class="relative">
                        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <img class="h-24 w-24 rounded-full object-cover border-4 {{ $theme === 'dark' ? 'border-gray-600' : 'border-gray-200' }}" 
                                 src="{{ Auth::user()->profile_photo_url }}" 
                                 alt="{{ Auth::user()->name }}" />
                        @else
                            <div class="h-24 w-24 rounded-full {{ $theme === 'dark' ? 'bg-gray-600' : 'bg-gray-300' }} flex items-center justify-center">
                                <svg class="h-12 w-12 {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-500' }}" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        @endif
                        <div class="absolute -bottom-1 -right-1 h-8 w-8 rounded-full bg-green-500 border-4 {{ $theme === 'dark' ? 'border-gray-800' : 'border-white' }} flex items-center justify-center">
                            <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                            {{ Auth::user()->name }}
                        </h3>
                        <p class="text-sm {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-600' }} mb-2">
                            {{ Auth::user()->email }}
                        </p>
                        <div class="flex items-center space-x-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 {{ $theme === 'dark' ? 'bg-green-900 text-green-300' : '' }}">
                                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                    <circle cx="4" cy="4" r="3"/>
                                </svg>
                                Cuenta Activa
                            </span>
                            <span class="text-xs {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-500' }}">
                                Miembro desde {{ Auth::user()->created_at->format('M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Configuration Sections -->
            <div class="space-y-8">
                
                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                <!-- Profile Information Section -->
                <div class="{{ $theme === 'dark' ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200' }} border rounded-2xl shadow-lg overflow-hidden">
                    <div class="px-8 py-6 border-b {{ $theme === 'dark' ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                                Información Personal
                            </h3>
                        </div>
                        <p class="mt-1 text-sm {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-600' }}">
                            Actualiza tu información personal y dirección de correo electrónico.
                        </p>
                    </div>
                    <div class="p-8">
                        @livewire('profile.update-profile-information-form')
                    </div>
                </div>
                @endif

                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <!-- Password Update Section -->
                <div class="{{ $theme === 'dark' ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200' }} border rounded-2xl shadow-lg overflow-hidden">
                    <div class="px-8 py-6 border-b {{ $theme === 'dark' ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                                Actualizar Contraseña
                            </h3>
                        </div>
                        <p class="mt-1 text-sm {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-600' }}">
                            Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerte seguro.
                        </p>
                    </div>
                    <div class="p-8">
                        @livewire('profile.update-password-form')
                    </div>
                </div>
                @endif

                @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <!-- Two Factor Authentication Section -->
                <div class="{{ $theme === 'dark' ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200' }} border rounded-2xl shadow-lg overflow-hidden">
                    <div class="px-8 py-6 border-b {{ $theme === 'dark' ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                                Autenticación de Dos Factores
                            </h3>
                        </div>
                        <p class="mt-1 text-sm {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-600' }}">
                            Agrega seguridad adicional a tu cuenta utilizando autenticación de dos factores.
                        </p>
                    </div>
                    <div class="p-8">
                        @livewire('profile.two-factor-authentication-form')
                    </div>
                </div>
                @endif

                <!-- Browser Sessions Section -->
                <div class="{{ $theme === 'dark' ? 'bg-gray-800 border-gray-700' : 'bg-white border-gray-200' }} border rounded-2xl shadow-lg overflow-hidden">
                    <div class="px-8 py-6 border-b {{ $theme === 'dark' ? 'border-gray-700 bg-gray-750' : 'border-gray-200 bg-gray-50' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                                Sesiones del Navegador
                            </h3>
                        </div>
                        <p class="mt-1 text-sm {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-600' }}">
                            Gestiona y cierra sesión en otras sesiones del navegador en todos tus dispositivos.
                        </p>
                    </div>
                    <div class="p-8">
                        @livewire('profile.logout-other-browser-sessions-form')
                    </div>
                </div>

                @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <!-- Account Deletion Section -->
                <div class="{{ $theme === 'dark' ? 'bg-red-900 border-red-800' : 'bg-red-50 border-red-200' }} border rounded-2xl shadow-lg overflow-hidden">
                    <div class="px-8 py-6 border-b {{ $theme === 'dark' ? 'border-red-800 bg-red-800' : 'border-red-200 bg-red-100' }}">
                        <div class="flex items-center space-x-3">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold {{ $theme === 'dark' ? 'text-red-400' : 'text-red-800' }}">
                                Eliminar Cuenta
                            </h3>
                        </div>
                        <p class="mt-1 text-sm {{ $theme === 'dark' ? 'text-red-300' : 'text-red-600' }}">
                            Elimina permanentemente tu cuenta. Esta acción no se puede deshacer.
                        </p>
                    </div>
                    <div class="p-8">
                        @livewire('profile.delete-user-form')
                    </div>
                </div>
                @endif

            </div>
            
            <!-- Footer Info -->
            <div class="mt-12 text-center">
                <p class="text-sm {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-600' }}">
                    ¿Necesitas ayuda con tu cuenta? 
                    <a href="#" class="text-blue-600 hover:text-blue-500 {{ $theme === 'dark' ? 'text-blue-400 hover:text-blue-300' : '' }}">
                        Contáctanos
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
    /* Custom gradient for dark theme */
    .bg-gray-750 {
        background-color: rgb(55, 65, 81);
    }
    
    /* Smooth transitions */
    .transition-all {
        transition: all 0.3s ease;
    }
    
    /* Hover effects */
    .hover\:shadow-xl:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
