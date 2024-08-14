<?php

namespace Modules\Option\Providers;

use Modules\Product\Entities\Product;
use Modules\Option\Listeners\SaveProductOptions;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Product::saved(SaveProductOptions::class);
    }
}
