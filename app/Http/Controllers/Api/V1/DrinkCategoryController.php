<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\DrinkCategoryRequest;
use App\Models\DrinkCategory;
use App\Services\DrinkCategoryService;
use Illuminate\Http\JsonResponse;

class DrinkCategoryController extends Controller
{
    protected $drinkCategoryService;

    /**
     * @param DrinkCategoryService $drinkCategoryService
     */
    public function __construct(DrinkCategoryService $drinkCategoryService)
    {
        $this->drinkCategoryService = $drinkCategoryService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->drinkCategoryService->getList(),
        ]);
    }

    /**
     * @param DrinkCategoryRequest $request
     * @param DrinkCategory $drinkCategory
     * @return JsonResponse
     */
    public function update(DrinkCategoryRequest $request, DrinkCategory $drinkCategory): JsonResponse
    {
        if ($record = $this->drinkCategoryService->update($request->validated(), $drinkCategory)) {
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
     * @param DrinkCategoryRequest $request
     * @return JsonResponse
     */
    public function store(DrinkCategoryRequest $request): JsonResponse
    {
        if ($record = $this->drinkCategoryService->store($request->validated())) {
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
     * @param DrinkCategory $drinkCategory
     * @return JsonResponse
     */
    public function show(DrinkCategory $drinkCategory): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' =>  $this->drinkCategoryService->show($drinkCategory)
        ]);
    }

    /**
     * @param DrinkCategory $drinkCategory
     * @return JsonResponse
     */
    public function destroy(DrinkCategory $drinkCategory): JsonResponse
    {
        if ($record = $this->drinkCategoryService->delete($drinkCategory)) {
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
