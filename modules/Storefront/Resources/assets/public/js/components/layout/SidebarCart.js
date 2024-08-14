import store from "../../store";

export default {
    components: { SidebarCartItem: () => import("./SidebarCartItem.vue") },

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
    },

    mounted() {
        this.initEventListeners();
    },

    methods: {
        initEventListeners() {
            $(".sidebar-cart-close").on("click", () => {
                $(".overlay").removeClass("active");
                $(".sidebar-cart-wrap").removeClass("active");
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
    },
};
