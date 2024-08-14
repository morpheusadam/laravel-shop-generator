<?php

namespace Modules\Payment\Responses;

use Modules\Order\Entities\Order;
use Modules\Payment\GatewayResponse;
use Modules\Payment\HasTransactionReference;

class PayFastResponse extends GatewayResponse implements HasTransactionReference
{
    private $order;
    private $data;


    public function __construct(Order $order, $data)
    {
        $this->order = $order;
        $this->data = $data;
    }


    public function getOrderId()
    {
        return $this->order->id;
    }


    public function getTransactionReference()
    {
        return $this->data->query('reference');
    }


    public function toArray()
    {
        return [
            'formFields' => $this->data,
        ];
    }
}
