<?php

namespace Modules\Checkout\Listeners;

use Modules\Checkout\Events\OrderPlaced;

class AddPlacedOrderToSession
{
    /**
     * Handle the event.
     *
     * @param OrderPlaced $event
     *
     * @return void
     */
    public function handle($event)
    {
        session()->flash('placed_order', $event->order);
    }
}
