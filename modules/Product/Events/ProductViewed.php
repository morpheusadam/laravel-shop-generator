<?php

namespace Modules\Product\Events;

use Modules\Product\Entities\Product;
use Illuminate\Queue\SerializesModels;

class ProductViewed
{
    use SerializesModels;

    /**
     * The product entity.
     *
     * @var Product
     */
    public $product;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }
}
