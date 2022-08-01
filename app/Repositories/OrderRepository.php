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
     * @return array
     */
    public function getList(): array
    {
        return $this->model->with('account:id,name')
            ->whereHas('account', function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })
            ->whereNotIn('status', [OrderStatus::UNPAID, OrderStatus::HIDDEN])
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
            ->where('status', '<>', OrderStatus::UNPAID)
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
            ->selectRaw('DATE_FORMAT(created_at, "%m/%d") as x_value, SUM(total_amount) as total_amount, count(id) as count')
            ->whereHas('account', function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })
            ->where('status', '<>', OrderStatus::UNPAID)
            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE()) AND MONTH(created_at) = MONTH(CURRENT_DATE())')
            ->groupByRaw('DATE_FORMAT(created_at, "%m/%d")')
            ->get()
            ->toArray();
    }

    /**
     * @return mixed
     */
    public function getTurnoverDetailByMonth()
    {
        return $this->model
            ->selectRaw('DATE_FORMAT(created_at, "%m") as x_value, SUM(total_amount) as total_amount, count(id) as count')
            ->whereHas('account', function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })
            ->where('status', '<>', OrderStatus::UNPAID)
            ->whereRaw('YEAR(created_at) = YEAR(CURRENT_DATE())')
            ->groupByRaw('DATE_FORMAT(created_at, "%m")')
            ->get()
            ->toArray();
    }

    /**
     * @return mixed
     */
    public function getTurnoverDetailByYear()
    {
        return $this->model
            ->selectRaw('DATE_FORMAT(created_at, "%Y") as x_value, SUM(total_amount) as total_amount, count(id) as count')
            ->whereHas('account', function ($query) {
                $query->where('branch_id', Auth::user()->branch_id);
            })
            ->where('status', '<>', OrderStatus::UNPAID)
            ->groupByRaw('DATE_FORMAT(created_at, "%Y")')
            ->get()
            ->toArray();
    }
}
