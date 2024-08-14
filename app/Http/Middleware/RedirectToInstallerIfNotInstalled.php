<?php

namespace FleetCart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectToInstallerIfNotInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next): mixed
    {
        if (!config('app.installed') && !$request->is('install')) {
            return redirect()->route('install.show');
        }

        return $next($request);
    }
}
