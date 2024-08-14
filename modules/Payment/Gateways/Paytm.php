<?php

namespace Modules\Payment\Gateways;

use Exception;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Modules\Payment\GatewayInterface;
use Modules\Payment\Responses\PaytmResponse;
use Paytm\JsCheckout\Facades\Paytm as PaytmAlias;

class Paytm implements GatewayInterface
{
    public $label;
    public $description;


    public function __construct()
    {
        $this->label = setting('paytm_label');
        $this->description = setting('paytm_description');

        config(
            [
                'services.paytm.env' => setting('paytm_test_mode') ? 'staging' : 'production',
                'services.paytm.merchant_id' => setting('paytm_merchant_id'),
                'services.paytm.merchant_key' => setting('paytm_merchant_key'),
                'services.paytm.merchant_website' => setting('paytm_test_mode') ? 'WEBSTAGING' : 'DEFAULT',
                'services.paytm.channel' => 'WEB',
                'services.paytm.industry_type' => 'Retail',
            ]
        );
    }


    /**
     * @throws Exception
     */
    public function purchase(Order $order, Request $request)
    {
        if (currency() !== 'INR') {
            throw new Exception(trans('payment::messages.only_supports_inr'));
        }

        $paytm = PaytmAlias::with('receive');
        $paytm->prepare(
            [
                'order' => $order->id,
                'user' => "$order->customer_first_name $order->customer_last_name",
                'mobile_number' => $order->customer_phone,
                'email' => $order->customer_email,
                'amount' => $order->total->convertToCurrentCurrency()->round()->amount(),
                'callback_url' => $this->getRedirectUrl($order),
            ]
        );
        $response = $paytm->receive();

        return new PaytmResponse($order, $response);
    }


    public function complete(Order $order)
    {
        return new PaytmResponse($order, request()->all());
    }


    private function getRedirectUrl($order)
    {
        return route('checkout.complete.store', ['orderId' => $order->id, 'paymentMethod' => 'paytm']);
    }
}
