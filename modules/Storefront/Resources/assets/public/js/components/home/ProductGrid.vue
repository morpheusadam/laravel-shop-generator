<template>
    <section class="grid-products-wrap">
        <div class="container">
            <div class="tab-products-header">
                <ul class="tabs">
                    <li
                        v-for="(tab, index) in tabs"
                        :key="index"
                        :class="classes(tab)"
                        @click="change(tab)"
                    >
                        {{ tab.label }}
                    </li>
                </ul>

                <hr>
            </div>

            <div class="tab-content">
                <div class="grid-products">
                    <div
                        v-for="(productChunks, index) in $chunk(products, 12)"
                        :key="index"
                        class="grid-products-slide d-flex flex-wrap flex-grow-1"
                    >
                        <div
                            class="grid-products-item"
                            v-for="product in productChunks"
                            :key="product.id"
                        >
                            <ProductCard :product="product" />
                        </div>
                    </div>
                </div>
            </div>

            <dynamic-tab
                v-for="(tabLabel, index) in data"
                :key="index"
                :label="tabLabel"
                :url="
                    route('storefront.product_grid.index', {
                        tabNumber: index + 1,
                    })
                "
            >
            </dynamic-tab>
        </div>
    </section>
</template>

<script>
import { slickPrevArrow, slickNextArrow } from "../../functions";
import ProductCard from "../ProductCard.vue";
import DynamicTabsMixin from "../../mixins/DynamicTabsMixin";

export default {
    components: { ProductCard },

    mixins: [DynamicTabsMixin],

    props: ["data"],

    methods: {
        selector() {
            return $(".grid-products");
        },

        slickOptions() {
            return {
                rows: 0,
                dots: false,
                arrows: true,
                infinite: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                rtl: window.FleetCart.rtl,
                prevArrow: slickPrevArrow(),
                nextArrow: slickNextArrow(),
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            dots: true,
                            arrows: false,
                        },
                    },
                ],
            };
        },
    },
};
</script>
