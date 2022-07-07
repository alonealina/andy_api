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
        $faker = \Faker\Factory::create();
        $storeIds = Store::pluck('id')->toArray();
        \App\Models\User::create([
            'store_id' => array_rand($storeIds),
            'role' => UserRole::SUPER_ADMIN,
            'email' => 'superadmin@gmail.com',
            'number_phone' => '0123456789',
            'name' => 'Super Admin',
            'password' => Hash::make('123456789'),
            'remember_token' => Str::random(10),
        ]);

        foreach ($storeIds as $storeId) {
            \App\Models\User::create([
                'store_id' => $storeId,
                'role' => UserRole::ADMIN,
                'email' => 'admin' . $storeId . '@gmail.com',
                'number_phone' => '0' . $faker->numberBetween(11111111, 99999999),
                'name' => 'Admin',
                'password' => Hash::make('123456789'),
                'remember_token' => Str::random(10),
            ]);

            for ($i=1; $i<10; $i++) {
                \App\Models\User::create([
                    'store_id' => $storeId,
                    'role' => UserRole::CUSTOMER,
                    'email' =>'room_' . $storeId . '_' . $i,
                    'number_phone' => '0' . $faker->numberBetween(11111111, 99999999),
                    'name' => 'Room ' . $storeId . ' ' . $i,
                    'password' => Hash::make('123456789'),
                    'remember_token' => Str::random(10),
                ]);
            }
        }
    }
}
