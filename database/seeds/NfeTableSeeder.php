<?php

use Illuminate\Database\Seeder;

class NfeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Nfe', 10)->create();
    }
}
