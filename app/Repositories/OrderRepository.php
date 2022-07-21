<?php

namespace App\Repositories;

use App\Enums\OrderStatus;
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
     * @param $params
     * @return array
     */
    public function getList($params): array
    {
        return $this->model->with('account:id,name')
            ->whereHas('account', function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })
            ->when(isset($params['status']), function ($query) use ($params) {
                $query->whereStatus($params['status']);
            })
            ->get()->toArray();
    }

    /**
     * @return mixed
     */
    public function getOderUnpaidByAccount()
    {
        return $this->model->firstOrCreate([
            'account_id' => Auth::user()->id,
            'status' => OrderStatus::UNPAID
        ]);
    }
}
