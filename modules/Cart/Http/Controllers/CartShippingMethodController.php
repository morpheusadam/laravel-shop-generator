<?php

namespace Modules\Cart\Http\Controllers;

use Modules\Cart\Facades\Cart;
use Modules\Shipping\Facades\ShippingMethod;

class CartShippingMethodController
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Modules\Cart\Cart
     */
    public function store()
    {
        Cart::addShippingMethod(
            ShippingMethod::get(
                request('shipping_method')
            )
        );

        return Cart::instance();
    }
}
