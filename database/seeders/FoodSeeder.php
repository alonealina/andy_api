<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Food;
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
        $faker = Factory::create();
        $branchIds = Branch::pluck('id')->toArray();
        foreach ($branchIds as $branchId) {
            for ($i=0; $i<50;$i++) {
                Food::create([
                    'branch_id' => $branchId,
                    'name' => $faker->name(),
                    'price' => rand(1,9) * 1000,
                    'description' => $faker->text(),
                ]);
            }
        }
    }
}
