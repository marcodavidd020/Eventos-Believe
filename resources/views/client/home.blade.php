@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light' ; @endphp <x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl {{ $theme === 'dark' ? 'text-white' : 'text-gray-800' }}">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($events as $event)
                <x-event-card :event="$event" :theme="$theme"/>
            @endforeach
        </div>
    </div>

    </x-app-layout>
