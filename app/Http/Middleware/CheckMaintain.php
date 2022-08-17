<?php

namespace App\Http\Middleware;

use App\Enums\MaintainStatus;
use App\Services\MaintenanceService;
use Closure;
use Illuminate\Http\Request;

class CheckMaintain
{

    /**
     * @var MaintenanceService
     */
    protected $maintenanceService;

    /**
     * @param MaintenanceService $maintenanceService
     */
    public function __construct(MaintenanceService $maintenanceService)
    {
        $this->maintenanceService = $maintenanceService;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       $maintainStatus = $this->maintenanceService->getMaintainStatus();
       if ($maintainStatus->maintain_status == MaintainStatus::MAINTAIN) {
           abort(503, json_encode([
               'data' => [
                   'message' => $maintainStatus->message,
                   'start_time' => $maintainStatus->start_time->format('Y-m-d H:i'),
                   'end_time' => $maintainStatus->end_time->format('Y-m-d H:i')
               ]
           ]));
       }
       return $next($request);
    }
}
