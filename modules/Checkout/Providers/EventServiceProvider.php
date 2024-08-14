<?php

namespace Modules\Checkout\Providers;

use Modules\Checkout\Events\OrderPlaced;
use Modules\Checkout\Listeners\SendNewOrderSms;
use Modules\Checkout\Listeners\UpdateOrderStatus;
use Modules\Checkout\Listeners\SendNewOrderEmails;
use Modules\Checkout\Listeners\AddPlacedOrderToSession;
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
            UpdateOrderStatus::class,
            SendNewOrderEmails::class,
            SendNewOrderSms::class,
            AddPlacedOrderToSession::class,
        ],
    ];
}
