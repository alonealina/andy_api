<?php

namespace App\Repositories;

use App\Models\Branch;

class BranchRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Branch::class;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model->orderBy('created_at', 'DESC')
            ->get()->toArray();
    }
}
