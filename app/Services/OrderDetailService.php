<?php

namespace App\Services;

use App\Enums\OrderDetailStatus;
use App\Models\Food;
use App\Models\Drink;
use App\Repositories\OrderDetailRepository;
use App\Repositories\StoreRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function getList($params)
    {
        return $this->orderDetailRepository->getOrderPending();
    }

    /**
     * @param $params
     * @return bool|null
     */
    public function store($params)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::user()->id;
            foreach ($params['foods'] as $item) {
                $this->orderDetailRepository->create([
                    'account_id' => $userId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'orderable_id' => $item['id'],
                    'orderable_type' => Food::class,
                ]);
            }
            foreach ($params['drinks'] as $item) {
                $this->orderDetailRepository->create([
                    'account_id' => $userId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'orderable_id' => $item['id'],
                    'orderable_type' => Drink::class,
                ]);
            }
            // Notify
            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    public function update($orderDetail, $params)
    {
        $orderDetail->status = $params['status'];
        $orderDetail->save();
        return $orderDetail;
    }
}
