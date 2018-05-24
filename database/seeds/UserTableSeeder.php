<?php

use App\User;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{

    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        // Add the master administrator, user id of 1
        User::create([
            'name'           => 'Alex Nordlinger',
            'email'          => 'alex.nordlinger@gmail.com',
            'password'       => Hash::make('password'),
            'remember_token' => null,
            'timezone'       => 'America/Los_Angeles',
        ]);
    }
}
