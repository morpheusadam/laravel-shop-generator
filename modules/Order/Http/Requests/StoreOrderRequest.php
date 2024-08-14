<?php

namespace Modules\Order\Http\Requests;

use Exception;
use Modules\Support\Country;
use Modules\Cart\Facades\Cart;
use Illuminate\Validation\Rule;
use Modules\Payment\Facades\Gateway;
use Modules\Core\Http\Requests\Request;
use Modules\Checkout\Exceptions\CheckoutException;

class StoreOrderRequest extends Request
{
    /**
     * Available attributes.
     *
     * @var string
     */
    protected $availableAttributes = 'checkout::attributes';


    /**
     * Validate the class instance.
     *
     * @return void
     * @throws Exception
     */
    public function prepareForValidation()
    {
        if (!Cart::allItemsAreVirtual() && !$this->input('shipping_method')) {
            throw new CheckoutException(trans('checkout::messages.no_shipping_method'));
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge(
            [
                'customer_email' => ['required', 'email', $this->emailUniqueRule()],
                'customer_phone' => ['required'],
                'create_an_account' => 'boolean',
                'password' => 'required_if:create_an_account,1',
                'ship_to_a_different_address' => 'boolean',
                'payment_method' => ['required', Rule::in(Gateway::names())],
                'terms_and_conditions' => 'accepted',
                'shipping_method' => Cart::allItemsAreVirtual() ? 'nullable' : 'required',
            ],
            $this->billingAddressRules(),
            $this->shippingAddressRules()
        );
    }


    private function emailUniqueRule()
    {
        return $this->create_an_account ? Rule::unique('users', 'email') : null;
    }


    private function billingAddressRules()
    {
        return [
            'billing.first_name' => 'required',
            'billing.last_name' => 'required',
            'billing.address_1' => 'required',
            'billing.city' => 'required',
            'billing.zip' => 'required',
            'billing.country' => ['required', Rule::in(Country::supportedCodes())],
            'billing.state' => 'required',
        ];
    }


    private function shippingAddressRules()
    {
        return [
            'shipping.first_name' => 'required_if:ship_to_a_different_address,1',
            'shipping.last_name' => 'required_if:ship_to_a_different_address,1',
            'shipping.address_1' => 'required_if:ship_to_a_different_address,1',
            'shipping.city' => 'required_if:ship_to_a_different_address,1',
            'shipping.zip' => 'required_if:ship_to_a_different_address,1',
            'shipping.country' => ['required_if:ship_to_a_different_address,1', Rule::in(Country::supportedCodes())],
            'shipping.state' => 'required_if:ship_to_a_different_address,1',
        ];
    }
}
