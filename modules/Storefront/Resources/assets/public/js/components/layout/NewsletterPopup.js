import "bootstrap";

export default {
    data() {
        return {
            email: "",
            subscribed: false,
            subscribing: false,
            error: "",
            modal: null,
        };
    },

    watch: {
        email() {
            this.error = "";
        },
    },

    mounted() {
        setTimeout(() => {
            $(".newsletter-wrap").modal("show");
        }, 1000);
    },

    methods: {
        closeNewsletterPopup() {
            $(".newsletter-wrap").modal("hide");
        },

        disableNewsletterPopup() {
            $(".newsletter-wrap").modal("hide");

            axios.delete(route("storefront.newsletter_popup.destroy"));
        },

        subscribe() {
            if (!this.email || this.subscribed) {
                return;
            }

            this.subscribing = true;

            document.activeElement.blur();

            axios
                .post(route("subscribers.store"), {
                    email: this.email,
                })
                .then(() => {
                    this.email = "";
                    this.subscribed = true;
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.error = error.response.data.errors.email[0];

                        return;
                    }

                    this.error = error.response.data.message;
                })
                .finally(() => {
                    this.subscribing = false;
                });
        },
    },
};
