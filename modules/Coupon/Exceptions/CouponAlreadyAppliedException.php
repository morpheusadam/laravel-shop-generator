<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CouponAlreadyAppliedException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return Response
     */
    public function render()
    {
        return response()->json([
            'message' => trans('coupon::messages.already_applied'),
        ], 403);
    }
}
