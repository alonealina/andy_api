<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function model()
    {
        return Order::class;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->model->whereHas('account', function ($query) {
            $query->where('branch_id', Auth::user()->branch_id);
        })->get()->toArray();
    }
}
