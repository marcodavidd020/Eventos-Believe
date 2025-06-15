<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Event Header -->
                <div class="relative">
                    @if($event->imagen)
                        <img src="{{ $event->imagen }}" alt="{{ $event->nombre }}" 
                             class="w-full h-64 md:h-80 object-cover">
                    @else
                        <div class="w-full h-64 md:h-80 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-6xl"></i>
                        </div>
                    @endif
                    
                    <!-- Event Title Overlay -->
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-6">
                        <h1 class="text-3xl md:text-4xl font-bold text-white mb-2">{{ $event->nombre }}</h1>
                        <p class="text-white/90 text-lg">{{ $event->descripcion }}</p>
                    </div>
                </div>

                <!-- Event Details -->
                <div class="p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Date -->
                        <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-calendar text-blue-600 dark:text-blue-400 mr-3"></i>
                                <span class="font-semibold text-blue-800 dark:text-blue-300">Fecha</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($event->fecha)->format('d/m/Y') }}</p>
                        </div>

                        <!-- Time -->
                        <div class="bg-green-50 dark:bg-green-900/30 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-clock text-green-600 dark:text-green-400 mr-3"></i>
                                <span class="font-semibold text-green-800 dark:text-green-300">Hora</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($event->hora)->format('H:i') }}</p>
                        </div>

                        <!-- Location -->
                        <div class="bg-purple-50 dark:bg-purple-900/30 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-map-marker-alt text-purple-600 dark:text-purple-400 mr-3"></i>
                                <span class="font-semibold text-purple-800 dark:text-purple-300">Ubicación</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">{{ $event->ubicacion }}</p>
                        </div>

                        <!-- Price -->
                        <div class="bg-orange-50 dark:bg-orange-900/30 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-ticket-alt text-orange-600 dark:text-orange-400 mr-3"></i>
                                <span class="font-semibold text-orange-800 dark:text-orange-300">Precio</span>
                            </div>
                            <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                                Bs. {{ number_format($event->precio_entrada, 2) }}
                            </p>
                        </div>
                    </div>

                    <!-- Booking Section -->
                    <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6 md:p-8">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                            <i class="fas fa-ticket-alt mr-3 text-blue-600"></i>
                            Reservar Entrada
                        </h2>

                        @auth
                            @if($hasBooking)
                                <div class="text-center p-6 bg-green-50 dark:bg-green-900 rounded-xl border-2 border-green-200 dark:border-green-700">
                                    <i class="fas fa-check-circle text-4xl text-green-500 mb-4"></i>
                                    <h4 class="text-xl font-bold text-green-700 dark:text-green-300 mb-2">
                                        ¡Ya tienes una reserva!
                                    </h4>
                                    <p class="text-green-600 dark:text-green-400">
                                        Tu entrada está confirmada para este evento.
                                    </p>
                                </div>
                            @else
                                <!-- Booking Form -->
                                <form class="space-y-6" action="{{ route('consumirServicio') }}" method="POST" target="QrImage" id="eventForm">
                                    @csrf
                                    
                                    <!-- NIT Field -->
                                    <div>
                                        <label for="tcCiNit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-id-card mr-2"></i>NIT o CI
                                        </label>
                                        <input type="text" name="tcCiNit" id="tcCiNit" 
                                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200" 
                                               placeholder="Ingresa tu NIT o CI" required>
                                    </div>
                                    
                                    <!-- Payment Method -->
                                    <div>
                                        <label for="tnTipoServicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            <i class="fas fa-credit-card mr-2"></i>Método de pago
                                        </label>
                                        <select id="tnTipoServicio" name="tnTipoServicio" 
                                                class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all duration-200">
                                            <option value="">Selecciona un método</option>
                                            <option value="1">
                                                <i class="fas fa-qrcode mr-2"></i>Servicio QR
                                            </option>
                                            <option value="2">
                                                <i class="fas fa-mobile-alt mr-2"></i>Tigo Money
                                            </option>
                                        </select>
                                    </div>
                                    
                                    <!-- Hidden Fields -->
                                    <input type="hidden" name="id_evento" value="{{ $event->id }}">
                                    <input type="hidden" name="id_usuario" value="{{ Auth::user()->id }}">
                                    <input type="hidden" name="tnTelefono" value="{{ Auth::user()->phone }}">
                                    <input type="hidden" name="tnNombre" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="tcCorreo" value="{{ Auth::user()->email }}">
                                    <input type="hidden" name="tnMonto" value="{{ $event->precio_entrada }}">
                                    <input type="hidden" name="tcDetallePedido" value="Reserva de entrada para el evento {{ $event->nombre }}">
                                    
                                    <!-- QR Service Section -->
                                    <div id="qrInfo" class="hidden space-y-4">
                                        <button type="submit" id="submitBtn" 
                                                class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-4 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                                            <span id="btnText">
                                                <i class="fas fa-qrcode mr-2"></i>
                                                Generar QR
                                            </span>
                                            <span id="btnLoading" class="hidden">
                                                <div class="loading-spinner mr-2"></div>
                                                Generando...
                                            </span>
                                        </button>
                                        
                                        <!-- QR Display Container -->
                                        <div id="qrContainer" class="hidden">
                                            <div class="bg-white dark:bg-gray-900 rounded-3xl p-6 lg:p-8 border border-gray-200 dark:border-gray-600 shadow-2xl max-w-4xl mx-auto">
                                                <!-- Header -->
                                                <div class="text-center mb-6 lg:mb-8">
                                                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mb-4">
                                                        <i class="fas fa-qrcode text-white text-2xl"></i>
                                                    </div>
                                                    <h4 class="text-xl lg:text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                                        Código QR de Pago
                                                    </h4>
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm lg:text-base">
                                                        Escanea este código con tu aplicación de pagos
                                                    </p>
                                                </div>
                                                
                                                <!-- Main Content Grid -->
                                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-start">
                                                    <!-- QR Code Display -->
                                                    <div class="order-1 lg:order-1">
                                                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 p-6 lg:p-8 rounded-3xl shadow-inner border-2 border-gray-200 dark:border-gray-600">
                                                            <iframe name="QrImage" id="QrImage" 
                                                                    class="w-full h-80 lg:h-96 rounded-2xl bg-white shadow-xl border-4 border-white dark:border-gray-600"
                                                                    style="min-height: 320px;"></iframe>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Payment Info and Instructions -->
                                                    <div class="order-2 lg:order-2 space-y-6">
                                                        <!-- Payment Info Cards -->
                                                        <div class="space-y-4">
                                                            <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 rounded-2xl p-4 lg:p-6 border border-green-200 dark:border-green-700">
                                                                <div class="flex items-center mb-2">
                                                                    <i class="fas fa-dollar-sign text-green-600 dark:text-green-400 mr-3 text-lg lg:text-xl"></i>
                                                                    <span class="font-medium text-green-700 dark:text-green-300 text-sm lg:text-base">Monto a pagar</span>
                                                                </div>
                                                                <p class="text-2xl lg:text-3xl font-bold text-green-600 dark:text-green-400">
                                                                    Bs. {{ number_format($event->precio_entrada, 2) }}
                                                                </p>
                                                            </div>
                                                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/30 dark:to-indigo-900/30 rounded-2xl p-4 lg:p-6 border border-blue-200 dark:border-blue-700">
                                                                <div class="flex items-center mb-2">
                                                                    <i class="fas fa-calendar-alt text-blue-600 dark:text-blue-400 mr-3 text-lg lg:text-xl"></i>
                                                                    <span class="font-medium text-blue-700 dark:text-blue-300 text-sm lg:text-base">Evento</span>
                                                                </div>
                                                                <p class="text-base lg:text-lg font-bold text-blue-600 dark:text-blue-400">
                                                                    {{ $event->nombre }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Instructions -->
                                                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-4 lg:p-6 border border-blue-200 dark:border-blue-700">
                                                            <h5 class="font-bold text-blue-800 dark:text-blue-300 mb-4 flex items-center text-base lg:text-lg">
                                                                <i class="fas fa-mobile-alt mr-3 text-lg lg:text-xl"></i>
                                                                Pasos para pagar
                                                            </h5>
                                                            <div class="space-y-3">
                                                                <div class="flex items-start space-x-3">
                                                                    <div class="bg-blue-500 text-white rounded-full w-7 h-7 lg:w-8 lg:h-8 flex items-center justify-center text-xs lg:text-sm font-bold flex-shrink-0">1</div>
                                                                    <p class="text-blue-700 dark:text-blue-300 font-medium text-sm lg:text-base">Abre tu aplicación de pagos móviles</p>
                                                                </div>
                                                                <div class="flex items-start space-x-3">
                                                                    <div class="bg-blue-500 text-white rounded-full w-7 h-7 lg:w-8 lg:h-8 flex items-center justify-center text-xs lg:text-sm font-bold flex-shrink-0">2</div>
                                                                    <p class="text-blue-700 dark:text-blue-300 font-medium text-sm lg:text-base">Selecciona la opción "Escanear QR"</p>
                                                                </div>
                                                                <div class="flex items-start space-x-3">
                                                                    <div class="bg-blue-500 text-white rounded-full w-7 h-7 lg:w-8 lg:h-8 flex items-center justify-center text-xs lg:text-sm font-bold flex-shrink-0">3</div>
                                                                    <p class="text-blue-700 dark:text-blue-300 font-medium text-sm lg:text-base">Apunta la cámara hacia este código</p>
                                                                </div>
                                                                <div class="flex items-start space-x-3">
                                                                    <div class="bg-blue-500 text-white rounded-full w-7 h-7 lg:w-8 lg:h-8 flex items-center justify-center text-xs lg:text-sm font-bold flex-shrink-0">4</div>
                                                                    <p class="text-blue-700 dark:text-blue-300 font-medium text-sm lg:text-base">Confirma el monto y completa el pago</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Warning - Bottom -->
                                                <div class="mt-6 lg:mt-8 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 border border-amber-200 dark:border-amber-700 rounded-xl p-4">
                                                    <div class="flex items-center">
                                                        <i class="fas fa-clock text-amber-600 dark:text-amber-400 mr-3 text-lg"></i>
                                                        <p class="text-amber-800 dark:text-amber-300 font-medium text-sm lg:text-base">
                                                            El código QR es válido por 10 minutos. Completa tu pago antes de que expire.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                
                                <!-- Final Payment Button -->
                                <div id="buy" class="hidden mt-6">
                                    <div class="bg-green-50 dark:bg-green-900 border-2 border-green-200 dark:border-green-700 rounded-xl p-6 text-center">
                                        <i class="fas fa-check-circle text-3xl text-green-500 mb-3"></i>
                                        <h4 class="text-lg font-bold text-green-700 dark:text-green-300 mb-2">
                                            ¡QR Generado Exitosamente!
                                        </h4>
                                        <p class="text-green-600 dark:text-green-400 mb-4">
                                            Escanea el código QR para completar tu pago
                                        </p>
                                        <form action="{{ route('bookings.store') }}" method="POST" id="finalForm">
                                            @csrf
                                            <input type="hidden" name="evento_id" value="{{ $event->id }}">
                                            <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="costo_entrada" value="{{ $event->precio_entrada }}">
                                            
                                            <button type="submit" 
                                                    class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-3 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                                                <i class="fas fa-ticket-alt mr-2"></i>
                                                Confirmar Reserva
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Tigo Money Section -->
                                <div id="tigoMoney" class="hidden mt-6">
                                    <div class="bg-orange-50 dark:bg-orange-900 border-2 border-orange-200 dark:border-orange-700 rounded-xl p-6">
                                        <h4 class="text-lg font-bold text-orange-700 dark:text-orange-300 mb-4 text-center">
                                            <i class="fas fa-mobile-alt mr-2"></i>
                                            Pago con Tigo Money
                                        </h4>
                                        <form action="{{ route('bookings.store') }}" method="POST" id="tigoForm">
                                            @csrf
                                            <input type="hidden" name="evento_id" value="{{ $event->id }}">
                                            <input type="hidden" name="usuario_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="costo_entrada" value="{{ $event->precio_entrada }}">
                                            
                                            <button type="submit" 
                                                    class="w-full bg-gradient-to-r from-orange-600 to-red-600 text-white font-bold py-4 rounded-xl hover:from-orange-700 hover:to-red-700 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                                                <i class="fas fa-mobile-alt mr-2"></i>
                                                Pagar con Tigo Money
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="text-center p-6 bg-blue-50 dark:bg-blue-900 rounded-xl border-2 border-blue-200 dark:border-blue-700">
                                <i class="fas fa-user-plus text-4xl text-blue-500 mb-4"></i>
                                <h4 class="text-xl font-bold text-blue-700 dark:text-blue-300 mb-2">
                                    Inicia sesión para reservar
                                </h4>
                                <p class="text-blue-600 dark:text-blue-400 mb-4">
                                    Necesitas una cuenta para poder reservar tu entrada
                                </p>
                                <div class="space-y-3">
                                    <a href="{{ route('login-client') }}" 
                                       class="inline-block w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-3 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Iniciar Sesión
                                    </a>
                                    <a href="{{ route('register-client') }}" 
                                       class="inline-block w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold py-3 rounded-xl hover:from-green-700 hover:to-emerald-700 transition-all duration-200 transform hover:scale-[1.02] shadow-lg">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Registrarse
                                    </a>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .loading-spinner {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const metodoPagoSelect = document.getElementById('tnTipoServicio');
        const qrInfoDiv = document.getElementById('qrInfo');
        const buyInfoDiv = document.getElementById('buy');
        const tigoMoneyDiv = document.getElementById('tigoMoney');
        const qrContainer = document.getElementById('qrContainer');
        const form = document.getElementById('eventForm');
        const nitField = document.getElementById('tcCiNit');
        const qrIframe = document.getElementById('QrImage');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const btnLoading = document.getElementById('btnLoading');

        // Payment method change handler
        metodoPagoSelect.addEventListener('change', function() {
            // Reset all payment options
            qrInfoDiv.classList.add('hidden');
            buyInfoDiv.classList.add('hidden');
            tigoMoneyDiv.classList.add('hidden');
            qrContainer.classList.add('hidden');
            
            if (metodoPagoSelect.value == '1') {
                qrInfoDiv.classList.remove('hidden');
            } else if (metodoPagoSelect.value == '2') {
                tigoMoneyDiv.classList.remove('hidden');
            }
        });

        // Form submission handler
        form.addEventListener('submit', function(event) {
            if (!nitField.value.trim()) {
                event.preventDefault();
                alert('Por favor, ingrese su NIT o CI antes de continuar.');
                nitField.focus();
                return;
            }

            if (!metodoPagoSelect.value) {
                event.preventDefault();
                alert('Por favor, seleccione un método de pago.');
                metodoPagoSelect.focus();
                return;
            }

            // Show loading state
            submitBtn.disabled = true;
            btnText.classList.add('hidden');
            btnLoading.classList.remove('hidden');
            
            // Show QR container
            setTimeout(() => {
                qrContainer.classList.remove('hidden');
            }, 500);
        });

        // QR iframe load handler
        qrIframe.addEventListener('load', function() {
            if (qrIframe.src && qrIframe.src !== 'about:blank') {
                // Hide loading state
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
                
                // Show success message and final button
                setTimeout(() => {
                    buyInfoDiv.classList.remove('hidden');
                    
                    // Scroll to the QR code
                    qrContainer.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center' 
                    });
                }, 1000);
            }
        });

        // Handle iframe errors
        qrIframe.addEventListener('error', function() {
            submitBtn.disabled = false;
            btnText.classList.remove('hidden');
            btnLoading.classList.add('hidden');
            alert('Error al generar el código QR. Por favor, inténtelo nuevamente.');
        });

        // Listen for messages from iframe
        window.addEventListener('message', function(event) {
            if (event.data.type === 'qr_loaded' && event.data.success) {
                // QR loaded successfully
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
                
                setTimeout(() => {
                    buyInfoDiv.classList.remove('hidden');
                }, 1000);
            } else if (event.data.type === 'qr_error') {
                // QR loading failed
                submitBtn.disabled = false;
                btnText.classList.remove('hidden');
                btnLoading.classList.add('hidden');
                alert('Error al generar el código QR: ' + event.data.message);
            }
        });
    });
    </script>
</x-app-layout>
