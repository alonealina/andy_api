<?php

namespace App\Services;

use App\Repositories\AccountRepository;
use App\Repositories\MaintenanceRepository;

class MaintenanceService
{
    /**
     * @var MaintenanceRepository
     */
    protected $maintenanceRepository;

    /**
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * @param MaintenanceRepository $maintenanceRepository
     * @param AccountRepository $accountRepository
     */
    public function __construct(
        MaintenanceRepository $maintenanceRepository,
        AccountRepository $accountRepository
    ) {
        $this->maintenanceRepository = $maintenanceRepository;
        $this->accountRepository = $accountRepository;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function setMaintain($data)
    {
        return $this->maintenanceRepository
            ->getRecordMaintain($this->accountRepository->getSuperAdmin()->id)->update($data);
    }

    /**
     * @return mixed
     */
    public function getMaintainStatus()
    {
        return $this->maintenanceRepository
            ->getRecordMaintain($this->accountRepository->getSuperAdmin()->id);
    }
}
