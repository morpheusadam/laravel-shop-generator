export default {
    methods: {
        productUrl(product) {
            return route("products.show", {
                slug: product.slug,
                ...(this.hasAnyVariant(product) && {
                    variant: product.variant.uid,
                }),
            });
        },

        hasAnyVariant(product) {
            return product.variant !== null;
        },

        hasAnyOption(product) {
            return product.options_count > 0;
        },

        hasBaseImage(product) {
            if (this.hasAnyVariant(product)) {
                return product.variant.base_image.length !== 0 ||
                    product.base_image.length !== 0
                    ? true
                    : false;
            }

            return product.base_image.length !== 0;
        },

        baseImage(product) {
            return this.hasBaseImage(product)
                ? product.variant?.base_image.path || product.base_image.path
                : `${window.FleetCart.baseUrl}/build/assets/image-placeholder.png`;
        },

        productPrice(product) {
            return this.hasAnyVariant(product)
                ? product.variant.formatted_price
                : product.formatted_price;
        },

        productIsInStock(product) {
            return this.hasAnyVariant(product)
                ? product.variant.is_in_stock
                : product.is_in_stock;
        },
    },
};
