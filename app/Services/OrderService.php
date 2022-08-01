<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Enums\OrderDetailStatus;
use App\Enums\OrderStatus;
use App\Enums\TurnoverDetailType;
use App\Events\CreateNotification;
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
     * @return array
     */
    public function getList(): array
    {
        return $this->orderRepository->getList();
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
        try {
            $order->status = $data['status'];
            if ($data['status'] == OrderStatus::CALL_PAID || $data['status'] == OrderStatus::PAID) {
                $order->total_amount = $order->orderDetails()
                    ->where('status', '<>', OrderDetailStatus::PENDING)
                    ->sum('amount');
            }
            $order->save();
            if ($data['status'] == OrderStatus::CALL_PAID)
                event(new CreateNotification(NotificationType::PAID_ORDER,
                    $order->load('account:id,name,created_at')->toArray()));
            return true;
        } catch (\Exception $exception) {
            report($exception);
            return false;
        }
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
