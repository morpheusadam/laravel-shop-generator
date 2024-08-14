<?php

namespace Modules\Payment\Responses;

use Modules\Order\Entities\Order;
use Modules\Payment\ShouldRedirect;
use Modules\Payment\GatewayResponse;
use Modules\Payment\HasTransactionReference;

class FlutterwaveResponse extends GatewayResponse implements ShouldRedirect, HasTransactionReference
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


    public function getRedirectUrl()
    {
        return $this->clientResponse['redirect_url'];
    }


    public function getTransactionReference()
    {
        return $this->clientResponse['tx_ref'];
    }


    public function toArray()
    {
        return (array)$this->clientResponse;
    }
}
