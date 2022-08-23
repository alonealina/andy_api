<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Information;
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
        Information::truncate();
        $faker = Factory::create();
        $branchIds = Branch::pluck('id')->toArray();

        foreach ($branchIds as $branchId) {
            for ($i=0; $i<50;$i++) {
                Information::create([
                    'branch_id' => $branchId,
                    'title' => $faker->word(),
                    'content' => $faker->text(),
                    'time_event' => $faker->time("Y-m-d H-i-s"),
                ]);
            }
        }
    }
}
