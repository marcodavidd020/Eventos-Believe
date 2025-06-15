@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light' ; $headers=['Id', 'Nombre' , 'Descripción', 'Proveedor' , 'Acciones' ];
    $rows=$services->map(function($service) {
    return [
    'id' => $service->id,
    'nombre' => $service->nombre,
    'descripcion' => $service->descripcion,
    'proveedor' => $service->proveedor->nombre,
    'acciones' => '' // Aquí puedes agregar los botones de acción si es necesario
    ];
    });
    @endphp

    <x-app-layout>
        <x-slot name="header">
            Contador: {{ $countPages->services }}
            <h2 class="font-semibold text-xl {{ $theme === 'dark' ? 'text-white' : 'text-gray-800' }}">
                {{ __('Servicios') }}
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
                <a href="{{ route('services.pdf') }}"
                    class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center {{ $theme === 'dark' ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : '' }}">
                    PDF
                </a>
                <button data-modal-toggle="createModal"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center {{ $theme === 'dark' ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : '' }}">
                    Crear
                </button>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <x-table :headers="$headers" :rows="$rows" :theme="$theme" resource="servicio" />
                </div>
            </div>
        </div>

        <!-- Modal de edición -->
        <x-modal id="editModal" title="Editar Servicio" :theme="$theme">
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="edit-nombre"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Nombre</label>
                    <input type="text" id="edit-nombre" name="nombre"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                </div>
                <div class="mb-4">
                    <label for="edit-descripcion"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Descripción</label>
                    <textarea id="edit-descripcion" name="descripcion" rows="4"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required></textarea>
                </div>

                <div class="mb-4">
                    <label for="edit-proveedor"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Proveedor</label>
                    <select id="edit-proveedor" name="proveedor_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                        @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" form="edit-form"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Actualizar
                </button>
            </form>
        </x-modal>

        <!-- Modal de creación -->
        <x-modal id="createModal" title="Crear Servicio" :theme="$theme">
            <form id="create-form" method="POST" action="{{ route('services.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="create-nombre"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Nombre</label>
                    <input type="text" id="create-nombre" name="nombre"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                </div>
                <div class="mb-4">
                    <label for="create-descripcion"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Descripción</label>
                    <textarea id="create-descripcion" name="descripcion" rows="4"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required></textarea>
                </div>

                <div class="mb-4">
                    <label for="create-proveedor"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Proveedor</label>
                    <select id="create-proveedor" name="proveedor_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                        @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" form="create-form"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Guardar
                </button>
               {{--  <button type="button"
                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Cancelar</button> --}}
            </form>
        </x-modal>



        <!-- Modal de eliminación -->
        <x-confirm-modal id="deleteModal" title="¿Estás seguro de que quieres eliminar este servicio?" :theme="$theme">
            <form id="delete-form" method="POST">
                @csrf
                @method('DELETE')
                
            </form>
        </x-confirm-modal>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const editButtons = document.querySelectorAll('[data-modal-target="editModal"]');
                const editForm = document.getElementById('edit-form');
                const editModalSaveBtn = document.querySelector('#editModal [type="submit"]');

                // Obtener proveedores
                const suppliers = @json($suppliers);

                editButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        /* const data = button.dataset.row; */
                        const data = JSON.parse(button.dataset.row);
                        console.log(data);
                        document.getElementById('edit-nombre').value = data.nombre;
                        document.getElementById('edit-descripcion').value = data.descripcion;
                        document.getElementById('edit-proveedor').value = suppliers.find(supplier => supplier.nombre === data.proveedor).id; 
                        editForm.setAttribute('action', `/services/${data.id}`);
                    });
                });

                editModalSaveBtn.addEventListener('click', () => {
                    editForm.submit();
                });

                const createForm = document.getElementById('create-form');
                const createModalSaveBtn = document.querySelector('#createModal [type="submit"]');

                createModalSaveBtn.addEventListener('click', () => {
                    createForm.submit();
                });

                const deleteButtons = document.querySelectorAll('[data-modal-target="deleteModal"]');
                const deleteForm = document.getElementById('delete-form');
                const deleteModalSaveBtn = document.querySelector('#deleteModal [type="submit"]');

                deleteButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const id = button.dataset.id;
                        deleteForm.setAttribute('action', `/services/${id}`);
                    });
                });

                deleteModalSaveBtn.addEventListener('click', () => {
                    deleteForm.submit();
                });
            });
        </script>
    </x-app-layout>