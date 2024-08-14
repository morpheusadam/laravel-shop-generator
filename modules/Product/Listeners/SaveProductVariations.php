<?php

namespace Modules\Product\Listeners;

use Modules\Product\Entities\Product;

class SaveProductVariations
{
    /**
     * Handle the event.
     *
     * @param Product $product
     *
     * @return void
     */
    public function handle(Product $product): void
    {
        $ids = $this->getDeleteCandidates($product);

        if ($ids->isNotEmpty()) {
            $product->variations()->detach($ids);
        }

        $this->saveVariations($product);
    }


    private function getDeleteCandidates($product)
    {
        return $product
            ->variations()
            ->pluck('id')
            ->diff(array_pluck($this->variations(), 'id'));
    }


    private function variations()
    {
        return array_filter(request('variations', []), function ($variation) {
            return !is_null($variation['name']);
        });
    }


    private function saveVariations($product): void
    {
        $counter = 0;

        foreach (array_reset_index($this->variations()) as $attributes) {
            #if it's a global variation make the id null to render it creatable
            if ($attributes['is_global'] === true) {
                $attributes['id'] = null;
            }

            $attributes['is_global'] = false;
            $attributes['position'] = ++$counter;

            $variation = $product->variations()->updateOrCreate(['id' => $attributes['id'] ?? null], $attributes);

            $variation->saveValues($attributes['values'] ?? []);
        }
    }
}
