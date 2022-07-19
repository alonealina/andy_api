<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderDetailRequest;
use App\Http\Requests\UpdateOrderDetailRequest;
use App\Models\OrderDetail;
use App\Services\OrderDetailService;
use Illuminate\Http\JsonResponse;

class OrderDetailController extends Controller
{

    /**
     * @var OrderDetailService
     */
    protected $orderDetailService;

    /**
     * @param OrderDetailService $orderDetailService
     */
    public function __construct(OrderDetailService $orderDetailService)
    {
        $this->orderDetailService = $orderDetailService;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->orderDetailService->index()
        ]);
    }

    /**
     * @param OrderDetailRequest $request
     * @return JsonResponse
     */
    public function store(OrderDetailRequest $request)
    {
        if ($this->orderDetailService->store($request->validated())) {
            return response()->json([
                'message' => MessageStatus::SUCCESS,
                'data' => []
            ]);
        }
        return response()->json([
            'message' => MessageStatus::ERROR
        ], 400);
    }

    /**
     * @param OrderDetail $orderDetail
     * @return JsonResponse
     */
    public function update(UpdateOrderDetailRequest $request, OrderDetail $orderDetail)
    {
        if ($record = $this->orderDetailService->update($orderDetail, $request->validated())) {
            return response()->json([
                'message' => MessageStatus::SUCCESS,
                'data' => $record
            ]);
        }
        return response()->json([
            'message' => MessageStatus::ERROR
        ], 400);
    }
}
