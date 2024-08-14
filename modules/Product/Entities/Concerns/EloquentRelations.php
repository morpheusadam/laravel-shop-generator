<?php

namespace Modules\Product\Entities\Concerns;

use Modules\Tag\Entities\Tag;
use Modules\Brand\Entities\Brand;
use Modules\Tax\Entities\TaxClass;
use Modules\Option\Entities\Option;
use Modules\Review\Entities\Review;
use Modules\Category\Entities\Category;
use Modules\Variation\Entities\Variation;
use Modules\Product\Entities\ProductVariant;
use Modules\Attribute\Entities\ProductAttribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait EloquentRelations
{
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class)->withDefault();
    }


    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }


    public function taxClass(): BelongsTo
    {
        return $this->belongsTo(TaxClass::class)->withDefault();
    }


    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }


    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }


    public function variations(): BelongsToMany
    {
        return $this->belongsToMany(Variation::class, 'product_variations')
            ->orderBy('position')
            ->withTrashed();
    }


    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }


    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'product_options')
            ->orderBy('position')
            ->withTrashed();
    }


    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(static::class, 'related_products', 'product_id', 'related_product_id');
    }


    public function upSellProducts(): BelongsToMany
    {
        return $this->belongsToMany(static::class, 'up_sell_products', 'product_id', 'up_sell_product_id');
    }


    public function crossSellProducts(): BelongsToMany
    {
        return $this->belongsToMany(static::class, 'cross_sell_products', 'product_id', 'cross_sell_product_id');
    }
}
