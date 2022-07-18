<?php

namespace Database\Seeders;

use App\Enums\AccountRole;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branchIds = Branch::pluck('id')->toArray();
        \App\Models\Account::create([
            'branch_id' => 1,
            'username' => 'super_admin',
            'password' => Hash::make('L63K7B7QxpE7j4n'),
            'role' => AccountRole::SUPER_ADMIN,
            'name' => 'Super Admin',
            'remember_token' => Str::random(10),
        ]);
        foreach ($branchIds as $branchId) {
            \App\Models\Account::create([
                'branch_id' => $branchId,
                'username' => 'admin_branch_' . $branchId,
                'password' => Hash::make('TvdaPeQmJ6p7LTj'),
                'role' => AccountRole::ADMIN,
                'name' => 'Admin ' . $branchId,
                'remember_token' => Str::random(10),
            ]);
            for ($i=1; $i<10; $i++) {
                \App\Models\Account::create([
                    'branch_id' => $branchId,
                    'username' =>'branch_' . $branchId . '_room_' . $i,
                    'password' => Hash::make('123456789'),
                    'role' => AccountRole::CUSTOMER,
                    'name' => 'Branch ' . $branchId . ' Room ' . $i,
                    'remember_token' => Str::random(10),
                ]);
            }
        }
    }
}
