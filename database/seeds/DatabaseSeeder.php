<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LocationsTableSeeder::class);
        $this->call(DirectionsTableSeeder::class);
        $this->call(TidesTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
    }
}
