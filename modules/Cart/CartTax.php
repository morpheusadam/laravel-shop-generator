<?php

namespace Modules\Cart;

use JsonSerializable;
use Modules\Support\Money;

class CartTax implements JsonSerializable
{
    private $cart;
    private $taxRate;
    private $taxCondition;


    public function __construct($cart, $taxRate, $taxCondition)
    {
        $this->cart = $cart;
        $this->taxRate = $taxRate;
        $this->taxCondition = $taxCondition;
    }


    public function id()
    {
        return $this->taxRate->id;
    }


    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }


    public function jsonSerialize()
    {
        return $this->toArray();
    }


    public function toArray(): array
    {
        return [
            'name' => $this->name(),
            'amount' => $this->amount(),
        ];
    }


    public function name()
    {
        return $this->taxRate->name;
    }


    public function amount(): Money
    {
        return Money::inDefaultCurrency($this->calculate());
    }


    private function calculate()
    {
        return $this->taxCondition->getCalculatedValue($this->taxApplicableProductsTotalPrice());
    }


    private function taxApplicableProductsTotalPrice()
    {
        return $this->taxApplicableProducts()->sum(function ($cartItem) {
            return $cartItem->totalPrice()->amount();
        });
    }


    private function taxApplicableProducts()
    {
        return $this->cart->items()->filter(function ($cartItem) {
            return $this->hasMatchingTaxClass($cartItem);
        });
    }


    private function hasMatchingTaxClass($cartItem): bool
    {
        return $cartItem->product->tax_class_id === $this->taxRate->tax_class_id;
    }
}
