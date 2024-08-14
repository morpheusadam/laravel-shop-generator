<?php

namespace Modules\Payment;

use JsonSerializable;

abstract class GatewayResponse implements JsonSerializable
{
    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }


    public function jsonSerialize()
    {
        return $this->toArray();
    }


    public function toArray()
    {
        $data = ['orderId' => $this->getOrderId()];

        if ($this instanceof ShouldRedirect) {
            $data['redirectUrl'] = $this->getRedirectUrl();
        }

        return $data;
    }


    abstract public function getOrderId();
}
