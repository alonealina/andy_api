<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use App\Services\BranchService;
use Illuminate\Http\JsonResponse;

class BranchController extends Controller
{

    protected $branchService;

    /**
     * Construct function
     *
     * @param BranchService $branchService
     */
    public function __construct(BranchService $branchService)
    {
        $this->branchService = $branchService;
    }

    /**
     * Get all branches
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->branchService->getList(),
        ]);
    }

    /**
     * @param BranchRequest $request
     * @return JsonResponse
     */
    public function store(BranchRequest $request): JsonResponse
    {
        if ($newRecord = $this->branchService->store($request->validated())) {
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
     * @param UpdateBranchRequest $request
     * @param Branch $branch
     * @return JsonResponse
     */
    public function update(UpdateBranchRequest $request, Branch $branch): JsonResponse
    {
        if ($updateRecord = $this->branchService->update($request->validated(), $branch)) {
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
     * @param Branch $branch
     * @return JsonResponse
     */
    public function show(Branch $branch): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $branch->toArray(),
        ]);
    }

    /**
     * @param Branch $branch
     * @return JsonResponse
     */
    public function destroy(Branch $branch): JsonResponse
    {
        if ($record = $this->branchService->delete($branch)) {
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
