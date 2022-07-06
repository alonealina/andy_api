<?php

namespace Database\Seeders;

use App\Models\StoreCategory;
use Illuminate\Database\Seeder;

class StoreCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayName = ['BAR', 'LOUNGE', '居酒屋', 'CAFE', '焼肉', '寿司', '和食', '韓国', '中華', 'インド', 'フレンチ',
            'イタリアン', 'スイーツ', 'その他食事', 'カラオケ'];
        foreach ($arrayName as $name) {
            StoreCategory::create([
                'name' => $name
            ]);
        }
    }
}
