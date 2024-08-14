<template>
    <div :href="productUrl" class="vertical-product-card">
        <a :href="productUrl" class="product-image">
            <img
                :src="baseImage"
                :class="{ 'image-placeholder': !hasBaseImage }"
                :alt="product.name"
            />
        </a>

        <div class="product-info">
            <a :href="productUrl" class="product-name">
                <h6>{{ product.name }}</h6>
            </a>

            <div class="product-price" v-html="item.formatted_price"></div>

            <product-rating
                :ratingPercent="product.rating_percent"
                :reviewCount="product.reviews.length"
            >
            </product-rating>
        </div>
    </div>
</template>

<script>
import ProductCardMixin from "../mixins/ProductCardMixin";

export default {
    mixins: [ProductCardMixin],

    props: ["product"],

    computed: {
        item() {
            return {
                ...(this.product.variant ? this.product.variant : this.product),
            };
        },
    },
};
</script>
