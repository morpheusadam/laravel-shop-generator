<template>
    <div
        :class="flashSaleEnabled ? 'col-xl-4 col-lg-6' : 'col-xl-6 col-lg-6'"
        v-if="hasAnyProduct"
    >
        <div class="vertical-products">
            <div class="vertical-products-header">
                <h4 class="section-title">{{ title }}</h4>
            </div>

            <div class="vertical-products-slider" ref="productsPlaceholder">
                <div
                    v-for="(productChunks, index) in $chunk(products, 5)"
                    :key="index"
                    class="vertical-products-slide"
                >
                    <ProductCardVertical
                        v-for="product in productChunks"
                        :key="product.id"
                        :product="product"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ProductCardVertical from "../ProductCardVertical.vue";

export default {
    components: { ProductCardVertical },

    props: ["flashSaleEnabled", "title", "url"],

    data() {
        return {
            products: [],
        };
    },

    computed: {
        hasAnyProduct() {
            return this.products.length !== 0;
        },
    },

    created() {
        this.fetchProducts();
    },

    methods: {
        async fetchProducts() {
            await axios.get(this.url).then((response) => {
                this.products = response.data;

                this.$nextTick(() => {
                    $(this.$refs.productsPlaceholder).slick(
                        this.slickOptions()
                    );
                });
            });
        },

        slickOptions() {
            return {
                rows: 0,
                dots: false,
                arrows: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                rtl: window.FleetCart.rtl,
            };
        },
    },
};
</script>
