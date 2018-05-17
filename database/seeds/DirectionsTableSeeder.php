<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DirectionsTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('directions')->delete();

        \DB::table('directions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'active' => 1,
                'title' => 'N',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'active' => 1,
                'title' => 'NNW',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            2 =>
            array (
                'id' => 3,
                'active' => 1,
                'title' => 'NW',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            3 =>
            array (
                'id' => 4,
                'active' => 1,
                'title' => 'WNW',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            4 =>
            array (
                'id' => 5,
                'active' => 1,
                'title' => 'W',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            5 =>
            array (
                'id' => 6,
                'active' => 1,
                'title' => 'WSW',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            6 =>
            array (
                'id' => 7,
                'active' => 1,
                'title' => 'SW',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            7 =>
            array (
                'id' => 8,
                'active' => 1,
                'title' => 'SSW',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            8 =>
            array (
                'id' => 9,
                'active' => 1,
                'title' => 'S',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            9 =>
            array (
                'id' => 10,
                'active' => 1,
                'title' => 'SSE',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            10 =>
            array (
                'id' => 11,
                'active' => 1,
                'title' => 'SE',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            11 =>
            array (
                'id' => 12,
                'active' => 1,
                'title' => 'ESE',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            12 =>
            array (
                'id' => 13,
                'active' => 1,
                'title' => 'E',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            13 =>
            array (
                'id' => 14,
                'active' => 1,
                'title' => 'ENE',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            14 =>
            array (
                'id' => 15,
                'active' => 1,
                'title' => 'NE',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            15 =>
            array (
                'id' => 16,
                'active' => 1,
                'title' => 'NNE',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
        ));
    }
}
