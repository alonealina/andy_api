<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\TurnoverDetailRequest;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class TurnoverController extends Controller
{
    protected $orderService;

    /**
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @return JsonResponse
     */
    public function getTurnoverTotal(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->orderService->getTurnoverTotal()
        ]);
    }

    /**
     * @param TurnoverDetailRequest $request
     * @return JsonResponse
     */
    public function getTurnoverDetail(TurnoverDetailRequest $request): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->orderService->getTurnoverDetail($request->type)
        ]);
    }
}
