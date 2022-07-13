<?php

namespace Database\Seeders;

use App\Models\DrinkCategory;
use Illuminate\Database\Seeder;

class DrinkCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayName = ['ウイスキー ブランデー', '焼酎', 'ワイン', 'シャンパン', 'レコメンド'];
        foreach ($arrayName as $name) {
            $drinkCategory = DrinkCategory::create([
                'name' => $name
            ]);
            for ($i=1; $i <= 3; $i++) {
                DrinkCategory::create([
                    'name' => $name . ' - ' . $i,
                    'parent_id' => $drinkCategory->id
                ]);
            }
        }
    }
}
