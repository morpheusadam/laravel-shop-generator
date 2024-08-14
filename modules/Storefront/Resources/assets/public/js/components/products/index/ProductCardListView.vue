<template>
    <div class="list-product-card">
        <div class="list-product-card-inner">
            <div class="product-card-left position-relative">
                <a :href="productUrl" class="product-image">
                    <img
                        :src="baseImage"
                        :class="{ 'image-placeholder': !hasBaseImage }"
                        :alt="product.name"
                    />
                </a>

                <ul class="list-inline product-badge">
                    <li class="badge badge-danger" v-if="item.is_out_of_stock">
                        {{ $trans("storefront::product_card.out_of_stock") }}
                    </li>

                    <li class="badge badge-primary" v-else-if="product.is_new">
                        {{ $trans("storefront::product_card.new") }}
                    </li>

                    <li
                        class="badge badge-success"
                        v-if="item.has_percentage_special_price"
                    >
                        -{{ item.special_price_percent }}%
                    </li>
                </ul>
            </div>

            <div class="product-card-right">
                <a :href="productUrl" class="product-name">
                    <h6>{{ product.name }}</h6>
                </a>

                <div class="clearfix"></div>

                <product-rating
                    :ratingPercent="product.rating_percent"
                    :reviewCount="product.reviews.length"
                >
                </product-rating>

                <div class="product-price" v-html="item.formatted_price"></div>

                <button
                    v-if="hasNoOption || item.is_out_of_stock"
                    class="btn btn-default btn-add-to-cart"
                    :class="{ 'btn-loading': addingToCart }"
                    :disabled="item.is_out_of_stock"
                    @click="addToCart"
                >
                    <i class="las la-cart-arrow-down"></i>

                    {{ $trans("storefront::product_card.add_to_cart") }}
                </button>

                <a
                    v-else
                    :href="productUrl"
                    class="btn btn-default btn-add-to-cart"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                    >
                        <path
                            d="M15.58 12C15.58 13.98 13.98 15.58 12 15.58C10.02 15.58 8.42004 13.98 8.42004 12C8.42004 10.02 10.02 8.41998 12 8.41998C13.98 8.41998 15.58 10.02 15.58 12Z"
                            stroke="#292D32"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M12 20.27C15.53 20.27 18.82 18.19 21.11 14.59C22.01 13.18 22.01 10.81 21.11 9.39997C18.82 5.79997 15.53 3.71997 12 3.71997C8.46997 3.71997 5.17997 5.79997 2.88997 9.39997C1.98997 10.81 1.98997 13.18 2.88997 14.59C5.17997 18.19 8.46997 20.27 12 20.27Z"
                            stroke="#292D32"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>

                    {{ $trans("storefront::product_card.view_options") }}
                </a>

                <div class="product-card-actions">
                    <button
                        class="btn btn-wishlist"
                        :class="{ added: inWishlist }"
                        @click="syncWishlist"
                    >
                        <svg
                            v-if="inWishlist"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M16.44 3.1001C14.63 3.1001 13.01 3.9801 12 5.3301C10.99 3.9801 9.37 3.1001 7.56 3.1001C4.49 3.1001 2 5.6001 2 8.6901C2 9.8801 2.19 10.9801 2.52 12.0001C4.1 17.0001 8.97 19.9901 11.38 20.8101C11.72 20.9301 12.28 20.9301 12.62 20.8101C15.03 19.9901 19.9 17.0001 21.48 12.0001C21.81 10.9801 22 9.8801 22 8.6901C22 5.6001 19.51 3.1001 16.44 3.1001Z"
                                fill="#292D32"
                            />
                        </svg>

                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M12.62 20.81C12.28 20.93 11.72 20.93 11.38 20.81C8.48 19.82 2 15.69 2 8.68998C2 5.59998 4.49 3.09998 7.56 3.09998C9.38 3.09998 10.99 3.97998 12 5.33998C13.01 3.97998 14.63 3.09998 16.44 3.09998C19.51 3.09998 22 5.59998 22 8.68998C22 15.69 15.52 19.82 12.62 20.81Z"
                                stroke="#292D32"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                        {{ $trans("storefront::product_card.wishlist") }}
                    </button>

                    <button
                        class="btn btn-compare"
                        :class="{ added: inCompareList }"
                        @click="syncCompareList"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M3.58008 5.15991H17.4201C19.0801 5.15991 20.4201 6.49991 20.4201 8.15991V11.4799"
                                stroke="#292D32"
                                stroke-width="1.5"
                                stroke-miterlimit="10"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></path>
                            <path
                                d="M6.74008 2L3.58008 5.15997L6.74008 8.32001"
                                stroke="#292D32"
                                stroke-width="1.5"
                                stroke-miterlimit="10"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></path>
                            <path
                                d="M20.4201 18.84H6.58008C4.92008 18.84 3.58008 17.5 3.58008 15.84V12.52"
                                stroke="#292D32"
                                stroke-width="1.5"
                                stroke-miterlimit="10"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></path>
                            <path
                                d="M17.26 21.9999L20.42 18.84L17.26 15.6799"
                                stroke="#292D32"
                                stroke-width="1.5"
                                stroke-miterlimit="10"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            ></path>
                        </svg>

                        {{ $trans("storefront::product_card.compare") }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ProductCardMixin from "../../../mixins/ProductCardMixin";

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
