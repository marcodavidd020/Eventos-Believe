@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light' ; $headers=['Id', 'Nombre' , 'Telefono' , 'Email' , 'Direccion'
    , 'Acciones' ]; $rows=$supliers->map(function($suplier) {
    return [
    'id' => $suplier->id,
    'nombre' => $suplier->nombre,
    'telefono' => $suplier->telefono,
    'email' => $suplier->email,
    'direccion' => $suplier->direccion,
    'acciones' => '' // Aquí puedes agregar los botones de acción si es necesario
    ];
    });
    @endphp

    <x-app-layout>
        <x-slot name="header">
            Contador: {{ $countPages->providers }}
            <h2 class="font-semibold text-xl {{ $theme === 'dark' ? 'text-white' : 'text-gray-800' }}">
                {{ __('Proveedores') }}
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
                <a href="{{ route('suppliers.pdf') }}"
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
                    <x-table :headers="$headers" :rows="$rows" :theme="$theme" resource="proveedor" />
                </div>
            </div>
        </div>

        <!-- Modal de edición -->
        <x-modal id="editModal" title="Editar Proveedor" :theme="$theme">
            <form id="edit-form" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="mb-4">
                        <label for="edit-nombre"
                            class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Nombre</label>
                        <input type="text" id="edit-nombre" name="nombre"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="edit-telefono"
                            class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Teléfono</label>
                        <input type="number" id="edit-telefono" name="telefono"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                            required>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="edit-email"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Email</label>
                    <input type="email" id="edit-email" name="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                        required>
                </div>
                <div class="mb-4">
                    <label for="edit-direccion"
                        class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Direccion</label>
                    <input type="text" id="edit-direccion" name="direccion"
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
        <x-modal id="createModal" title="Crear Proveedor" :theme="$theme">
            <form id="create-form" method="POST" action="{{ route('suppliers.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="create-nombre"
                            class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Nombre</label>
                        <input type="text" id="create-nombre" name="nombre"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                            required>
                    </div>
                    <div>
                        <label for="create-telefono"
                            class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Teléfono</label>
                        <input type="number" id="create-telefono" name="telefono"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                            required>
                    </div>
                </div>
                <div class="mb-4">
                    <div>
                        <label for="create-email"
                            class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Email</label>
                        <input type="email" id="create-email" name="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                            required>
                    </div>
                    <div>
                        <label for="create-direccion"
                            class="block mb-2 text-sm font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">Direccion</label>
                        <input type="text" id="create-direccion" name="direccion"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 {{ $theme === 'dark' ? 'dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white' : '' }}"
                            required>
                    </div>
                </div>
                <button type="submit" form="create-form"
                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    Guardar
                </button>
            </form>
        </x-modal>

        <!-- Modal de eliminación -->
        <x-confirm-modal id="deleteModal" title="¿Estás seguro de que quieres eliminar este proveedor?" :theme="$theme">
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

                editButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        /* const data = button.dataset.row; */
                        const data = JSON.parse(button.dataset.row);
                        console.log(data);
                        document.getElementById('edit-nombre').value = data.nombre;
                        document.getElementById('edit-telefono').value = data.telefono;
                        document.getElementById('edit-email').value = data.email;
                        document.getElementById('edit-direccion').value = data.direccion;
                        editForm.setAttribute('action', `/suppliers/${data.id}`);
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
                        deleteForm.setAttribute('action', `/suppliers/${id}`);
                    });
                });

                deleteModalSaveBtn.addEventListener('click', () => {
                    deleteForm.submit();
                });
            });
        </script>
    </x-app-layout>