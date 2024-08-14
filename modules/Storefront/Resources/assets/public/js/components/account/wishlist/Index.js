import store from "../../../store";
import ProductHelpersMixin from "../../../mixins/ProductHelpersMixin";

export default {
    components: { VPagination: () => import("../../VPagination.vue") },

    mixins: [ProductHelpersMixin],

    data() {
        return {
            fetchingWishlist: false,
            products: { data: [] },
            currentPage: 1,
        };
    },

    computed: {
        wishlistIsEmpty() {
            return this.products.data.length === 0;
        },

        totalPage() {
            return Math.ceil(this.products.total / 10);
        },
    },

    created() {
        this.fetchWishlist();
    },

    methods: {
        changePage(page) {
            this.currentPage = page;

            this.fetchWishlist();
        },

        async fetchWishlist() {
            this.fetchingWishlist = true;

            try {
                const response = await axios.get(
                    route("account.wishlist.products.index", {
                        page: this.currentPage,
                    })
                );

                this.products = response.data;
            } catch (error) {
                this.$notify(error.response.data.message);
            } finally {
                this.fetchingWishlist = false;
            }
        },

        remove(product) {
            this.products.data.splice(this.products.data.indexOf(product), 1);
            this.products.total--;

            store.removeFromWishlist(product.id);
        },
    },
};
