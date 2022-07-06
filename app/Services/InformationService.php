<?php

namespace App\Services;

use App\Repositories\InformationRepository;

class InformationService
{
    /**
     * @var InformationRepository
     */
    protected $informationRepository;

    /**
     * Construct function
     *
     * @param InformationRepository $informationRepository
     */
    public function __construct(InformationRepository $informationRepository)
    {
        $this->informationRepository = $informationRepository;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->informationRepository->getList();
    }
}
