<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Variation\Entities\Variation;
use Modules\Variation\Entities\VariationValue;

class OrderProductVariation extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['variation', 'values'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function variation()
    {
        return $this->belongsTo(Variation::class)->withTrashed();
    }


    public function getNameAttribute()
    {
        return $this->variation->name;
    }


    public function storeValues($values)
    {
        $this->values()->attach($values->pluck('id'));
    }


    public function values()
    {
        return $this->belongsToMany(VariationValue::class, 'order_product_variation_values')
            ->using(OrderProductVariationValue::class);
    }
}
