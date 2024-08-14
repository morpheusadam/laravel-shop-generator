<?php

namespace Modules\Cart\Contracts;

interface CartCoupon
{
    public function id(): void;


    public function code(): void;


    public function isFreeShipping(): bool;


    public function usageLimitReached(): bool;


    public function didNotSpendTheRequiredAmount(): bool;


    public function spentMoreThanMaximumAmount(): bool;


    public function usedOnce(): void;


    public function value(): \Modules\Support\Money;
}
