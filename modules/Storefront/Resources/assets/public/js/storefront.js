import "./vendors/vendors";

$(() => {
    /*      variables
    /*----------------------------------------*/

    let _window = $(window),
        body = $("body");

    /*      button loading
    /*----------------------------------------*/

    $("[data-loading]").on("click", (e) => {
        e.currentTarget.classList.add("btn-loading");
    });

    /*      select option
    /*----------------------------------------*/

    let select = $(".custom-select-option");

    select.niceSelect();

    select.on("change", (e) => {
        e.target.dispatchEvent(
            new Event("nice-select-updated", { bubbles: true })
        );
    });

    /*      overlay
    /*----------------------------------------*/

    let overlay = $(".overlay");

    /*      header
    /*----------------------------------------*/

    let headerWrap = $(".header-wrap"),
        headerWrapInner = $(".header-wrap-inner"),
        headerWrapInnerHeight = headerWrapInner.outerHeight(),
        headerSearchSm = $(".header-search-sm"),
        searchInputSm = $(".search-input-sm"),
        headerSearchSmClose = $(".header-search-sm-form .btn-close");

    headerSearchSm.on("click", (e) => {
        let target = $(e.currentTarget);

        target.parents(".header-search").next().toggleClass("active");
        searchInputSm.trigger("focus");
    });

    headerSearchSmClose.on("click", (e) => {
        let target = $(e.currentTarget);

        target.parents(".header-search-sm-form").removeClass("active");
    });

    _window.on("resize", () => {
        headerWrapInnerHeight = headerWrapInner.outerHeight();
    });

    _window.on("load scroll resize", () => {
        let headerWrapHeight = headerWrap.outerHeight(),
            headerWrapOffsetTop = headerWrap.offset().top + headerWrapHeight;

        function stickyHeader() {
            let scrollTop = _window.scrollTop();

            if (scrollTop > headerWrapOffsetTop) {
                headerWrap.css("padding-top", `${headerWrapInnerHeight}px`);
                headerWrapInner.addClass("sticky");

                setTimeout(() => {
                    headerWrapInner.addClass("show");
                });

                return;
            }

            headerWrap.css("padding-top", 0);
            headerWrapInner.removeClass("sticky show");
        }

        stickyHeader();
    });

    /*      menu dropdown arrow
    /*----------------------------------------*/

    let megaMenuItem = $(".mega-menu > li"),
        subMenuDropdown = $(".sub-menu > .dropdown"),
        sidebarMenuSubMenu = $(".sidebar-menu .sub-menu");

    function menuDropdownArrow(parentSelector, childSelector) {
        parentSelector.each(function () {
            let self = $(this);

            if (self.children().length > 1) {
                if (window.FleetCart.rtl) {
                    self.children(`${childSelector}`).append(
                        '<i class="las la-angle-left"></i>'
                    );

                    return;
                }

                self.children(`${childSelector}`).append(
                    '<i class="las la-angle-right"></i>'
                );
            }
        });
    }

    menuDropdownArrow(subMenuDropdown, "a");
    menuDropdownArrow(megaMenuItem, ".menu-item");

    /*      navigation
    /*----------------------------------------*/

    let categoryNavInner = $(".category-nav-inner"),
        categoryDropdownWrap = $(".category-dropdown-wrap");

    categoryNavInner.on("click", (e) => {
        e.stopPropagation();

        if (!route().current("home")) {
            categoryDropdownWrap.toggleClass("show");
        }
    });

    categoryDropdownWrap.on("click", (e) => {
        e.stopPropagation();
    });

    /*      sidebar menu
    /*----------------------------------------*/

    let sidebarMenuIcon = $(".sidebar-menu-icon"),
        sidebarMenuWrap = $(".sidebar-menu-wrap"),
        sidebarMenuClose = $(".sidebar-menu-close"),
        sidebarMenuTab = $(".sidebar-menu-tab a"),
        sidebarMenuList = $(".sidebar-menu li"),
        sidebarMenuLink = $(".sidebar-menu > li > a"),
        sidebarMenuListUl = $(".sidebar-menu > li > ul"),
        sidebarMenuDropdown = $(".sidebar-menu > .dropdown"),
        sidebarMenuSubMenuUl = $(".sidebar-menu .sub-menu ul"),
        sidebarMenuSubMenuLink = $(".sidebar-menu .sub-menu > a");

    sidebarMenuIcon.on("click", (e) => {
        e.stopPropagation();

        overlay.addClass("active");
        sidebarMenuWrap.addClass("active");
    });

    sidebarMenuClose.on("click", (e) => {
        overlay.removeClass("active");
        sidebarMenuWrap.removeClass("active");
    });

    sidebarMenuWrap.on("click", (e) => {
        e.stopPropagation();
    });

    sidebarMenuTab.on("click", (e) => {
        let target = $(e.currentTarget);

        e.preventDefault();
        target.tab("show");
    });

    sidebarMenuList.each(function () {
        let self = $(this);

        if (self.children().length > 1) {
            if (window.FleetCart.rtl) {
                self.children("a").after('<i class="las la-angle-left"></i>');

                return;
            }

            self.children("a").after('<i class="las la-angle-right"></i>');
        }
    });

    sidebarMenuDropdown.on("click", (e) => {
        let target = $(e.currentTarget);

        if (!target.hasClass("active")) {
            $(".sidebar-menu > li").removeClass("active");
            target.addClass("active");
        } else {
            $(".sidebar-menu > li").removeClass("active");
        }

        if (!target.children("ul").hasClass("open")) {
            $(".sidebar-menu .open").removeClass("open").slideUp(300);
            target.children("ul").addClass("open").slideDown(300);

            return;
        }

        $(".sidebar-menu .open").removeClass("open").slideUp(300);
    });

    sidebarMenuLink.on("click", (e) => {
        e.stopPropagation();
    });

    sidebarMenuListUl.on("click", (e) => {
        e.stopPropagation();
    });

    sidebarMenuSubMenu.on("click", (e) => {
        let target = $(e.currentTarget);

        if (!target.hasClass("active")) {
            target.addClass("active");
        } else {
            target.removeClass("active");
        }

        target.children("ul").slideToggle(300);
    });

    sidebarMenuSubMenuUl.on("click", function (e) {
        e.stopPropagation();
    });

    sidebarMenuSubMenuLink.on("click", (e) => {
        e.stopPropagation();
    });

    /*     localization 
    /*----------------------------------------*/

    let headerLocalization = $(".header-localization"),
        localizationCrossIcon = $(".localization-cross-icon"),
        localization = $(".localization");

    headerLocalization.on("click", (e) => {
        e.stopPropagation();

        localization.addClass("active");
        overlay.addClass("active");
    });

    localization.on("click", (e) => {
        e.stopPropagation();
    });

    localizationCrossIcon.on("click", (e) => {
        localization.removeClass("active");
        overlay.removeClass("active");
    });

    /*      home slider
    /*----------------------------------------*/

    const homeSlider = $(".home-slider");

    if (homeSlider.length !== 0) {
        const { speed, autoplay, autoplaySpeed, fade, dots, arrows } =
            homeSlider.data();

        homeSlider
            .slick({
                rows: 0,
                rtl: window.FleetCart.rtl,
                cssEase: fade ? "cubic-bezier(0.7, 0, 0.3, 1)" : "ease",
                speed,
                autoplay,
                autoplaySpeed,
                fade,
                dots,
                arrows,
            })
            .slickAnimation();
    }

    /*      features slider
    /*----------------------------------------*/
    const featuresList = $(".features .feature-list");

    featuresList.slick({
        rows: 0,
        rtl: window.FleetCart.rtl,
        autoplay: true,
        slidesToShow: 5,
        slidesToScroll: 5,
        arrows: true,
        responsive: [
            {
                breakpoint: 1401,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                },
            },
            {
                breakpoint: 1181,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                },
            },
            {
                breakpoint: 781,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                },
            },
            {
                breakpoint: 577,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });

    /*      sidebar filter
    /*----------------------------------------*/

    let mobileViewFilter = $(".mobile-view-filter");
    let filterSectionWrap = $(".filter-section-wrap");
    let sidebarFilterClose = $(".sidebar-filter-close");

    mobileViewFilter.on("click", (e) => {
        e.stopPropagation();

        filterSectionWrap.addClass("active");
        overlay.addClass("active");
    });

    sidebarFilterClose.on("click", () => {
        filterSectionWrap.removeClass("active");
        overlay.removeClass("active");
    });

    filterSectionWrap.on("click", (e) => {
        e.stopPropagation();
    });

    body.on("click", () => {
        $(".sidebar-cart-wrap").removeClass("active");
        overlay.removeClass("active");
        sidebarMenuWrap.removeClass("active");
        filterSectionWrap.removeClass("active");
        localization.removeClass("active");
        categoryDropdownWrap.removeClass("show");
    });

    /*      browse categories
    /*----------------------------------------*/

    $(".browse-categories li").each((_, li) => {
        if ($(li).children("ul").length > 0) {
            $(li).addClass("parent");
        }
    });

    let filterCategoriesLink = $(".browse-categories li.parent > a");
    let parentUls = $(".browse-categories li.active").parentsUntil(
        ".browse-categories",
        "ul"
    );

    if (window.FleetCart.rtl) {
        filterCategoriesLink.before('<i class="las la-angle-left"></i>');
    } else {
        filterCategoriesLink.before('<i class="las la-angle-right"></i>');
    }

    parentUls.show().siblings("i").addClass("open");

    $(".browse-categories li i").on("click", (e) => {
        $(e.currentTarget).toggleClass("open").siblings("ul").slideToggle(300);
    });
});
