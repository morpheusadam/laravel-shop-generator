<?php

namespace Modules\Cart;

use Modules\Support\Money;
use Modules\Cart\Contracts\CartShippingMethod;

class NullCartShippingMethod implements CartShippingMethod
{
    public function name()
    {
        //
    }


    public function title()
    {
        //
    }


    public function cost(): Money
    {
        return Money::inDefaultCurrency(0);
    }
}
