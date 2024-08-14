import Vue from "vue";
import ProductMixin from "./mixins/ProductMixin";
import Errors from "@admin/js/Errors";
import { generateSlug } from "@admin/js/functions";

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
        this.setSearchableSelectizeConfig();
        this.setCategoriesSelectizeConfig();
    },

    methods: {
        setProductSlug(value) {
            this.form.slug = generateSlug(value);
        },

        setFormDefaultData() {
            this.form = {
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
            };
        },

        resetForm() {
            this.setFormDefaultData();
            this.textEditor.get("description").setContent("");
            this.textEditor.get("description").execCommand("mceCancel");
            this.resetBulkEditVariantFields();

            this.focusField({
                selector: "#name",
            });
        },

        submit({ submissionType }) {
            this.formSubmissionType = submissionType;

            $.ajax({
                type: "POST",
                url: route("admin.products.store", {
                    ...((submissionType === "save_and_edit" ||
                        submissionType === "save_and_exit") && {
                        exit_flash: true,
                    }),
                }),
                data: this.transformData(this.form),
                dataType: "json",
                success: ({ message, product_id }) => {
                    if (submissionType === "save_and_edit") {
                        location.href = route(
                            "admin.products.edit",
                            product_id
                        );

                        return;
                    }

                    if (submissionType === "save_and_exit") {
                        location.href = route("admin.products.index");

                        return;
                    }

                    toaster(message, {
                        type: "success",
                    });

                    this.resetForm();
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
