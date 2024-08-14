export default {
    computed: {
        totalReviews() {
            if (!this.reviews.total) {
                return this.reviewCount;
            }

            return this.reviews.total;
        },

        ratingPercent() {
            return (this.avgRating / 5) * 100;
        },

        emptyReviews() {
            return this.totalReviews === 0;
        },

        totalReviewPage() {
            return Math.ceil(this.reviews.total / 5);
        },
    },

    created() {
        this.fetchReviews();
    },

    methods: {
        async fetchReviews() {
            this.fetchingReviews = true;

            try {
                const response = await axios.get(
                    route("products.reviews.index", {
                        productId: this.product.id,
                        page: this.currentReviewPage,
                    })
                );

                this.reviews = response.data;
            } catch (error) {
                this.$notify(error.response.data.message);
            } finally {
                this.fetchingReviews = false;
            }
        },

        addNewReview() {
            this.addingNewReview = true;

            axios
                .post(
                    route("products.reviews.store", {
                        productId: this.product.id,
                    }),
                    {
                        ...this.reviewForm,
                        "g-recaptcha-response": grecaptcha.getResponse(),
                    }
                )
                .then((response) => {
                    this.reviewForm = {};
                    this.reviews.total++;
                    this.reviews.data.unshift(response.data);

                    this.$notify(
                        this.$trans("storefront::product.review_submitted")
                    );

                    this.errors.reset();
                })
                .catch(({ response }) => {
                    if (response.status === 422) {
                        this.errors.record(response.data.errors);

                        return;
                    }

                    this.$notify(response.data.message);
                })
                .finally(() => {
                    this.addingNewReview = false;

                    grecaptcha.reset();
                });
        },

        changeReviewPage(page) {
            this.currentReviewPage = page;

            this.fetchReviews();
        },
    },
};
