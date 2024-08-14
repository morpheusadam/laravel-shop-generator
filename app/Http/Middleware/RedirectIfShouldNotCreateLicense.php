<?php

namespace FleetCart\Http\Middleware;

use Closure;
use FleetCart\License;
use Illuminate\Http\Request;

class RedirectIfShouldNotCreateLicense
{
    private $license;


    public function __construct(License $license)
    {
        $this->license = $license;
    }


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
        if ($this->license->valid() || !$this->license->shouldCreateLicense()) {
            return redirect()->intended('/admin');
        }

        return $next($request);
    }
}
