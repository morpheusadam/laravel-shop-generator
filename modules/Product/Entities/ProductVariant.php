<?php

namespace Modules\Product\Entities;

use Modules\Support\Money;
use Modules\Media\Entities\File;
use Modules\Support\Eloquent\Model;
use Modules\Media\Eloquent\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use SoftDeletes, HasMedia;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['files'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid',
        'uids',
        'name',
        'sku',
        'position',
        'price',
        'special_price',
        'special_price_type',
        'special_price_start',
        'special_price_end',
        'selling_price',
        'manage_stock',
        'qty',
        'in_stock',
        'is_active',
        'is_default',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'special_price_start' => 'datetime',
        'special_price_end' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    protected $appends = [
        'base_image',
        'additional_images',
        'media',
        'formatted_price',
        'has_percentage_special_price',
        'special_price_percent',
        'does_manage_stock',
        'is_in_stock',
        'is_out_of_stock',
    ];


    protected static function booted()
    {
        static::addActiveGlobalScope();

        static::saved(function ($productVariant) {
            $productVariant->withoutEvents(function () use ($productVariant) {
                $productVariant->update([
                    'selling_price' => ($productVariant->hasSpecialPrice() ? $productVariant->getSpecialPrice() : $productVariant->price)->amount(),
                ]);
            });
        });
    }


    public function url()
    {
        return route('products.show', ['slug' => $this->product->slug, 'variant' => $this->uid]);
    }


    public function scopeDefault($query)
    {
        return $query->where('is_default', 1);
    }


    public function scopeWithName($query)
    {
        $query->with('id,product_id,name');
    }


    public function scopeWithPrice($query)
    {
        $query->addSelect(['price', 'special_price', 'special_price_type', 'special_price_start', 'special_price_end']);
    }


    public function scopeWithBaseImage($query)
    {
        $query->with([
            'files' => function ($q) {
                $q->wherePivot('zone', '=', 'base_image')->orWherePivot('zone', '=', 'additional_images');
            },
        ]);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function getPriceAttribute($price)
    {
        return Money::inDefaultCurrency($price);
    }


    public function getSpecialPriceAttribute($specialPrice)
    {
        if (!is_null($specialPrice)) {
            return Money::inDefaultCurrency($specialPrice);
        }
    }


    public function getSellingPriceAttribute($sellingPrice)
    {
        return Money::inDefaultCurrency($sellingPrice);
    }


    public function getHasPercentageSpecialPriceAttribute()
    {
        return $this->hasPercentageSpecialPrice();
    }


    public function getSpecialPricePercentAttribute()
    {
        if ($this->hasPercentageSpecialPrice()) {
            return round($this->special_price->amount(), 2);
        }
    }


    public function getTotalAttribute($total)
    {
        return Money::inDefaultCurrency($total);
    }


    public function getDoesManageStockAttribute(): bool
    {
        return (bool)$this->manage_stock;
    }


    public function getIsInStockAttribute(): bool
    {
        return (bool)$this->isInStock();
    }


    public function getIsOutOfStockAttribute(): bool
    {
        return $this->isOutOfStock();
    }


    /**
     * Get the product's base image.
     *
     * @return File
     */
    public function getBaseImageAttribute()
    {
        return $this->files
            ->where('pivot.zone', 'base_image')
            ->first()
            ?:
            new File();
    }


    /**
     * Get the product's base image.
     *
     * @return File
     */
    public function getAdditionalImagesAttribute()
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


    public function getFormattedPriceAttribute()
    {
        return product_price_formatted($this);
    }


    public function hasSpecialPrice(): bool
    {
        if (is_null($this->special_price)) {
            return false;
        }

        if ($this->hasSpecialPriceStartDate() && $this->hasSpecialPriceEndDate()) {
            return $this->specialPriceStartDateIsValid() && $this->specialPriceEndDateIsValid();
        }

        if ($this->hasSpecialPriceStartDate()) {
            return $this->specialPriceStartDateIsValid();
        }

        if ($this->hasSpecialPriceEndDate()) {
            return $this->specialPriceEndDateIsValid();
        }

        return true;
    }


    public function getSpecialPrice()
    {
        $specialPrice = $this->attributes['special_price'];

        if ($this->special_price_type === 'percent') {
            $discountedPrice = ($specialPrice / 100) * $this->attributes['price'];

            $specialPrice = $this->attributes['price'] - $discountedPrice;
        }

        if ($specialPrice < 0) {
            $specialPrice = 0;
        }

        return Money::inDefaultCurrency($specialPrice);
    }


    public function getSellingPrice()
    {
        if ($this->hasSpecialPrice()) {
            return $this->getSpecialPrice();
        }

        return $this->price;
    }


    public function isInStock(): bool
    {
        if ($this->manage_stock && $this->qty === 0) {
            return false;
        }

        return (bool)$this->in_stock;
    }


    public function isOutOfStock(): bool
    {
        return !$this->isInStock();
    }


    public function markAsInStock()
    {
        $this->withoutEvents(function () {
            $this->update(['in_stock' => true]);
        });
    }


    public function markAsOutOfStock()
    {
        $this->withoutEvents(function () {
            $this->update(['in_stock' => false]);
        });
    }


    public function clean()
    {
        $cleanExceptAttributes = [
            'files',
            'is_active',
            'in_stock',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        return array_except($this->toArray(), $cleanExceptAttributes);
    }


    /**
     * Help HasMedia trait to extract media
     * for this model from the HTTP request.
     *
     * @return mixed
     */
    public function extractMediaFromRequest(): mixed
    {
        $media = collect(request('variants.' . $this->uid . '.media') ?? []);

        return [
            'base_image' => $media->first(),
            'additional_images' =>
                $media->except(
                    $media->keys()->first()
                )->toArray(),
        ];
    }


    private function hasPercentageSpecialPrice()
    {
        return $this->hasSpecialPrice() && $this->special_price_type === 'percent';
    }


    private function hasSpecialPriceStartDate(): bool
    {
        return !is_null($this->special_price_start);
    }


    private function hasSpecialPriceEndDate(): bool
    {
        return !is_null($this->special_price_end);
    }


    private function specialPriceStartDateIsValid(): bool
    {
        return today() >= $this->special_price_start;
    }


    private function specialPriceEndDateIsValid(): bool
    {
        return today() <= $this->special_price_end;
    }
}
