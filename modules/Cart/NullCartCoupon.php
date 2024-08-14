<?php

namespace Modules\Cart;

use Modules\Support\Money;
use Modules\Cart\Contracts\CartCoupon;

class NullCartCoupon implements CartCoupon
{
    public function id(): void
    {
        //
    }


    public function code(): void
    {
        //
    }


    public function isFreeShipping(): bool
    {
        return false;
    }


    public function usageLimitReached(): bool
    {
        return false;
    }


    public function didNotSpendTheRequiredAmount(): bool
    {
        return false;
    }


    public function spentMoreThanMaximumAmount(): bool
    {
        return false;
    }


    public function usedOnce(): void
    {
        //
    }


    public function value(): Money
    {
        return Money::inDefaultCurrency(0);
    }


    public function __get($attribute)
    {
        //
    }
}
