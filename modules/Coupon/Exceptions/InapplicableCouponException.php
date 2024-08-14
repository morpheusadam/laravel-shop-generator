<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Illuminate\Http\Response;

class InapplicableCouponException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @return Response
     */
    public function render()
    {
        return response()->json([
            'message' => trans('coupon::messages.inapplicable'),
        ], 403);
    }
}
