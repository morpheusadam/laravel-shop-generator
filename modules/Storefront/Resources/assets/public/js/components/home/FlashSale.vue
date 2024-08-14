<template>
    <div class="col-xl-6 col-lg-18" v-if="hasAnyProduct">
        <div class="daily-deals-wrap">
            <div class="daily-deals-header clearfix">
                <h4 class="section-title" v-html="title"></h4>
            </div>

            <div class="daily-deals" ref="productsPlaceholder">
                <FlashSaleProductCard
                    v-for="product in products"
                    :key="product.id"
                    :product="product"
                />
            </div>
        </div>
    </div>
</template>

<script>
import { slickPrevArrow, slickNextArrow } from "../../functions";
import FlashSaleProductCard from "./FlashSaleProductCard.vue";

export default {
    components: { FlashSaleProductCard },

    props: ["title", "url"],

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
                prevArrow: slickPrevArrow(),
                nextArrow: slickNextArrow(),
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        },
                    },
                ],
            };
        },
    },
};
</script>
