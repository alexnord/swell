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
                'lat' => 34.008333,
                'lng' => -118.500000,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'noaa_id' => '9410777',
                'title' => 'El Segundo',
                'lat' => 33.908333,
                'lng' => -118.433333,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            2 =>
            array (
                'id' => 3,
                'noaa_id' => '9411189',
                'title' => 'Ventura',
                'lat' => 34.266667,
                'lng' => -119.283333,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            3 =>
            array (
                'id' => 4,
                'noaa_id' => '9411270',
                'title' => 'Rincon Island / Mussel Shoals',
                'lat' => 34.348333,
                'lng' => -119.443333,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
        ));
    }
}





























