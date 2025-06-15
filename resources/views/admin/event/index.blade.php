@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light';
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="font-bold text-3xl {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }} mb-2">
                    <i class="fas fa-calendar-alt mr-3 text-purple-500"></i>
                    Gestión de Eventos
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Administra y gestiona todos los eventos de la plataforma
                </p>
            </div>
            <div class="mt-4 lg:mt-0 flex items-center space-x-3">
                <div class="bg-purple-100 dark:bg-purple-900 px-4 py-2 rounded-lg">
                    <span class="text-purple-800 dark:text-purple-200 font-semibold">
                        <i class="fas fa-chart-line mr-2"></i>
                        Total: {{ $countPages->events }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <!-- Alerts -->
        @if ($errors->any())
            <div class="mb-6 mx-6">
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                        <h3 class="text-red-800 dark:text-red-300 font-medium">Errores encontrados:</h3>
                    </div>
                    <ul class="mt-2 text-red-700 dark:text-red-400 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 mx-6">
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-3"></i>
                        <span class="text-green-800 dark:text-green-300 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 mx-6">
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Eventos</p>
                        <p class="text-3xl font-bold">{{ $events->count() }}</p>
                    </div>
                    <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Activos</p>
                        <p class="text-3xl font-bold">{{ $events->where('estado', 'Activo')->count() }}</p>
                    </div>
                    <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Programados</p>
                        <p class="text-3xl font-bold">{{ $events->where('estado', 'Programado')->count() }}</p>
                    </div>
                    <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Capacidad Total</p>
                        <p class="text-3xl font-bold">{{ $events->sum('capacidad') }}</p>
                    </div>
                    <div class="bg-orange-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 mb-8 mx-6">
            <button data-modal-toggle="createModal"
                class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-plus mr-2"></i>Nuevo Evento
            </button>
            
            <a href="{{ route('events.pdf') }}"
                class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
            </a>
            
            <a href="{{ route('eventdetails.index') }}"
                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-cogs mr-2"></i>Gestionar Servicios
            </a>
        </div>

        <!-- Events Grid -->
        <div class="mx-6">
            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <!-- Event Image -->
                            <div class="relative h-48 bg-gradient-to-br from-purple-400 to-blue-500">
                                @if($event->imagen)
                                    <img src="{{ $event->imagen }}" 
                                         alt="{{ $event->nombre }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-6xl text-white opacity-50"></i>
                                    </div>
                                @endif
                                
                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    @if($event->estado === 'Activo')
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                            <i class="fas fa-check-circle mr-1"></i>Activo
                                        </span>
                                    @elseif($event->estado === 'Programado')
                                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                            <i class="fas fa-clock mr-1"></i>Programado
                                        </span>
                                    @else
                                        <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                            <i class="fas fa-pause-circle mr-1"></i>Inactivo
                                        </span>
                                    @endif
                                </div>

                                <!-- Price Badge -->
                                <div class="absolute bottom-4 left-4">
                                    <span class="bg-white bg-opacity-90 text-gray-900 px-3 py-1 rounded-full text-sm font-bold">
                                        ${{ number_format($event->precio_entrada, 2) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6">
                                <div class="space-y-4">
                                    <!-- Event Title -->
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">
                                            {{ $event->nombre }}
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                            {{ $event->descripcion }}
                                        </p>
                                    </div>

                                    <!-- Event Details -->
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-calendar text-purple-500 mr-3 w-4"></i>
                                            <span class="text-gray-700 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($event->fecha)->format('d/m/Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-clock text-blue-500 mr-3 w-4"></i>
                                            <span class="text-gray-700 dark:text-gray-300">
                                                {{ \Carbon\Carbon::parse($event->hora)->format('H:i') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-map-marker-alt text-red-500 mr-3 w-4"></i>
                                            <span class="text-gray-700 dark:text-gray-300 truncate">
                                                {{ $event->ubicacion }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-users text-green-500 mr-3 w-4"></i>
                                            <span class="text-gray-700 dark:text-gray-300">
                                                Capacidad: {{ $event->capacidad }} personas
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Stats -->
                                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <div class="text-center">
                                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                                                {{ $event->bookings->count() }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Reservas</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                                                {{ $event->created_at->diffForHumans() }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Creado</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="px-6 pb-6">
                                <div class="flex space-x-2">
                                    <button data-modal-target="editModal" 
                                            data-row="{{ json_encode($event) }}"
                                            class="flex-1 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-edit mr-2"></i>Editar
                                    </button>
                                    <button data-modal-target="deleteModal" 
                                            data-id="{{ $event->id }}"
                                            class="flex-1 bg-red-100 hover:bg-red-200 dark:bg-red-900 dark:hover:bg-red-800 text-red-700 dark:text-red-300 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-trash mr-2"></i>Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="bg-gray-100 dark:bg-gray-800 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-calendar-alt text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        No hay eventos registrados
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Comienza creando tu primer evento para gestionar las actividades.
                    </p>
                    <button data-modal-toggle="createModal"
                        class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-plus mr-2"></i>Crear Primer Evento
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de edición -->
    <x-modal id="editModal" title="Editar Evento" :theme="$theme">
        <form id="edit-form" method="POST" action="" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="edit-nombre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-tag mr-2 text-purple-500"></i>Nombre del Evento
                    </label>
                    <input type="text" id="edit-nombre" name="nombre"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Ingrese el nombre del evento" required>
                </div>

                <div>
                    <label for="edit-descripcion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-align-left mr-2 text-green-500"></i>Descripción
                    </label>
                    <textarea id="edit-descripcion" name="descripcion" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Describe el evento" required></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edit-capacidad" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-users mr-2 text-blue-500"></i>Capacidad
                        </label>
                        <input type="number" id="edit-capacidad" name="capacidad"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            placeholder="100" required>
                    </div>
                    <div>
                        <label for="edit-precio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-dollar-sign mr-2 text-green-500"></i>Precio
                        </label>
                        <input type="number" id="edit-precio" name="precio_entrada" step="0.01"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            placeholder="50.00" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edit-fecha" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-calendar mr-2 text-purple-500"></i>Fecha
                        </label>
                        <input type="date" id="edit-fecha" name="fecha"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            required>
                    </div>
                    <div>
                        <label for="edit-hora" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-clock mr-2 text-blue-500"></i>Hora
                        </label>
                        <input type="time" id="edit-hora" name="hora"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            required>
                    </div>
                </div>

                <div>
                    <label for="edit-ubicacion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>Ubicación
                    </label>
                    <input type="text" id="edit-ubicacion" name="ubicacion"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Dirección del evento" required>
                </div>

                <div>
                    <label for="edit-estado" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-toggle-on mr-2 text-orange-500"></i>Estado
                    </label>
                    <select id="edit-estado" name="estado"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        required>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                        <option value="Programado">Programado</option>
                    </select>
                </div>

                <div>
                    <label for="edit-imagen" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-image mr-2 text-pink-500"></i>Imagen del Evento
                    </label>
                    <div class="mb-3">
                        <img id="edit-imagen-preview" class="w-32 h-32 object-cover rounded-lg border-2 border-gray-300 dark:border-gray-600" src="" alt="Vista previa">
                    </div>
                    <input type="file" id="edit-imagen" name="imagen" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200">
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <button type="button" data-modal-toggle="editModal"
                    class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors duration-200">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold rounded-xl transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Actualizar
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal de creación -->
    <x-modal id="createModal" title="Crear Nuevo Evento" :theme="$theme">
        <form id="create-form" method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="create-nombre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-tag mr-2 text-purple-500"></i>Nombre del Evento
                    </label>
                    <input type="text" id="create-nombre" name="nombre"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Ingrese el nombre del evento" required>
                </div>

                <div>
                    <label for="create-descripcion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-align-left mr-2 text-green-500"></i>Descripción
                    </label>
                    <textarea id="create-descripcion" name="descripcion" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Describe el evento" required></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="create-capacidad" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-users mr-2 text-blue-500"></i>Capacidad
                        </label>
                        <input type="number" id="create-capacidad" name="capacidad"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            placeholder="100" required>
                    </div>
                    <div>
                        <label for="create-precio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-dollar-sign mr-2 text-green-500"></i>Precio
                        </label>
                        <input type="number" id="create-precio" name="precio_entrada" step="0.01"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            placeholder="50.00" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="create-fecha" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-calendar mr-2 text-purple-500"></i>Fecha
                        </label>
                        <input type="date" id="create-fecha" name="fecha"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            required>
                    </div>
                    <div>
                        <label for="create-hora" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-clock mr-2 text-blue-500"></i>Hora
                        </label>
                        <input type="time" id="create-hora" name="hora"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            required>
                    </div>
                </div>

                <div>
                    <label for="create-ubicacion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>Ubicación
                    </label>
                    <input type="text" id="create-ubicacion" name="ubicacion"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Dirección del evento" required>
                </div>

                <div>
                    <label for="create-estado" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-toggle-on mr-2 text-orange-500"></i>Estado
                    </label>
                    <select id="create-estado" name="estado"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        required>
                        <option value="Programado">Programado</option>
                        <option value="Activo">Activo</option>
                        <option value="Inactivo">Inactivo</option>
                    </select>
                </div>

                <div>
                    <label for="create-imagen" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-image mr-2 text-pink-500"></i>Imagen del Evento
                    </label>
                    <input type="file" id="create-imagen" name="imagen" accept="image/*"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        required>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <button type="button" data-modal-toggle="createModal"
                    class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors duration-200">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-bold rounded-xl transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Crear Evento
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal de eliminación -->
    <x-confirm-modal id="deleteModal" title="¿Estás seguro de que quieres eliminar este evento?" :theme="$theme">
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </x-confirm-modal>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Edición
            const editButtons = document.querySelectorAll('[data-modal-target="editModal"]');
            const editForm = document.getElementById('edit-form');

            editButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const data = JSON.parse(button.dataset.row);
                    document.getElementById('edit-nombre').value = data.nombre;
                    document.getElementById('edit-descripcion').value = data.descripcion;
                    document.getElementById('edit-capacidad').value = data.capacidad;
                    document.getElementById('edit-precio').value = data.precio_entrada;
                    document.getElementById('edit-fecha').value = data.fecha;
                    document.getElementById('edit-hora').value = data.hora;
                    document.getElementById('edit-ubicacion').value = data.ubicacion;
                    document.getElementById('edit-estado').value = data.estado;
                    
                    // Preview image
                    const preview = document.getElementById('edit-imagen-preview');
                    if (data.imagen) {
                        preview.src = data.imagen;
                        preview.style.display = 'block';
                    } else {
                        preview.style.display = 'none';
                    }
                    
                    editForm.setAttribute('action', `/events/${data.id}`);
                });
            });

            // Eliminación
            const deleteButtons = document.querySelectorAll('[data-modal-target="deleteModal"]');
            const deleteForm = document.getElementById('delete-form');

            deleteButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = button.dataset.id;
                    deleteForm.setAttribute('action', `/events/${id}`);
                });
            });
        });
    </script>
</x-app-layout>
