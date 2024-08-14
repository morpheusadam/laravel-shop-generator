<?php

namespace Modules\Payment\Responses;

use Modules\Order\Entities\Order;
use Modules\Payment\GatewayResponse;
use Modules\Payment\HasTransactionReference;

class AuthorizenetResponse extends GatewayResponse implements HasTransactionReference
{
    private $order;

    private $clientResponse;


    public function __construct(Order $order, object $clientResponse)
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
        return $this->order->toArray() + [
                'token' => $this->clientResponse->token,
            ];
    }
}
