<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromocionesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('promociones')->insert([
            [
                'descripcion' => '20% de descuento en eventos de música',
                'descuento' => 20,
                'fecha_inicio' => '2024-01-01',
                'fecha_fin' => '2024-06-30',
                'evento_id' => 1  // Asegúrate de que este ID exista en la tabla 'proveedores'
            ]
        ]);
    }
}

