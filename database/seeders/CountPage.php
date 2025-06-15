<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountPage extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('count_pages')->insert([
            [
                'sponsors' => 0,
                'events' => 0,
                'eventdetails' => 0,
                'sponsorships' => 0,
                'promotions' => 0,
                'providers' => 0,
                'bookings' => 0,
                'bookings-users' => 0,
                'services' => 0,
                'users' => 0,
                'home' => 0,
                'stores' => 0
            ]
        ]);
    }
}
