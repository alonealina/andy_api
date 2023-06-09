<?php

namespace App\Repositories;

use App\Enums\AccountRole;
use App\Enums\PositionBackground;
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
        return $this->model->with([
            'backgrounds' => function ($query) {
                $query->select(['branch_id', 'file_name'])->where('position', PositionBackground::TOP1);
            }
        ])->get()->toArray();
    }

    /**
     * @param Branch $branch
     * @return array
     */
    public function show(Branch $branch): array
    {
        return $branch->load([
            'backgrounds' => function ($query) {
                $query->select(['branch_id', 'file_name'])->where('position', PositionBackground::TOP1);
            }
        ])->load([
            'accounts' => function ($query) {
                $query->select(['branch_id', 'password_show'])->where('role', AccountRole::ADMIN);
            }
        ])->toArray();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getMaintain()
    {
        return $this->model->with('maintenances:branch_id,role,maintain_status,message,start_time,end_time')
            ->with([
                'backgrounds' => function ($query) {
                    $query->select(['branch_id', 'file_name'])->where('position', PositionBackground::TOP1);
                }
            ])
            ->select(['id', 'name'])
            ->get()->map(function ($item) {
                $item->maintain = $item->maintenances->keyBy('role')->toArray();
                return $item;
            });
    }
}
