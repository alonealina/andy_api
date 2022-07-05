<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Http\Requests\UpdateFoodRequest;
use App\Models\Food;
use App\Services\FoodService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
     * @param Request $request
     * @return array|JsonResponse
     */
    public function index()
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->foodService->getList(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\FoodRequest $request
     * @return JsonResponse|Response
     */
    public function store(FoodRequest $request)
    {
        if ($newRecord = $this->foodService->store($request->validated())) {
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
     * @param \App\Models\Food $food
     * @return Response
     */
    public function show(Food $food)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Food $food
     * @return Response
     */
    public function edit(Food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateFoodRequest $request
     * @param \App\Models\Food $food
     * @return Response
     */
    public function update(UpdateFoodRequest $request, Food $food)
    {
        $result = $this->foodService->update($request, $food->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Food $food
     * @return Response
     */
    public function destroy(Food $food)
    {
        //
    }
}
