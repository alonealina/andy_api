<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CastRequest;
use App\Http\Requests\GetScheduleCastRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Cast;
use App\Services\CastService;
use Illuminate\Http\JsonResponse;

class CastController extends Controller
{
    /**
     * @var CastService
     */
    protected $castService;

    /**
     * @param CastService $castService
     */
    public function __construct(CastService $castService)
    {
        $this->castService = $castService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->castService->getList(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CastRequest $request
     * @return JsonResponse
     */
    public function store(CastRequest $request): JsonResponse
    {
        if ($newRecord = $this->castService->store($request->validated())) {
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
     * @param Cast $cast
     * @return JsonResponse
     */
    public function show(Cast $cast): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $cast
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CastRequest $request
     * @param Cast $cast
     * @return JsonResponse
     */
    public function update(CastRequest $request, Cast $cast): JsonResponse
    {
        if ($updateRecord = $this->castService->update($request->validated(), $cast)) {
            return response()->json([
                'message' => MessageStatus::SUCCESS,
                'data' => $updateRecord
            ]);
        }
        return response()->json([
            'message' => MessageStatus::ERROR
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cast $cast
     * @return JsonResponse
     */
    public function destroy(Cast $cast): JsonResponse
    {
        if ($record = $this->castService->destroy($cast)) {
            return response()->json([
                'message' => MessageStatus::SUCCESS,
                'data' => $record
            ]);
        }
        return response()->json([
            'message' => MessageStatus::ERROR
        ], 400);
    }

    /**
     * @param Cast $cast
     * @param GetScheduleCastRequest $request
     * @return JsonResponse
     */
    public function getSchedule(Cast $cast, GetScheduleCastRequest $request): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->castService->getSchedule($cast, $request->validated())
        ]);
    }

    /**
     * @param Cast $cast
     * @param UpdateScheduleRequest $request
     * @return JsonResponse
     */
    public function updateSchedule(Cast $cast, UpdateScheduleRequest $request): JsonResponse
    {
        if ($record = $this->castService->setSchedule($cast, $request->validated())) {
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
