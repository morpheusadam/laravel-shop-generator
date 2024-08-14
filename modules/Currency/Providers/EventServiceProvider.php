<?php

namespace Modules\Currency\Providers;

use Modules\Setting\Events\SettingSaved;
use Modules\Currency\Listeners\CreateCurrencyRates;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        SettingSaved::class => [
            CreateCurrencyRates::class,
        ],
    ];
}
