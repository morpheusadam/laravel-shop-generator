<?php

namespace Modules\Product\Listeners;

use Modules\Product\Entities\Product;
use Modules\Product\Events\ProductViewed;

class IncrementProductView
{
    /**
     * Handle the event.
     *
     * @param ProductViewed $event
     *
     * @return void
     */
    public function handle(ProductViewed $event)
    {
        Product::withoutTimestamps(fn () => $event->product->increment('viewed'));
    }
}
