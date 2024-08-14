<?php

namespace Modules\Coupon\Exceptions;

use Exception;
use Modules\Support\Money;
use Illuminate\Http\Response;

class MinimumSpendException extends Exception
{
    /**
     * The amount that need to spend.
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
            'message' => trans('coupon::messages.minimum_spend', ['amount' => $this->money->convertToCurrentCurrency()->format()]),
        ], 403);
    }
}
