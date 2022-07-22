<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Drink;
use App\Models\DrinkCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DrinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Drink::truncate();
        $faker = Factory::create();
        $branchIds = Branch::pluck('id')->toArray();

        foreach ($branchIds as $branchId) {
            $categoriesId = DrinkCategory::where('branch_id', $branchId)->where('parent_id','!=',null)->pluck('id')->toArray();
            for ($i=0; $i<150;$i++) {
                Drink::create([
                    'branch_id' => $branchId,
                    'drink_category_id' => $categoriesId[array_rand($categoriesId)],
                    'name' => $faker->name(),
                    'price' => rand(1,9) * 1000,
                    'description' => $faker->text(),
                ]);
            }
        }
    }
}
