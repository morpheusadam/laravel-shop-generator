import store from "../../store";
import CartHelpersMixin from "../../mixins/CartHelpersMixin";
import CartItemHelpersMixin from "../../mixins/CartItemHelpersMixin";

export default {
    mixins: [CartHelpersMixin, CartItemHelpersMixin],

    data() {
        return {
            controller: null,
            shippingMethodName: null,
            crossSellProducts: [],
        };
    },

    computed: {
        hasAnyCrossSellProduct() {
            return this.crossSellProducts.length !== 0;
        },
    },

    created() {
        this.$nextTick(() => {
            this.fetchCrossSellProducts();
        });
    },

    methods: {
        updateCart(cartItem, qty) {
            this.loadingOrderSummary = true;

            if (this.controller) {
                this.controller.abort();
            }

            this.controller = new AbortController();

            axios
                .put(
                    route("cart.items.update", { id: cartItem.id }),
                    {
                        qty: qty || 1,
                    },
                    {
                        signal: this.controller.signal,
                    }
                )
                .then((response) => {
                    store.updateCart(response.data);
                })
                .catch((error) => {
                    if (error.code !== "ERR_CANCELED") {
                        store.updateCart(error.response.data.cart);

                        this.$notify(error.response.data.message);
                    }
                })
                .finally(() => {
                    this.loadingOrderSummary = false;
                });
        },

        removeCartItem(cartItem) {
            this.loadingOrderSummary = true;

            store.removeCartItem(cartItem);

            if (store.cartIsEmpty()) {
                this.crossSellProducts = [];
            }

            axios
                .delete(route("cart.items.destroy", { id: cartItem.id }))
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

        clearCart() {
            store.clearCart();

            if (store.cartIsEmpty()) {
                this.crossSellProducts = [];
            }

            axios
                .delete(route("cart.clear"))
                .then((response) => {
                    store.updateCart(response.data);
                })
                .catch((error) => {
                    this.$notify(error.response.data.message);
                });
        },

        async fetchCrossSellProducts() {
            try {
                const response = await axios.get(
                    route("cart.cross_sell_products.index")
                );

                this.crossSellProducts = response.data;
            } catch (error) {
                this.$notify(error.response.data.message);
            }
        },
    },
};
