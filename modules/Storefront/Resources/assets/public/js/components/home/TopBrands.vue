<template>
    <section class="top-brands-wrap clearfix">
        <div class="container">
            <div class="top-brands overflow-hidden clearfix">
                <a
                    v-for="(topBrand, index) in topBrands"
                    :key="index"
                    :href="topBrand.url"
                    class="top-brand-item d-inline-flex align-items-center justify-content-center overflow-hidden"
                >
                    <img :src="topBrand.logo.path" alt="Brand logo" />
                </a>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    props: ["topBrands"],

    mounted() {
        $(".top-brands").slick(this.slickOptions());
    },

    methods: {
        slickOptions() {
            return {
                rows: 0,
                dots: false,
                arrows: true,
                infinite: true,
                slidesToShow: 7,
                slidesToScroll: 7,
                rtl: window.FleetCart.rtl,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 6,
                            slidesToScroll: 6,
                        },
                    },
                    {
                        breakpoint: 1050,
                        settings: {
                            slidesToShow: 5,
                            slidesToScroll: 5,
                        },
                    },
                    {
                        breakpoint: 900,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4,
                        },
                    },
                    {
                        breakpoint: 750,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        },
                    },
                    {
                        breakpoint: 450,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        },
                    },
                ],
            };
        },
    },
};
</script>
