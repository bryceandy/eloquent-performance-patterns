<?php

use App\Club;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Club::create(['name' => 'Da Locals Know']);
        Club::create(['name' => 'Freshwater Folk']);
        Club::create(['name' => 'The Nothern Pikes']);
        Club::create(['name' => 'Bass Catchers United']);
    }
}
