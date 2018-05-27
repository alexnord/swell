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

                'start_time' => '07:00:00',
                'end_time' => null,

                'location_id' => 1,

                'start_swell_dir' => 'ssw',
                'start_swell_angle' => 195,
                'start_swell_height' => 4.5,
                'start_swell_period' => '18',

                'end_swell_dir' => null,
                'end_swell_angle' => null,
                'end_swell_height' => null,
                'end_swell_period' => null,

                'start_wind_dir' => 'ese',
                'start_wind_angle' => null,
                'start_wind_speed' => 0,

                'end_wind_dir' => null,
                'end_wind_angle' => null,
                'end_wind_speed' => null,

                'tide_dir' => 'Rising',
                'start_tide_height' => 3,
                'end_tide_height' => null,

                'actual_surf_height' => '4-6',
                'condition_id' => 2,
                'score' => 9,
                'notes' => 'Very good conditions, biggest in LA county. Good on lower tide but more consistent even at the top of the high tide.',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'active' => 1,
                'user_id' => 1,
                'date' => '2018-01-21',

                'start_time' => '09:00:00',
                'end_time' => null,

                'location_id' => 3,

                'start_swell_dir' => 'wnw',
                'start_swell_angle' => 295,
                'start_swell_height' => 5.0,
                'start_swell_period' => '13',

                'end_swell_dir' => null,
                'end_swell_angle' => null,
                'end_swell_height' => null,
                'end_swell_period' => null,

                'start_wind_dir' => 'ene',
                'start_wind_angle' => null,
                'start_wind_speed' => 6.0,

                'end_wind_dir' => null,
                'end_wind_angle' => null,
                'end_wind_speed' => null,

                'tide_dir' => 'Rising',
                'start_tide_height' => 3,
                'end_tide_height' => null,

                'actual_surf_height' => '6',
                'condition_id' => 1,
                'score' => 10,
                'notes' => 'Shoulder to overhead waves, barreling',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            2 =>
            array (
                'id' => 3,
                'active' => 1,
                'user_id' => 1,
                'date' => "2017-10-29",

                'start_time' => "08:00:00",
                'end_time' => null,

                'location_id' => 2,

                'start_swell_dir' => 'nw',
                'start_swell_angle' => 300,
                'start_swell_height' => 4,
                'start_swell_period' => "19",

                'end_swell_dir' => null,
                'end_swell_angle' => null,
                'end_swell_height' => null,
                'end_swell_period' => null,

                'start_wind_dir' => 'nw',
                'start_wind_angle' => null,
                'start_wind_speed' => 1,

                'end_wind_dir' => null,
                'end_wind_angle' => null,
                'end_wind_speed' => null,

                'tide_dir' => 'Rising',
                'start_tide_height' => 3,
                'end_tide_height' => null,

                'actual_surf_height' => "5",
                'condition_id' => 2,
                'score' => 8,
                'notes' => 'Steep angle NW, the longer the periods the greater the difference in shoaling. Ventura was big, good on the low tide and improved as it built. LA county was 2-3ft',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            3 =>
            array (
                'id' => 4,
                'active' => 1,
                'user_id' => 1,
                'date' => "2018-05-15",

                'start_time' => "06:00:00",
                'end_time' => null,

                'location_id' => 1,

                'start_swell_dir' => 'sw',
                'start_swell_angle' => 195,
                'start_swell_height' => 2.5,
                'start_swell_period' => "15",

                'end_swell_dir' => null,
                'end_swell_angle' => null,
                'end_swell_height' => null,
                'end_swell_period' => null,

                'start_wind_dir' => 'ese',
                'start_wind_angle' => null,
                'start_wind_speed' => 1,

                'end_wind_dir' => null,
                'end_wind_angle' => null,
                'end_wind_speed' => null,

                'tide_dir' => 'Rising',
                'start_tide_height' => 1.5,
                'end_tide_height' => null,

                'actual_surf_height' => "3-5",
                'condition_id' => 2,
                'score' => 8,
                'notes' => null,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            4 =>
            array (
                'id' => 5,
                'active' => 1,
                'user_id' => 1,
                'date' => "2018-05-22",

                'start_time' => "06:00:00",
                'end_time' => null,

                'location_id' => 1,

                'start_swell_dir' => 'ssw',
                'start_swell_angle' => 195,
                'start_swell_height' => 3.9,
                'start_swell_period' => "20",

                'end_swell_dir' => null,
                'end_swell_angle' => null,
                'end_swell_height' => null,
                'end_swell_period' => null,

                'start_wind_dir' => 'ese',
                'start_wind_angle' => null,
                'start_wind_speed' => 4,

                'end_wind_dir' => null,
                'end_wind_angle' => null,
                'end_wind_speed' => null,

                'tide_dir' => 'Dropping',
                'start_tide_height' => 2,
                'end_tide_height' => null,

                'actual_surf_height' => "3-5 occasional 6",
                'condition_id' => 2,
                'score' => 8,
                'notes' => "Long period heavy and fast sets in the bay. 15-20m between sets. Connected all the way through, steep and fast. Super fun.",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            5 =>
            array (
                'id' => 6,
                'active' => 1,
                'user_id' => 1,
                'date' => "2018-05-23",

                'start_time' => "06:00:00",
                'end_time' => null,

                'location_id' => 1,

                'start_swell_dir' => 'ssw',
                'start_swell_angle' => 200,
                'start_swell_height' => 3.7,
                'start_swell_period' => "17",

                'end_swell_dir' => null,
                'end_swell_angle' => null,
                'end_swell_height' => null,
                'end_swell_period' => null,

                'start_wind_dir' => 'ese',
                'start_wind_angle' => null,
                'start_wind_speed' => 3,

                'end_wind_dir' => null,
                'end_wind_angle' => null,
                'end_wind_speed' => null,

                'tide_dir' => 'Dropping',
                'start_tide_height' => 3.9,
                'end_tide_height' => null,

                'actual_surf_height' => "5-7",
                'condition_id' => 2,
                'score' => 9,
                'notes' => "Big set waves from the bay to the inside. Overhead, glassy sets as good as Dume an get. High tide was better than low.",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            6 =>
            array (
                'id' => 7,
                'active' => 1,
                'user_id' => 1,
                'date' => "2018-05-25",

                'start_time' => "07:00:00",
                'end_time' => null,

                'location_id' => 1,

                'start_swell_dir' => 'ssw',
                'start_swell_angle' => 202,
                'start_swell_height' => 2.95,
                'start_swell_period' => "14",

                'end_swell_dir' => 'ssw',
                'end_swell_angle' => 195,
                'end_swell_height' => 3.28,
                'end_swell_period' => 14,

                'start_wind_dir' => 'wsw',
                'start_wind_angle' => null,
                'start_wind_speed' => 18,

                'end_wind_dir' => 'wsw',
                'end_wind_angle' => null,
                'end_wind_speed' => 18,

                'tide_dir' => 'Rising',
                'start_tide_height' => 1.6,
                'end_tide_height' => 3.1,

                'actual_surf_height' => "2-4",
                'condition_id' => 3,
                'score' => 6,
                'notes' => "The point had playful shoulder high barrels on lower tide. The bay was breaking far down towards Mistos for fun little chest-shoulder high ramps.",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
        ));
    }
}
