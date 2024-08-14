import Drift from "drift-zoom";
import GLightbox from "glightbox";

let galleryPreviewSlider;
let galleryThumbnailSlider;
let galleryPreviewLightbox;
let galleryPreviewZoomInstances = [];

export default {
    created() {
        this.setOldMediaLength();
    },

    mounted() {
        galleryPreviewSlider = this.initGalleryPreviewSlider();
        galleryThumbnailSlider = this.initGalleryThumbnailSlider();
        galleryPreviewLightbox = this.initGalleryPreviewLightbox();
        this.triggerGalleryPreviewLightbox();
        this.initGalleryPreviewZoom();
        this.initUpSellProductsSlider();
    },

    methods: {
        setOldMediaLength() {
            if (this.hasAnyVariant) {
                this.oldMediaLength = this.item.media.length;
            }
        },

        initGalleryPreviewSlider() {
            return $(".product-gallery-preview").slick({
                rows: 0,
                speed: 200,
                fade: true,
                dots: false,
                swipe: false,
                arrows: true,
                infinite: false,
                draggable: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                asNavFor: $(".product-gallery-thumbnail"),
                rtl: window.FleetCart.rtl,
            });
        },

        initGalleryThumbnailSlider() {
            return $(".product-gallery-thumbnail")
                .on("setPosition", (_, slick) => {
                    if (slick.slideCount <= slick.options.slidesToShow) {
                        slick.$slideTrack.css("transform", "");
                    }
                })
                .slick({
                    rows: 0,
                    dots: false,
                    arrows: true,
                    infinite: false,
                    slidesToShow: 6,
                    slideToScroll: 1,
                    focusOnSelect: true,
                    rtl: window.FleetCart.rtl,
                    asNavFor: $(".product-gallery-preview"),
                    responsive: [
                        {
                            breakpoint: 1601,
                            settings: {
                                slidesToShow: 5,
                            },
                        },
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: 6,
                            },
                        },
                        {
                            breakpoint: 577,
                            settings: {
                                slidesToShow: 5,
                                arrows: false,
                            },
                        },
                        {
                            breakpoint: 451,
                            settings: {
                                arrows: false,
                                slidesToShow: 4,
                            },
                        },
                    ],
                });
        },

        updateGallerySlider() {
            // Product media exists
            if (this.product.media.length !== 0) {
                // Product variant media exists
                if (this.hasAnyMedia) {
                    this.addGallerySlides();
                    this.removeOldGallerySlides();
                } else {
                    this.removeOldGallerySlides();
                }
            } else {
                // Product media does not exist
                // Product variant media exists
                if (this.hasAnyMedia) {
                    this.addGallerySlides();

                    const itemMediaLength = this.item.media.length;
                    const slideCount =
                        galleryPreviewSlider.slick("getSlick").slideCount -
                        itemMediaLength;

                    [...Array(slideCount)].forEach(() => {
                        const slideIndex = itemMediaLength;

                        galleryPreviewSlider.slick("slickRemove", slideIndex);
                        galleryThumbnailSlider.slick("slickRemove", slideIndex);
                    });
                } else {
                    // Product variant media does not exist
                    if (this.oldMediaLength !== 0) {
                        this.addGalleryEmptySlide();
                        this.removeOldGallerySlides();
                    }
                }
            }

            this.addGalleryEventListeners();
        },

        addGallerySlides() {
            this.item.media.forEach(({ path }, index) => {
                this.addGalleryPreviewSlide(path, index);
                this.addGalleryThumbnailSlide(path, index);
            });
        },

        addGalleryPreviewSlide(filePath, slideIndex) {
            galleryPreviewSlider.slick(
                "slickAdd",
                this.galleryPreviewSlideTemplate(filePath),
                slideIndex,
                true
            );
        },

        addGalleryThumbnailSlide(filePath, slideIndex) {
            galleryThumbnailSlider.slick(
                "slickAdd",
                this.galleryThumbnailSlideTemplate(filePath),
                slideIndex,
                true
            );
        },

        addGalleryEmptySlide() {
            const filePath = `${FleetCart.baseUrl}/build/assets/image-placeholder.png`;

            galleryPreviewSlider.slick(
                "slickAdd",
                this.galleryPreviewEmptySlideTemplate(filePath),
                null,
                true
            );

            galleryThumbnailSlider.slick(
                "slickAdd",
                this.galleryThumbnailEmptySlideTemplate(filePath),
                null,
                true
            );
        },

        removeOldGallerySlides() {
            // Count removable gallery slides
            const slideCount =
                galleryPreviewSlider.slick("getSlick").slideCount -
                this.product.media.length -
                1;

            [...Array(this.oldMediaLength)].forEach((_, index) => {
                const slideIndex = slideCount - index;

                galleryPreviewSlider.slick("slickRemove", slideIndex);
                galleryThumbnailSlider.slick("slickRemove", slideIndex);
            });
        },

        addGalleryEventListeners() {
            this.$nextTick(() => {
                galleryThumbnailSlider.slick("refresh");
                galleryPreviewLightbox.reload();

                this.initGalleryPreviewZoom();
            });
        },

        initGalleryPreviewZoom() {
            if (this.isMobileDevice()) {
                this.initGalleryPreviewMobileZoom();

                return;
            }

            this.initGalleryPreviewDesktopZoom();
        },

        initGalleryPreviewMobileZoom() {
            this.destroyGalleryPreviewZoomInstances();

            [
                ...document.querySelectorAll(".gallery-preview-item > img"),
            ].forEach((el) => {
                galleryPreviewZoomInstances.push(
                    new Drift(el, {
                        namespace: "mobile-drift",
                        inlinePane: true,
                        inlineOffsetY: -55,
                        passive: false,
                    })
                );
            });
        },

        initGalleryPreviewDesktopZoom() {
            this.destroyGalleryPreviewZoomInstances();

            [
                ...document.querySelectorAll(".gallery-preview-item > img"),
            ].forEach((el) => {
                galleryPreviewZoomInstances.push(
                    new Drift(el, {
                        inlinePane: false,
                        hoverBoundingBox: true,
                        boundingBoxContainer: document.body,
                        paneContainer:
                            document.querySelector(".product-gallery"),
                    })
                );
            });
        },

        destroyGalleryPreviewZoomInstances() {
            if (galleryPreviewZoomInstances.length !== 0) {
                galleryPreviewZoomInstances.forEach((instance) => {
                    instance.destroy();
                });
            }
        },

        initGalleryPreviewLightbox() {
            return GLightbox({
                zoomable: true,
                preload: false,
            });
        },

        triggerGalleryPreviewLightbox() {
            if (window.innerWidth > 990) {
                $(".product-gallery-preview").on(
                    "click",
                    ".gallery-preview-item",
                    (event) => {
                        event.currentTarget.nextElementSibling.click();
                    }
                );
            }
        },

        galleryPreviewSlideTemplate(filePath) {
            return `
                <div class="gallery-preview-slide">
                    <div class="gallery-preview-item">
                        <img src="${filePath}" data-zoom="${filePath}" alt="${this.product.name}">
                    </div>

                    <a href="${filePath}" data-gallery="product-gallery-preview" class="gallery-view-icon glightbox">
                        <i class="las la-search-plus"></i>
                    </a>
                </div>
            `;
        },

        galleryThumbnailSlideTemplate(filePath) {
            return `
                <div class="gallery-thumbnail-slide">
                    <div class="gallery-thumbnail-item">
                        <img src="${filePath}" alt="${this.product.name}">
                    </div>
                </div>
            `;
        },

        galleryPreviewEmptySlideTemplate(filePath) {
            return `
                <div class="gallery-preview-slide">
                    <div class="gallery-preview-item">
                        <img src="${filePath}" data-zoom="${filePath}" alt="${this.product.name}" class="image-placeholder">
                    </div>

                    <a href="${filePath}" data-gallery="product-gallery-preview" class="gallery-view-icon glightbox">
                        <i class="las la-search-plus"></i>
                    </a>
                </div>
            `;
        },

        galleryThumbnailEmptySlideTemplate(filePath) {
            return `
                <div class="gallery-thumbnail-slide">
                    <div class="gallery-thumbnail-item">
                        <img src="${filePath}" alt="${this.product.name}" class="image-placeholder">
                    </div>
                </div>
            `;
        },
    },
};
