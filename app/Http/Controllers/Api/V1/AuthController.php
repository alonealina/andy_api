<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Construct function
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('username', 'password');

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['message' => __('messages.users.login_fail')], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Account successfully signed out']);
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * @return JsonResponse
     */
    public function userProfile(): JsonResponse
    {

        return response()->json(auth()->user()->load('casts:id,name,account_id'));
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    protected function createNewToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer Token',
            'account' => auth()->user()
        ]);
    }
}
