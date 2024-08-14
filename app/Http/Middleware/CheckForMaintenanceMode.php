<?php

namespace FleetCart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Http\Exceptions\MaintenanceModeException;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as BaseCheckForMaintenanceMode;

class CheckForMaintenanceMode extends BaseCheckForMaintenanceMode
{
    /**
     * The URIs that should be accessible while maintenance mode is enabled.
     *
     * @var array
     */
    protected $except = [
        '*/admin*',
    ];


    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     *
     * @throws HttpException
     * @throws MaintenanceModeException
     */
    public function handle($request, Closure $next): mixed
    {
        if (
            config('app.installed')
            && $this->app->isDownForMaintenance()
            && optional(auth()->user())->hasRoleName('Admin')
        ) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
