<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodCategoryRequest;
use App\Models\FoodCategory;
use App\Services\FoodCategoryService;
use Illuminate\Http\JsonResponse;

class FoodCategoryController extends Controller
{
    protected $foodCategoryService;

    /**
     * @param FoodCategoryService $foodCategoryService
     */
    public function __construct(FoodCategoryService $foodCategoryService)
    {
        $this->foodCategoryService = $foodCategoryService;
    }

    /**
     * @param FoodCategoryRequest $request
     * @return JsonResponse
     */
    public function store(FoodCategoryRequest $request): JsonResponse
    {
        if ($record = $this->foodCategoryService->store($request->validated())) {
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
     * @param FoodCategoryRequest $request
     * @param FoodCategory $foodCategory
     * @return JsonResponse
     */
    public function update(FoodCategoryRequest $request, FoodCategory $foodCategory): JsonResponse
    {
        if ($record = $this->foodCategoryService->update($request->validated(), $foodCategory)) {
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->foodCategoryService->getList()
        ]);
    }

    /**
     * @param FoodCategory $foodCategory
     * @return JsonResponse
     */
    public function show(FoodCategory $foodCategory): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $foodCategory
        ]);
    }

    /**
     * @param FoodCategory $foodCategory
     * @return JsonResponse
     */
    public function destroy(FoodCategory $foodCategory): JsonResponse
    {
        if ($record = $this->foodCategoryService->delete($foodCategory)) {
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
