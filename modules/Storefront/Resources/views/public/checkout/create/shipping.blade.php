<div class="shipping-method" v-if="hasShippingMethod">
    <h4 class="title">{{ trans('storefront::checkout.shipping_method') }}</h4>

    <div class="shipping-method-form">
        <div class="form-group">
            <div class="form-radio" v-for="(shippingMethod, key, index) in cart.availableShippingMethods" :key="index">
                <input
                    type="radio"
                    name="shipping_method"
                    v-model="form.shipping_method"
                    :value="shippingMethod.name"
                    :id="shippingMethod.name"
                    @change="updateShippingMethod(shippingMethod.name)"
                >

                <label :for="shippingMethod.name" v-text="shippingMethod.label"></label>

                <span
                    :class="{ 'text-line-through': hasFreeShipping }"
                    v-text="shippingMethod.cost.inCurrentCurrency.formatted"
                >
                </span>
            </div>
        </div>
    </div>
</div>
