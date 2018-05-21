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
                'noaa_station_id' => 1,
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
                'noaa_station_id' => 3,
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
                'noaa_station_id' => 3,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            3 =>
            array (
                'id' => 4,
                'active' => 1,
                'title' => 'Mistos',
                'lat' => 34.006696,
                'long' => -118.793766,
                'noaa_station_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            4 =>
            array (
                'id' => 5,
                'active' => 1,
                'title' => 'Malibu - 3rd Point',
                'lat' => 34.036096,
                'long' => -118.677467,
                'noaa_station_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            5 =>
            array (
                'id' => 6,
                'active' => 1,
                'title' => 'Malibu - 2nd Point',
                'lat' => 34.036096,
                'long' => -118.677467,
                'noaa_station_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            6 =>
            array (
                'id' => 7,
                'active' => 1,
                'title' => 'Malibu - 1st Point',
                'lat' => 34.036096,
                'long' => -118.677467,
                'noaa_station_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            7 =>
            array (
                'id' => 8,
                'active' => 1,
                'title' => 'Zuma',
                'lat' => 34.014158,
                'long' => -118.822531,
                'noaa_station_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            8 =>
            array (
                'id' => 9,
                'active' => 1,
                'title' => 'El Porto',
                'lat' => 33.903275,
                'long' => -118.423502,
                'noaa_station_id' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            9 =>
            array (
                'id' => 10,
                'active' => 1,
                'title' => 'Venice Breakwater',
                'lat' => 33.984722,
                'long' => -118.475104,
                'noaa_station_id' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            10 =>
            array (
                'id' => 11,
                'active' => 1,
                'title' => 'Venice Pier - Southside',
                'lat' => 33.978074,
                'long' => -118.468606,
                'noaa_station_id' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            11 =>
            array (
                'id' => 12,
                'active' => 1,
                'title' => 'Venice Pier - Northside',
                'lat' => 33.978074,
                'long' => -118.468606,
                'noaa_station_id' => 2,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            12 =>
            array (
                'id' => 13,
                'active' => 1,
                'title' => 'Topanga',
                'lat' => 34.037270,
                'long' => -118.582449,
                'noaa_station_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            13 =>
            array (
                'id' => 14,
                'active' => 1,
                'title' => 'Mussel Shoals',
                'lat' => 34.355055,
                'long' => -119.442271,
                'noaa_station_id' => 4,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
            14 =>
            array (
                'id' => 15,
                'active' => 1,
                'title' => 'Rincon',
                'lat' => 34.372101,
                'long' => -119.477926,
                'noaa_station_id' => 4,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
           ),
        ));
    }
}





























