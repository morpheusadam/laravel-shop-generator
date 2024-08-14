window.admin.removeSubmitButtonOffsetOn([
    "#logo",
    "#footer",
    "#newsletter",
    "#product_page",
    "#slider_banners",
    "#three_column_full_width_banners",
    "#brands",
    "#two_column_banners",
    "#three_column_banners",
    "#one_column_banner",
]);

$("#storefront_theme_color").on("change", (e) => {
    if (e.currentTarget.value === "custom_color") {
        $("#custom-theme-color").removeClass("hide");
    } else {
        $("#custom-theme-color").addClass("hide");
    }
});

$("#storefront_mail_theme_color").on("change", (e) => {
    if (e.currentTarget.value === "custom_color") {
        $("#custom-mail-theme-color").removeClass("hide");
    } else {
        $("#custom-mail-theme-color").addClass("hide");
    }
});

$("#storefront-settings-edit-form").on("click", ".panel-image", (e) => {
    let picker = new MediaPicker({ type: "image" });

    picker.on("select", (file) => {
        const target = $(e.currentTarget);

        target.find("i").remove();
        target.find("img").attr("src", file.path).removeClass("hide");
        target.find(".banner-file-id").val(file.id);

        if (target.find("button.remove-image").length === 0) {
            target.append(
                `<button type="button" class="btn remove-image"></button>`
            );
        }
    });
});

$("#storefront-settings-edit-form").on("click", ".remove-image", (e) => {
    e.stopPropagation();

    const target = $(e.currentTarget);

    target.parent().prepend('<i class="fa fa-picture-o"></i>');
    target.parent().find("img").removeAttr("src").addClass("hide");
    target.parent().find("input").attr("value", "");
    target.remove();
});

$(".product-type").on("change", (e) => {
    let categoryProducts = $(e.currentTarget)
        .parents(".form-group")
        .siblings(".category-products");
    let productsLimit = $(e.currentTarget)
        .parents(".form-group")
        .siblings(".products-limit");
    let customProducts = $(e.currentTarget)
        .parents(".form-group")
        .siblings(".custom-products");

    categoryProducts.addClass("hide");
    productsLimit.addClass("hide");
    customProducts.addClass("hide");

    if (e.currentTarget.value === "category_products") {
        categoryProducts.removeClass("hide");
    }

    if (
        e.currentTarget.value === "latest_products" ||
        e.currentTarget.value === "recently_viewed_products" ||
        e.currentTarget.value === "category_products"
    ) {
        productsLimit.removeClass("hide");
    }

    if (e.currentTarget.value === "custom_products") {
        customProducts.removeClass("hide");
    }
});

$(function () {
    if ($("#logo").hasClass("active")) {
        $("#logo")
            .parent()
            .find('button[type="submit"]')
            .parent()
            .removeClass("col-md-offset-2");
    }
});
