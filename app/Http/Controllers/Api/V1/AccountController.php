<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Services\AccountService;
use Illuminate\Http\JsonResponse;

class AccountController extends Controller
{
    /**
     * @var AccountService
     */
    protected $accountService;

    /**
     * Construct function
     *
     * @param AccountService $accountService
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->accountService->getList()
        ]);
    }

    /**
     * @param AccountRequest $request
     * @return JsonResponse
     */
    public function store(AccountRequest $request): JsonResponse
    {
        if ($newRecord = $this->accountService->store($request->validated())) {
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
     * @param Account $account
     * @return JsonResponse
     */
    public function show(Account $account): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $account
        ]);
    }

    /**
     * @param AccountRequest $request
     * @param Account $account
     * @return JsonResponse
     */
    public function update(AccountRequest $request, Account $account): JsonResponse
    {
        if ($updateRecord = $this->accountService->update($request->validated(), $account)) {
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
     * @param Account $account
     * @return JsonResponse
     */
    public function destroy(Account $account): JsonResponse
    {
        if ($record = $this->accountService->delete($account)) {
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
