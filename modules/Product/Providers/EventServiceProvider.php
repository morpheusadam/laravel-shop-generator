<?php

namespace Modules\Product\Providers;

use Modules\Product\Entities\Product;
use Modules\Product\Events\ProductViewed;
use Modules\Product\Listeners\StoreSearchTerm;
use Modules\Product\Events\ShowingProductList;
use Modules\Product\Listeners\SaveProductVariants;
use Modules\Product\Listeners\AddToRecentlyViewed;
use Modules\Product\Listeners\IncrementProductView;
use Modules\Product\Listeners\SaveProductVariations;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ProductViewed::class => [
            IncrementProductView::class,
            AddToRecentlyViewed::class,
        ],
        ShowingProductList::class => [
            StoreSearchTerm::class,
        ],
    ];


    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        Product::saved(SaveProductVariations::class);
        Product::saved(SaveProductVariants::class);
    }
}
