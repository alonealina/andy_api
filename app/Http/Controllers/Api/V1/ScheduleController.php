<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetScheduleCastRequest;
use App\Http\Requests\ScheduleRequest;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    /**
     * @var ScheduleService
     */
    protected $scheduleService;

    /**
     * @param ScheduleService $scheduleService
     */
    public function __construct(ScheduleService $scheduleService)
    {
        $this->middleware('role:ADMIN', ['except' => ['index', 'show']]);
        $this->scheduleService = $scheduleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param GetScheduleCastRequest $request
     * @return JsonResponse
     */
    public function index(GetScheduleCastRequest $request): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->scheduleService->getSchedule($request->validated()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ScheduleRequest $request
     * @param Schedule $schedule
     * @return JsonResponse
     */
    public function update(ScheduleRequest $request, Schedule $schedule): JsonResponse
    {
        if ($updateRecord = $this->scheduleService->update($request->validated(), $schedule)) {
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
