<?php

namespace Modules\Cart\Contracts;

use Modules\Support\Money;

interface CartShippingMethod
{
    public function name();


    public function title();


    public function cost(): Money;
}
