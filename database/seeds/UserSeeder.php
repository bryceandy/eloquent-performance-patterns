<?php

use App\Trip;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 2000)->create(); // Create 2000 random users

        User::find(1)->buddies()->sync([2, 3, 4, 5, 6, 7]); // Attach 6 buddies to the first user

        // For every user, attach 250 trips. 500,000 trip records to be generated
        User::all()->each(fn ($user) => $user->trips()->saveMany(factory(Trip::class, 250)->make()));
    }
}
