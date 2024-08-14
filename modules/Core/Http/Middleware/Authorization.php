<?php

namespace Modules\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authorization
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param string $permission
     * @param string $to
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next, $permission, $to = '')
    {
        if (!auth()->user()->hasAccess($permission)) {
            return $this->handleUnauthorizedRequest($request, $permission);
        }

        return $next($request);
    }


    /**
     * @param Request $request
     * @param string $permission
     *
     * @return Response
     */
    private function handleUnauthorizedRequest(Request $request, $permission)
    {
        if ($request->ajax()) {
            abort(401, 'Unauthorized.');
        }

        return back()->withError(trans('admin::messages.permission_denied', ['permission' => $permission]));
    }
}
