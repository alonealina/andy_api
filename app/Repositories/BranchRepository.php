<?php

namespace App\Repositories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * @return Builder[]|Collection
     */
    public function getMaintain()
    {
        return $this->model->with('maintenances:branch_id,role,maintain_status,message,start_time,end_time')
            ->select(['id', 'name'])
            ->get()->map(function ($item) {
            $item->maintain = $item->maintenances->keyBy('role')->toArray();
            return $item;
        });
    }
}
