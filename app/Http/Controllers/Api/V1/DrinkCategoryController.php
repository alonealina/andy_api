<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
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
     * @param DrinkCategory $drinkCategory
     * @return JsonResponse
     */
    public function show(DrinkCategory $drinkCategory): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' =>  $this->drinkCategoryService->getByCategory($drinkCategory)
        ]);
    }
}
