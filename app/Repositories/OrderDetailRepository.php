<?php

namespace App\Repositories;

use App\Enums\OrderDetailStatus;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class OrderDetailRepository extends BaseRepository
{
    /**
     * @return mixed
     */
    public function model()
    {
        return OrderDetail::class;
    }

    /**
     * @return mixed
     */
    public function getOrderPending()
    {
         return Auth::user()->store->orderDetails()
             ->where('status', OrderDetailStatus::PENDING)
             ->with('orderable:id,name,price')
             ->get()->toArray();
    }
}
