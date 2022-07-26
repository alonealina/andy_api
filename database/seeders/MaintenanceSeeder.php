<?php

namespace Database\Seeders;

use App\Enums\AccountRole;
use App\Enums\MaintainStatus;
use App\Models\Account;
use App\Models\Maintenance;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = Account::where('role', AccountRole::SUPER_ADMIN)->first();
        Maintenance::create([
            'account_id' => $superAdmin->id,
            'maintain_status' => MaintainStatus::ACTIVE
        ]);
    }
}
