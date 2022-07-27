<?php

namespace Database\Seeders;

use App\Enums\AccountRole;
use App\Enums\OrderStatus;
use App\Models\Account;
use App\Models\Order;
use Illuminate\Database\Seeder;

class OrderTurnoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Order::factory(100000)->create();
    }
}
