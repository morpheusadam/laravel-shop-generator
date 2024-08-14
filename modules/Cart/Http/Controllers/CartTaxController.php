<?php

namespace Modules\Cart\Http\Controllers;

use Exception;
use Modules\Cart\Facades\Cart;
use Illuminate\Pipeline\Pipeline;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Checkers\ValidCoupon;
use Modules\Coupon\Checkers\CouponExists;
use Modules\Coupon\Checkers\MinimumSpend;
use Modules\Coupon\Checkers\MaximumSpend;
use Modules\Coupon\Checkers\AlreadyApplied;
use Modules\Coupon\Checkers\ExcludedProducts;
use Modules\Coupon\Checkers\ApplicableProducts;
use Modules\Coupon\Checkers\ExcludedCategories;
use Modules\Coupon\Checkers\UsageLimitPerCoupon;
use Modules\Coupon\Checkers\ApplicableCategories;
use Modules\Coupon\Checkers\UsageLimitPerCustomer;
use Modules\Cart\Http\Requests\AddTaxesToCartRequest;

class CartTaxController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param AddTaxesToCartRequest $addTaxesToCartRequest
     *
     * @return \Modules\Cart\Cart
     */
    public function store(AddTaxesToCartRequest $addTaxesToCartRequest)
    {
        Cart::addTaxes($addTaxesToCartRequest);

        return Cart::instance();
    }
}
