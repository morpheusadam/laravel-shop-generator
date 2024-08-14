<?php

namespace Modules\Cart\Providers;

use Modules\Cart\Listeners\ClearCart;
use Modules\Checkout\Events\OrderPlaced;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderPlaced::class => [
            ClearCart::class,
        ],
    ];
}
