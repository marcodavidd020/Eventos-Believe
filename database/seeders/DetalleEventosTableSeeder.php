<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DetalleEventosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('detalle_eventos')->insert([
            [
                'evento_id' => 1, // Asegúrate de que este ID exista en la tabla 'eventos'
                'servicio_id' => 1, // Asegúrate de que este ID exista en la tabla 'servicios'
                'costo_servicio' => 3000.00
            ]
        ]);
    }
}

