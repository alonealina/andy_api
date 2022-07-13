<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderDetailRequest;
use App\Models\OrderDetail;
use App\Services\OrderDetailService;
use Illuminate\Http\JsonResponse;

class OrderDetailController extends Controller
{

    /**
     * @var OrderDetailService
     */
    protected $orderDetailService;

    /**
     * @param OrderDetailService $orderDetailService
     */
    public function __construct(OrderDetailService $orderDetailService)
    {
        $this->middleware('role:ADMIN', ['except' => ['index', 'show']]);
        $this->orderDetailService = $orderDetailService;
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json([
            'message' => MessageStatus::SUCCESS,
            'data' => $this->orderDetailService->index()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\OrderDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function show(OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderDetailRequest  $request
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderDetailRequest $request, OrderDetail $orderDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderDetail  $orderDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrderDetail $orderDetail)
    {
        //
    }
}
