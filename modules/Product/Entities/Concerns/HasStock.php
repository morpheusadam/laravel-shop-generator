<?php

namespace Modules\Product\Entities\Concerns;

use Modules\FlashSale\Entities\FlashSale;

trait HasStock
{
    public function isOutOfStock(): bool
    {
        return !$this->isInStock();
    }


    public function isInStock()
    {
        if (FlashSale::contains($this)) {
            return FlashSale::remainingQty($this) > 0;
        }
        if ($this->hasAnyVariants()) {
            $productWithStock = $this->variants
                ->where(function ($query) {
                    $query->where(
                        [
                            ['manage_stock', true],
                            ['qty', '>', 0],
                        ]);

                    $query->orWhere('manage_stock', false);
                })
                ->where('in_stock', true)
                ->first();

            return (bool)$productWithStock;
        } else {
            if ($this->manage_stock && $this->qty === 0) {
                return false;
            }

            return $this->in_stock;
        }
    }


    public function markAsInStock(): void
    {
        $this->withoutEvents(function () {
            $this->update(['in_stock' => true]);
        });
    }


    public function markAsOutOfStock(): void
    {
        $this->withoutEvents(function () {
            $this->update(['in_stock' => false]);
        });
    }
}
