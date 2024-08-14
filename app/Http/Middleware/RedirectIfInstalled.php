<?php

namespace FleetCart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfInstalled
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
        if (config('app.installed')) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
