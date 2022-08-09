<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Models\MaintainHistory;
use App\Services\MaintainHistoryService;
use Illuminate\Http\JsonResponse;

class MaintainHistoryController extends Controller
{
    /**
     * @var MaintainHistoryService
     */
    protected  $maintainHistoryService;

    /**
     * @param MaintainHistoryService $maintainHistoryService
     */
    public function __construct(MaintainHistoryService $maintainHistoryService)
    {
        $this->maintainHistoryService = $maintainHistoryService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->maintainHistoryService->getMaintainList()
        ]);
    }

    /**
     * @param MaintainHistory $maintainHistory
     * @return JsonResponse
     */
    public function show(MaintainHistory $maintainHistory): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $maintainHistory
        ]);
    }
}
