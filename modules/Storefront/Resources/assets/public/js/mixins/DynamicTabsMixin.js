export default {
    data() {
        return {
            tabs: [],
            activeTab: null,
            loading: false,
            products: [],
        };
    },

    mounted() {
        this.tabs = this.$children.filter((component) => {
            return component.$options.name === "DynamicTab";
        });

        // Show the first tab by default on page load.
        this.change(this.tabs[0]);
    },

    methods: {
        classes(tab) {
            return {
                "tab-item": true,
                loading: this.activeTab === tab && this.loading,
                active: this.activeTab === tab && !this.loading,
            };
        },

        async change(activeTab) {
            if (this.activeTab === activeTab || activeTab === undefined) {
                return;
            }

            this.loading = true;
            this.activeTab = activeTab;

            const response = await axios.get(activeTab.url);

            if (this.selector().hasClass("slick-initialized")) {
                this.selector().slick("unslick");
            }

            this.products = response.data;
            this.loading = false;

            this.$nextTick(() => {
                this.selector().slick(this.slickOptions());
            });
        },
    },
};
