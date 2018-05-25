<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BuoyDataTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('buoy_data')->delete();

        \DB::table('buoy_data')->insert(array (
            0 =>
            array (
                'id' => 1,
                'timestamp' => '2018-05-23 15:30:00',
                'buoy_id' => '1',
                'wave_height' => '2.95',
                'dominant_period' => 14,
                'average_period' => 6.60,
                'angle' => 186,
                'water_temp' => 59.18,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'timestamp' => '2018-05-23 14:30:00',
                'buoy_id' => '1',
                'wave_height' => '3.28',
                'dominant_period' => 4,
                'average_period' => 6.20,
                'angle' => 193,
                'water_temp' => 59.18,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
        ));
    }
}
