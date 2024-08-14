<template>
    <section
        class="vertical-products-wrap"
        :class="{
            'flash-sale-enabled': flashSaleEnabled,
        }"
    >
        <div class="container">
            <div class="row">
                <flash-sale
                    v-if="flashSaleEnabled"
                    :title="data.flash_sale_title"
                    :url="route('storefront.flash_sale_products.index')"
                >
                </flash-sale>

                <vertical-products
                    :flash-sale-enabled="flashSaleEnabled"
                    :title="data.vertical_products_1_title"
                    :url="
                        route('storefront.vertical_products.index', {
                            columnNumber: 1,
                        })
                    "
                >
                </vertical-products>

                <vertical-products
                    :flash-sale-enabled="flashSaleEnabled"
                    :title="data.vertical_products_2_title"
                    :url="
                        route('storefront.vertical_products.index', {
                            columnNumber: 2,
                        })
                    "
                >
                </vertical-products>

                <vertical-products
                    :flash-sale-enabled="flashSaleEnabled"
                    :title="data.vertical_products_3_title"
                    :url="
                        route('storefront.vertical_products.index', {
                            columnNumber: 3,
                        })
                    "
                >
                </vertical-products>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    components: {
        FlashSale: () => import("./FlashSale.vue"),
        VerticalProducts: () => import("./VerticalProducts.vue"),
    },

    props: ["data", "flashSaleEnabled"],
};
</script>
