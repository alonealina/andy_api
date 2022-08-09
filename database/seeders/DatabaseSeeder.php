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
        $this->call(BranchSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(MaintenanceSeeder::class);
        $this->call(StoreCategorySeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(SystemInformationSeeder::class);
        $this->call(FoodCategorySeeder::class);
        $this->call(FoodSeeder::class);
        $this->call(DrinkCategorySeeder::class);
        $this->call(DrinkSeeder::class);
        $this->call(InformationSeeder::class);
        $this->call(CastSeeder::class);
        $this->call(NewsSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(OrderDetailSeeder::class);
        $this->call(MaintainHistorySeeder::class);
    }
}
