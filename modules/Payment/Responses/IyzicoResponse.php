<?php

namespace Modules\Payment\Responses;

use Modules\Order\Entities\Order;
use Modules\Payment\GatewayResponse;
use Modules\Payment\HasTransactionReference;

class IyzicoResponse extends GatewayResponse implements HasTransactionReference
{
    private Order $order;
    private array|object $clientResponse;


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


    public function toArray(): array
    {
        return [
            'orderId' => $this->getOrderId(),
            'redirectUrl' => $this->clientResponse->getPaymentPageUrl(),
        ];
    }
}
