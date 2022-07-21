<?php

namespace Database\Seeders;

use App\Models\FoodCategory;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodCategory::truncate();
        for ($i = 1; $i <= 10; $i++ ) {
            FoodCategory::create([
                'name' => 'Food category' . ' - ' . $i,
            ]);
        }
    }
}
