<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $storeIds = Store::pluck('id')->toArray();
        \App\Models\User::create([
            'store_id' => array_rand($storeIds),
            'username' => 'super_admin',
            'password' => Hash::make('L63K7B7QxpE7j4n'),
            'role' => UserRole::SUPER_ADMIN,
            'name' => 'Super Admin',
            'remember_token' => Str::random(10),
        ]);
        foreach ($storeIds as $storeId) {
            \App\Models\User::create([
                'store_id' => $storeId,
                'username' => 'admin_store_' . $storeId,
                'password' => Hash::make('TvdaPeQmJ6p7LTj'),
                'role' => UserRole::ADMIN,
                'name' => 'Admin ' . $storeId,
                'remember_token' => Str::random(10),
            ]);
            for ($i=1; $i<10; $i++) {
                \App\Models\User::create([
                    'store_id' => $storeId,
                    'username' =>'store_' . $storeId . '_room_' . $i,
                    'password' => Hash::make('123456789'),
                    'role' => UserRole::CUSTOMER,
                    'name' => 'Store ' . $storeId . ' Room ' . $i,
                    'remember_token' => Str::random(10),
                ]);
            }
        }
    }
}
