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
     * @return array
     */
    public function getOrderPending(): array
    {
         return $this->model->with(['account:accounts.id,name', 'orderable:id,name'])
             ->whereHas('account', function ($query) {
                 $query->where('branch_id', Auth::user()->branch_id);
             })
             ->whereIn('status', [OrderDetailStatus::PENDING, OrderDetailStatus::DONE, OrderDetailStatus::CLOSE])
             ->get()->sortBy('account.id')->values()
             ->toArray();
    }
}
