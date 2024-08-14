<?php

namespace Modules\Cart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Cart\Facades\Cart;
use Modules\Coupon\Exceptions\CouponUsageLimitReachedException;

class CheckCouponUsageLimit
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     * @throws CouponUsageLimitReachedException
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Cart::coupon()->usageLimitReached($request->customer_email)) {
            throw new CouponUsageLimitReachedException;
        }

        return $next($request);
    }
}
