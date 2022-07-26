<?php

namespace App\Services;

use App\Repositories\MaintenanceRepository;

class MaintenanceService
{
    /**
     * @var MaintenanceRepository
     */
    protected $maintenanceRepository;

    /**
     * @param MaintenanceRepository $maintenanceRepository
     */
    public function __construct(MaintenanceRepository $maintenanceRepository)
    {
        $this->maintenanceRepository = $maintenanceRepository;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function setMaintain($data)
    {
        return $this->maintenanceRepository
            ->getRecordMaintain()->update($data);
    }

    /**
     * @return mixed
     */
    public function getMaintainStatus()
    {
        return $this->maintenanceRepository->getRecordMaintain();
    }
}
