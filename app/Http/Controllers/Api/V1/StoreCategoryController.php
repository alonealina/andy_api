<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Services\StoreCategoryService;
use Illuminate\Http\JsonResponse;

class StoreCategoryController extends Controller
{

    /**
     * @var StoreCategoryService
     */
    protected $storeCategoryService;

    /**
     * @param StoreCategoryService $storeCategoryService
     */
    public function __construct(StoreCategoryService $storeCategoryService)
    {
        $this->storeCategoryService = $storeCategoryService;
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
            'data' => $this->storeCategoryService->getList(),
        ]);
    }

    /**
     * @param StoreCategoryRequest $request
     * @return JsonResponse
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        if ($newRecord = $this->storeCategoryService->store($request->validated())) {
            return response()->json([
                'message' => MessageStatus::SUCCESS,
                'data' => $newRecord
            ]);
        }
        return response()->json([
            'message' => MessageStatus::ERROR
        ], 400);
    }
}
