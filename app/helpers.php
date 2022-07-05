<?php

use Illuminate\Http\JsonResponse;

if (! function_exists('responseDataNotFound')) {
    /**
     * @return JsonResponse
     */
    function responseDataNotFound(): JsonResponse
    {
        return response()->json([
            'message' => __('messages.common.data_not_found')
        ], 400);
    }
}
