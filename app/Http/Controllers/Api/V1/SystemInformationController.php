<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\SystemInformationRequest;
use App\Models\SystemInformation;
use App\Services\SystemInformationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SystemInformationController extends Controller
{

    protected $systemInformationService;

    /**
     * @param SystemInformationService $systemInformationService
     */
    public function __construct(SystemInformationService $systemInformationService)
    {
        $this->middleware('role:ADMIN', ['except' => ['index']]);
        $this->systemInformationService = $systemInformationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->systemInformationService->getSystemInformation(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SystemInformationRequest $request
     * @param SystemInformation $systemInformation
     * @return JsonResponse
     */
    public function update(SystemInformationRequest $request, SystemInformation $systemInformation): JsonResponse
    {
        if ($updateRecord = $this->systemInformationService->update($request->validated(), $systemInformation)) {
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
