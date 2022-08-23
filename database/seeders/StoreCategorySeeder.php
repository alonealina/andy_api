<?php

namespace Database\Seeders;

use App\Models\StoreCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('store_categories')->truncate();
        DB::table('images')->truncate();
        $arrayName = ['BAR' => 'bar.jpg',
            'LOUNGE' => 'lounge.jpg',
            '居酒屋' => 'izakaya.jpg',
            'CAFE' => 'cafe.jpg',
            '焼肉' => 'yakiniku.jpg',
            '寿司' => 'sushi.jpg',
            '和食' => 'japanesefood.jpg',
            '韓国' => 'koreanfood.jpg',
            '中華' => 'chinesefood.jpg',
            'インド' => 'india.jpg',
            'フレンチ' => 'french.jpg',
            'イタリアン' => 'italian.jpg',
            'スイーツ' => 'sweets.jpg',
            'その他食事' => 'food.jpg',
            'カラオケ' => 'karaoke.jpg'];
        foreach ($arrayName as $key => $value) {
            StoreCategory::create([
                'name' => $key
            ])->images()->create([
                'file_name' => $value
            ]);
        }
    }
}
