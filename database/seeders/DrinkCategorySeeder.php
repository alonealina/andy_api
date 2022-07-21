<?php

namespace Database\Seeders;

use App\Models\Branch;
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
        DrinkCategory::truncate();
        $branchIds = Branch::pluck('id')->toArray();
        $arrayName = ['シャンパン', 'ワイン', 'ブランデーウイスキー', '焼酎', '日本酒', 'カクテルサワー', 'ソフトドリンク', '割りもの', 'その他'];
        foreach ($branchIds as $branchId) {
            foreach ($arrayName as $name) {
                $drinkCategory = DrinkCategory::create([
                    'branch_id' => $branchId,
                    'name' => $name
                ]);
                for ($i=1; $i <= 3; $i++) {
                    DrinkCategory::create([
                        'branch_id' => $drinkCategory->branch_id,
                        'name' => $name . ' - ' . $i,
                        'parent_id' => $drinkCategory->id
                    ]);
                }
            }
        }
    }
}
