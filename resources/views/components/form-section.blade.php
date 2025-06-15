@props(['submit'])
@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light' ; @endphp <div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div class="px-4 py-5 bg-white sm:p-6 shadow {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}
                {{ $theme === 'dark' ? 'dark:bg-gray-800' : 'bg-white' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
            <div class="flex items-center justify-end px-4 py-3 bg-gray-50 text-end sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md
                    {{ $theme === 'dark' ? 'dark:bg-gray-700 dark:text-gray-300' : 'bg-gray-50 text-gray-700' }}">
                {{ $actions }}
            </div>
            @endif
        </form>
    </div>
    </div>
