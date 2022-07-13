<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Models\Food;
use App\Services\FoodService;
use Illuminate\Http\JsonResponse;

class FoodController extends Controller
{
    /**
     * @var FoodService
     */
    protected $foodService;

    /**
     * Construct function
     *
     * @param FoodService $foodService
     */
    public function __construct(FoodService $foodService)
    {
        $this->foodService = $foodService;
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
            'data' => $this->foodService->getList(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FoodRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(FoodRequest $request): JsonResponse
    {
        if ($newRecord = $this->foodService->store($request->validated())) {
            return response()->json([
                'message' => MessageStatus::SUCCESS,
                'data' => $newRecord,
            ]);
        }

        return response()->json([
            'message' => MessageStatus::ERROR,
        ], 400);
    }

    /**
     *
     * @param FoodRequest $request
     * @param Food $food
     * @return JsonResponse
     */
    public function update(FoodRequest $request, Food $food): JsonResponse
    {
        if ($updateRecord = $this->foodService->update($request->validated(), $food)) {
            return response()->json([
                'message' => MessageStatus::SUCCESS,
                'data' => $updateRecord,
            ]);
        }

        return response()->json([
            'message' => MessageStatus::ERROR,
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Food $food
     * @return JsonResponse
     */
    public function destroy(Food $food): JsonResponse
    {
        if ($record = $this->foodService->destroy($food)) {
            return response()->json([
                'message' => MessageStatus::SUCCESS,
                'data' => $record,
            ]);
        }

        return response()->json([
            'message' => MessageStatus::ERROR,
        ], 400);
    }

    /**
     * Get list images default
     *
     * @return JsonResponse
     */
    public function getImageDefault(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->foodService->getImageDefault(),
        ]);
    }
}
