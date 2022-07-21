<?php

namespace App\Services;

use App\Enums\OrderDetailStatus;
use App\Models\Food;
use App\Models\Drink;
use App\Models\Order;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderDetailService
{
    /**
     * @var OrderDetailRepository
     */
    protected $orderDetailRepository;

    /**
     * @var OrderRepository
     */
    protected $orderRepository;

    /**
     * @param OrderDetailRepository $orderDetailRepository
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        OrderDetailRepository $orderDetailRepository,
        OrderRepository $orderRepository
    ){
        $this->orderDetailRepository = $orderDetailRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function getList($params): array
    {
        return $this->orderDetailRepository->getOrderPending();
    }

    /**
     * @param $params
     * @return bool|null
     */
    public function store($params): ?bool
    {
        DB::beginTransaction();
        try {
            $orderUnpaid = $this->orderRepository->getOderUnpaidByAccount();
            if (!empty($params['foods']))
                $this->storeOrderDetails($orderUnpaid, Food::class, $params['foods']);
            if (!empty($params['drinks']))
                $this->storeOrderDetails($orderUnpaid, Drink::class, $params['drinks']);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param Order $order
     * @param $className
     * @param $arrayData
     * @return void
     */
    public function storeOrderDetails(Order $order, $className, $arrayData)
    {
        foreach ($arrayData as $item) {
            $order->orderDetails()->create([
                'orderable_id' => $item['id'],
                'orderable_type' => $className,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'amount' => $item['price'] * $item['quantity'],
                'status' => OrderDetailStatus::PENDING,
            ]);
        }
    }

    /**
     * @param $orderDetail
     * @param $params
     * @return mixed
     */
    public function update($orderDetail, $params)
    {
        $orderDetail->status = $params['status'];
        $orderDetail->save();
        return $orderDetail;
    }

    /**
     * @return array
     */
    public function getListPending(): array
    {
        return $this->orderDetailRepository->getOrderPending();
    }

    /**
     * @return Builder[]|Collection
     */
    public function getNewOrder()
    {
        return $this->orderDetailRepository->getNewOrder();
    }
}
