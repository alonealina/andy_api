<?php

namespace App\Repositories;

use App\Enums\AccountRole;
use App\Enums\InventoryStatus;
use App\Models\DrinkCategory;
use Illuminate\Support\Facades\Auth;

class DrinkCategoryRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return DrinkCategory::class;
    }

    /**
     * @return array
     */
    public function getListParent()
    {
        return $this->model->belongsToBranch()->where('parent_id', null)->get()->toArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAllDrinkOfBranch($id)
    {
        $drink = $this->find($id);
        if ($drink->isParent()) {
            $dataReturn = $drink->childs()->with(['drinks' => function ($query) {
                $query->belongsToBranch()->when(Auth::user()->role->is(AccountRole::CUSTOMER), function ($query) {
                    $query->where('status', InventoryStatus::ON_SALE);
                });
            }])->get();
        } else {
            $dataReturn = $drink->load(['drinks' => function ($query) {
                $query->belongsToBranch()->when(Auth::user()->role->is(AccountRole::CUSTOMER), function ($query) {
                    $query->where('status', InventoryStatus::ON_SALE);
                });
            }]);
        }
        return $dataReturn;
    }
}
