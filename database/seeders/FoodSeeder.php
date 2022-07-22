<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Food;
use App\Models\FoodCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Food::truncate();
        $faker = Factory::create();
        $branchIds = Branch::pluck('id')->toArray();
        foreach ($branchIds as $branchId) {
            $categoriesId = FoodCategory::where('branch_id', $branchId)->pluck('id')->toArray();
            for ($i=0; $i<150;$i++) {
                Food::create([
                    'branch_id' => $branchId,
                    'food_category_id' => $categoriesId[array_rand($categoriesId)],
                    'name' => $faker->name(),
                    'price' => rand(1,9) * 1000,
                    'description' => $faker->text(),
                ]);
            }
        }
    }
}
