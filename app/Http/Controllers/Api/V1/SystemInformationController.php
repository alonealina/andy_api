<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Models\SystemInformation;
use App\Services\SystemInformationService;
use Illuminate\Http\Request;

class SystemInformationController extends Controller
{

    protected $systemInformationService;

    /**
     * @param SystemInformationService $systemInformationService
     */
    public function __construct(SystemInformationService $systemInformationService)
    {
        $this->middleware('role:ADMIN', ['except' => ['index']]);
        $this->systemInformationService = $systemInformationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->systemInformationService->getSystemInformation(),
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
     * @param  \App\Models\SystemInformation  $systemInformation
     * @return \Illuminate\Http\Response
     */
    public function show(SystemInformation $systemInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SystemInformation  $systemInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(SystemInformation $systemInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SystemInformation  $systemInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SystemInformation $systemInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SystemInformation  $systemInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(SystemInformation $systemInformation)
    {
        //
    }
}
