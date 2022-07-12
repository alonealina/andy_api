<?php

namespace App\Services;

use App\Repositories\OrderDetailRepository;
use App\Repositories\StoreRepository;

class OrderDetailService
{
    /**
     * @var OrderDetailRepository
     */
    protected $orderDetailRepository;
    protected $storeRepository;

    /**
     * @param OrderDetailRepository $orderDetailRepository
     */
    public function __construct(
        OrderDetailRepository $orderDetailRepository,
        StoreRepository $storeRepository
    ){
        $this->orderDetailRepository = $orderDetailRepository;
        $this->storeRepository = $storeRepository;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->orderDetailRepository->getOrderPending();
    }
}
