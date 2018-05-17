<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TidesTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('tides')->delete();

        \DB::table('tides')->insert(array (
            0 =>
            array (
                'id' => 1,
                'active' => 1,
                'title' => 'Incoming',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'active' => 1,
                'title' => 'Outgoing',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
        ));
    }
}
