<?php

namespace Modules\Cart;

use JsonSerializable;
use Modules\Support\Money;
use Modules\Tax\Entities\TaxRate;
use Illuminate\Support\Collection;
use Modules\Coupon\Entities\Coupon;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductVariant;
use Modules\Shipping\Facades\ShippingMethod;
use Darryldecode\Cart\Cart as DarryldecodeCart;
use Modules\Variation\Entities\VariationValue;
use Modules\Product\Services\ChosenProductOptions;
use Modules\Product\Services\ChosenProductVariations;
use Darryldecode\Cart\Exceptions\InvalidItemException;
use Darryldecode\Cart\Exceptions\InvalidConditionException;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Cart extends DarryldecodeCart implements JsonSerializable
{
    /**
     * Get the current instance.
     *
     * @return $this
     */
    public function instance(): static
    {
        return $this;
    }


    /**
     * Clear the cart.
     *
     * @return void
     */
    public function clear(): void
    {
        parent::clear();

        $this->clearCartConditions();
    }


    /**
     * Store a new item to the cart.
     *
     * @param int $productId
     * @param       $variantId
     * @param int $qty
     * @param array $options
     *
     * @return void
     * @throws InvalidItemException
     */
    public function store($productId, $variantId, $qty, $options = []): void
    {
        $options = array_filter($options);
        $variations = [];

        $product = Product::with('files', 'categories', 'taxClass')->findOrFail($productId);
        $variant = ProductVariant::find($variantId);
        $item = $variant ?? $product;

        if ($variant) {
            $uids = collect(explode('.', $variant->uids));
            $rawVariations = $uids->map(function ($uid) {
                return VariationValue::where('uid', $uid)->get()->pluck('id', 'variation.id');
            });

            foreach ($rawVariations as $variation) {
                foreach ($variation as $variationId => $variationValueId) {
                    $variations[$variationId] = $variationValueId;
                }
            }
        }

        $chosenVariations = new ChosenProductVariations($product, $variations);
        $chosenOptions = new ChosenProductOptions($product, $options);

        $this->add([
            'id' => md5("product_id.{$productId}.variant_id.{$variantId}:options." . serialize($options)),
            'name' => $product->name,
            'price' => $item->selling_price->amount(),
            'quantity' => (int)$qty,
            'attributes' => [
                'product' => $product,
                'variant' => $variant,
                'item' => $item,
                'variations' => $chosenVariations->getEntities(),
                'options' => $chosenOptions->getEntities(),
                'created_at' => time(),
            ],
        ]);
    }


    public function updateQuantity($id, $qty)
    {
        $this->update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $qty,
            ],
        ]);
    }


    /**
     * Total quantity of the given cartItem
     * in the Cart.
     *
     * @param CartItem $cartItem
     *
     * @return int
     */
    public function addedQty(CartItem $cartItem): int
    {
        $items = $this->items()->filter(function ($cartItemAlias) use ($cartItem) {
            if ($cartItem->variant && $cartItemAlias->variant) {
                return $cartItemAlias->variant->id === $cartItem->variant->id;
            }

            return $cartItemAlias->product->id === $cartItem->product->id;
        });

        return $items->sum('qty');
    }


    public function items()
    {
        return $this->getContent()
            ->sortBy('attributes.created_at')
            ->map(function ($item) {
                return new CartItem($item);
            });
    }


    public function crossSellProducts()
    {
        return $this->getAllProducts()
            ->load([
                'crossSellProducts' => function ($query) {
                    $query->forCard();
                },
            ])
            ->pluck('crossSellProducts')
            ->flatten();
    }


    public function getAllProducts(): EloquentCollection
    {
        return $this->items()->map(function ($cartItem) {
            return $cartItem->product;
        })->flatten()->pipe(function ($products) {
            return new EloquentCollection($products);
        });
    }


    public function reduceStock()
    {
        $this->manageStock(function ($cartItem) {
            $cartItem->item->decrement('qty', $cartItem->qty);
        });
    }


    public function restoreStock()
    {
        $this->manageStock(function ($cartItem) {
            $cartItem->product->increment('qty', $cartItem->qty);
        });
    }


    /**
     * @throws InvalidConditionException
     */
    public function addShippingMethod($shippingMethod)
    {
        $this->removeShippingMethod();

        $this->condition(
            new CartCondition([
                'name' => $shippingMethod->label,
                'type' => 'shipping_method',
                'target' => 'total',
                'value' => $this->coupon()?->free_shipping ? 0 : $shippingMethod->cost->amount(),
                'order' => 1,
                'attributes' => [
                    'shipping_method' => $shippingMethod,
                ],
            ]),
        );

        return $this->shippingMethod();
    }


    public function removeShippingMethod()
    {
        $this->removeConditionsByType('shipping_method');
    }


    public function coupon()
    {
        if (!$this->hasCoupon()) {
            return new NullCartCoupon();
        }

        $couponCondition = $this->getConditionsByType('coupon')->first();
        $coupon = Coupon::with('products', 'categories')->find($couponCondition->getAttribute('coupon_id'));

        return new CartCoupon($this, $coupon, $couponCondition);
    }


    public function hasCoupon()
    {
        if ($this->getConditionsByType('coupon')->isEmpty()) {
            return false;
        }

        $couponId = $this->getConditionsByType('coupon')
            ->first()
            ->getAttribute('coupon_id');

        return Coupon::where('id', $couponId)->exists();
    }


    /**
     * @throws InvalidConditionException
     */
    public function applyCoupon(Coupon $coupon)
    {
        $this->removeCoupon();

        try {
            $this->condition(
                new CartCondition([
                    'name' => $coupon->code,
                    'type' => 'coupon',
                    'target' => 'total',
                    'value' => $this->getCouponValue($coupon),
                    'order' => 2,
                    'attributes' => [
                        'coupon_id' => $coupon->id,
                    ],
                ]),
            );
        } catch (InvalidConditionException $e) {
            if (app()->hasDebugModeEnabled()) {
                $message = $e->getMessage();
            } else {
                $message = trans('core::something_went_wrong');
            }

            if (request()->ajax()) {
                return response()->json(
                    [
                        'message' => $message,
                    ],
                    400
                );
            }
        }

        if ($coupon->free_shipping) {
            $this->addShippingMethod(
                ShippingMethod::get(
                    $this->shippingMethod()->name()
                )
            );
        }
    }


    public function removeCoupon()
    {
        $this->removeConditionsByType('coupon');
    }


    public function shippingMethod()
    {
        if (!$this->hasShippingMethod()) {
            return new NullCartShippingMethod();
        }

        return new CartShippingMethod($this, $this->getConditionsByType('shipping_method')->first());
    }


    public function hasShippingMethod()
    {
        return $this->getConditionsByType('shipping_method')->isNotEmpty();
    }


    public function couponAlreadyApplied(Coupon $coupon)
    {
        return $this->coupon()->code() === $coupon->code;
    }


    public function discount()
    {
        return $this->coupon()->value();
    }


    public function addTaxes($addTaxesToCartRequest)
    {
        $this->removeTaxes();

        $this->findTaxes(
            $addTaxesToCartRequest->billing,
            $addTaxesToCartRequest->shipping
        )->each(
        /**
         * @throws InvalidConditionException
         */
            function ($taxRate) {
                $this->condition(
                    new CartCondition([
                        'name' => $taxRate->id,
                        'type' => 'tax',
                        'target' => 'total',
                        'value' => "+{$taxRate->rate}%",
                        'order' => 3,
                        'attributes' => [
                            'tax_rate_id' => $taxRate->id,
                        ],
                    ]),
                );
            });
    }


    public function removeTaxes()
    {
        $this->removeConditionsByType('tax');
    }


    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }


    public function jsonSerialize(): array
    {
        return $this->toArray();
    }


    public function toArray(): array
    {
        return [
            'items' => $this->items(),
            'quantity' => $this->getTotalQuantity(),
            'availableShippingMethods' => $this->availableShippingMethods(),
            'subTotal' => $this->subTotal(),
            'shippingMethodName' => $this->shippingMethod()->name(),
            'shippingCost' => $this->shippingCost(),
            'coupon' => $this->coupon(),
            'taxes' => $this->taxes(),
            'total' => $this->total(),
        ];
    }


    public function availableShippingMethods(): Collection
    {
        if ($this->allItemsAreVirtual()) {
            return collect();
        }

        return ShippingMethod::available();
    }


    public function allItemsAreVirtual()
    {
        return $this->items()->every(function (CartItem $cartItem) {
            return $cartItem->product->is_virtual;
        });
    }


    public function subTotal()
    {
        return Money::inDefaultCurrency($this->getSubTotal())->add($this->optionsPrice());
    }


    public function shippingCost()
    {
        return $this->shippingMethod()->cost();
    }


    public function taxes()
    {
        if (!$this->hasTax()) {
            return new Collection();
        }

        $taxConditions = $this->getConditionsByType('tax');
        $taxRates = TaxRate::whereIn('id', $this->getTaxRateIds($taxConditions))->get();

        return $taxConditions->map(function ($taxCondition) use ($taxRates) {
            $taxRate = $taxRates->where('id', $taxCondition->getAttribute('tax_rate_id'))->first();

            return new CartTax($this, $taxRate, $taxCondition);
        });
    }


    public function hasTax()
    {
        return $this->getConditionsByType('tax')->isNotEmpty();
    }


    public function total()
    {
        return $this->subTotal()
            ->add($this->shippingMethod()->cost())
            ->subtract($this->coupon()->value())
            ->add($this->tax());
    }


    public function tax()
    {
        return Money::inDefaultCurrency($this->calculateTax());
    }


    private function manageStock($callback)
    {
        $this->items()
            ->filter(function ($cartItem) {
                return $cartItem->item->manage_stock;
            })
            ->each($callback);
    }


    private function refreshFreeShippingCoupon()
    {
        if ($this->coupon()->isFreeShipping()) {
            $this->applyCoupon($this->coupon()->entity());
        }
    }


    private function getCouponValue($coupon)
    {
        if ($coupon->is_percent) {
            return "-{$coupon->value}%";
        }

        return "-{$coupon->value->amount()}";
    }


    private function findTaxes($billing_address, $shipping_address)
    {
        return $this->items()
            ->groupBy('tax_class_id')
            ->flatten()
            ->map(function (CartItem $cartItem) use ($billing_address, $shipping_address) {
                return $cartItem->findTax($billing_address, $shipping_address);
            })
            ->filter();
    }


    private function optionsPrice()
    {
        return Money::inDefaultCurrency($this->calculateOptionsPrice());
    }


    private function calculateOptionsPrice()
    {
        return $this->items()->sum(function ($cartItem) {
            return $cartItem
                ->optionsPrice()
                ->multiply($cartItem->qty)
                ->amount();
        });
    }


    private function getTaxRateIds($taxConditions)
    {
        return $taxConditions->map(function ($taxCondition) {
            return $taxCondition->getAttribute('tax_rate_id');
        });
    }


    private function calculateTax()
    {
        return $this->taxes()->sum(function ($cartTax) {
            return $cartTax->amount()->amount();
        });
    }
}
