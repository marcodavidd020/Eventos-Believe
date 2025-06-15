<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CountPage;

class HomeController extends Controller
{
    public function index()
    {
        $hour = date('H');
        $theme = ($hour >= 18 || $hour < 6) ? 'dark' : 'light';

        // Obtén el primer registro de CountPage
        $countPages = CountPage::first();

        // Verifica si se encontró el registro
        if (!$countPages) {
            // Maneja el caso cuando no se encuentra el registro
            abort(404, 'CountPage data not found');
        }

        // Crea un array de puntos para la gráfica
        $puntos = [];

        // Añade datos a los puntos desde el registro countPages
        $puntos[] = ['name' => 'Sponsors', 'y' => $countPages->sponsors];
        $puntos[] = ['name' => 'Events', 'y' => $countPages->events];
        $puntos[] = ['name' => 'Event Details', 'y' => $countPages->eventdetails];
        $puntos[] = ['name' => 'Sponsorships', 'y' => $countPages->sponsorships];
        $puntos[] = ['name' => 'Promotions', 'y' => $countPages->promotions];
        $puntos[] = ['name' => 'Providers', 'y' => $countPages->providers];
        $puntos[] = ['name' => 'Bookings', 'y' => $countPages->bookings];
        $puntos[] = ['name' => 'Bookings Users', 'y' => $countPages->{'bookings-users'}];
        $puntos[] = ['name' => 'Services', 'y' => $countPages->services];
        $puntos[] = ['name' => 'Users', 'y' => $countPages->users];
        $puntos[] = ['name' => 'Home', 'y' => $countPages->home];
        $puntos[] = ['name' => 'Stores', 'y' => $countPages->stores];

        // Convierte los puntos a formato JSON
        $data = json_encode($puntos);

        // Retorna la vista con los datos necesarios
        return view('dashboard', compact('theme', 'data'));
    }
}
