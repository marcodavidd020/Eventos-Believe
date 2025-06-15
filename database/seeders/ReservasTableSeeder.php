<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservasTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('reservas')->insert([
            [
                'codigo' => 'RES12345',
                'fecha' => '2024-12-10',
                'costo_entrada' => 100.00,
                'cantidad' => 2,
                'costo_total' => 200.00,
                'estado' => 'Confirmada',
                'usuario_id' => 1, // Asegúrate de que este ID exista en la tabla 'usuarios'
                'evento_id' => 1  // Asegúrate de que este ID exista en la tabla 'eventos'
            ]
        ]);
    }
}

