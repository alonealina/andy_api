<?php

namespace Database\Seeders;

use App\Models\Drink;
use App\Models\DrinkCategory;
use App\Models\Store;
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
//        \App\Models\Drink::factory(50)->create();

        $faker = Factory::create();
        $storeIds = Store::pluck('id')->toArray();
        $categoriesId = DrinkCategory::where('parent_id','!=',null)->pluck('id')->toArray();

        foreach ($storeIds as $storeId) {
            for ($i=0; $i<50;$i++) {
                Drink::create([
                    'store_id' => $storeId,
                    'drink_category_id' => $categoriesId[array_rand($categoriesId)],
                    'name' => $faker->name(),
                    'price' => rand(1,9) * 1000,
                    'description' => $faker->text(),
                ]);
            }
        }
    }
}
