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
        
        factory(App\Setores::class,6)->create();

        factory(App\Fases::class,3)->create();

        factory(App\TipoBusness::class,3)->create();

        
     
    }
}
