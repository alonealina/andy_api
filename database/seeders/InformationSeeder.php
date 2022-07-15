<?php

namespace Database\Seeders;

use App\Models\Information;
use App\Models\Store;
use Faker\Factory;
use Illuminate\Database\Seeder;

class InformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\Information::factory(50)->create();

        $faker = Factory::create();
        $storeIds = Store::pluck('id')->toArray();

        foreach ($storeIds as $storeId) {
            for ($i=0; $i<50;$i++) {
                Information::create([
                    'store_id' => $storeId,
                    'title' => $faker->word(),
                    'content' => $faker->text(),
                ]);
            }
        }
    }
}
