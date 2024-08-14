<?php

namespace Modules\Cart;

use stdClass;
use JsonSerializable;
use Modules\Support\Money;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductVariant;

class CartItem implements JsonSerializable
{
    /**
     * The ID of the cart item.
     *
     * @var int
     */
    public $id;

    /**
     * Quantity of the cart item.
     *
     * @var int
     */
    public $qty;

    /**
     * Underlying product of the cart item.
     *
     * @var Product
     */
    public $product;

    /**
     * Underlying product variant of the cart item.
     *
     * @var array
     */
    public $variant;

    /**
     * The registered custom driver creators.
     *
     * @var
     */
    public $item;

    /**
     * Options of the cart item.
     *
     * @var array
     */
    public $options;

    /**
     * Variations of the cart item.
     *
     * @var array
     */
    public $variations;


    /**
     * @param $item
     */
    public function __construct($item)
    {
        $this->id = $item->id;
        $this->qty = $item->quantity;
        $this->product = $item->attributes['product'];
        $this->variant = $item->attributes['variant'];
        $this->item = $item->attributes['item'];
        $this->variations = $item->attributes['variations'];
        $this->options = $item->attributes['options'];
    }


    /**
     * @return $this
     */
    public function refreshStock()
    {
        $item = $this->getItem();

        $this->item->fill([
            'manage_stock' => $item->manage_stock,
            'in_stock' => $item->in_stock,
            'qty' => $item->qty,
        ]);

        return $this;
    }


    /**
     * @return mixed
     */
    private function getProduct()
    {
        return Product::withName()
            ->addSelect('id', 'in_stock', 'manage_stock', 'qty', 'is_active')
            ->where('id', $this->product->id)
            ->first();
    }


    /**
     * @return mixed
     */
    private function getVariant()
    {
        return ProductVariant::addSelect('id', 'in_stock', 'manage_stock', 'qty', 'is_active')
            ->where('id', $this->variant->id)
            ->first();
    }


    /**
     * @return mixed
     */
    public function getItem()
    {
        if ($this->item instanceof ProductVariant) {
            return $this->getVariant();
        }

        return $this->getProduct();
    }


    /**
     * @param array $billing_address
     * @param array $shipping_address
     *
     * @return mixed
     */
    public function findTax($billing_address, $shipping_address)
    {
        return $this->product->taxClass
            ->findTaxRate($billing_address, $shipping_address);
    }


    /**
     * @return false|string
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }


    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'qty' => $this->qty,
            'product' => $this->product->clean(),
            'variant' => $this->variant?->clean(),
            'item' => $this->refreshStock()->item,
            'variations' => $this->variations->isNotEmpty() ? $this->variations->keyBy('position') : new stdClass,
            'options' => $this->options->isNotEmpty() ? $this->options->keyBy('position') : new stdClass,
            'unitPrice' => $this->unitPrice(),
            'total' => $this->totalPrice(),
        ];
    }


    /**
     * Calculate the unit price of the cart item.
     *
     * @return mixed
     */
    public function unitPrice()
    {
        return $this->item->selling_price->add($this->optionsPrice());
    }


    /**
     * Calculate the price of the options
     * of the cart item.
     *
     * @return \Modules\Support\Money
     */
    public function optionsPrice()
    {
        return Money::inDefaultCurrency($this->calculateOptionsPrice());
    }


    /**
     * Calculate the total price of the cart item.
     *
     * @return mixed
     */
    public function totalPrice()
    {
        return $this->unitPrice()->multiply($this->qty);
    }


    /**
     * Calculate the price of the options.
     *
     * @return float
     */
    private function calculateOptionsPrice()
    {
        return (float)$this->options
            ->sum(
                fn ($option) => $this->sumOfThePricesOfTheValuesOf($option)
            );
    }


    /**
     * Calculate the sum of the prices of the
     * values of the given option.
     *
     * @param $option
     *
     * @return float
     */
    private function sumOfThePricesOfTheValuesOf($option)
    {
        return (float)$option->values
            ->sum(function ($value) {
                return $value->price_type === 'fixed'
                    ? $value->price->amount()
                    : take_percent(
                        $value->price,
                        $this->item->selling_price->amount()
                    );
            });
    }
}
