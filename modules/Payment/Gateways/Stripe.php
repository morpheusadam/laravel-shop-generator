<?php

namespace Modules\Payment\Gateways;

use Stripe\Coupon;
use Stripe\TaxRate;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Modules\Order\Entities\Order;
use Modules\Payment\GatewayInterface;
use Stripe\Exception\ApiErrorException;
use Modules\Payment\Responses\StripeResponse;

class Stripe implements GatewayInterface
{
    public $label;
    public $description;


    public function __construct()
    {
        $this->label = setting('stripe_label');
        $this->description = setting('stripe_description');
    }


    public function purchase(Order $order, Request $request): StripeResponse
    {
        \Stripe\Stripe::setApiKey(setting('stripe_secret_key'));

        $response = Session::create(
            array_merge(
                [
                    'client_reference_id' => uniqid('ref_'),
                    'line_items' => $this->prepareLineItems($order),
                    'mode' => 'payment',
                    'success_url' => $this->getRedirectUrl($order),
                    'cancel_url' => $this->getPaymentFailedUrl($order),
                ],
                $this->getShippingOptions($order),
                $this->getDiscounts($order)
            )
        );


        return new StripeResponse($order, $response);
    }


    private function getShippingOptions($order): array
    {
        if ($order->hasShippingMethod()) {
            return [
                'shipping_options' => [
                    [
                        'shipping_rate_data' => [
                            'display_name' => $order->shipping_method,
                            'type' => 'fixed_amount',
                            'fixed_amount' => [
                                'amount' => (int)$order->shipping_cost->amount() * 100,
                                'currency' => currency(),
                            ],
                        ],
                    ],
                ],
            ];
        }

        return [];
    }


    /**
     * @throws ApiErrorException
     */
    private function getDiscounts($order): array
    {
        if ($order->discount->amount() > 0) {
            $coupon = Coupon::create([
                'currency' => currency(),
                'amount_off' => (int)$order->discount->amount() * 100,
            ]);

            return [
                'discounts' => [
                    [
                        'coupon' => $coupon->id,
                    ],
                ],
            ];
        }


        return [];
    }


    public function complete(Order $order): StripeResponse
    {
        return new StripeResponse($order, request());
    }


    /**
     * @throws ApiErrorException
     */
    public function prepareLineItems($order): array
    {
        $lineItems = [];

        foreach ($order->products as $orderProduct) {
            $lineItems[] = $this->prepareLineItem($orderProduct);
        }

        return $lineItems;
    }


    /**
     * @throws ApiErrorException
     */
    private function prepareLineItem($orderProduct): array
    {
        $item = [];
        $item['price_data'] = [
            'currency' => currency(),
            'unit_amount' => (int)$orderProduct->unit_price->convertToCurrentCurrency()->amount() * 100,
            'product_data' => [
                'name' => $orderProduct->product->name,
                'images' => [
                    $orderProduct->product_variant?->base_image?->path
                     ?? $orderProduct->product?->base_image?->path
                     ?? asset('build/assets/image-placeholder.png')
                ],
            ],
        ];
        $item['quantity'] = $orderProduct->qty;

        $tax = $orderProduct->product->taxClass
            ->findTaxRate(
                request('billing'),
                request('shipping')
            );

        if ($tax) {
            $taxRate = TaxRate::create([
                'display_name' => 'Tax',
                'percentage' => $tax->rate,
                'inclusive' => false,
            ])->id;
            $item['tax_rates'] = [$taxRate];
        }

        return $item;
    }


    private function getRedirectUrl($order)
    {
        return route('checkout.complete.store', ['orderId' => $order->id, 'paymentMethod' => 'stripe', 'reference' => uniqid('stripe_')]);
    }


    private function getPaymentFailedUrl($order)
    {
        return route('checkout.payment_canceled.store', ['orderId' => $order->id, 'paymentMethod' => 'stripe']);
    }
}
