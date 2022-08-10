<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\AccountRole;
use App\Enums\MaintainStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Maintenance;
use App\Services\MaintenanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @var MaintenanceService
     */
    protected $maintenanceService;

    /**
     * Construct function
     */
    public function __construct(MaintenanceService $maintenanceService)
    {
        $this->maintenanceService = $maintenanceService;
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('username', 'password');

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['message' => __('messages.users.login_fail')], 401);
        }
        $this->checkMaintain();
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

    /**
     * @return bool|void
     */
    protected function checkMaintain()
    {
        if (Auth::user()->role->value == AccountRole::SUPER_ADMIN) {
            return true;
        }
        $maintainStatus = $this->maintenanceService->getMaintainStatus();
        if ($maintainStatus->maintain_status == MaintainStatus::MAINTAIN) {
            auth()->logout();

            abort(503, json_encode([
                'data' => [
                    'message' => $maintainStatus->message,
                    'start_time' => $maintainStatus->start_time,
                    'end_time' => $maintainStatus->end_time,
                ]
            ]));
        }
    }
}
