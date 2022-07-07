<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\InformationRequest;
use App\Models\Information;
use App\Services\InformationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class InformationController extends Controller
{
    /**
     * @var InformationService
     */
    protected $informationService;

    /**
     * Construct function
     *
     * @param InformationService $informationService
     */
    public function __construct(InformationService $informationService)
    {
        $this->informationService = $informationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->informationService->getList(),
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
     * @param InformationRequest $request
     * @return JsonResponse
     */
    public function store(InformationRequest $request): JsonResponse
    {

        if ($newRecord = $this->informationService->store($request->validated())) {
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
     * @param \App\Models\Information $information
     * @return Response
     */
    public function show(Information $information)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Information $information
     * @return Response
     */
    public function edit(Information $information)
    {
        //
    }

    /**
     * @param InformationRequest $request
     * @param Information $information
     * @return void
     */
    public function update(InformationRequest $request, Information $information)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Information $information
     * @return Response
     */
    public function destroy(Information $information)
    {
        //
    }
}
