<?php

namespace Modules\Cart\Facades;

use Modules\Support\Money;
use Illuminate\Http\Request;
use Modules\Cart\CartCoupon;
use Modules\Shipping\Method;
use Modules\Coupon\Entities\Coupon;
use Modules\Cart\CartShippingMethod;
use Darryldecode\Cart\CartCollection;
use Illuminate\Support\Facades\Facade;
use Illuminate\Database\Eloquent\Collection;
use Darryldecode\Cart\CartConditionCollection;
use Illuminate\Support\Collection as SupportCollection;

/**
 * @method static \Modules\Cart\Cart instance()
 * @method static void clear()
 * @method static void store(int $productId, int $variantId, int $qty, array $options = [], array $variations = [])
 * @method static void updateQuantity(string $id, int $qty)
 * @method static CartCollection items()
 * @method static int addedQty(int $productId)
 * @method static crossSellProducts()
 * @method static Collection getAllProducts()
 * @method static void reduceStock()
 * @method static void restoreStock()
 * @method static int quantity()
 * @method static bool hasAvailableShippingMethod()
 * @method static SupportCollection availableShippingMethods()
 * @method static bool hasShippingMethod()
 * @method static CartShippingMethod shippingMethod()
 * @method static Money shippingCost()
 * @method static Money addShippingMethod(Method $shippingMethod)
 * @method static void removeShippingMethod()
 * @method static bool hasCoupon()
 * @method static bool couponAlreadyApplied()
 * @method static CartCoupon coupon()
 * @method static Money discount()
 * @method static void applyCoupon(Coupon $coupon)
 * @method static void removeCoupon()
 * @method static void hasTax()
 * @method static CartConditionCollection taxes()
 * @method static Money tax()
 * @method static void addTaxes($addTaxesToCart)
 * @method static void removeTaxes()
 * @method static Money subTotal()
 * @method static Money total()
 * @method static array toArray()
 * @method static array jsonSerialize()
 * @method static bool remove(string $id)
 * @method static bool allItemsAreVirtual()
 *
 * @see \Modules\Cart\Cart
 */
class Cart extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Modules\Cart\Cart::class;
    }
}
