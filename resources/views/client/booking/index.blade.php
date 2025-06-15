@php
$hour = date('H');
$theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light' ; $headers=[ 'Id' , 'Evento' , 'Fecha' , ]; $rows=$bookings->map(function($booking){
    return [
    'id' => $booking->id,
    'event' => $booking->evento->nombre,
    'date' => $booking->fecha,
    ];
    });
    @endphp <x-app-layout>

        <x-slot name="header">
            <h2 class="font-semibold text-xl {{ $theme === 'dark' ? 'text-white' : 'text-gray-800' }}">
                {{ __('Reservas') }}
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
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    {{ session('success') }}
                </div>
            </div>
            @endif
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <x-table :headers="$headers" :rows="$rows" :theme="$theme" resource="evento" />
                </div>
            </div>
        </div>


    </x-app-layout>
