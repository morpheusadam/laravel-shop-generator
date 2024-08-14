export default {
    methods: {
        productUrl({ product, variant }) {
            return route("products.show", {
                slug: product.slug,
                ...(variant !== null && {
                    variant: variant.uid,
                }),
            });
        },

        hasAnyVariant(variant) {
            return variant !== null;
        },

        hasBaseImage({ item, product, variant }) {
            if (this.hasAnyVariant(variant)) {
                return item.base_image.length !== 0 ||
                    product.base_image.length !== 0
                    ? true
                    : false;
            }

            return item.base_image.length !== 0;
        },

        baseImage({ item, product, variant }) {
            return this.hasBaseImage({ item, product, variant })
                ? item.base_image.path || product.base_image.path
                : `${window.FleetCart.baseUrl}/build/assets/image-placeholder.png`;
        },

        optionValues(option) {
            let values = [];

            for (let value of option.values) {
                values.push(value.label);
            }

            return values.join(", ");
        },

        maxQuantity({ item }) {
            return item.is_in_stock && item.does_manage_stock ? item.qty : null;
        },

        exceedsMaxStock({ item, qty }) {
            return item.does_manage_stock && item.qty < qty;
        },

        isQtyIncreaseDisabled(cartItem) {
            return (
                this.maxQuantity(cartItem) !== null &&
                cartItem.qty >= cartItem.item.qty
            );
        },

        changeQuantity(cartItem, qty) {
            if (isNaN(qty) || qty < 1) {
                qty = 1;

                this.updateCart(cartItem, qty);

                return;
            }

            cartItem.qty = qty;

            if (this.exceedsMaxStock(cartItem)) {
                qty = cartItem.item.qty;

                this.updateCart(cartItem, qty);

                return;
            }

            this.updateCart(cartItem, qty);
        },

        updateQuantity(event, cartItem, qty) {
            if (isNaN(qty) || qty < 1) {
                qty = 1;
                cartItem.qty = 1;

                return;
            }

            cartItem.qty = qty;

            if (this.exceedsMaxStock(cartItem)) {
                cartItem.qty = cartItem.item.qty;

                this.updateCart(cartItem, cartItem.qty);

                return;
            }

            $(event.currentTarget).siblings(".input-quantity").trigger("focus");
            this.updateCart(cartItem, qty);
        },
    },
};
