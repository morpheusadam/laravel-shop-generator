<div class="coupon-wrap">
    <div class="d-flex">
        <input
            type="text"
            v-model="couponCode"
            placeholder="{{ trans('storefront::cart.enter_coupon_code') }}"
            class="form-control"
            @keyup.enter="applyCoupon"
            @input="couponError = null"
        >

        <button
            type="button"
            class="btn btn-default btn-apply-coupon"
            :class="{ 'btn-loading': applyingCoupon }"
            @click.prevent="applyCoupon"
        >
            {{ trans('storefront::cart.apply') }}
        </button>
    </div>

    <span
        class="error-message"
        v-if="couponError"
        v-text="couponError"
    >
    </span>
</div>
