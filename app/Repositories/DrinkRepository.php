<?php

namespace App\Repositories;

use App\Enums\InventoryStatus;
use App\Enums\AccountRole;
use App\Models\Drink;
use Illuminate\Support\Facades\Auth;

class DrinkRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Drink::class;
    }

    /**
     * @return mixed
     */
    public function getList($params)
    {
        $dataReturn = $this->model->belongsToBranch()
            ->when(Auth::user()->role->is(AccountRole::CUSTOMER), function ($query) {
                $query->where('status', InventoryStatus::ON_SALE);
            })
            ->when(isset($params['drink_category_id']), function ($query) use ($params){
                $query->where('drink_category_id', $params['drink_category_id']);
            })
            ->orderBy('created_at', 'DESC')
            ->get();
        return Auth::user()->role->is(AccountRole::CUSTOMER) ? $dataReturn->toArray() :
            $dataReturn->groupBy('category_child')->toArray();
    }
}
