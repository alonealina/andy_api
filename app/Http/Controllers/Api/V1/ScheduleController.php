<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetScheduleCastRequest;
use App\Models\Schedule;
use App\Services\ScheduleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    protected $scheduleService;

    /**
     * @param ScheduleService $scheduleService
     */
    public function __construct(ScheduleService $scheduleService)
    {
        $this->middleware('role:ADMIN', ['except' => ['index', 'show']]);
        $this->scheduleService = $scheduleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param GetScheduleCastRequest $request
     * @return JsonResponse
     */
    public function index(GetScheduleCastRequest $request): JsonResponse
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->scheduleService->getSchedule($request->validated()),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedul
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedul
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedul)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedul
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedul)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedul
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedul)
    {
        //
    }
}
