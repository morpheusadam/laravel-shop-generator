export default {
    data() {
        return {
            email: "",
            subscribed: false,
            subscribing: false,
        };
    },

    methods: {
        subscribe() {
            if (!this.email || this.subscribed) {
                return;
            }

            this.subscribing = true;

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
                        this.$notify(error.response.data.errors.email[0]);

                        return;
                    }

                    this.$notify(error.response.data.message);
                })
                .finally(() => {
                    this.subscribing = false;
                });
        },
    },
};
