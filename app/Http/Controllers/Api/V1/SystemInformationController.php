<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\SystemInformationRequest;
use App\Services\SystemInformationService;
use Illuminate\Http\JsonResponse;

class SystemInformationController extends Controller
{

    /**
     * @var SystemInformationService
     */
    protected $systemInformationService;

    /**
     * @param SystemInformationService $systemInformationService
     */
    public function __construct(SystemInformationService $systemInformationService)
    {
        $this->systemInformationService = $systemInformationService;
    }

    /**
     * @return JsonResponse
     */
    public function getSystemInformation(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->systemInformationService->getSystemInformation()
        ]);
    }

    /**
     * Update system information
     *
     * @param SystemInformationRequest $request
     * @return JsonResponse
     */
    public function updateSystemInformation(SystemInformationRequest $request): JsonResponse
    {
        if ($updateRecord = $this->systemInformationService->updateSystemInformation($request->validated())) {
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
