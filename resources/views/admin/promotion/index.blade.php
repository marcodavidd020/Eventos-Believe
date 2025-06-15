@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light';
@endphp

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="font-bold text-3xl {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }} mb-2">
                    <i class="fas fa-tags mr-3 text-orange-500"></i>
                    Gestión de Promociones
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Administra y gestiona todas las promociones y descuentos
                </p>
            </div>
            <div class="mt-4 lg:mt-0 flex items-center space-x-3">
                <div class="bg-orange-100 dark:bg-orange-900 px-4 py-2 rounded-lg">
                    <span class="text-orange-800 dark:text-orange-200 font-semibold">
                        <i class="fas fa-chart-line mr-2"></i>
                        Total: {{ $countPages->promotions }}
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
            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Total Promociones</p>
                        <p class="text-3xl font-bold">{{ $promotions->count() }}</p>
                    </div>
                    <div class="bg-orange-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-tags text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Activas</p>
                        <p class="text-3xl font-bold">{{ $promotions->where('fecha_inicio', '<=', now())->where('fecha_fin', '>=', now())->count() }}</p>
                    </div>
                    <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Próximas</p>
                        <p class="text-3xl font-bold">{{ $promotions->where('fecha_inicio', '>', now())->count() }}</p>
                    </div>
                    <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Descuento Promedio</p>
                        <p class="text-3xl font-bold">{{ $promotions->avg('descuento') ? round($promotions->avg('descuento')) : 0 }}%</p>
                    </div>
                    <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                        <i class="fas fa-percentage text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 mb-8 mx-6">
            <button data-modal-toggle="createModal"
                class="bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-plus mr-2"></i>Nueva Promoción
            </button>
            
            <a href="{{ route('promotions.pdf') }}"
                class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
            </a>
        </div>

        <!-- Promotions Grid -->
        <div class="mx-6">
            @if($promotions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($promotions as $promotion)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <!-- Promotion Header -->
                            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-t-2xl p-6 text-white relative">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-bold mb-1">{{ $promotion->descuento }}% OFF</h3>
                                        <p class="text-orange-100 text-sm">Promoción #{{ $promotion->id }}</p>
                                    </div>
                                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                                        <i class="fas fa-percentage text-2xl"></i>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    @if($promotion->fecha_inicio <= now() && $promotion->fecha_fin >= now())
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                            <i class="fas fa-check-circle mr-1"></i>Activa
                                        </span>
                                    @elseif($promotion->fecha_inicio > now())
                                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                            <i class="fas fa-clock mr-1"></i>Próxima
                                        </span>
                                    @else
                                        <span class="bg-gray-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                            <i class="fas fa-times-circle mr-1"></i>Expirada
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6">
                                <div class="space-y-4">
                                    <!-- Description -->
                                    <div>
                                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2">
                                            {{ $promotion->descripcion }}
                                        </p>
                                    </div>

                                    <!-- Event Info -->
                                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt text-purple-500 mr-3"></i>
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-white text-sm">
                                                    {{ $promotion->evento->nombre }}
                                                </p>
                                                <p class="text-gray-500 dark:text-gray-400 text-xs">
                                                    Evento asociado
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date Range -->
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-play text-green-500 mr-3 w-4"></i>
                                            <span class="text-gray-700 dark:text-gray-300">
                                                Inicio: {{ \Carbon\Carbon::parse($promotion->fecha_inicio)->format('d/m/Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <i class="fas fa-stop text-red-500 mr-3 w-4"></i>
                                            <span class="text-gray-700 dark:text-gray-300">
                                                Fin: {{ \Carbon\Carbon::parse($promotion->fecha_fin)->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Duration -->
                                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <div class="text-center">
                                            <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                                                {{ \Carbon\Carbon::parse($promotion->fecha_inicio)->diffInDays(\Carbon\Carbon::parse($promotion->fecha_fin)) + 1 }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Días de duración</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="px-6 pb-6">
                                <div class="flex space-x-2">
                                    <button data-modal-target="editModal" 
                                            data-row="{{ json_encode($promotion) }}"
                                            class="flex-1 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-edit mr-2"></i>Editar
                                    </button>
                                    <button data-modal-target="deleteModal" 
                                            data-id="{{ $promotion->id }}"
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
                        <i class="fas fa-tags text-4xl text-gray-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                        No hay promociones registradas
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        Comienza creando tu primera promoción para atraer más clientes.
                    </p>
                    <button data-modal-toggle="createModal"
                        class="bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-bold py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-plus mr-2"></i>Crear Primera Promoción
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de edición -->
    <x-modal id="editModal" title="Editar Promoción" :theme="$theme">
        <form id="edit-form" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="edit-descripcion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-align-left mr-2 text-orange-500"></i>Descripción
                    </label>
                    <input type="text" id="edit-descripcion" name="descripcion"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Describe la promoción" required>
                </div>

                <div>
                    <label for="edit-descuento" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-percentage mr-2 text-green-500"></i>Descuento (%)
                    </label>
                    <input type="number" id="edit-descuento" name="descuento" min="1" max="100"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="20" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="edit-fecha_inicio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-play mr-2 text-blue-500"></i>Fecha Inicio
                        </label>
                        <input type="date" id="edit-fecha_inicio" name="fecha_inicio"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            required>
                    </div>
                    <div>
                        <label for="edit-fecha_fin" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-stop mr-2 text-red-500"></i>Fecha Fin
                        </label>
                        <input type="date" id="edit-fecha_fin" name="fecha_fin"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            required>
                    </div>
                </div>

                <div>
                    <label for="edit-evento" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-purple-500"></i>Evento
                    </label>
                    <select id="edit-evento" name="evento_id"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        required>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <button type="button" data-modal-toggle="editModal"
                    class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors duration-200">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-bold rounded-xl transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-save mr-2"></i>Actualizar
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal de creación -->
    <x-modal id="createModal" title="Crear Nueva Promoción" :theme="$theme">
        <form id="create-form" method="POST" action="{{ route('promotions.store') }}">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="create-descripcion" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-align-left mr-2 text-orange-500"></i>Descripción
                    </label>
                    <input type="text" id="create-descripcion" name="descripcion"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="Describe la promoción" required>
                </div>

                <div>
                    <label for="create-descuento" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-percentage mr-2 text-green-500"></i>Descuento (%)
                    </label>
                    <input type="number" id="create-descuento" name="descuento" min="1" max="100"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        placeholder="20" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="create-fecha_inicio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-play mr-2 text-blue-500"></i>Fecha Inicio
                        </label>
                        <input type="date" id="create-fecha_inicio" name="fecha_inicio"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            required>
                    </div>
                    <div>
                        <label for="create-fecha_fin" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-stop mr-2 text-red-500"></i>Fecha Fin
                        </label>
                        <input type="date" id="create-fecha_fin" name="fecha_fin"
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                            required>
                    </div>
                </div>

                <div>
                    <label for="create-evento" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-calendar-alt mr-2 text-purple-500"></i>Evento
                    </label>
                    <select id="create-evento" name="evento_id"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all duration-200"
                        required>
                        <option value="">Selecciona un evento</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-8">
                <button type="button" data-modal-toggle="createModal"
                    class="px-6 py-3 bg-gray-300 hover:bg-gray-400 dark:bg-gray-600 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-xl transition-colors duration-200">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-bold rounded-xl transition-all duration-200 transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>Crear Promoción
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal de eliminación -->
    <x-confirm-modal id="deleteModal" title="¿Estás seguro de que quieres eliminar esta promoción?" :theme="$theme">
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
                    document.getElementById('edit-descripcion').value = data.descripcion;
                    document.getElementById('edit-descuento').value = data.descuento;
                    document.getElementById('edit-fecha_inicio').value = data.fecha_inicio;
                    document.getElementById('edit-fecha_fin').value = data.fecha_fin;
                    document.getElementById('edit-evento').value = data.evento_id;
                    editForm.setAttribute('action', `/promotions/${data.id}`);
                });
            });

            // Eliminación
            const deleteButtons = document.querySelectorAll('[data-modal-target="deleteModal"]');
            const deleteForm = document.getElementById('delete-form');

            deleteButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    const id = button.dataset.id;
                    deleteForm.setAttribute('action', `/promotions/${id}`);
                });
            });
        });
    </script>
</x-app-layout>