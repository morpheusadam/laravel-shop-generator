import store from "../../store";
import Errors from "../../Errors";
import GalleryMixin from "./show/mixins/GalleryMixin";
import VariationMixin from "./show/mixins/VariationMixin";
import VariantMixin from "./show/mixins/VariantMixin";
import OptionMixin from "./show/mixins/OptionMixin";
import QuantityMixin from "./show/mixins/QuantityMixin";
import ReviewMixin from "./show/mixins/ReviewMixin";
import ProductCardMixin from "../../mixins/ProductCardMixin";

export default {
    components: {
        VPagination: () => import("../VPagination.vue"),
        RelatedProducts: () => import("./show/RelatedProducts.vue"),
    },

    mixins: [
        GalleryMixin,
        VariationMixin,
        VariantMixin,
        OptionMixin,
        QuantityMixin,
        ReviewMixin,
        ProductCardMixin,
    ],

    props: ["product", "variant", "reviewCount", "avgRating"],

    data() {
        return {
            item: {
                ...(this.product.variant ? this.variant : this.product),
            },
            oldMediaLength: null,
            activeVariationValues: {},
            variationImagePath: null,
            price: this.product.formatted_price,
            activeTab: "description",
            currentReviewPage: 1,
            fetchingReviews: false,
            reviews: {},
            addingNewReview: false,
            reviewForm: {},
            cartItemForm: {
                product_id: this.product.id,
                qty: 1,
                variations: {},
                options: {},
            },
            errors: new Errors(),
            showDescriptionContent: false,
            isShowMore: false,
        };
    },

    computed: {
        productUrl() {
            return route("products.show", {
                slug: this.product.slug,
                ...(this.hasAnyVariant && {
                    variant: this.item.uid,
                }),
            });
        },

        isActiveItem() {
            return this.item.is_active === true;
        },

        isAddToCartDisabled() {
            return this.item.is_out_of_stock ?? true;
        },
    },

    created() {
        if (this.hasAnyVariant && !this.item.is_active) {
            this.setInactiveItemData();
        }
    },

    mounted() {
        const descriptionContent = this.$refs.descriptionContent;

        if (descriptionContent) {
            this.isShowMore =
                descriptionContent.clientHeight >= 400 ? true : false;
        }
    },

    methods: {
        setInactiveItemData() {
            this.item = {
                uid: this.item.uid,
                media: [],
                base_image: [],
            };
        },

        isMobileDevice() {
            return window.matchMedia("only screen and (max-width: 992px)")
                .matches;
        },

        addToCart() {
            if (this.isAddToCartDisabled) return;

            this.addingToCart = true;

            axios
                .post(route("cart.items.store"), {
                    ...this.cartItemForm,
                    ...(this.hasAnyVariant && { variant_id: this.item.id }),
                })
                .then((response) => {
                    store.updateCart(response.data);

                    $(".header-cart").trigger("click");
                })
                .catch(({ response }) => {
                    if (response.status === 422) {
                        this.errors.record(response.data.errors);
                    }

                    this.$notify(response.data.message);
                })
                .finally(() => {
                    this.addingToCart = false;
                });
        },

        initUpSellProductsSlider() {
            $(this.$refs.upSellProducts).slick({
                rows: 0,
                dots: false,
                arrows: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                rtl: window.FleetCart.rtl,
            });
        },

        toggleDescriptionContent() {
            this.showDescriptionContent = !this.showDescriptionContent;
        },
    },
};
