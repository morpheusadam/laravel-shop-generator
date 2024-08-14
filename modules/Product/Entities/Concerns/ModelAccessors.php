<?php

namespace Modules\Product\Entities\Concerns;

use Modules\Support\Money;
use Modules\Media\Entities\File;
use Modules\FlashSale\Entities\FlashSale;
use Illuminate\Database\Eloquent\Collection;
use Modules\FlashSale\Entities\FlashSaleProduct;

trait ModelAccessors
{
    public function getVariantAttribute()
    {
        return $this->variants->where('is_default', 1)->first();
    }


    public function getIsInFlashSaleAttribute()
    {
        return FlashSale::contains($this);
    }


    public function getFlashSaleEndDateAttribute()
    {
        if (FlashSale::contains($this)) {
            return FlashSaleProduct::where('product_id', $this->id)->first()?->end_date;
        }
    }


    public function getPriceAttribute($price): Money
    {
        return Money::inDefaultCurrency($price);
    }


    public function getFormattedPriceAttribute(): string
    {
        return product_price_formatted($this);
    }


    public function getFormattedPriceRangeAttribute(): ?string
    {
        if ($this->variants->count()) {
            $minPrice = $this->variants->min('price');
            $maxPrice = $this->variants->max('price');

            if ($minPrice !== $maxPrice) {
                $formattedMinPriceInCurrentCurrency = Money::inDefaultCurrency($minPrice->amount())->convertToCurrentCurrency()->format();
                $formattedMaxPriceInCurrentCurrency = Money::inDefaultCurrency($maxPrice->amount())->convertToCurrentCurrency()->format();

                return "$formattedMinPriceInCurrentCurrency - $formattedMaxPriceInCurrentCurrency";
            }
        }

        return null;
    }


    public function getSpecialPriceAttribute($specialPrice)
    {
        if (!is_null($specialPrice)) {
            return Money::inDefaultCurrency($specialPrice);
        }
    }


    public function getHasPercentageSpecialPriceAttribute(): bool
    {
        return $this->hasPercentageSpecialPrice();
    }


    public function getSpecialPricePercentAttribute()
    {
        if ($this->hasPercentageSpecialPrice()) {
            return round($this->special_price->amount(), 2);
        }
    }


    public function getSellingPriceAttribute($sellingPrice): Money
    {
        if (FlashSale::contains($this)) {
            $sellingPrice = FlashSale::pivot($this)->price->amount();
        }

        return Money::inDefaultCurrency($sellingPrice);
    }


    public function getTotalAttribute($total): Money
    {
        return Money::inDefaultCurrency($total);
    }


    /**
     * Get the product's base image.
     *
     * @return File
     */
    public function getBaseImageAttribute(): File
    {
        return $this->files
            ->where('pivot.zone', 'base_image')
            ->first()
            ?:
            new File();
    }


    /**
     * Get product's additional images.
     *
     * @return Collection
     */
    public function getAdditionalImagesAttribute(): Collection
    {
        return $this->files
            ->where('pivot.zone', 'additional_images')
            ->sortBy('pivot.id');
    }


    public function getMediaAttribute()
    {
        return $this->files
            ->whereIn('pivot.zone', ['base_image', 'additional_images'])
            ->sortBy('pivot.id');
    }


    /**
     * Get product's downloadable files.
     *
     * @return Collection
     */
    public function getDownloadsAttribute()
    {
        return $this->files
            ->where('pivot.zone', 'downloads')
            ->sortBy('pivot.id')
            ->flatten();
    }


    public function getDoesManageStockAttribute(): bool
    {
        return (bool)$this->manage_stock;
    }


    public function getQtyAttribute($qty)
    {
        return $qty;
    }


    public function getIsInStockAttribute(): bool
    {
        return (bool)$this->isInStock();
    }


    public function getIsOutOfStockAttribute(): bool
    {
        return $this->isOutOfStock();
    }


    public function getIsNewAttribute(): bool
    {
        return $this->isNew();
    }


    public function getAttributeSetsAttribute()
    {
        return $this->getAttribute('attributes')->groupBy('attributeSet');
    }


    public function getRatingPercentAttribute()
    {
        if ($this->relationLoaded('reviews')) {
            return ($this->reviews->avg->rating / 5) * 100;
        }
    }
}
