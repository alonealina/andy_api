<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\MaintainRequest;
use App\Services\MaintenanceService;
use Illuminate\Http\JsonResponse;

class MaintenanceController extends Controller
{
    /**
     * @var MaintenanceService
     */
    protected $maintenanceService;

    /**
     * @param MaintenanceService $maintenanceService
     */
    public function __construct(MaintenanceService $maintenanceService)
    {
        $this->maintenanceService = $maintenanceService;
    }

    /**
     * @param MaintainRequest $request
     * @return JsonResponse
     */
    public function setMaintain(MaintainRequest $request): JsonResponse
    {
        if ($newRecord = $this->maintenanceService->setMaintain($request->validated())) {
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
    public function getMaintain(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->maintenanceService->getMaintainStatus()
        ]);
    }
}
