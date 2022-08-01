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
        $branch = Branch::all();
        for ($i = 0; $i < 50; $i++) {
            $news = News::create([
                'title' => $faker->word(),
                'content' => $faker->text()
            ]);
            $news->branches()->attach(
                $branch->random(rand(1, $branch->count()))->pluck('id')->toArray()
            );
        }
    }
}
