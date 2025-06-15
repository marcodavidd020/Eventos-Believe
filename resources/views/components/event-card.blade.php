@props(['event', 'theme' => 'light'])

<div class="event-card relative overflow-hidden rounded-2xl shadow-lg transition-all duration-300 hover:transform hover:-translate-y-2 hover:shadow-2xl {{ $theme === 'dark' ? 'bg-gray-800 border border-gray-700' : 'bg-white border border-gray-200' }}">
    
    @if($event->hasActivePromotion())
        <div class="promotion-badge absolute top-4 right-4 z-10">
            <div class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">
                -{{ $event->promotion->descuento }}% OFF
            </div>
        </div>
    @endif
    
    <!-- Image Section -->
    <div class="relative overflow-hidden">
        <img class="w-full h-48 object-cover transition-transform duration-300 hover:scale-110" 
             src="{{ $event->imagen ?? 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80' }}" 
             alt="{{ $event->nombre }}" 
             loading="lazy" />
        
        <!-- Date Badge -->
        <div class="absolute top-4 left-4">
            <div class="bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                {{ \Carbon\Carbon::parse($event->fecha)->format('d M') }}
            </div>
        </div>
        
        <!-- Status Badge -->
        <div class="absolute bottom-4 left-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                {{ $event->estado === 'Activo' ? 'bg-green-100 text-green-800' : 
                   ($event->estado === 'Programado' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                <svg class="w-2 h-2 mr-1" fill="currentColor" viewBox="0 0 8 8">
                    <circle cx="4" cy="4" r="3"/>
                </svg>
                {{ $event->estado }}
            </span>
        </div>
    </div>
    
    <!-- Content Section -->
    <div class="p-6">
        <!-- Title -->
        <h3 class="text-xl font-bold mb-2 line-clamp-1 {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
            {{ $event->nombre }}
        </h3>
        
        <!-- Description -->
        <p class="text-sm {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }} mb-4 line-clamp-2">
            {{ $event->descripcion }}
        </p>
        
        <!-- Event Details -->
        <div class="space-y-2 mb-4">
            <div class="flex items-center text-sm {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }}">
                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ \Carbon\Carbon::parse($event->fecha)->format('d/m/Y') }} - {{ $event->hora }}
            </div>
            
            <div class="flex items-center text-sm {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }}">
                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ $event->ubicacion }}
            </div>
            
            <div class="flex items-center text-sm {{ $theme === 'dark' ? 'text-gray-300' : 'text-gray-600' }}">
                <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                {{ $event->capacidad }} asistentes
            </div>
        </div>
        
        <!-- Price and Action Section -->
        <div class="flex items-center justify-between pt-4 border-t {{ $theme === 'dark' ? 'border-gray-700' : 'border-gray-200' }}">
            <!-- Price Display -->
            <div class="price-display">
                @if($event->hasActivePromotion())
                    <div class="flex flex-col">
                        <span class="text-sm line-through {{ $theme === 'dark' ? 'text-gray-400' : 'text-gray-500' }}">
                            ${{ number_format($event->precio_entrada, 2) }}
                        </span>
                        <span class="text-xl font-bold text-green-600">
                            ${{ number_format($event->discounted_price, 2) }}
                        </span>
                    </div>
                @else
                    <span class="text-2xl font-bold {{ $theme === 'dark' ? 'text-white' : 'text-gray-900' }}">
                        ${{ number_format($event->precio_entrada, 2) }}
                    </span>
                @endif
            </div>
            
            <!-- Action Button -->
            <a href="{{ route('events.show', $event->id) }}" 
               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg hover:from-blue-700 hover:to-purple-700 focus:ring-4 focus:outline-none focus:ring-blue-300 transition-all duration-200 transform hover:scale-105 {{ $theme === 'dark' ? 'focus:ring-blue-800' : '' }}">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Ver Detalles
            </a>
        </div>
        
        <!-- Promotion Details -->
        @if($event->hasActivePromotion())
            <div class="mt-3 p-3 bg-gradient-to-r from-red-50 to-pink-50 {{ $theme === 'dark' ? 'from-red-900/20 to-pink-900/20' : '' }} rounded-lg">
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium {{ $theme === 'dark' ? 'text-red-400' : 'text-red-700' }}">
                        {{ $event->promotion->descripcion }}
                    </span>
                </div>
                <div class="text-xs {{ $theme === 'dark' ? 'text-red-300' : 'text-red-600' }} mt-1">
                    Válido hasta: {{ \Carbon\Carbon::parse($event->promotion->fecha_fin)->format('d/m/Y') }}
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .event-card:hover {
        transform: translateY(-8px);
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }
</style>
