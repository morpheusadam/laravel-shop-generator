import store from "../../store";
import ProductHelpersMixin from "../../mixins/ProductHelpersMixin";

export default {
    mixins: [ProductHelpersMixin],

    props: ["compare"],

    data() {
        return {
            products: this.compare.products,
            attributes: this.compare.attributes,
            fetchingRelatedProducts: false,
            relatedProducts: [],
        };
    },

    computed: {
        hasAnyProduct() {
            return Object.keys(this.products).length !== 0;
        },

        hasAnyRelatedProduct() {
            return this.relatedProducts.length !== 0;
        },
    },

    created() {
        if (this.hasAnyProduct) {
            this.fetchRelatedProducts();
        }
    },

    methods: {
        badgeClass(product) {
            if (product.is_in_stock) {
                return "badge-success";
            }

            return "badge-danger";
        },

        hasAttribute(product, attribute) {
            for (let productAttribute of product.attributes) {
                if (productAttribute.name === attribute.name) {
                    return true;
                }
            }
        },

        attributeValues(product, attribute) {
            for (let productAttribute of product.attributes) {
                if (productAttribute.name === attribute.name) {
                    return productAttribute.values
                        .map((productAttributeValue) => {
                            return productAttributeValue.value;
                        })
                        .join(", ");
                }
            }
        },

        remove(product) {
            this.$delete(this.products, product.id);

            if (!this.hasAnyProduct) {
                this.relatedProducts = [];
            }

            store.removeFromCompareList(product.id);
        },

        inWishlist(product) {
            return store.inWishlist(product.id);
        },

        syncWishlist(product) {
            store.syncWishlist(product.id);
        },

        addToCart(product) {
            if (product.options_count !== 0) {
                return (window.location.href = this.productUrl(product));
            }

            axios
                .post(
                    route("cart.items.store", {
                        product_id: product.id,
                        qty: 1,
                    })
                )
                .then((response) => {
                    store.updateCart(response.data);

                    $(".header-cart").trigger("click");
                })
                .catch((error) => {
                    this.$notify(error.response.data.message);
                });
        },

        async fetchRelatedProducts() {
            this.fetchingRelatedProducts = true;

            try {
                const response = await axios.get(
                    route("compare.related_products.index")
                );

                this.relatedProducts = response.data;
            } catch (error) {
                this.$notify(error.response.data.message);
            } finally {
                this.fetchingRelatedProducts = false;
            }
        },
    },
};
