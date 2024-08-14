<?php

namespace Modules\Product\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Collection;

class ShowingProductList
{
    use SerializesModels;

    /**
     * Collection of product.
     *
     * @var Collection
     */
    public $products;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($products)
    {
        $this->products = $products;
    }
}
