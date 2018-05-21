<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NoaaStationsTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('noaa_stations')->delete();

        \DB::table('noaa_stations')->insert(array (
            0 =>
            array (
                'id' => 1,
                'noaa_id' => '9410840',
                'title' => 'Santa Monica Municipal Pier',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'noaa_id' => '9410777',
                'title' => 'El Segundo',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            2 =>
            array (
                'id' => 3,
                'noaa_id' => '9411189',
                'title' => 'Ventura',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            3 =>
            array (
                'id' => 4,
                'noaa_id' => '9411270',
                'title' => 'Rincon Island / Mussel Shoals',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
        ));
    }
}





























