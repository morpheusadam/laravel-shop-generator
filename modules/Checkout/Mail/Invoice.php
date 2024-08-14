<?php

namespace Modules\Checkout\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Media\Entities\File;
use Modules\Order\Entities\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invoice extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * The instance of the order.
     *
     * @var Order
     */
    public $order;


    /**
     * Create a new message instance.
     *
     * @param Order $order
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        app()->setLocale($this->order->locale);

        $this->order->load('products');

        return $this->subject(trans('storefront::invoice.subject', ['id' => $this->order->id]))
            ->view("storefront::emails.{$this->getViewName()}", [
                'logo' => File::findOrNew(setting('storefront_mail_logo'))->path,
            ]);
    }


    private function getViewName()
    {
        return 'invoice' . (is_rtl() ? '_rtl' : '');
    }
}
