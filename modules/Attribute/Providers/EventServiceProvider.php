<?php

namespace Modules\Attribute\Providers;

use Modules\Product\Entities\Product;
use Modules\Attribute\Listeners\SaveProductAttributes;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Product::saved(SaveProductAttributes::class);
    }
}
