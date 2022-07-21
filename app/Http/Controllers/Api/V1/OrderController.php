<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->orderService->getList($request->all())
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getHistory(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->orderService->getHistory()
        ]);
    }

    /**
     * @param UpdateOrderRequest $request
     * @param Order $order
     * @return JsonResponse
     */
    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        if ($updateRecord = $this->orderService->update($request->validated(), $order)) {
            return response()->json([
                'message' => MessageStatus::SUCCESS,
                'data' => $updateRecord
            ]);
        }
        return response()->json([
            'message' => MessageStatus::ERROR
        ], 400);
    }
}
