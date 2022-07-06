<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\DrinkRequest;
use App\Models\Drink;
use App\Services\DrinkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DrinkController extends Controller
{
    /**
     * @var DrinkService
     */
    protected $drinkService;

    /**
     * @param DrinkService $drinkService
     */
    public function __construct(DrinkService $drinkService)
    {
        $this->drinkService = $drinkService;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->drinkService->getList()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DrinkRequest $request
     * @return JsonResponse
     */
    public function store(DrinkRequest $request): JsonResponse
    {
        if ($newRecord = $this->drinkService->store($request->validated())) {
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param DrinkRequest $request
     * @param Drink $drink
     * @return JsonResponse
     */
    public function update(DrinkRequest $request, Drink $drink): JsonResponse
    {
        if ($record = $this->drinkService->update($request->validated(), $drink)) {
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
     * @param Drink $drink
     * @return JsonResponse
     */
    public function destroy(Drink $drink): JsonResponse
    {
        if ($record = $this->drinkService->delete($drink)) {
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
