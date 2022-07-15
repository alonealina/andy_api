<?php

namespace Database\Seeders;

use App\Models\Cast;
use App\Models\Store;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\Cast::factory(100)->create();

        $faker = Factory::create();
        $storeIds = Store::pluck('id')->toArray();

        foreach ($storeIds as $storeId) {
            for ($i=0; $i<50;$i++) {
                Cast::create([
                    'store_id' => $storeId,
                    'name' => $faker->name(),
                    'height' => $faker->randomFloat(2, 150, 170 ),
                    'blood_type' => $faker->numberBetween(1,8),
                    'hobbit' => $faker->word(),
                    'type_person' => $faker->word(),
                    'dream' => $faker->word(),
                    'fetish' => $faker->word(),
                    'slogan' => $faker->word(),
                    'instagram_url' => $faker->url(),
                    'special_skill' => $faker->word(),
                ]);
            }
        }
    }
}
