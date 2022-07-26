<?php

namespace App\Repositories;

use App\Models\Maintenance;

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
    public function getRecordMaintain($superAdminId)
    {
        return $this->model->where('account_id', $superAdminId)->first();
    }
}
