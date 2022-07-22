<?php

namespace App\Services;

use App\Enums\OrderDetailStatus;
use App\Enums\TurnoverDetailType;
use App\Models\Order;
use App\Repositories\OrderRepository;

class OrderService
{
    /**
     * @var OrderRepository
     */
    protected $orderRepository;


    /**
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        OrderRepository $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function getList($params): array
    {
        return $this->orderRepository->getList($params);
    }

    /**
     * @return mixed
     */
    public function getHistory()
    {
        return $this->orderRepository->getOderUnpaidByAccount()->orderDetails
            ->load('orderable:id,name')
            ->sortByDesc('created_at')->values()
            ->toArray();
    }

    /**
     * @param $data
     * @param Order $order
     * @return bool
     */
    public function update($data, Order $order): bool
    {
        return $order->update([
            'status' => $data['status'],
            'total_amount' => $order->orderDetails()->where('status', '<>', OrderDetailStatus::PENDING)->sum('amount'),
        ]);
    }

    /**
     * @return array
     */
    public function getTurnoverTotal(): array
    {
        return $this->orderRepository->getTurnoverTotal();
    }

    /**
     * @param $type
     * @return mixed|void
     */
    public function getTurnoverDetail($type)
    {
        if ($type == TurnoverDetailType::DAY)
            return $this->orderRepository->getTurnoverDetailByDay();
        if ($type == TurnoverDetailType::MONTH)
            return $this->orderRepository->getTurnoverDetailByMonth();
        if ($type == TurnoverDetailType::YEAR)
            return $this->orderRepository->getTurnoverDetailByYear();
    }
}
