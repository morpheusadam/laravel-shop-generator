<div class="payment-method">
    <h4 class="title">{{ trans('storefront::checkout.payment_method') }}</h4>

    <div class="payment-method-form">
        <div class="form-group">
            <div class="form-radio" v-for="(gateway, name, index) in gateways" :key="index">
                <input
                    type="radio"
                    name="payment_method"
                    v-model="form.payment_method"
                    :value="name"
                    :id="name"
                >

                <label :for="name" v-text="gateway.label"></label>

                <span class="helper-text" v-text="gateway.description"></span>
            </div>

            <span class="error-message" v-if="hasNoPaymentMethod">
                {{ trans('storefront::checkout.no_payment_method') }}
            </span>
        </div>
    </div>
</div>

<div class="payment-instructions" v-if="shouldShowPaymentInstructions">
    <h4 class="title">{{ trans('storefront::checkout.payment_instructions') }}</h4>

    <p v-html="paymentInstructions"></p>
</div>
