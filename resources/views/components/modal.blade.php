@props(['id', 'title', 'theme'])

<div id="{{ $id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow {{ $theme === 'dark' ? 'dark:bg-gray-700' : '' }}">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 border-b rounded-t {{ $theme === 'dark' ? 'dark:border-gray-600' : '' }}">
                <h3 class="text-lg font-semibold text-gray-900 {{ $theme === 'dark' ? 'dark:text-white' : '' }}">
                    {{ $title }}
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center {{ $theme === 'dark' ? 'dark:hover:bg-gray-600 dark:hover:text-white' : '' }}" data-modal-toggle="{{ $id }}">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4">
                {{ $slot }}
            </div>
            <!-- Modal footer -->
            <!-- <div class="flex items-center justify-end p-4 border-t border-gray-200 rounded-b {{ $theme === 'dark' ? 'dark:border-gray-600' : '' }}">
                <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 {{ $theme === 'dark' ? 'dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600' : '' }}" data-modal-toggle="{{ $id }}">
                    Cancelar
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ml-2 {{ $theme === 'dark' ? 'dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800' : '' }}">
                    Guardar
                </button>
            </div> -->
        </div>
    </div>
</div>

