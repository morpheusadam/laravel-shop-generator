@extends('storefront::public.layout')

@section('title', trans('storefront::checkout.checkout'))

@section('content')
    <checkout-create
        customer-email="{{ auth()->user()->email ?? null }}"
        customer-phone="{{ auth()->user()->phone ?? null }}"
        :addresses="{{ $addresses }}"
        :default-address="{{ $defaultAddress }}"
        :gateways="{{ $gateways }}"
        :countries="{{ json_encode($countries) }}"
        inline-template
    >
        <section class="checkout-wrap">
            <div class="container">
                <template v-if="cartIsNotEmpty">
                    @include('storefront::public.cart.index.steps')

                    <form class="checkout-form" @input="errors.clear($event.target.name)">
                        <div class="checkout-inner">
                            <div class="checkout-left">
                                @include('storefront::public.checkout.create.form.account_details')
                                @include('storefront::public.checkout.create.form.billing_details')
                                @include('storefront::public.checkout.create.form.shipping_details')
                                @include('storefront::public.checkout.create.form.order_note')
                            </div>

                            <div class="checkout-right">
                                @include('storefront::public.checkout.create.payment')
                                @include('storefront::public.checkout.create.shipping')
                            </div>
                        </div>

                        @include('storefront::public.checkout.create.order_summary')
                    </form>

                    @if (setting('authorizenet_enabled'))
                        <form ref="authorizeNetForm" method="post"
                            action="{{ setting('authorizenet_test_mode') ? 'https://test.authorize.net/payment/payment' : 'https://accept.authorize.net/payment/payment' }}"
                            v-if="authorizeNetToken">
                            <input type="hidden" name="token" :value="authorizeNetToken" />
                            <button type="submit"></button>
                        </form>
                    @endif

                    @if (setting('payfast_enabled'))
                        <form ref="payFastForm" action="https://sandbox.payfast.co.za/eng/process" method="post">
                            <div v-for="(value, name, index) in payFastFormFields" :key="index">
                                <input :name="name" type="hidden" :value="value" />
                            </div>
                        </form>
                    @endif
                </template>

                @include('storefront::public.cart.index.empty_cart')
            </div>
        </section>
    </checkout-create>
@endsection

@push('pre-scripts')
    @if (setting('paypal_enabled'))
        <script
            src="https://www.paypal.com/sdk/js?client-id={{ setting('paypal_client_id') }}&currency={{ setting('default_currency') }}&disable-funding=credit,card,venmo,sepa,bancontact,eps,giropay,ideal,mybank,p24,p24">
        </script>
    @endif

    @if (setting('paytm_enabled'))
        @if (setting('paytm_test_mode'))
            <script src="https://securegw-stage.paytm.in/merchantpgpui/checkoutjs/merchants/{{ setting('paytm_merchant_id') }}.js">
            </script>
        @else
            <script src="https://securegw.paytm.in/merchantpgpui/checkoutjs/merchants/{{ setting('paytm_merchant_id') }}.js">
            </script>
        @endif
    @endif

    @if (setting('razorpay_enabled'))
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    @endif

    @if (setting('mercadopago_enabled'))
        <script src="https://sdk.mercadopago.com/js/v2"></script>
    @endif

    @if (setting('flutterwave_enabled'))
        <script src="https://checkout.flutterwave.com/v3.js"></script>
    @endif

    @if (setting('paystack_enabled'))
        <script src="https://js.paystack.co/v1/inline.js"></script>
    @endif

    @if (setting('payfast_enabled'))
        <script src="https://www.payfast.co.za/onsite/engine.js"></script>
    @endif
@endpush
