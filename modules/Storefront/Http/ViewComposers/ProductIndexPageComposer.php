<?php

namespace Modules\Storefront\Http\ViewComposers;

use Illuminate\View\View;
use Modules\Support\Money;
use Modules\Product\Entities\Product;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\ProductVariant;

class ProductIndexPageComposer
{
    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose($view)
    {
        $view->with([
            'categories' => $this->categories(),
            'minPrice' => $this->minPrice(),
            'maxPrice' => $this->maxPrice(),
            'latestProducts' => $this->latestProducts(),
        ]);
    }


    private function categories()
    {
        return Category::tree();
    }


    private function minPrice()
    {
        $minProductPrice = Product::min('selling_price');
        $minVariantPrice = ProductVariant::min('selling_price');
        $minPrice = min($minProductPrice, $minVariantPrice);

        return Money::inDefaultCurrency($minPrice)
            ->convertToCurrentCurrency()
            ->ceil()
            ->amount();
    }


    private function maxPrice()
    {
        $maxProductPrice = Product::max('selling_price');
        $maxVariantPrice = ProductVariant::max('selling_price');
        $maxPrice = max($maxProductPrice, $maxVariantPrice);

        return Money::inDefaultCurrency($maxPrice)
            ->convertToCurrentCurrency()
            ->ceil()
            ->amount();
    }


    private function latestProducts()
    {
        return Product::forCard()->take(5)->latest()->get()->map->clean();
    }
}
