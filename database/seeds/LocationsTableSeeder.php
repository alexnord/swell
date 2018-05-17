<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LocationsTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('locations')->delete();

        \DB::table('locations')->insert(array (
            0 =>
            array (
                'id' => 1,
                'active' => 1,
                'title' => 'Point Dume',
                'lat' => 34.001204,
                'long' => -118.806826,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'active' => 1,
                'title' => 'Ventura Point',
                'lat' => 34.273581,
                'long' => -119.302935,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            2 =>
            array (
                'id' => 3,
                'active' => 1,
                'title' => 'Silver Strand',
                'lat' => 34.155537,
                'long' => -119.227043,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
        ));
    }
}
