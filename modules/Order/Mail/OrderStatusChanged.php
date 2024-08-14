<?php

namespace Modules\Order\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Modules\Media\Entities\File;
use Modules\Order\Entities\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderStatusChanged extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $heading;
    public $text;


    /**
     * Create a new message instance.
     *
     * @param Order $order
     *
     * @return void
     */
    public function __construct($order)
    {
        app()->setLocale($order->locale);

        $this->heading = $this->getHeading($order);
        $this->text = $this->getText($order);
    }


    public function getHeading($order)
    {
        return trans('storefront::mail.hello', ['name' => $order->customer_first_name]);
    }


    public function getText($order)
    {
        return trans('order::mail.your_order_status_changed_text', [
            'order_id' => $order->id,
            'status' => mb_strtolower($order->status()),
        ]);
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('order::mail.your_order_status_changed_subject'))
            ->view("storefront::emails.{$this->getViewName()}", [
                'logo' => File::findOrNew(setting('storefront_mail_logo'))->path,
            ]);
    }


    private function getViewName()
    {
        return 'text' . (is_rtl() ? '_rtl' : '');
    }
}
