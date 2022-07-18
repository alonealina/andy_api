<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Requests\BackgroundRequest;
use App\Services\BackgroundService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BackgroundController extends Controller
{
    protected $backgroundService;

    /**
     * @param BackgroundService $backgroundService
     */
    public function __construct(BackgroundService $backgroundService)
    {
        $this->backgroundService = $backgroundService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(BackgroundRequest $request): JsonResponse
    {
        if ($newRecord = $this->backgroundService->store($request->all())) {
            return response()->json([
                'message' => MessageStatus::SUCCESS,
                'data' => $newRecord
            ]);
        }
        return response()->json([
            'message' => MessageStatus::ERROR
        ], 400);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->backgroundService->index()
        ]);
    }
}
