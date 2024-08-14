export default {
    data() {
        return {
            bulkEditVariantsUid: "",
            bulkEditVariantsField: "",
            bulkEditVariants: {},
        };
    },

    computed: {
        hasBulkEditVariantsUid() {
            return this.bulkEditVariantsUid !== "";
        },

        hasBulkEditVariantsField() {
            return this.bulkEditVariantsField !== "";
        },
    },

    methods: {
        changeBulkEditVariantsUid(uid) {
            this.resetVariantsSelection();

            if (uid === "") {
                this.resetBulkEditVariantsField();

                return;
            }

            this.selectVariants(uid);
        },

        selectVariants(uid) {
            this.resetVariantsSelection();

            if (uid === "") return;

            if (uid !== "all") {
                this.selectSpecificVariants(uid);

                return;
            }

            this.selectAllVariants();
        },

        selectAllVariants() {
            this.form.variants.forEach((variant) => {
                this.$set(variant, "is_selected", true);
            });
        },

        selectSpecificVariants(uid) {
            this.form.variants.forEach((variant) => {
                if (variant.uids.includes(uid)) {
                    this.$set(variant, "is_selected", true);
                }
            });
        },

        changeBulkEditVariantsField(fieldName) {
            const focusableFieldNames = ["sku", "price", "special_price"];

            if (focusableFieldNames.includes(fieldName)) {
                this.focusField({
                    selector: `#bulk-edit-variants-${fieldName.replace(
                        /_/g,
                        "-"
                    )}`,
                });
            }

            this.resetBulkEditVariants();
        },

        addBulkEditVariantsMedia() {
            const picker = new MediaPicker({ type: "image", multiple: true });

            picker.on("select", ({ id, path }) => {
                this.bulkEditVariants.media.push({
                    id: +id,
                    path,
                });
            });
        },

        removeBulkEditVariantsMedia(index) {
            this.bulkEditVariants.media.splice(index, 1);
        },

        bulkEditvariantsDefaultData() {
            return {
                is_active: true,
                media: [],
                price: null,
                special_price: null,
                special_price_type: "fixed",
                special_price_start: null,
                special_price_end: null,
                manage_stock: 0,
                qty: null,
                in_stock: 1,
            };
        },

        resetBulkEditVariantFields() {
            this.bulkEditVariantsUid = "";

            this.resetVariantsSelection();
            this.resetBulkEditVariantsField();
        },

        resetBulkEditVariantsField() {
            this.bulkEditVariantsField = "";

            this.resetBulkEditVariants();
        },

        resetBulkEditVariants() {
            this.bulkEditVariants = {
                ...this.bulkEditvariantsDefaultData(),
            };
        },

        resetVariantsSelection() {
            this.form.variants.forEach((variant) => {
                this.$set(variant, "is_selected", false);
            });
        },

        clearVariantsSpecialPriceErrors(uid) {
            Object.keys(this.errors).forEach((key) => {
                if (
                    key.startsWith(`variants.${uid}`) &&
                    key.includes("special_price")
                ) {
                    this.errors.clear(key);
                }
            });
        },

        updateVariantsField(variant, { key, value }) {
            this.$set(variant, key, value);

            this.errors.clear(`variants.${variant.uid}.${key}`);
        },

        updateVariantsStatus(variant, { key, value }) {
            if (variant.is_default === true) return;

            this.$set(variant, key, value);

            this.errors.clear(`variants.${variant.uid}.${key}`);
        },

        updateVariantsSpecialPrice(
            variant,
            { key, value },
            { special_price_type, special_price_start, special_price_end }
        ) {
            this.$set(variant, key, value);
            this.$set(variant, "special_price_type", special_price_type);
            this.$set(variant, "special_price_start", special_price_start);
            this.$set(variant, "special_price_end", special_price_end);

            this.clearVariantsSpecialPriceErrors(variant.uid);
        },

        updateVariantsManageStock(variant, { key, value }, { qty }) {
            this.$set(variant, key, value);
            this.$set(variant, "qty", qty);

            this.errors.clear([
                `variants.${variant.uid}.${key}`,
                `variants.${variant.uid}.qty`,
            ]);
        },

        callUpdateVariantsMethodByField(key) {
            return {
                media: this.updateVariantsField,
                sku: this.updateVariantsField,
                is_active: this.updateVariantsStatus,
                price: this.updateVariantsField,
                special_price: this.updateVariantsSpecialPrice,
                manage_stock: this.updateVariantsManageStock,
                in_stock: this.updateVariantsField,
            }[key];
        },

        updateVariants(field) {
            this.form.variants.forEach((variant) => {
                if (variant.is_selected) {
                    this.callUpdateVariantsMethodByField(field.key)(
                        variant,
                        field,
                        this.bulkEditVariants
                    );
                }
            });
        },

        bulkUpdateVariants() {
            if (
                !this.hasBulkEditVariantsUid &&
                !this.hasBulkEditVariantsField
            ) {
                return;
            }

            const field = {
                key: this.bulkEditVariantsField,
                value: this.bulkEditVariants[this.bulkEditVariantsField],
            };

            this.updateVariants(field);
            this.resetBulkEditVariantFields();

            toaster(trans("product::products.variants.bulk_variants_updated"), {
                type: "default",
            });
        },
    },
};
