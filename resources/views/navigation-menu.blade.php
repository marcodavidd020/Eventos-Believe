@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light' ; @endphp <nav class="bg-white border-gray-200 {{ $theme === 'dark' ? 'dark:bg-gray-900 dark:border-gray-600' : '' }}">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
        <button data-collapse-toggle="mega-menu-full" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 {{ $theme === 'dark' ? 'dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600' : '' }}" aria-controls="mega-menu-full" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <a href="{{ url('/dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="https://res.cloudinary.com/dg2ugi96k/image/upload/v1721204281/LOGOTAG-a1fb86e0_nb8n4l.png" class="h-12" alt="Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap {{ $theme === 'dark' ? 'dark:text-white' : '' }}">TAG</span>
        </a>
        <form method="POST" action="{{ route('updateStyle') }}">
            @csrf
            @method('PUT')

            <div class="col-span-6 sm:col-span-4">
                <x-label for="style" value="{{ __('Estilo') }}" class="{{ $theme === 'dark' ? 'dark:text-gray-300' : 'text-gray-900' }}" />
                <select name="style" id="style" class="mt-1 block w-full {{ $theme === 'dark' ? 'dark:text-gray-300 dark:bg-gray-700 dark:border-gray-600' : 'text-gray-900 bg-gray-50 border-gray-300' }}" required>
                    <option value="young" {{ Auth::user()->style == 'young' ? 'selected' : '' }}>Joven</option>
                    <option value="adult" {{ Auth::user()->style == 'adult' ? 'selected' : '' }}>Adulto</option>
                    <option value="senior" {{ Auth::user()->style == 'senior' ? 'selected' : '' }}>Adulto Mayor</option>
                </select>
            </div>

            <div class="mt-4">
                <x-button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Actualizar Estilo') }}
                </x-button>
            </div>
        </form>

        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 {{ $theme === 'dark' ? 'dark:focus:ring-gray-600' : '' }}" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                <span class="sr-only">Open user menu</span>
                <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                    <span class="font-medium text-gray-600 dark:text-gray-300">{{ Auth::user()->name[0] }}</span>
                </div>
            </button>
            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow {{ $theme === 'dark' ? 'dark:bg-gray-700 dark:divide-gray-600' : '' }}" id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">{{
                        Auth::user()->name }}</span>
                    <span class="block text-sm text-gray-500 truncate {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">{{
                        Auth::user()->email }}</span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                        <a href="{{ url('/dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white' : '' }}">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white' : '' }}">Perfil</a>
                    </li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <li>
                            <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white' : '' }}" onclick="event.preventDefault(); this.closest('form').submit();">Sign out</a>
                        </li>
                    </form>
                </ul>
            </div>
        </div>
        <div id="mega-menu-full" class="items-center justify-between font-medium hidden w-full md:flex md:w-auto md:order-1">
            <ul class="flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white {{ $theme === 'dark' ? 'dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700' : '' }}">
                <li>
                    <a href="{{ url('/dashboard') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 {{ $theme === 'dark' ? 'dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700' : '' }}" aria-current="page">Home</a>
                </li>
                <li>
                    <button id="mega-menu-full-dropdown-button" data-collapse-toggle="mega-menu-full-dropdown" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 rounded md:w-auto hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-600 md:p-0 {{ $theme === 'dark' ? 'dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-blue-500 md:dark:hover:bg-transparent dark:border-gray-700' : '' }}">Secciones
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg></button>
                </li>
            </ul>
        </div>

    </div>
    <div id="mega-menu-full-dropdown" class="hidden mt-1 border-gray-200 shadow-sm bg-gray-50 md:bg-white border-y {{ $theme === 'dark' ? 'dark:bg-gray-800 dark:border-gray-700' : '' }}">
        <div class="grid max-w-screen-xl px-4 py-5 mx-auto text-gray-900 {{ $theme === 'dark' ? 'dark:text-gray-300' : '' }} sm:grid-cols-2 md:px-6">
            <ul>
                <li>
                    <a href="{{ route('sponsors.index')}}" class="block p-3 rounded-lg hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-700' : '' }}">
                        <div class="font-semibold">Patrocinadores</div>
                        <span class="text-sm text-gray-500 {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">Información
                            sobre patrocinadores.</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('events.index')}}" class="block p-3 rounded-lg hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-700' : '' }}">
                        <div class="font-semibold">Eventos</div>
                        <span class="text-sm text-gray-500 {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">Información
                            sobre eventos.</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="#"
                        class="block p-3 rounded-lg hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-700' : '' }}">
                <div class="font-semibold">Patrocinios</div>
                <span class="text-sm text-gray-500 {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">Información
                    sobre patrocinios.</span>
                </a>
                </li> --}}
                <li>
                    <a href="{{ route('services.index')}}" class="block p-3 rounded-lg hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-700' : '' }}">
                        <div class="font-semibold">Servicios</div>
                        <span class="text-sm text-gray-500 {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">Información
                            sobre servicios.</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index')}}" class="block p-3 rounded-lg hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-700' : '' }}">
                        <div class="font-semibold">Usuarios</div>
                        <span class="text-sm text-gray-500 {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">Información
                            sobre usuarios.</span>
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <a href="{{ route('promotions.index')}}" class="block p-3 rounded-lg hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-700' : '' }}">
                        <div class="font-semibold">Promociones</div>
                        <span class="text-sm text-gray-500 {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">Información
                            sobre promociones.</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('suppliers.index')}}" class="block p-3 rounded-lg hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-700' : '' }}">
                        <div class="font-semibold">Proveedores</div>
                        <span class="text-sm text-gray-500 {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">Información
                            sobre proveedores.</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('bookings.index')}}" class="block p-3 rounded-lg hover:bg-gray-100 {{ $theme === 'dark' ? 'dark:hover:bg-gray-700' : '' }}">
                        <div class="font-semibold">Reservas</div>
                        <span class="text-sm text-gray-500 {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">Información
                            sobre reservas.</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    </nav>

    <!-- Flowbite JS -->
    <!-- <script src="https://unpkg.com/flowbite@1.4.1/dist/flowbite.js"></script> -->
