<?php

namespace Modules\Payment\Responses;

use Stripe\PaymentIntent;
use Modules\Order\Entities\Order;
use Modules\Payment\GatewayResponse;
use Modules\Payment\HasTransactionReference;

class StripeResponse extends GatewayResponse implements HasTransactionReference
{
    private $order;
    private $clientResponse;


    public function __construct(Order $order, array|object $clientResponse)
    {
        $this->order = $order;
        $this->clientResponse = $clientResponse;
    }


    public function getOrderId()
    {
        return $this->order->id;
    }


    public function getTransactionReference()
    {
        return $this->clientResponse->query('reference');
    }


    public function toArray()
    {
        return ['redirectUrl' => $this->clientResponse->url];
    }
}
