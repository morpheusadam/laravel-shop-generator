<?php

use Modules\Product\Entities\Product;
use Modules\FlashSale\Entities\FlashSale;
use Modules\Product\Entities\ProductVariant;

if (!function_exists('product_price_formatted')) {
    /**
     * Get the selling price of the given product.
     *
     * @param Product $productOrProductVariant
     * @param Closure|null $callback
     *
     * @return string
     */
    function product_price_formatted(Product|ProductVariant $productOrProductVariant, Closure $callback = null): string
    {
        if ($productOrProductVariant instanceof Product && FlashSale::contains($productOrProductVariant)) {
            $sellingPrice = $productOrProductVariant->hasSpecialPrice() ? $productOrProductVariant->getSpecialPrice() : $productOrProductVariant->price;
            $previousPrice = $sellingPrice->convertToCurrentCurrency()->format();
            $flashSalePrice = FlashSale::pivot($productOrProductVariant)->price->convertToCurrentCurrency()->format();

            if (is_callable($callback)) {
                return $callback($flashSalePrice, $previousPrice);
            }

            return "<span class='special-price'>{$flashSalePrice}</span> <span class='previous-price'>{$previousPrice}</span>";
        }

        $price = $productOrProductVariant->price->convertToCurrentCurrency()->format();
        $specialPrice = $productOrProductVariant->getSpecialPrice()->convertToCurrentCurrency()->format();

        if (is_callable($callback)) {
            return $callback($price, $specialPrice);
        }

        if (!$productOrProductVariant->hasSpecialPrice()) {
            return $price;
        }
        return "<span class='special-price'>{$specialPrice}</span> <span class='previous-price'>{$price}</span>";
    }
}
