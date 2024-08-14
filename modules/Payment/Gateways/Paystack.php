<?php

namespace Modules\Payment\Gateways;

use Exception;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Modules\Payment\GatewayInterface;
use Modules\Payment\Responses\PaystackResponse;

class Paystack implements GatewayInterface
{
    const SUPPORTED_CURRENCIES = ['NGN', 'GHS', 'USD', 'ZAR'];
    public $label;
    public $description;


    public function __construct()
    {
        $this->label = setting('paystack_label');
        $this->description = setting('paystack_description');
    }


    /**
     * @throws Exception
     */
    public function purchase(Order $order, Request $request)
    {
        if (!in_array(currency(), self::SUPPORTED_CURRENCIES)) {
            throw new Exception(trans('payment::messages.currency_not_supported'));
        }

        return new PaystackResponse($order);
    }


    public function complete(Order $order)
    {
        return new PaystackResponse($order);
    }
}
