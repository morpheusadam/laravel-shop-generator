<?php

namespace Modules\Setting\Providers;

use Modules\Setting\Events\SettingSaved;
use Modules\Setting\Listeners\ClearSettingCache;
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
            ClearSettingCache::class,
        ],
    ];
}
