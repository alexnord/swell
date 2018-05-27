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
        $this->call(UserTableSeeder::class);
        $this->call(NoaaStationsTableSeeder::class);
        $this->call(BuoysTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
        $this->call(ReportsTableSeeder::class);
        $this->call(TideDataTableSeeder::class);
        $this->call(BuoyDataTableSeeder::class);
        $this->call(WeatherDataTableSeeder::class);
    }
}
