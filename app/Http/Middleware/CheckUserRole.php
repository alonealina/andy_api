<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param ...$role
     * @return mixed|void
     */
    public function handle(Request $request, Closure $next, ...$role)
    {
        if (in_array(Auth::user()->role->key, $role)) {
            return $next($request);
        }
        abort(403, __('messages.common.forbidden'));
    }
}
