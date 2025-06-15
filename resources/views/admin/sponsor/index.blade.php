@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light';
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="font-bold text-3xl {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }} mb-2">
                    <i class="fas fa-handshake mr-3 text-blue-500"></i>
                    Gestión de Patrocinadores
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Administra y gestiona todos los patrocinadores de eventos
                </p>
            </div>
            <div class="mt-4 lg:mt-0 flex items-center space-x-3">
                <div class="bg-blue-100 dark:bg-blue-900 px-4 py-2 rounded-lg">
                    <span class="text-blue-800 dark:text-blue-200 font-semibold">
                        <i class="fas fa-chart-line mr-2"></i>
                        Total: {{ $countPages->sponsors }}
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
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Patrocinadores</p>
                        <p class="text-3xl font-bold">{{ $sponsors->count() }}</p>
                    </div>
                    <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-handshake text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Activos</p>
                        <p class="text-3xl font-bold">{{ $sponsors->count() }}</p>
                    </div>
                    <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Nuevos este mes</p>
                        <p class="text-3xl font-bold">{{ $sponsors->filter(function($sponsor) { return $sponsor->created_at && $sponsor->created_at >= now()->startOfMonth(); })->count() }}</p>
                    </div>
                    <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-plus-circle text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Patrocinios</p>
                        <p class="text-3xl font-bold">{{ $sponsors->sum(function($sponsor) { return $sponsor->sponsorships->count(); }) }}</p>
                    </div>
                    <div class="bg-orange-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-star text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 mb-8 mx-6">
            <button data-modal-toggle="createModal"
                class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-plus mr-2"></i>Nuevo Patrocinador
            </button>
            
            <a href="{{ route('sponsors.pdf') }}"
                class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
            </a>
            
            <a href="{{ route('sponsorships.index') }}"
                class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-star mr-2"></i>Gestionar Patrocinios
            </a>
        </div>

        <!-- Sponsors Grid -->
        <div class="mx-6">
            @if($sponsors->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($sponsors as $sponsor)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700">
                            <!-- Card Header -->
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-t-2xl p-6 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold mb-1">{{ $sponsor->nombre }}</h3>
                                        <p class="text-blue-100 text-sm">ID: #{{ $sponsor->id }}</p>
                                    </div>
                                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                                        <i class="fas fa-handshake text-2xl"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6">
                                <div class="space-y-4">
                                    <!-- Description -->
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3">
                                            {{ $sponsor->descripcion }}
                                        </p>
                                    </div>

                                    <!-- Contact Info -->
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-envelope text-blue-500 mr-3 w-4"></i>
                                            <span class="text-gray-700 dark:text-gray-300 truncate">{{ $sponsor->email }}</span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-phone text-green-500 mr-3 w-4"></i>
                                            <span class="text-gray-700 dark:text-gray-300">{{ $sponsor->telefono }}</span>
                                        </div>
                                    </div>

                                    <!-- Stats -->
                                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <div class="text-center">
                                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                                {{ $sponsor->sponsorships->count() }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Patrocinios</p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                                                {{ optional($sponsor->created_at)->diffForHumans() ?? 'Sin fecha' }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Registrado</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="px-6 pb-6">
                                <div class="flex space-x-2">
                                    <button data-modal-target="editModal" 
                                            data-row="{{ json_encode($sponsor) }}"
                                            class="flex-1 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-edit mr-2"></i>Editar
                                    </button>
                                    <button data-modal-target="deleteModal" 
                                            data-id="{{ $sponsor->id }}"
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
                        <i class="fas fa-handshake text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        No hay patrocinadores registrados
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Comienza agregando tu primer patrocinador para gestionar las colaboraciones.
                    </p>
                    <button data-modal-toggle="createModal"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-plus mr-2"></i>Crear Primer Patrocinador
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de edición -->
    <x-modal id="editModal" title="Editar Patrocinador" :theme="$theme">
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="edit-nombre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-building mr-2 text-blue-500"></i>Nombre del Patrocinador
                    </label>
                    <input type="text" id="edit-nombre" name="nombre"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Ingrese el nombre del patrocinador" required>
                </div>

                <div>
                    <label for="edit-descripcion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-align-left mr-2 text-green-500"></i>Descripción
                    </label>
                    <textarea id="edit-descripcion" name="descripcion" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Describe al patrocinador y sus servicios" required></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edit-email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2 text-purple-500"></i>Email
                        </label>
                        <input type="email" id="edit-email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            placeholder="correo@ejemplo.com" required>
                    </div>
                    <div>
                        <label for="edit-telefono" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-phone mr-2 text-orange-500"></i>Teléfono
                        </label>
                        <input type="tel" id="edit-telefono" name="telefono"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            placeholder="70123456" required>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <button type="button" data-modal-toggle="editModal"
                    class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors duration-200">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold rounded-xl transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Actualizar
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal de creación -->
    <x-modal id="createModal" title="Crear Nuevo Patrocinador" :theme="$theme">
        <form id="create-form" method="POST" action="{{ route('sponsors.store') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="create-nombre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-building mr-2 text-blue-500"></i>Nombre del Patrocinador
                    </label>
                    <input type="text" id="create-nombre" name="nombre"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Ingrese el nombre del patrocinador" required>
                </div>

                <div>
                    <label for="create-descripcion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-align-left mr-2 text-green-500"></i>Descripción
                    </label>
                    <textarea id="create-descripcion" name="descripcion" rows="4"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Describe al patrocinador y sus servicios" required></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="create-email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-envelope mr-2 text-purple-500"></i>Email
                        </label>
                        <input type="email" id="create-email" name="email"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            placeholder="correo@ejemplo.com" required>
                    </div>
                    <div>
                        <label for="create-telefono" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-phone mr-2 text-orange-500"></i>Teléfono
                        </label>
                        <input type="tel" id="create-telefono" name="telefono"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            placeholder="70123456" required>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <button type="button" data-modal-toggle="createModal"
                    class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors duration-200">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold rounded-xl transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Crear Patrocinador
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal de eliminación -->
    <x-confirm-modal id="deleteModal" title="¿Estás seguro de que quieres eliminar este patrocinador?" :theme="$theme">
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
        </form>
    </x-confirm-modal>

    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
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
                    document.getElementById('edit-email').value = data.email;
                    document.getElementById('edit-telefono').value = data.telefono;
                    editForm.setAttribute('action', `/sponsors/${data.id}`);
                });
            });

            // Eliminación
            const deleteButtons = document.querySelectorAll('[data-modal-target="deleteModal"]');
            const deleteForm = document.getElementById('delete-form');

            deleteButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = button.dataset.id;
                    deleteForm.setAttribute('action', `/sponsors/${id}`);
                });
            });
        });
    </script>
</x-app-layout>