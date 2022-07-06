<?php

namespace Database\Seeders;

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
         \App\Models\Store::factory(10)->create();
         \App\Models\User::factory(10)->create();
        $this->call(FoodSeeder::class);
        $this->call(InformationSeeder::class);
        \App\Models\Drink::factory(10)->create();
        \App\Models\Event::factory(10)->create();
    }
}
