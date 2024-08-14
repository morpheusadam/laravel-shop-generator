<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;

class CouponUsageLimitReachedException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return JsonResponse
     */
    public function render(): JsonResponse
    {
        return response()->json([
            'message' => trans('coupon::messages.usage_limit_reached'),
        ], 403);
    }
}
