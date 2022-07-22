<?php

namespace App\Repositories;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Support\Carbon;
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

    /**
     * @return array
     */
    public function getTurnoverTotal(): array
    {
        $data = $this->model
            ->selectRaw('id, DAY(created_at) as day, MONTH(created_at) as month, YEAR(created_at) as year, total_amount')
            ->whereHas('account', function ($query) {
            $query->where('branch_id', Auth::user()->branch_id);
            })
            ->whereStatus(OrderStatus::PAID)
            ->havingRaw('year = ' . Carbon::yesterday()->year);
        $yesterday = $data->get()->where('day', Carbon::yesterday()->day)
            ->where('month', Carbon::yesterday()->month);
        $month = $data->get()->where('month', Carbon::yesterday()->month);
        $year = $data->get();
        return [
            'yesterday_amount' => $yesterday->sum('total_amount'),
            'yesterday_count' => $yesterday->count('id'),
            'month_amount' => $month->sum('total_amount'),
            'month_count' => $month->count('id'),
            'year_amount' => $year->sum('total_amount'),
            'year_count' => $year->count('id')
        ];
    }

    /**
     * @return mixed
     */
    public function getTurnoverDetailByDay()
    {
        return $this->model
            ->selectRaw('count(id) as count, DATE_FORMAT(created_at, "%d/%m") as day, SUM(total_amount) as total_amount')
            ->whereHas('account', function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })
            ->whereStatus(OrderStatus::PAID)
            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at) = MONTH(CURRENT_DATE())')
            ->groupByRaw('DATE_FORMAT(created_at, "%d/%m")')
            ->get()->keyBy('day')
            ->toArray();
    }

    /**
     * @return mixed
     */
    public function getTurnoverDetailByMonth()
    {
        return $this->model
            ->selectRaw('count(id) as count, DATE_FORMAT(created_at, "%m") as month, SUM(total_amount) as total_amount')
            ->whereHas('account', function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })
            ->whereStatus(OrderStatus::PAID)
            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE())')
            ->groupByRaw('DATE_FORMAT(created_at, "%m")')
            ->get()->keyBy('month')
            ->toArray();
    }

    /**
     * @return mixed
     */
    public function getTurnoverDetailByYear()
    {
        return $this->model
            ->selectRaw('count(id) as count, DATE_FORMAT(created_at, "%Y") as year, SUM(total_amount) as total_amount')
            ->whereHas('account', function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })
            ->whereStatus(OrderStatus::PAID)
            ->groupByRaw('DATE_FORMAT(created_at, "%Y")')
            ->get()->keyBy('year')
            ->toArray();
    }
}
