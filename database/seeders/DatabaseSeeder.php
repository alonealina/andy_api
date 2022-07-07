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
        $this->call(StoreCategorySeeder::class);
         \App\Models\Store::factory(10)->create();
        $this->call(UserSeeder::class);
        $this->call(FoodSeeder::class);
        $this->call(InformationSeeder::class);
        \App\Models\Drink::factory(100)->create();
        \App\Models\Event::factory(100)->create();
    }
}
