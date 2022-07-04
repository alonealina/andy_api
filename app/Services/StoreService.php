<?php

namespace App\Services;

use App\Repositories\StoreRepository;

class StoreService
{
    /**
     * @var StoreRepository
     */
    protected $storeRepository;

    /**
     * Construct function
     *
     * @param StoreRepository $storeRepository
     */
    public function __construct(StoreRepository $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * Get list store
     *
     * @return array
     */
    public function getList(): array
    {
        return $this->storeRepository->getAll()->toArray();
    }
}
