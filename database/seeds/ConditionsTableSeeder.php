<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ConditionsTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('conditions')->delete();

        \DB::table('conditions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'active' => 1,
                'title' => 'Groomed',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            1 =>
            array (
                'id' => 2,
                'active' => 1,
                'title' => 'Glassy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            3 =>
            array (
                'id' => 3,
                'active' => 1,
                'title' => 'Bumpy',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
            4 =>
            array (
                'id' => 4,
                'active' => 1,
                'title' => 'Blown Out',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ),
        ));
    }
}
