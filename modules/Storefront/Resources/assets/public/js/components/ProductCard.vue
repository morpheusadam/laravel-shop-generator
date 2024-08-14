<template>
    <div class="product-card">
        <div class="product-card-top">
            <a :href="productUrl" class="product-image">
                <img
                    :src="baseImage"
                    :class="{ 'image-placeholder': !hasBaseImage }"
                    :alt="product.name"
                />
            </a>

            <div class="product-card-actions">
                <button
                    class="btn btn-wishlist"
                    :class="{ added: inWishlist }"
                    :title="$trans('storefront::product_card.wishlist')"
                    @click="syncWishlist"
                >
                    <svg
                        v-if="inWishlist"
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="18"
                        viewBox="0 0 20 18"
                        fill="none"
                    >
                        <path
                            d="M14.44 0.100098C12.63 0.100098 11.01 0.980098 10 2.3301C8.99 0.980098 7.37 0.100098 5.56 0.100098C2.49 0.100098 0 2.6001 0 5.6901C0 6.8801 0.19 7.9801 0.52 9.0001C2.1 14.0001 6.97 16.9901 9.38 17.8101C9.72 17.9301 10.28 17.9301 10.62 17.8101C13.03 16.9901 17.9 14.0001 19.48 9.0001C19.81 7.9801 20 6.8801 20 5.6901C20 2.6001 17.51 0.100098 14.44 0.100098Z"
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
                </button>

                <button
                    class="btn btn-compare"
                    :class="{ added: inCompareList }"
                    :title="$trans('storefront::product_card.compare')"
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
                </button>
            </div>

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

        <div class="product-card-middle">
            <product-rating
                :ratingPercent="product.rating_percent"
                :reviewCount="product.reviews.length"
            >
            </product-rating>

            <a :href="productUrl" class="product-name">
                <h6>{{ product.name }}</h6>
            </a>

            <div
                class="product-price product-price-clone"
                v-html="item.formatted_price"
            ></div>
        </div>

        <div class="product-card-bottom">
            <div class="product-price" v-html="item.formatted_price"></div>

            <button
                v-if="hasNoOption || item.is_out_of_stock"
                class="btn btn-primary btn-add-to-cart"
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
                class="btn btn-primary btn-add-to-cart"
            >
                <i class="las la-eye"></i>
                {{ $trans("storefront::product_card.view_options") }}
            </a>
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
