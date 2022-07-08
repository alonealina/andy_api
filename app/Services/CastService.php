<?php

namespace App\Services;

use App\Repositories\CastRepository;

class CastService
{
    /**
     * @var CastRepository
     */
    protected $castRepository;

    /**
     * @param CastRepository $castRepository
     */
    public function __construct(CastRepository $castRepository)
    {
        $this->castRepository = $castRepository;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->castRepository->getList();
    }
}
