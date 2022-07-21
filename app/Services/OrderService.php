<?php

namespace App\Services;

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
}
