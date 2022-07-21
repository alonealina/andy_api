<?php

namespace App\Services;

use App\Repositories\SystemInformationRepository;

class SystemInformationService
{
    /**
     * @var SystemInformationRepository
     */
    protected $systemInformationRepository;

    /**
     * @param SystemInformationRepository $systemInformationRepository
     */
    public function __construct(SystemInformationRepository $systemInformationRepository)
    {
        $this->systemInformationRepository = $systemInformationRepository;
    }

    /**
     * @return mixed
     */
    public function getSystemInformation()
    {
        return $this->systemInformationRepository->getSystemInformation()->toArray();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function updateSystemInformation($data)
    {
        $systemInfo = $this->systemInformationRepository->getSystemInformation();
        $systemInfo->update($data);
        return $systemInfo;
    }
}
