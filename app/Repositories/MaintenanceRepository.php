<?php

namespace App\Repositories;

use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;

class MaintenanceRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Maintenance::class;
    }

    /**
     * @return mixed
     */
    public function getRecordMaintain()
    {
        $currentUser = Auth::user();
        return $this->model->where([
            'branch_id' => $currentUser->branch_id,
            'role' => $currentUser->maintain_role
        ])->first();
    }
}
