<?php

namespace Modules\Payment\Responses;

use Modules\Order\Entities\Order;
use Modules\Payment\ShouldRedirect;
use Modules\Payment\GatewayResponse;
use Modules\Payment\HasTransactionReference;

class MercadoPagoResponse extends GatewayResponse implements ShouldRedirect, HasTransactionReference
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


    public function getRedirectUrl()
    {
        return $this->clientResponse->back_urls->success;
    }


    public function getTransactionReference()
    {
        return $this->clientResponse->external_reference;
    }


    public function toArray()
    {
        return [
            'publicKey' => setting('mercadopago_public_key'),
            'currentLocale' => locale(),
            'preferenceId' => $this->clientResponse->id,
        ];
    }
}
