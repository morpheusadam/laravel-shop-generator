<template>
    <section class="landscape-tab-products-wrap">
        <div class="container">
            <div class="tab-products-header">
                <h5 class="section-title">{{ data.title }}</h5>

                <div class="tab-products-header-overflow">
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
            </div>

            <div class="tab-content">
                <div class="landscape-right-tab-products">
                    <ProductCard
                        v-for="product in products"
                        :key="product.id"
                        :product="product"
                    />
                </div>
            </div>
        </div>

        <dynamic-tab
            v-for="(tabLabel, index) in data.tabs"
            :key="index"
            :label="tabLabel"
            :url="
                route('storefront.tab_products.index', {
                    sectionNumber: 2,
                    tabNumber: index + 1,
                })
            "
        >
        </dynamic-tab>
    </section>
</template>

<script>
import ProductCard from "../ProductCard.vue";
import DynamicTabsMixin from "../../mixins/DynamicTabsMixin";

export default {
    components: { ProductCard },

    mixins: [DynamicTabsMixin],

    props: ["data"],

    methods: {
        selector() {
            return $(".landscape-right-tab-products");
        },

        slickOptions() {
            return {
                rows: 0,
                dots: true,
                arrows: false,
                infinite: true,
                slidesToShow: 6,
                slidesToScroll: 6,
                rtl: window.FleetCart.rtl,
                responsive: [
                    {
                        breakpoint: 1761,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 5,
                        },
                    },
                    {
                        breakpoint: 1301,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4,
                        },
                    },
                    {
                        breakpoint: 1051,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        },
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4,
                        },
                    },
                    {
                        breakpoint: 881,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        },
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        },
                    },
                    {
                        breakpoint: 641,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        },
                    },
                ],
            };
        },
    },
};
</script>
