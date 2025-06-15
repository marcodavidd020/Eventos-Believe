<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatrocinadoresTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('patrocinadores')->insert([
            [
                'nombre' => 'Empresa de Bebidas XYZ',
                'descripcion' => 'Principal proveedor de bebidas en eventos',
                'email' => 'info@xyzbebidas.com',
                'telefono' => '9876543210'
            ]
        ]);
    }
}

