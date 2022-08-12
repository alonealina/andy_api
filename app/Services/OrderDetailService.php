<?php

namespace App\Services;

use App\Enums\NotificationType;
use App\Enums\OrderDetailStatus;
use App\Events\CreateNotification;
use App\Models\Account;
use App\Models\Food;
use App\Models\Drink;
use App\Models\Order;
use App\Repositories\OrderDetailRepository;
use App\Repositories\OrderRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
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
    ) {
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
        $admin = Auth::user()->getAdminBranch();
        try {
            $orderUnpaid = $this->orderRepository->getOderUnpaidByAccount();
            $newOrder = new Collection();
            if (!empty($params['foods'])) {
                $this->storeOrderDetails($orderUnpaid, $newOrder, Food::class, $params['foods']);
            }
            if (!empty($params['drinks'])) {
                $this->storeOrderDetails($orderUnpaid, $newOrder, Drink::class, $params['drinks']);
            }
            $newOrder = $newOrder->load('orderable:id,name')->toArray();
            event(new CreateNotification(NotificationType::NEW_ORDER, $newOrder));
            $admin->notifications()->create([
                'type' => NotificationType::NEW_ORDER,
                'notifiable_type' => Account::class,
                'notifiable_id' => Auth::user()->id,
                'data' => $newOrder
            ]);
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param Order $order
     * @param $collection
     * @param $className
     * @param $arrayData
     * @return void
     */
    public function storeOrderDetails(Order $order, &$collection, $className, $arrayData)
    {
        $record = $className::whereIn('id', array_column($arrayData, 'id'))->onlyTrashed()->count();
        abort_if($record != 0, 400, 'カートに無効商品があります');
        foreach ($arrayData as $item) {
            $collection->push($order->orderDetails()->create([
                'orderable_id' => $item['id'],
                'orderable_type' => $className,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'amount' => $item['price'] * $item['quantity'],
                'status' => OrderDetailStatus::PENDING,
            ]));
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
