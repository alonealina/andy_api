<?php

namespace App\Repositories;

use App\Enums\InventoryStatus;
use App\Enums\AccountRole;
use App\Models\Food;
use Illuminate\Support\Facades\Auth;

class FoodRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Food::class;

    }

    /**
     * @return mixed
     */
    public function getList($params)
    {
        return $this->model->belongsToBranch()
            ->when(isset($params['food_category_id']), function ($query) use ($params){
                $query->where('food_category_id', $params['food_category_id']);
            })
            ->when(Auth::user()->role->is(AccountRole::CUSTOMER), function ($query) {
                $query->where('status', InventoryStatus::ON_SALE);
            })
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
    }
}
