<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodCategoryRequest;
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
}
