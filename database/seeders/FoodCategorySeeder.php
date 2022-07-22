<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\FoodCategory;
use Illuminate\Database\Seeder;

class FoodCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FoodCategory::truncate();
        $branchIds = Branch::pluck('id')->toArray();
        foreach ($branchIds as $branchId) {
            for ($i = 1; $i <= 10; $i++ ) {
                FoodCategory::create([
                    'branch_id' => $branchId,
                    'name' => 'Food category' . ' - ' . $i,
                ]);
            }
        }
    }
}
