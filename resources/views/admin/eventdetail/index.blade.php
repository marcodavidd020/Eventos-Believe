@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light' ; $headers=['Id', 'Evento' , 'Servicio' , 'Costo' , 'Acciones' ];
    $rows=$eventdetails->
    map(function($eventdetail) {
    return [
    'id' => $eventdetail->id,
    'evento' => $eventdetail->evento->nombre,
    'servicio' => $eventdetail->servicio->nombre,
    'costo_servicio' => $eventdetail->costo_servicio,
    'acciones' => '' // Aquí puedes agregar los botones de acción si es necesario
    ];
    });
    @endphp

    <x-app-layout>
        <x-slot name="header">
            Contador: {{ $countPages->eventdetails }}
            <h2 class="font-semibold text-xl {{ $theme === 'dark' ? 'text-white' : 'text-gray-800' }}">
                {{ __('Eventos - Servicios') }}
            </h2>
        </x-slot>

        <div class="py-12">
            @if ($errors->any())
            <div class="mb-4">
                <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    {{ session('success') }}
                </div>
            </div>
            @endif
            <!-- Button Crear -->
            <div class="flex justify-end p-6">
                <a href="{{ route('eventdetails.pdf') }}"
                    class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center {{ $theme === 'dark' ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : '' }}">
                    PDF
                </a>
                <a href="{{ route('events.index') }}"
                    class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center {{ $theme === 'dark' ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : '' }}">
                    Volver
                </a>
                <button data-modal-toggle="createModal"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center {{ $theme === 'dark' ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : '' }}">
                    Crear
                </button>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <x-table :headers="$headers" :rows="$rows" :theme="$theme" resource="" />
                </div>
            </div>
        </div>

        <!-- Modal de edición -->
        <x-modal id="editModal" title="Editar Evento - Servicio" :theme="$theme">
            <form id="edit-form" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit-evento"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Evento</label>
                    <select id="edit-evento" name="evento_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                        @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="edit-servicio"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Servicio</label>
                    <select id="edit-servicio" name="servicio_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="edit-costo"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Costo
                        Servicio </label>
                    <input type="number" id="edit-costo" name="costo_servicio"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                </div>
                <button type="submit" form="edit-form"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Actualizar
                </button>
            </form>
        </x-modal>

        <!-- Modal de creación -->
        <x-modal id="createModal" title="Agregar Evento - Servicio" :theme="$theme">
            <form id="create-form" method="POST" action="{{ route('eventdetails.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="create-evento"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Evento</label>
                    <select id="create-evento" name="evento_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                        @foreach($events as $event)
                        <option value="{{ $event->id }}">{{ $event->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="create-servicio"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Servicio</label>
                    <select id="create-servicio" name="servicio_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="create-costo"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Costo
                        Servicio </label>
                    <input type="number" id="create-costo" name="costo_servicio"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                </div>

                <button type="submit" form="create-form"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Guardar
                </button>
            </form>
        </x-modal>

        <!-- Modal de eliminación -->
        <x-confirm-modal id="deleteModal" title="¿Estás seguro de que quieres eliminar este evento con servicio?"
            :theme="$theme">
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
            </form>
        </x-confirm-modal>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Edición
                const editButtons = document.querySelectorAll('[data-modal-target="editModal"]');
                const editForm = document.getElementById('edit-form');
                const editModalSaveBtn = document.querySelector('#editModal [type="submit"]');

                // Obtener servicios y eventos
                const events = @json($events);
                const services = @json($services);

                editButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const data = JSON.parse(button.dataset.row);
                        
                        document.getElementById('edit-evento').value = events.find(event => event.nombre === data.evento).id; 
                        document.getElementById('edit-servicio').value = services.find(service => service.nombre === data.servicio).id; 
                        document.getElementById('edit-costo').value = data.costo_servicio;
                        editForm.setAttribute('action', `/eventdetails/${data.id}`);
                    });
                });

                editModalSaveBtn.addEventListener('click', () => {
                    editForm.submit();
                });

                // Creación
                const createForm = document.getElementById('create-form');
                const createModalSaveBtn = document.querySelector('#createModal [type="submit"]');

                createModalSaveBtn.addEventListener('click', () => {
                    createForm.submit();
                });

                // Eliminación
                const deleteButtons = document.querySelectorAll('[data-modal-target="deleteModal"]');
                const deleteForm = document.getElementById('delete-form');
                const deleteModalSaveBtn = document.querySelector('#deleteModal [type="submit"]');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const id = button.dataset.id;
                        deleteForm.setAttribute('action', `/eventdetails/${id}`);
                    });
                });

                deleteModalSaveBtn.addEventListener('click', () => {
                    deleteForm.submit();
                });
            });
        </script>
    </x-app-layout>