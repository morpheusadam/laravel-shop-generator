<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Modules\Support\Money;
use Illuminate\Http\Response;

class MaximumSpendException extends Exception
{
    /**
     * The maximum amount that is allowed.
     *
     * @var Money
     */
    private $money;


    /**
     * Create a new instance of the exceptions
     *
     * @param Money $money
     */
    public function __construct($money)
    {
        $this->money = $money;
    }


    /**
     * Render the exception into an HTTP response.
     *
     * @return Response
     */
    public function render()
    {
        return response()->json([
            'message' => trans('coupon::messages.maximum_spend', ['amount' => $this->money->convertToCurrentCurrency()->format()]),
        ], 403);
    }
}
