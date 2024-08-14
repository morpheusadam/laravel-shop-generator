import store from "../store";

export default {
    data() {
        return {
            loadingOrderSummary: false,
            shippingMethodName: null,
            applyingCoupon: false,
            couponCode: null,
            couponError: null,
        };
    },

    computed: {
        cart() {
            return store.state.cart;
        },

        cartIsEmpty() {
            return store.cartIsEmpty();
        },

        cartIsNotEmpty() {
            return !store.cartIsEmpty();
        },

        hasShippingMethod() {
            return store.hasShippingMethod();
        },

        firstShippingMethod() {
            return Object.keys(store.state.cart.availableShippingMethods)[0];
        },

        hasCoupon() {
            return store.state.cart.coupon.code !== undefined;
        },
    },

    methods: {
        applyCoupon() {
            if (!this.couponCode) {
                return;
            }

            this.loadingOrderSummary = true;
            this.applyingCoupon = true;

            axios
                .post(route("cart.coupon.store"), { coupon: this.couponCode })
                .then((response) => {
                    this.couponCode = null;
                    this.couponError = null;

                    store.updateCart(response.data);
                })
                .catch((error) => {
                    this.couponError = error.response.data.message;
                })
                .finally(() => {
                    this.loadingOrderSummary = false;
                    this.applyingCoupon = false;
                });
        },

        removeCoupon() {
            this.loadingOrderSummary = true;

            axios
                .delete(route("cart.coupon.destroy"))
                .then((response) => {
                    store.updateCart(response.data);
                })
                .catch((error) => {
                    this.$notify(error.response.data.message);
                })
                .finally(() => {
                    this.loadingOrderSummary = false;
                });
        },
    },
};
