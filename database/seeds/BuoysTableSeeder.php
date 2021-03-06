<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BuoysTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('buoys')->delete();

        \DB::table('buoys')->insert(array (
            0 =>
            array (
                'id' => 1,
                'active' => 1,
                'title' => 'Santa Monica Bay',
                'station_id' => '46221',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'active' => 1,
                'title' => 'Anacapa Passage',
                'station_id' => '46217',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            2 =>
            array (
                'id' => 3,
                'active' => 1,
                'title' => 'San Pedro',
                'station_id' => '46222',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            )
        ));
    }
}
