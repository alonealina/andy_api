<?php

namespace App\Repositories;

use App\Enums\OrderDetailStatus;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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
             ->get()->sortBy('account.id')->sortBy('created_at')->values()
             ->toArray();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getNewOrder()
    {
        $newOrder = $this->model
            ->with('orderable:id,name')
            ->whereHas('account', function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })
            ->whereNull('read_at');
        $dataReturn = $newOrder->get();
        $newOrder->update([
            'read_at' => now()
        ]);
        return $dataReturn;
    }

    public function getListOrderHistory($params)
    {
        return $this->model
            ->with('order:id,created_at')
            ->with('orderable:id,name')
            ->with('account:name')
            ->when(isset($params['table_number']), function ($query) use ($params) {
                $query->whereHas('account', function ($subQuery) use ($params) {
                    $subQuery->where(function (Builder $q) use ($params) {
                        $q->where('id', $params['table_number']);
                    });
                });
            })
            ->when(isset($params['start_date']), function ($query) use ($params) {
                $query->whereHas('order', function ($subQuery) use ($params) {
                    $subQuery->where(function (Builder $q) use ($params) {
                        $q->where('created_at', '>=', $params['start_date']);
                    });
                });
            })
            ->when(isset($params['end_date']), function ($query) use ($params) {
                $query->whereHas('order', function ($subQuery) use ($params) {
                    $subQuery->where(function (Builder $q) use ($params) {
                        $q->where('created_at', '<=', $params['end_date']);
                    });
                });
            })
            ->paginate(config('constants.per_page'), ['*'], 'page', $params['page']);
    }
}
