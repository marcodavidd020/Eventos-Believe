<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProveedoresTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('proveedores')->insert([
            [
                'nombre' => 'Proveedor de Sonido S.A.',
                'telefono' => '9876543210',
                'email' => 'contacto@sonidos.com',
                'direccion' => 'Calle 123, Ciudad'
            ],
            [
                'nombre' => 'Iluminación Profesional LTDA',
                'telefono' => '1234567890',
                'email' => 'ventas@iluminacionpro.com',
                'direccion' => 'Avenida Principal 456, Ciudad'
            ]
        ]);
    }
}

