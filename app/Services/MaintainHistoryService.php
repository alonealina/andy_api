<?php

namespace App\Services;

use App\Repositories\MaintainHistoryRepository;

class MaintainHistoryService
{
    /**
     * @var MaintainHistoryRepository
     */
    protected $maintainHistoryRepository;

    /**
     * @param MaintainHistoryRepository $maintainHistoryRepository
     */
    public function __construct(MaintainHistoryRepository $maintainHistoryRepository)
    {
        $this->maintainHistoryRepository = $maintainHistoryRepository;
    }

    /**
     * @return mixed
     */
    public function getMaintainList()
    {
        return $this->maintainHistoryRepository->getMaintainList();
    }
}
