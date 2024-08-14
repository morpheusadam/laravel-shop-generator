<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $route = app('inAdminPanel') ? 'admin.dashboard.index' : 'account.dashboard.index';

            return redirect()->route($route);
        }

        return $next($request);
    }
}
