<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\CastRequest;
use App\Models\Cast;
use App\Services\CastService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CastController extends Controller
{
    /**
     * @var CastService
     */
    protected $castService;

    /**
     * @param CastService $castService
     */
    public function __construct(CastService $castService)
    {
        $this->middleware('role:ADMIN', ['except' => ['index', 'show']]);
        $this->castService = $castService;
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
            'data' => $this->castService->getList(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CastRequest $request
     * @return JsonResponse
     */
    public function store(CastRequest $request): JsonResponse
    {
        if ($newRecord = $this->castService->store($request->validated())) {
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
     * @param \App\Models\Cast $worker
     * @return Response
     */
    public function show(Cast $worker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Cast $worker
     * @return Response
     */
    public function edit(Cast $worker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateWorkerRequest $request
     * @param \App\Models\Cast $worker
     * @return Response
     */
    public function update(CastRequest $request, Cast $worker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cast $worker
     * @return Response
     */
    public function destroy(Cast $worker)
    {
        //
    }
}
