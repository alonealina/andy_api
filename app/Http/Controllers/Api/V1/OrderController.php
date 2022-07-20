<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
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
            'data' => $this->orderService->getList()
        ]);
    }
}
