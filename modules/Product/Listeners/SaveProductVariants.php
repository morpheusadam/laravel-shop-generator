<?php

namespace Modules\Product\Listeners;

use Modules\Product\Entities\Product;

class SaveProductVariants
{
    /**
     * Handle the event.
     *
     * @param Product $product
     *
     * @return void
     */
    public function handle($product)
    {
        $ids = $this->getDeleteCandidates($product);

        if ($ids->isNotEmpty()) {
            $product->variants()->forceDelete($ids);
        }

        $this->saveVariants($product);
    }


    private function getDeleteCandidates($product)
    {
        return $product
            ->variants()
            ->withoutGlobalScope('active')
            ->pluck('id')
            ->diff(array_pluck($this->variants(), 'id'));
    }


    private function variants()
    {
        return request('variants', []);
    }


    private function saveVariants($product)
    {
        $variants = $this->variants();
        $counter = 0;

        foreach ($variants as $attributes) {
            $attributes['position'] = ++$counter;
            $product->variants()->withoutGlobalScope('active')->updateOrCreate(['id' => $attributes['id'] ?? null], $attributes);
        }
    }
}
