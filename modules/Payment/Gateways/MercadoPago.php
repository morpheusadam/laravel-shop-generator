<?php

namespace Modules\Payment\Gateways;

use Exception;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use MercadoPago\SDK as MercadoPagoSDK;
use Modules\Payment\GatewayInterface;
use MercadoPago\Item as MercadoPagoItem;
use Modules\Payment\Responses\MercadoPagoResponse;
use MercadoPago\Preference as MercadoPagoPreference;

class MercadoPago implements GatewayInterface
{
    public const CURRENCIES = ['UYU', 'PEN', 'COP', 'MXN', 'CLP', 'BRL', 'ARS'];
    public $label;
    public $description;


    public function __construct()
    {
        $this->label = setting('mercadopago_label');
        $this->description = setting('mercadopago_description');
    }


    /**
     * @throws Exception
     */
    public function purchase(Order $order, Request $request)
    {
        $this->init();

        if (!in_array(currency(), $this->getSupportedCurrencies())) {
            throw new Exception(trans('payment::messages.currency_not_supported'));
        }

        $preference = new MercadoPagoPreference();

        try {
            $preference->items = $this->prepareItems($order);
            $preference->binary_mode = true;

            $preference->back_urls = [
                'success' => $this->getRedirectUrl($order),
                'failure' => $this->getPaymentFailedUrl($order),
            ];

            $preference->auto_return = 'approved';
            $preference->external_reference = 'ref' . time();

            $preference->save();
        } catch (Exception $e) {
            throw new Exception(trim(trim($e->getMessage()), '"'));
        } finally {
            if (!$preference->id) {
                throw new Exception(trans('payment::messages.payment_gateway_error'));
            }
        }

        return new MercadoPagoResponse($order, $preference);
    }


    public function init()
    {
        if (setting('mercadopago_enabled')) {
            MercadoPagoSDK::setAccessToken(setting('mercadopago_access_token'));
        }
    }


    public function getSupportedCurrencies()
    {
        return [setting('mercadopago_supported_currency'), 'USD'];
    }


    public function prepareItems($order): array
    {
        $items = $this->prepareProductItems($order->products);
        $taxItem = $this->prepareTaxItem($order);

        if (!empty($taxItem->unit_price)) {
            $items[] = $this->prepareTaxItem($order);
        }

        $discountItem = $this->prepareDiscountItem($order);

        if (!empty($discountItem->unit_price)) {
            $items[] = $this->prepareDiscountItem($order);
        }

        return $items;
    }


    public function prepareProductItems($orderProducts): array
    {
        $productItems = [];

        $orderProducts->each(function ($product) use (&$productItems) {
            $productItem = $this->prepareProductItem($product);
            if (!empty($productItem->unit_price)) {
                $productItems[] = $productItem;
            }
        });

        return $productItems;
    }


    public function prepareProductItem($orderProduct)
    {
        $item = new MercadoPagoItem();
        $item->title = $orderProduct->product->name;
        $item->quantity = $orderProduct->qty;
        $item->currency_id = currency();
        $item->unit_price = (float)$orderProduct->unit_price->convertToCurrentCurrency()->amount();

        return $item;
    }


    public function prepareTaxItem($order)
    {
        $item = new MercadoPagoItem();
        $item->title = trans('payment::order.tax');
        $item->quantity = 1;
        $item->currency_id = currency();
        $item->unit_price = (float)$order
            ->totalTax()
            ->convertToCurrentCurrency()
            ->amount();

        return $item;
    }


    public function prepareDiscountItem($order)
    {
        $item = new MercadoPagoItem();
        $item->title = trans('payment::order.discount');
        $item->quantity = 1;
        $item->currency_id = currency();

        $item->unit_price = (float)(-1 * $order->discount->convertToCurrentCurrency()->amount());

        return $item;
    }


    public function complete(Order $order)
    {
        return new MercadoPagoResponse($order, request());
    }


    private function getRedirectUrl($order)
    {
        return route('checkout.complete.store', ['orderId' => $order->id, 'paymentMethod' => 'mercadopago']);
    }


    private function getPaymentFailedUrl($order)
    {
        return route('checkout.payment_canceled.store', ['orderId' => $order->id, 'paymentMethod' => 'mercadopago']);
    }
}
