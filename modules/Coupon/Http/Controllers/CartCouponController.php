<?php

namespace Modules\Coupon\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Cart\Facades\Cart;
use Illuminate\Pipeline\Pipeline;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Checkers\ValidCoupon;
use Modules\Coupon\Checkers\CouponExists;
use Modules\Coupon\Checkers\MaximumSpend;
use Modules\Coupon\Checkers\MinimumSpend;
use Modules\Coupon\Checkers\AlreadyApplied;
use Modules\Coupon\Checkers\ExcludedProducts;
use Modules\Coupon\Checkers\ApplicableProducts;
use Modules\Coupon\Checkers\ExcludedCategories;
use Modules\Coupon\Checkers\UsageLimitPerCoupon;
use Modules\Coupon\Checkers\ApplicableCategories;
use Modules\Coupon\Checkers\UsageLimitPerCustomer;

class CartCouponController
{
    private array $checkers = [
        CouponExists::class,
        AlreadyApplied::class,
        ValidCoupon::class,
        MinimumSpend::class,
        MaximumSpend::class,
        ApplicableProducts::class,
        ExcludedProducts::class,
        ApplicableCategories::class,
        ExcludedCategories::class,
        UsageLimitPerCoupon::class,
        UsageLimitPerCustomer::class,
    ];


    /**
     * Store a newly created resource in storage.
     *
     * @return \Modules\Cart\Cart
     */
    public function store()
    {
        $coupon = Coupon::findByCode(request('coupon'));

        resolve(Pipeline::class)
            ->send($coupon)
            ->through($this->checkers)
            ->then(function ($coupon) {
                Cart::applyCoupon($coupon);
            });

        return Cart::instance();
    }


    /**
     * Destroy resources by given ids.
     *
     * @return \Modules\Cart\Cart
     */
    public function destroy(): \Modules\Cart\Cart
    {
        Cart::removeCoupon();

        return Cart::instance();
    }
}
