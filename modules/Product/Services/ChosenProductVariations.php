<?php

namespace Modules\Product\Services;

use Modules\Product\Entities\Product;

class ChosenProductVariations
{
    private $product;
    private $chosenVariations;


    public function __construct(Product $product, array $chosenVariations = [])
    {
        $this->product = $product;
        $this->chosenVariations = array_filter($chosenVariations);
    }


    public function getEntities()
    {
        return $this->product->variations()
            ->with(['values' => function ($query) {
                $query->whereIn('id', array_flatten($this->chosenVariations));
            }])
            ->whereIn('id', array_keys($this->chosenVariations))
            ->get()
            ->filter(function ($productVariation) {
                return $productVariation->values->isNotEmpty();
            });
    }
}
