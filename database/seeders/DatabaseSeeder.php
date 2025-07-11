<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UsuariosTableSeeder::class,
            ProveedoresTableSeeder::class,
            EventosTableSeeder::class,
            PromocionesTableSeeder::class,
            ServiciosTableSeeder::class,
            ReservasTableSeeder::class,
            PagosTableSeeder::class,
            PatrocinadoresTableSeeder::class,
            PatrociniosTableSeeder::class,
            DetalleEventosTableSeeder::class,
            CountPage::class
        ]);
    }
}
