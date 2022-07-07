<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\SystemInformation;
use Illuminate\Database\Seeder;

class SystemInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeIds = Store::pluck('id')->toArray();
        foreach ($storeIds as $storeId) {
            SystemInformation::create([
                'store_id' => $storeId,
                'pm_last' => [
                    'price' => 8800,
                    'minute' => 60,
                ],
                'companion_fee' => [
                    'price' => 5500
                ],
                'nomination_fee' => [
                    'price' => 3300
                ],
                'extension_fee' => [
                    'first' => [
                        'price' => 4950,
                        'minute' => 30
                    ],
                    'second' => [
                        'price' => 8800,
                        'minute' => 60
                    ]
                ],
                'vip_fee' => [
                    'price' => 22000,
                    'set' => 1
                ],
                'shochu_fee' => [
                    'price' => 1100,
                    'set' => 1,
                    'people' => 1,
                ],
                'brandy_fee'=> [
                    'price' => 1100,
                    'set' => 1,
                    'people' => 1,
                ],
                'whisky_fee'=> [
                    'price' => 1100,
                    'set' => 1,
                    'people' => 1,
                ],
            ]);
        }
    }
}
