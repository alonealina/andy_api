<?php

namespace App\Services;

use App\Repositories\BranchRepository;
use App\Traits\SaveImagesUpload;

class BranchService
{
    use SaveImagesUpload;

    protected $branchRepository;

    /**
     * Construct function
     *
     * @param BranchRepository $branchRepository
     */
    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    /**
     * Get all branches
     *
     * @return array
     */
    public function getList(): array
    {
        return $this->branchRepository->getAll()->toArray();
    }

}
