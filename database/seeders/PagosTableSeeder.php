<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagosTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pagos')->insert([
            [
                'monto' => 200.00,
                'fecha' => '2024-12-11',
                'metodo_pago' => 'Tarjeta de crédito',
                'reserva_id' => 1  // Asegúrate de que este ID exista en la tabla 'reservas'
            ]
        ]);
    }
}

