<?php

// routes/web.php

// Ruta de prueba para Vercel
Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Laravel is working on Vercel!',
        'php_version' => PHP_VERSION,
        'laravel_version' => app()->version(),
        'timestamp' => now()
    ]);
});

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventDetailController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ConsumirServicioController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    $hour = date('H');
    $theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light';
    
    try {
        // Obtener eventos con sus promociones activas
        $events = App\Models\Event::with(['promotion' => function($query) {
            $query->where('fecha_inicio', '<=', now())
                  ->where('fecha_fin', '>=', now());
        }])
        ->whereIn('estado', ['Activo', 'Programado'])
        ->orderBy('fecha', 'asc')
        ->limit(6)
        ->get();
        
        // Contar eventos y promociones para las estadísticas
        $eventsCount = App\Models\Event::count();
        $activePromotions = App\Models\Promotion::where('fecha_inicio', '<=', now())
                                              ->where('fecha_fin', '>=', now())
                                              ->count();
    } catch (\Exception $e) {
        // Si hay error de base de datos, usar datos por defecto
        $events = collect([]);
        $eventsCount = 0;
        $activePromotions = 0;
        
        // Log del error para debugging
        \Log::error('Database error in welcome route: ' . $e->getMessage());
    }
    
    return view('welcome', compact('theme', 'events', 'eventsCount', 'activePromotions'));
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'checkrole:Administrador'
])->group(function () {
    /* Route::get('/dashboard', function () {
        $hour = date('H');
        $theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light';
        return view('dashboard', compact('theme'));
    })->name('dashboard'); */
    Route::get('/dashboard', [HomeController::class, 'index'])->name('/dashboard');
    Route::resource('services', ServiceController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('sponsors', SponsorController::class);
    Route::resource('promotions', PromotionController::class);
    Route::resource('eventdetails', EventDetailController::class);
    Route::resource('sponsorships', SponsorshipController::class);
    Route::resource('users', UserController::class);

    Route::get('sponsorspdf', [PDFController::class, 'sponsorspdf'])->name('sponsors.pdf');
    Route::get('sponsorshipspdf', [PDFController::class, 'sponsorshipspdf'])->name('sponsorships.pdf');
    Route::get('servicespdf', [PDFController::class, 'servicespdf'])->name('services.pdf');
    Route::get('eventspdf', [PDFController::class, 'eventspdf'])->name('events.pdf');
    Route::get('eventdetailspdf', [PDFController::class, 'eventdetailspdf'])->name('eventdetails.pdf');
    Route::get('userspdf', [PDFController::class, 'userspdf'])->name('users.pdf');
    Route::get('promotionspdf', [PDFController::class, 'promotionspdf'])->name('promotions.pdf');
    Route::get('supplierspdf', [PDFController::class, 'supplierspdf'])->name('suppliers.pdf');
    Route::get('bookingspdf', [PDFController::class, 'bookingspdf'])->name('bookings.pdf');
});

Route::resource('events', EventController::class);
Route::resource('bookings', BookingController::class);

Route::get('login-client', [ClientController::class, 'login'])->name('login-client');
Route::post('login-client', [ClientController::class, 'authenticate'])->name('login-client.authenticate');
Route::get('register-client', [ClientController::class, 'register'])->name('register-client');
Route::post('register-client', [ClientController::class, 'store'])->name('register-client.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'checkrole:Usuario'
])->group(function () {
    /* Route::resource('home-client', ClientController::class)->only(['index'])->names('dashboard'); */
    Route::get('home-client', [ClientController::class, 'index'])->name('dashboard');
    Route::get('booking-client', [BookingController::class, 'indexClient'])->name('booking-client');

    Route::post('/consumirServicio', [ConsumirServicioController::class, 'RecolectarDatos'])->name('consumirServicio');
    Route::post('/consultar', [ConsumirServicioController::class, 'ConsultarEstado']);
});

Route::put('/update-style', [UserController::class, 'updateStyle'])->name('updateStyle');
