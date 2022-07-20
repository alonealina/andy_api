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
        $arrayName = ['シャンパン', 'ワイン', 'ブランデーウイスキー', '焼酎', '日本酒', 'カクテルサワー', 'ソフトドリンク', '割りもの', 'その他'];
        foreach ($arrayName as $name) {
            DrinkCategory::create([
                'name' => $name
            ]);
        }
    }
}
