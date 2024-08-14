<?php

namespace Modules\Payment\Gateways;

use Exception;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Modules\Payment\GatewayInterface;
use Stripe\Exception\ApiErrorException;
use Modules\Payment\Responses\PayFastResponse;

class PayFast implements GatewayInterface
{
    public $label;
    public $description;


    public function __construct()
    {
        $this->label = setting('payfast_label');
        $this->description = setting('payfast_description');
    }


    /**
     * @throws ApiErrorException|Exception
     */
    public function purchase(Order $order, Request $request)
    {
        if (currency() !== 'ZAR') {
            throw new Exception(trans('payment::messages.only_supports_zar'));
        }

        $reference = uniqid('ref_');

        $data = [
            'merchant_id' => setting('payfast_merchant_id'),
            'merchant_key' => setting('payfast_merchant_key'),
            'return_url' => $this->getRedirectUrl($order, $reference),
            'cancel_url' => $this->getPaymentFailedUrl($order),
            'name_first' => $order->customer_first_name,
            'name_last' => $order->customer_last_name,
            'email_address' => $order->customer_email,
            'm_payment_id' => $reference,
            'amount' => number_format(
                sprintf('%.2f', $order->total->convertToCurrentCurrency()->amount()),
                2,
                '.',
                ''
            ),
            'item_name' => 'Order#' . $order->id,
        ];

        $signature = self::generateSignature($data, setting('payfast_passphrase'));
        $data['signature'] = $signature;

        return new PayFastResponse($order, $data);
    }


    public function complete(Order $order)
    {
        return new PayFastResponse($order, request());
    }


    /**
     * @param array $data
     * @param null $passPhrase
     *
     * @return string
     */
    private function generateSignature($data, $passPhrase = null)
    {
        # Create parameter string
        $pfOutput = '';
        foreach ($data as $key => $val) {
            if ($val !== '') {
                $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
            }
        }
        # Remove last ampersand
        $getString = substr($pfOutput, 0, -1);
        if ($passPhrase !== null) {
            $getString .= '&passphrase=' . urlencode(trim($passPhrase));
        }

        return md5($getString);
    }


    private function getRedirectUrl($order, $reference)
    {
        return route('checkout.complete.store', [
            'orderId' => $order->id,
            'paymentMethod' => 'payfast',
            'reference' => $reference,
        ]);
    }


    private function getPaymentFailedUrl($order)
    {
        return route('checkout.payment_canceled.store', [
            'orderId' => $order->id,
            'paymentMethod' => 'payfast',
        ]);
    }
}
