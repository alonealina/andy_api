<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Store;
use Faker\Factory;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        \App\Models\Event::factory(50)->create();

        $faker = Factory::create();
        $storeIds = Store::pluck('id')->toArray();

        foreach ($storeIds as $storeId) {
            for ($i=0; $i<50;$i++) {
                Event::create([
                    'store_id' => $storeId,
                    'title' => $faker->text(),
                ]);
            }
        }
    }
}
