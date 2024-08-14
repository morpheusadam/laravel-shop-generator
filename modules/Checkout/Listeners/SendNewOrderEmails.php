<?php

namespace Modules\Checkout\Listeners;

use Exception;
use Modules\Checkout\Mail\Invoice;
use Modules\Checkout\Mail\NewOrder;
use Illuminate\Support\Facades\Mail;
use Modules\Checkout\Events\OrderPlaced;

class SendNewOrderEmails
{
    /**
     * Handle the event.
     *
     * @param OrderPlaced $event
     *
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        try {
            if (setting('admin_order_email')) {
                Mail::to(setting('store_email'))
                    ->send(new NewOrder($event->order));
            }

            if (setting('invoice_email')) {
                Mail::to($event->order->customer_email)
                    ->send(new Invoice($event->order));
            }
        } catch (Exception) {
            //TODO:handle exception
        }
    }
}
