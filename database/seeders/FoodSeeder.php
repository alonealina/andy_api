<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\Store;
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
//        \App\Models\Food::factory(50)->create();

        $faker = Factory::create();
        $storeIds = Store::pluck('id')->toArray();
        foreach ($storeIds as $storeId) {
            for ($i=0; $i<50;$i++) {
                Food::create([
                    'store_id' => $storeId,
                    'name' => $faker->name(),
                    'price' => rand(1,9) * 1000,
                    'description' => $faker->text(),
                ]);
            }
        }
    }
}
