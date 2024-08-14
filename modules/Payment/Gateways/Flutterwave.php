<?php

namespace Modules\Payment\Gateways;

use stdClass;
use Exception;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Modules\Payment\GatewayInterface;
use Modules\Payment\Responses\FlutterwaveResponse;

class Flutterwave implements GatewayInterface
{
    public const SUPPORTED_CURRENCIES = ['GBP', 'CAD', 'XAF', 'CLP', 'COP', 'EGP', 'EUR', 'GHS', 'GNF', 'KES', 'MWK', 'MAD', 'NGN', 'RWF', 'SLL', 'STD', 'ZAR', 'TZS', 'UGX', 'USD', 'XOF', 'ZMW'];
    public const PAYMENT_OPTIONS = ['credit', 'ussd', 'nqr', 'barter', 'mobilemoneyzambia', 'mobilemoneyrwanda', 'mobilemoneyuganda', 'mobilemoneyfranco', 'mobilemoneyghana', 'mpesa', 'banktransfer', 'account', 'card'];
    public $label;
    public $description;


    public function __construct()
    {
        $this->label = setting('flutterwave_label');
        $this->description = setting('flutterwave_description');
    }


    /**
     * @throws Exception
     */
    public function purchase(Order $order, Request $request)
    {
        if (!in_array(currency(), self::SUPPORTED_CURRENCIES)) {
            throw new Exception(trans('payment::messages.currency_not_supported'));
        }

        $response = new stdClass();
        $response->public_key = setting('flutterwave_public_key');
        $response->currency = currency();
        $response->order_id = $order->id;
        $response->amount = $order->total->convertToCurrentCurrency()->amount();
        $response->tx_ref = 'ref' . time();
        $response->payment_options = self::PAYMENT_OPTIONS;
        $response->redirect_url = $this->getRedirectUrl($order);

        return new FlutterwaveResponse($order, $response);
    }


    public function complete(Order $order)
    {
        return new FlutterwaveResponse($order, request()->all());
    }


    private function getRedirectUrl($order)
    {
        return route('checkout.complete.store', ['orderId' => $order->id, 'paymentMethod' => 'flutterwave']);
    }
}
