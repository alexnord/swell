<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ReportsTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('reports')->delete();

        \DB::table('reports')->insert(array (
            0 =>
            array (
                'id' => 1,
                'active' => 1,
                'user_id' => 1,
                'date' => '2017-10-06',
                'time' => '07:00:00',
                'location_id' => 1,
                'swell_dir_id' => 8,
                'swell_angle' => '195',
                'swell_height' => 4.5,
                'swell_period' => '18',
                'wind_dir_id' => 12,
                'wind_speed' => 0,
                'tide_dir_id' => 1,
                'tide_height' => 3,
                'actual_surf_height' => '4-6',
                'condition_id' => 2,
                'score' => 9,
                'notes' => "Very good conditions, biggest in LA county. Good on lower tide but more consistent even at the top of the high tide.",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
        ));
    }
}
