import Vue from "vue";
import ProductMixin from "./mixins/ProductMixin";
import Errors from "@admin/js/Errors";

Vue.prototype.defaultCurrencySymbol = FleetCart.defaultCurrencySymbol;
Vue.prototype.route = route;

new Vue({
    el: "#app",

    mixins: [ProductMixin],

    data: {
        formSubmissionType: null,
        form: {
            brand_id: "",
            tax_class_id: "",
            is_active: true,
            media: [],
            is_virtual: false,
            manage_stock: 0,
            in_stock: 1,
            special_price_type: "fixed",
            meta: {},
            attributes: [],
            downloads: [],
            variations: [],
            variants: [],
            options: [],
            slug: null,
        },
        errors: new Errors(),
        selectizeConfig: {
            plugins: ["remove_button"],
        },
        searchableSelectizeConfig: {},
        categoriesSelectizeConfig: {},
        flatPickrConfig: {
            mode: "single",
            enableTime: true,
            altInput: true,
        },
    },

    created() {
        this.setFormData();
        this.setSearchableSelectizeConfig();
        this.setCategoriesSelectizeConfig();
        this.setDefaultVariantUid();
        this.setVariantsLength();
    },

    mounted() {
        this.hideAlertExitFlash();
    },

    methods: {
        prepareFormData(formData) {
            this.prepareAttributes(formData.attributes);
            this.prepareVariations(formData.variations);
            this.prepareVariants(formData.variants);
            this.prepareOptions(formData.options);

            return formData;
        },

        setFormData() {
            this.form = { ...this.prepareFormData(FleetCart.data["product"]) };
        },

        setDefaultVariantUid() {
            if (this.hasAnyVariant) {
                this.defaultVariantUid = this.form.variants.find(
                    ({ is_default }) => is_default === true
                ).uid;
            }
        },

        setVariantsLength() {
            this.variantsLength = this.form.variants.length;
        },

        hideAlertExitFlash() {
            const alertExitFlash = $(".alert-exit-flash");

            if (alertExitFlash.length !== 0) {
                setTimeout(() => {
                    alertExitFlash.remove();
                }, 3000);
            }
        },

        submit({ submissionType }) {
            this.formSubmissionType = submissionType;

            $.ajax({
                type: "PUT",
                url: route("admin.products.update", {
                    id: this.form.id,
                    ...(submissionType === "save_and_exit" && {
                        exit_flash: true,
                    }),
                }),
                data: this.transformData(this.form),
                dataType: "json",
                success: (response) => {
                    if (submissionType === "save_and_exit") {
                        location.href = route("admin.products.index");

                        return;
                    }

                    this.form = { ...response.product_resource };

                    this.errors.reset();
                    this.prepareFormData(this.form);
                    this.resetBulkEditVariantFields();

                    if (this.hasAnyVariant) {
                        this.setVariantsName();
                    }

                    toaster(response.message, {
                        type: "success",
                    });
                },
            })
                .catch((error) => {
                    this.formSubmissionType = null;

                    toaster(error.responseJSON.message, {
                        type: "default",
                    });

                    if (error.status === 422) {
                        this.errors.reset();
                        this.errors.record(error.responseJSON.errors);
                        this.focusFirstErrorField(this.$refs.form.elements);

                        return;
                    }

                    if (this.hasAnyVariant) {
                        this.regenerateVariationsAndVariantsUid();
                    }
                })
                .always(() => {
                    if (submissionType === "save") {
                        this.formSubmissionType = null;
                    }
                });
        },
    },
});
