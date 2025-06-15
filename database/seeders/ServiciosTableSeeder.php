<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiciosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('servicios')->insert([
            [
                'nombre' => 'Catering',
                'descripcion' => 'Servicio de catering para eventos, incluye menú completo',
                'proveedor_id' => 1
            ],
            [
                'nombre' => 'Seguridad',
                'descripcion' => 'Servicio de seguridad para eventos, personal cualificado',
                'proveedor_id' => 2
            ]
        ]);
    }
}

