<?php

namespace Database\Seeders;

use App\Enums\MaintainRole;
use App\Enums\MaintainStatus;
use App\Models\Branch;
use App\Models\Maintenance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('maintenances')->truncate();
        $branchIds = Branch::pluck('id')->toArray();
        foreach ($branchIds as $branchId) {
            Maintenance::create([
                'branch_id' => $branchId,
                'role' => MaintainRole::ADMIN,
                'maintain_status' => MaintainStatus::ACTIVE
            ]);
            Maintenance::create([
                'branch_id' => $branchId,
                'role' => MaintainRole::USER,
                'maintain_status' => MaintainStatus::ACTIVE
            ]);
        }
    }
}
