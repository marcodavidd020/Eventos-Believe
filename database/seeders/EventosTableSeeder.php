<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('eventos')->insert([
            [
                'nombre' => 'Concierto de Rock',
                'descripcion' => 'Concierto de bandas locales',
                'capacidad' => 500,
                'precio_entrada' => 150.50,
                'fecha' => '2024-12-05',
                'hora' => '20:00:00',
                'ubicacion' => 'Auditorio ciudad',
                'estado' => 'Programado',
                'imagen' => 'https://res.cloudinary.com/dg2ugi96k/image/upload/v1721191106/php4113_ocscpp.jpg',
            ]
        ]);
    }
}

