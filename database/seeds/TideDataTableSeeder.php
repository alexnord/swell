<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TideDataTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('tide_data')->delete();

        \DB::table('tide_data')->insert(array (
            0 =>
            array (
                'id' => 1,
                'timestamp' => '2018-05-23 02:13:00',
                'type' => 'H',
                'height' => '5.27',
                'noaa_station_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'timestamp' => '2018-05-23 08:42:00',
                'type' => 'L',
                'height' => '0.66',
                'noaa_station_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            2 =>
            array (
                'id' => 3,
                'timestamp' => '2018-05-23 14:30:00',
                'type' => 'H',
                'height' => '4.01',
                'noaa_station_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            3 =>
            array (
                'id' => 4,
                'timestamp' => '2018-05-23 20:19:00',
                'type' => 'L',
                'height' => '0.67',
                'noaa_station_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
        ));
    }
}
