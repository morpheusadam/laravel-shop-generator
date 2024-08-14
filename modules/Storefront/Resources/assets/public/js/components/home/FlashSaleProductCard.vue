<template>
    <div class="daily-deals-inner">
        <div class="daily-deals-top">
            <a :href="productUrl" class="product-image">
                <img
                    :src="baseImage"
                    :class="{ 'image-placeholder': !hasBaseImage }"
                    :alt="product.name"
                />
            </a>
        </div>

        <a :href="productUrl" class="product-name">
            <h6>{{ product.name }}</h6>
        </a>

        <div class="product-info">
            <div class="product-price" v-html="item.formatted_price"></div>

            <product-rating
                :ratingPercent="product.rating_percent"
                :reviewCount="product.reviews.length"
            >
            </product-rating>
        </div>

        <countdown :end-date="product.pivot.end_date"></countdown>

        <div class="deal-progress">
            <div class="deal-stock">
                <div class="stock-available">
                    {{ $trans("storefront::product_card.available") }}
                    <span>{{ product.pivot.qty }}</span>
                </div>

                <div class="stock-sold">
                    {{ $trans("storefront::product_card.sold") }}
                    <span>{{ product.pivot.sold }}</span>
                </div>
            </div>

            <div class="progress">
                <div class="progress-bar" :style="{ width: progress }"></div>
            </div>
        </div>
    </div>
</template>

<script>
import Countdown from "../Countdown.vue";
import ProductCardMixin from "../../mixins/ProductCardMixin";

export default {
    components: { Countdown },

    mixins: [ProductCardMixin],

    props: ["product"],

    computed: {
        item() {
            return {
                ...(this.product.variant ? this.product.variant : this.product),
            };
        },

        progress() {
            return (
                (this.product.pivot.sold / this.product.pivot.qty) * 100 + "%"
            );
        },
    },
};
</script>
