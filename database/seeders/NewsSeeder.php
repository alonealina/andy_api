<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\News;
use App\Models\Store;
use Faker\Factory;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
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
                News::create([
                    'branch_id' => $branchId,
                    'title' => $faker->word(),
                    'content' => $faker->text(),
                ]);
            }
        }
    }
}
