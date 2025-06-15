@props(['submit'])
@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light' ; @endphp <div class="md:col-span-1 flex justify-between">
    <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium text-gray-900 {{ $theme === 'dark' ? 'dark:text-gray-200' : '' }}">{{ $title }}

            <p class="mt-1 text-sm text-gray-600 {{ $theme === 'dark' ? 'dark:text-gray-400' : '' }}">
                {{ $description }}
            </p>
    </div>

    <div class="px-4 sm:px-0">
        {{ $aside ?? '' }}
    </div>
    </div>
