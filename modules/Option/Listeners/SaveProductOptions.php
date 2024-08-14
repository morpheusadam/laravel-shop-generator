<?php

namespace Modules\Option\Listeners;

use Modules\Product\Entities\Product;

class SaveProductOptions
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
            $product->options()->detach($ids);
        }

        $this->saveOptions($product);
    }


    private function getDeleteCandidates($product)
    {
        return $product->options()
            ->pluck('id')
            ->diff(array_pluck($this->options(), 'id'));
    }


    private function options()
    {
        return array_filter(request('options', []), function ($option) {
            return !is_null($option['name']);
        });
    }


    private function saveOptions($product)
    {
        $counter = 0;

        foreach (array_reset_index($this->options()) as $attributes) {
            #if it's a global option make the id null to render it creatable
            if ($attributes['is_global'] === true) {
                $attributes['id'] = null;
            }

            $attributes['is_global'] = false;
            $attributes['position'] = ++$counter;

            $option = $product->options()->updateOrCreate(['id' => $attributes['id'] ?? null], $attributes);

            $option->saveValues($attributes['values'] ?? []);
        }
    }
}
