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
    public function getList()
    {
        return $this->model->belongsToBranch()
            ->when(Auth::user()->role->is(AccountRole::CUSTOMER), function ($query) {
                $query->where('status', InventoryStatus::ON_SALE);
            })
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();
    }
}
