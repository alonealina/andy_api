<?php

namespace Database\Seeders;

use App\Enums\AccountRole;
use App\Enums\OrderStatus;
use App\Models\Account;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accountIds = Account::where('role', AccountRole::CUSTOMER)->pluck('id')->toArray();
        foreach ($accountIds as $accountId) {
            Order::create([
                'account_id' => $accountId,
                'total_amount' => 0,
                'status' => OrderStatus::UNPAID
            ]);
        }
    }
}
