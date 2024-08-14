import store from "../store";

export default {
    data() {
        return {
            addingToCart: false,
        };
    },

    computed: {
        productUrl() {
            return route("products.show", {
                slug: this.product.slug,
                ...(this.hasAnyVariant && {
                    variant: this.item.uid,
                }),
            });
        },

        hasAnyVariant() {
            return this.product.variant !== null;
        },

        hasAnyOption() {
            return this.product.options_count > 0;
        },

        hasNoOption() {
            return !this.hasAnyOption;
        },

        hasAnyMedia() {
            return this.item.media.length !== 0;
        },

        hasBaseImage() {
            if (this.hasAnyVariant) {
                return this.item.base_image.length !== 0 ||
                    this.product.base_image.length !== 0
                    ? true
                    : false;
            }

            return this.item.base_image.length !== 0;
        },

        baseImage() {
            return this.hasBaseImage
                ? this.item.base_image.path || this.product.base_image.path
                : `${window.FleetCart.baseUrl}/build/assets/image-placeholder.png`;
        },

        inWishlist() {
            return store.inWishlist(this.product.id);
        },

        inCompareList() {
            return store.inCompareList(this.product.id);
        },
    },

    methods: {
        syncWishlist() {
            store.syncWishlist(this.product.id);
        },

        syncCompareList() {
            store.syncCompareList(this.product.id);
        },

        addToCart() {
            this.addingToCart = true;

            axios
                .post(
                    route("cart.items.store", {
                        product_id: this.product.id,
                        qty: 1,
                        ...(this.hasAnyVariant && {
                            variant_id: this.item.id,
                        }),
                    })
                )
                .then((response) => {
                    store.updateCart(response.data);

                    if (document.location.href !== route("cart.index")) {
                        $(".header-cart").trigger("click");
                    }
                })
                .catch((error) => {
                    this.$notify(error.response.data.message);
                })
                .finally(() => {
                    this.addingToCart = false;
                });
        },
    },
};
