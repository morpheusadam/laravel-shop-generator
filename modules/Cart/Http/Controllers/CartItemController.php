<?php

namespace Modules\Cart\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\Cart\Facades\Cart;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Controller;
use Modules\Coupon\Entities\Coupon;
use Modules\Coupon\Checkers\ValidCoupon;
use Modules\Coupon\Checkers\MaximumSpend;
use Modules\Coupon\Checkers\MinimumSpend;
use Modules\Coupon\Checkers\CouponExists;
use Modules\Coupon\Checkers\AlreadyApplied;
use Modules\Coupon\Checkers\ExcludedProducts;
use Modules\Coupon\Checkers\ApplicableProducts;
use Modules\Coupon\Checkers\ExcludedCategories;
use Modules\Coupon\Checkers\UsageLimitPerCoupon;
use Modules\Cart\Http\Middleware\CheckItemStock;
use Modules\Coupon\Checkers\ApplicableCategories;
use Modules\Coupon\Checkers\UsageLimitPerCustomer;
use Modules\Cart\Http\Requests\StoreCartItemRequest;

class CartItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(CheckItemStock::class)
            ->only(['store', 'update']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCartItemRequest $request
     *
     * @return \Modules\Cart\Cart
     */
    public function store(StoreCartItemRequest $request)
    {
        Cart::store(
            $request->product_id,
            $request->variant_id,
            $request->qty,
            $request->options ?? [],
        );

        return Cart::instance();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param string $id
     *
     * @return \Modules\Cart\Cart
     */
    public function update(string $id)
    {
        Cart::updateQuantity($id, request('qty'));

        return Cart::instance();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return \Modules\Cart\Cart
     */
    public function destroy(string $id)
    {
        Cart::remove($id);

        return Cart::instance();
    }
}
