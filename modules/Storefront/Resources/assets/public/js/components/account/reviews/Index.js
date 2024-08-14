import ProductHelpersMixin from "../../../mixins/ProductHelpersMixin";

export default {
    components: {
        VPagination: () => import("../../VPagination.vue"),
    },

    mixins: [ProductHelpersMixin],

    data() {
        return {
            fetchingReviews: false,
            reviews: { data: [] },
            currentPage: 1,
        };
    },

    computed: {
        reviewIsEmpty() {
            return this.reviews.data.length === 0;
        },

        totalPage() {
            return Math.ceil(this.reviews.total / 10);
        },
    },

    created() {
        this.fetchReviews();
    },

    methods: {
        changePage(page) {
            this.currentPage = page;

            this.fetchReviews();
        },

        async fetchReviews() {
            this.fetchingReviews = true;

            try {
                const response = await axios.get(
                    route("reviews.products.index", {
                        page: this.currentPage,
                    })
                );

                this.reviews = response.data;
            } catch (error) {
                this.$notify(error.response.data.message);
            } finally {
                this.fetchingReviews = false;
            }
        },
    },
};
