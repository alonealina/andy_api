<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Event;
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
        $faker = Factory::create();
        $branchIds = Branch::pluck('id')->toArray();

        foreach ($branchIds as $branchId) {
            for ($i=0; $i<50;$i++) {
                Event::create([
                    'branch_id' => $branchId,
                    'title' => $faker->text(),
                ]);
            }
        }
    }
}
