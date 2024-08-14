import { trans } from "../../functions";
import noUiSlider from "nouislider";

export default {
    components: { VPagination: () => import("../VPagination.vue") },

    props: [
        "initialQuery",
        "initialBrandName",
        "initialBrandBanner",
        "initialBrandSlug",
        "initialCategoryName",
        "initialCategoryBanner",
        "initialCategorySlug",
        "initialTagName",
        "initialTagSlug",
        "initialAttribute",
        "minPrice",
        "maxPrice",
        "initialSort",
        "initialPerPage",
        "initialPage",
        "initialViewMode",
    ],

    data() {
        return {
            fetchingProducts: false,
            products: { data: [] },
            attributeFilters: [],
            brandBanner: this.initialBrandBanner,
            categoryName: this.initialCategoryName,
            categoryBanner: this.initialCategoryBanner,
            viewMode: this.initialViewMode,
            queryParams: {
                query: this.initialQuery,
                brand: this.initialBrandSlug,
                category: this.initialCategorySlug,
                tag: this.initialTagSlug,
                attribute: this.initialAttribute,
                fromPrice: 0,
                toPrice: this.maxPrice,
                sort: this.initialSort,
                perPage: this.initialPerPage,
                page: this.initialPage,
            },
        };
    },

    computed: {
        emptyProducts() {
            return this.products.data.length === 0;
        },

        totalPage() {
            return Math.ceil(this.products.total / this.queryParams.perPage);
        },

        showingResults() {
            if (this.emptyProducts) {
                return;
            }

            return trans("storefront::products.showing_results", {
                from: this.products.from,
                to: this.products.to,
                total: this.products.total,
            });
        },
    },

    mounted() {
        this.addEventListeners();
        this.initPriceFilter();
        this.fetchProducts();
        this.initLatestProductsSlider();
    },

    methods: {
        addEventListeners() {
            $(this.$refs.sortSelect).on("change", (e) => {
                this.queryParams.sort = e.currentTarget.value;

                this.fetchProducts();
            });

            $(this.$refs.perPageSelect).on("change", (e) => {
                this.queryParams.perPage = e.currentTarget.value;

                this.fetchProducts();
            });
        },

        initPriceFilter() {
            noUiSlider.create(this.$refs.priceRange, {
                connect: true,
                direction: window.FleetCart.rtl ? "rtl" : "ltr",
                start: [this.minPrice, this.maxPrice],
                range: {
                    min: [this.minPrice],
                    max: [this.maxPrice],
                },
            });

            this.$refs.priceRange.noUiSlider.on("update", (values, handle) => {
                let value = Math.round(values[handle]);

                if (handle === 0) {
                    this.queryParams.fromPrice = value;
                } else {
                    this.queryParams.toPrice = value;
                }
            });

            this.$refs.priceRange.noUiSlider.on("change", this.fetchProducts);
        },

        updatePriceRange(fromPrice, toPrice) {
            this.$refs.priceRange.noUiSlider.set([fromPrice, toPrice]);

            this.fetchProducts();
        },

        toggleAttributeFilter(slug, value) {
            if (!this.queryParams.attribute.hasOwnProperty(slug)) {
                this.queryParams.attribute[slug] = [];
            }

            if (this.queryParams.attribute[slug].includes(value)) {
                this.queryParams.attribute[slug].splice(
                    this.queryParams.attribute[slug].indexOf(value),
                    1
                );
            } else {
                this.queryParams.attribute[slug].push(value);
            }

            this.fetchProducts({ updateAttributeFilters: false });
        },

        isFilteredByAttribute(slug, value) {
            if (!this.queryParams.attribute.hasOwnProperty(slug)) {
                return false;
            }

            return this.queryParams.attribute[slug].includes(value);
        },

        changeCategory(category) {
            this.categoryName = category.name;
            this.categoryBanner = category.banner.path;
            this.queryParams.query = null;
            this.queryParams.category = category.slug;
            this.queryParams.attribute = {};
            this.queryParams.page = 1;

            this.fetchProducts();
        },

        changePage(page) {
            this.queryParams.page = page;

            this.fetchProducts();
        },

        async fetchProducts(options = { updateAttributeFilters: true }) {
            this.fetchingProducts = true;

            try {
                const response = await axios.get(
                    route("products.index", this.queryParams)
                );

                this.products = response.data.products;

                if (options.updateAttributeFilters) {
                    this.attributeFilters = response.data.attributes;
                }
            } catch (error) {
                this.$notify(error.response.data.message);
            } finally {
                this.fetchingProducts = false;
            }
        },

        initLatestProductsSlider() {
            $(this.$refs.latestProducts).slick({
                rows: 0,
                dots: false,
                arrows: true,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                rtl: window.FleetCart.rtl,
            });
        },
    },
};
