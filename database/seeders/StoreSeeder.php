<?php

namespace Database\Seeders;

use App\Enums\PaymentMethod;
use App\Models\Branch;
use App\Models\Store;
use App\Models\StoreCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branchIds = Branch::pluck('id')->toArray();
        $categoriesId = StoreCategory::pluck('id')->toArray();
        $faker = Factory::create();
        foreach ($branchIds as $branchId) {
            for ($i=0; $i<10; $i++) {
                Store::create([
                    'branch_id' => $branchId,
                    'store_category_id' => array_rand($categoriesId),
                    'name' => $faker->company(),
                    'post_code_1' => $faker->numberBetween(1111, 9999),
                    'post_code_2' => $faker->numberBetween(1111, 9999),
                    'address' => $faker->address(),
                    'start_time' => $faker->time('H:i'),
                    'end_time' => $faker->time('H:i'),
                    'payment_method' => array_rand(PaymentMethod::getValues(), rand(1, 4)),
                    'counter_count' => rand(10, 50),
                    'table_count' => rand(10, 50),
                    'room_count' => rand(10, 50),
                    'stand_count' => rand(10, 50),
                    'hotline' => '1900' . rand(11111, 99999),
                    'homepage_url' => $faker->url(),
                ]);
            }

        }
    }
}
