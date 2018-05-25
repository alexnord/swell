<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WeatherDataTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('weather_data')->delete();

        \DB::table('weather_data')->insert(array (
            0 =>
            array (
                'id' => 1,
                'timestamp' => '2018-05-23 15:00:00',
                'location_id' => '1',
                'angle' => 270,
                'speed' => 11,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'timestamp' => '2018-05-23 16:00:00',
                'location_id' => '2',
                'angle' => 270,
                'speed' => 11,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            2 =>
            array (
                'id' => 3,
                'timestamp' => '2018-05-23 17:00:00',
                'location_id' => '3',
                'angle' => 270,
                'speed' => 11,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
        ));
    }
}
