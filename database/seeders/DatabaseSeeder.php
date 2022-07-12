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
        $this->call(StoreSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FoodSeeder::class);
        $this->call(InformationSeeder::class);
        $this->call(CastSeeder::class);
        $this->call(DrinkSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(OrderDetailSeeder::class);
    }
}
