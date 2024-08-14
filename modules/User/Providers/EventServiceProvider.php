<?php

namespace Modules\User\Providers;

use Modules\User\Listeners\SendWelcomeSms;
use Modules\User\Events\CustomerRegistered;
use Modules\User\Listeners\SendWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CustomerRegistered::class => [
            SendWelcomeEmail::class,
            SendWelcomeSms::class,
        ],
    ];
}
