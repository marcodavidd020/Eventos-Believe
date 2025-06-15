<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PatrociniosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('patrocinios')->insert([
            [
                'aporte' => 5000.00,
                'patrocinador_id' => 1, // Asegúrate de que este ID exista en la tabla 'patrocinadores'
                'evento_id' => 1      // Asegúrate de que este ID exista en la tabla 'eventos'
            ]
        ]);
    }
}

