<?php

namespace Modules\Payment\Gateways;

use stdClass;
use Exception;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Modules\Payment\GatewayInterface;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\constants\ANetEnvironment;
use net\authorize\api\controller as AnetController;
use Modules\Payment\Responses\AuthorizenetResponse;

class AuthorizeNet implements GatewayInterface
{
    public const SUPPORTED_CURRENCIES = ['CHF', 'DKK', 'EUR', 'GBP', 'NOK', 'PLN', 'SEK', 'USD', 'AUD', 'NZD', 'CAD'];
    public $label;
    public $description;


    public function __construct()
    {
        $this->label = setting('authorizenet_label');
        $this->description = setting('authorizenet_description');
    }


    /**
     * @throws Exception
     */
    public function purchase(Order $order, Request $request)
    {
        if (!in_array(currency(), self::SUPPORTED_CURRENCIES)) {
            throw new Exception(trans('payment::messages.currency_not_supported'));
        }

        $response = $this->getAnAcceptPaymentPage($order);

        return new AuthorizenetResponse($order, $response);
    }


    public function complete(Order $order)
    {
        return new AuthorizenetResponse($order, request());
    }


    /**
     * @throws Exception
     */
    private function getAnAcceptPaymentPage(Order $order)
    {
        define('AUTHORIZENET_LOG_FILE', 'phplog');
        $reference = 'ref' . time();

        $callbackUrl = config('app.env') === 'local' ? 'https://example.com/receipt' : $this->getRedirectUrl($order, $reference);
        $cancelUrl = config('app.env') === 'local' ? 'https://example.com/cancel' : route('checkout.create');

        //encode ampersand of the query parameter to make it compatible for api usage
        $encodedCallbackUrl = str_replace('&', '%26', $callbackUrl);

        /* Create a merchantAuthenticationType object with authentication details
         retrieved from the constants file */
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(setting('authorizenet_merchant_login_id'));
        $merchantAuthentication->setTransactionKey(setting('authorizenet_merchant_transaction_key'));

        //create a transaction
        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType('authCaptureTransaction');
        $transactionRequestType->setAmount($order->total->convertToCurrentCurrency()->amount());
        $transactionRequestType->setCurrencyCode(currency());

        // Set Hosted Form options
        $hostedPaymentButtonOptions = new AnetAPI\SettingType();
        $hostedPaymentButtonOptions->setSettingName('hostedPaymentButtonOptions');
        $hostedPaymentButtonOptions->setSettingValue("{\"text\": \"Pay\"}");

        $hostedPaymentOrderOptions = new AnetAPI\SettingType();
        $hostedPaymentOrderOptions->setSettingName('hostedPaymentOrderOptions');
        $hostedPaymentOrderOptions->setSettingValue("{\"show\": false}");

        $hostedPaymentReturnOptions = new AnetAPI\SettingType();
        $hostedPaymentReturnOptions->setSettingName('hostedPaymentReturnOptions');

        $hostedPaymentReturnOptions->setSettingValue("{\"url\": \"$encodedCallbackUrl\", \"cancelUrl\": \"$cancelUrl\", \"showReceipt\": true}");

        // Build transaction request
        $request = new AnetAPI\GetHostedPaymentPageRequest();
        $request->setMerchantAuthentication($merchantAuthentication);

        // Set the transaction's refId
        $request->setRefId($reference);

        $request->setTransactionRequest($transactionRequestType);

        $request->addToHostedPaymentSettings($hostedPaymentButtonOptions);
        $request->addToHostedPaymentSettings($hostedPaymentOrderOptions);
        $request->addToHostedPaymentSettings($hostedPaymentReturnOptions);

        //execute request
        $controller = new AnetController\GetHostedPaymentPageController($request);
        $response = $controller->executeWithApiResponse(setting('authorizenet_test_mode') ? ANetEnvironment::SANDBOX : ANetEnvironment::PRODUCTION);

        $extendedResponse = new stdClass();

        if ($response != null && $response->getMessages()->getResultCode() == 'Ok') {
            $extendedResponse->token = $response->getToken();
        } else {
            $errorMessage = $response->getMessages()->getMessage();

            throw new Exception(trans('payment::messages.payment_gateway_error'));
        }

        $extendedResponse->data = $response;
        $extendedResponse->reference = $reference;

        return $extendedResponse;
    }


    private function getRedirectUrl($order, $reference)
    {
        return route('checkout.complete.store', ['orderId' => $order->id, 'paymentMethod' => 'authorizenet', 'reference' => $reference]);
    }
}
