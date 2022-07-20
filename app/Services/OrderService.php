<?php

namespace App\Services;

use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;

class OrderService
{
    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @var
     */
    protected $orderDetailRepository;

    /**
     * @param OrderRepository $orderRepository
     * @param OrderDetailRepository $orderDetailRepository
     */
    public function __construct(
        OrderRepository $orderRepository,
        OrderDetailRepository $orderDetailRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
    }

    /**
     * @return array
     */
    public function getListPending(): array
    {
        return $this->orderDetailRepository->getOrderPending();
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->orderRepository->getList();
    }
}
