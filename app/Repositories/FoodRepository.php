<?php

namespace App\Repositories;

use App\Enums\InventoryStatus;
use App\Enums\UserRole;
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
    public function getList()
    {
        return $this->model->belongsToStore()
            ->when(Auth::user()->role->is(UserRole::CUSTOMER), function ($query) {
                $query->where('status', InventoryStatus::ON_SALE);
            })
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
    }
}
