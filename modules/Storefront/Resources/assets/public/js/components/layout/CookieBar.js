export default {
    data() {
        return {
            show: false,
        };
    },

    mounted() {
        setTimeout(() => {
            this.show = true;
        });
    },

    methods: {
        decline() {
            this.show = false;

            axios.delete(route("storefront.cookie_bar.destroy"));
        },

        accept() {
            this.show = false;

            axios.delete(route("storefront.cookie_bar.destroy"));
        },
    },
};
