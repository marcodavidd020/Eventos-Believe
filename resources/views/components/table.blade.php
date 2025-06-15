@props(['headers', 'rows', 'theme', 'resource'])

<div
    class="relative overflow-x-auto shadow-md sm:rounded-lg {{ $theme === 'dark' ? 'dark:bg-gray-900 dark:border-gray-700' : 'bg-white' }}">
    <div class="bg-white p-3 {{ $theme === 'dark' ? 'dark:bg-gray-900' : '' }}">
        <label for="table-search" class="sr-only">Buscar</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 {{ $theme === 'dark' ? 'text-gray-400' : '' }}" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" id="table-search"
                class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 {{ $theme === 'dark' ? 'dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500' : '' }}"
                placeholder="Buscar {{ $resource }}">
        </div>
    </div>
    <table id="resource-table"
        class="w-full text-sm text-left rtl:text-right text-gray-500 {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">
        <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 {{ $theme === 'dark' ? 'dark:bg-gray-700 dark:text-gray-400' : '' }}">
            <tr>
                @foreach ($headers as $header)
                <th scope="col" class="px-6 py-3">
                    {{ $header }}
                </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
            <tr
                class="table-row bg-white border-b {{ $theme === 'dark' ? 'dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600' : 'hover:bg-gray-50' }}">
                @foreach ($row as $key => $value)
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap {{ $theme === 'dark' ? 'dark:text-white' : '' }}">
                    @if ($key === 'imagen')
                    <img src="{{ $value }}" alt="{{ $row['nombre'] }}" class="w-30 h-30">
                    @endif
                    @if ($key === 'acciones')
                    <button data-modal-target="editModal" data-modal-toggle="editModal" data-id="{{ $row['id'] }}"
                        class="text-blue-600 hover:text-blue-900" data-row="{{ json_encode($row) }}">
                        <svg class="w-6 h-6 text-gray-800 {{ $theme === 'dark' ? 'dark:text-white' : '' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button data-modal-target="deleteModal" data-modal-toggle="deleteModal" data-id="{{ $row['id'] }}"
                        class="text-red-600 hover:text-red-900">
                        <svg class="w-6 h-6 text-gray-800 {{ $theme === 'dark' ? 'dark:text-white' : '' }}"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    @else
                    {{ $value }}
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('table-search');
        const tableRows = document.querySelectorAll('#resource-table .table-row');

        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();
            tableRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let rowContainsTerm = false;
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchTerm)) {
                        rowContainsTerm = true;
                    }
                });
                if (rowContainsTerm) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
