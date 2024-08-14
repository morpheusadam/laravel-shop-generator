<?php

namespace Modules\Product\Entities\Concerns;

trait QueryScopes
{
    public function scopeForCard($query): void
    {
        $query
            ->withName()
            ->withBaseImage()
            ->withPrice()
            ->withCount('options')
            ->with('reviews')
            ->withStock()
            ->withNew()
            ->addSelect(
                [
                    'products.id',
                    'products.slug',
                ]
            );
    }


    public function scopeWithName($query): void
    {
        $query->with('translations:id,product_id,locale,name');
    }


    public function scopeWithStock($query): void
    {
        $query->addSelect(
            [
                'products.in_stock',
                'products.manage_stock',
                'products.qty',
            ]
        );
    }


    public function scopeWithNew($query): void
    {
        $query->addSelect(
            [
                'products.new_from',
                'products.new_to',
            ]
        );
    }


    public function scopeWithPrice($query): void
    {
        $query->addSelect(
            [
                'products.price',
                'products.special_price',
                'products.special_price_type',
                'products.selling_price',
                'products.special_price_start',
                'products.special_price_end',
            ]
        );
    }


    public function scopeWithBaseImage($query): void
    {
        $query->with([
            'files' => function ($q) {
                $q->wherePivot('zone', 'base_image');
            },
        ]);
    }
}
