export default {
    data() {
        return {
            defaultVariantUid: "",
            variantPosition: 0,
            variantsLength: 0,
        };
    },

    computed: {
        hasAnyVariant() {
            return this.form.variants.length !== 0;
        },

        isCollapsedVariantsAccordion() {
            return this.form.variants.every(({ is_open }) => is_open === false);
        },
    },

    mounted() {
        if (this.hasAnyVariant) {
            this.setVariantsName();
        }
    },

    methods: {
        prepareVariants(variants) {
            variants.forEach((variant) => {
                this.$set(variant, "position", this.variantPosition++);
                this.$set(variant, "is_open", false);
                this.$set(variant, "is_selected", false);
            });
        },

        changeDefaultVariant(uid) {
            const variants = this.form.variants;
            const index = variants.findIndex((variant) => variant.uid === uid);

            if (variants[index].is_active === true) {
                this.resetDefaultVariant();
                this.defaultVariantUid = variants[index].uid;
                this.$set(variants[index], "is_default", true);

                return;
            }

            this.defaultVariantUid = this.defaultVariantUid;
        },

        setDefaultVariant() {
            const variants = this.form.variants;
            const index = variants.findIndex(
                ({ uid }) => uid === this.defaultVariantUid
            );

            this.resetDefaultVariant();

            const variant = variants[index === -1 ? 0 : index];

            this.defaultVariantUid = variant.uid;
            this.$set(variant, "is_default", true);

            if (index === -1) {
                this.defaultVariantUid = variants[0].uid;
                this.$set(variants[0], "is_active", true);
            }
        },

        isActiveVariant(index) {
            return this.form.variants[index].is_active;
        },

        changeVariantStatus(variantUid) {
            if (this.defaultVariantUid === variantUid) {
                toaster(
                    trans("product::products.variants.disable_default_variant"),
                    {
                        type: "default",
                    }
                );

                return;
            }

            this.clearErrors({
                name: "variants",
                uid: variantUid,
            });
        },

        resetDefaultVariant() {
            this.form.variants.some((variant) => {
                if (variant.is_default === true) {
                    this.$set(variant, "is_default", false);

                    return true;
                }
            });
        },

        getFilteredVariations() {
            return this.form.variations
                .map(({ type, values }) =>
                    values
                        .map(({ uid, label }) => {
                            if (type !== "" && Boolean(label)) {
                                return { uid, label };
                            }
                        })
                        .filter(Boolean)
                )
                .filter((data) => data.length !== 0);
        },

        generateNewVariants(variations) {
            return variations
                .reduce((accumulator, currentValue) =>
                    accumulator.flatMap((x) =>
                        currentValue.map((y) => {
                            return {
                                uid: x.uid + "." + y.uid,
                                label: x.label + " / " + y.label,
                            };
                        })
                    )
                )
                .map(({ uid, label }) => {
                    return {
                        uids: uid.split(".").sort().join("."),
                        name: label,
                    };
                });
        },

        setVariantsName() {
            this.generateNewVariants(this.getFilteredVariations()).forEach(
                (variant, index) => {
                    this.form.variants[index].name = variant.name;
                }
            );
        },

        isEqualVariants(newVariants, oldVariants) {
            return (
                newVariants.map(({ uids }) => uids).toString() ===
                oldVariants.map(({ uids }) => uids).toString()
            );
        },

        generateVariants(isReordered) {
            this.$nextTick(() => {
                this.initColorPicker();
                this.updateColorThumbnails();
            });

            // Filter empty variation values
            const variations = this.getFilteredVariations();

            if (variations.length === 0) {
                this.form.variants = [];
                this.variantsLength = 0;

                return;
            }

            const newVariants = this.generateNewVariants(variations);
            const oldVariants = this.form.variants.map(({ uids }) => {
                return {
                    uids,
                };
            });

            // Do not generate variants if empty value is reordered
            if (
                isReordered === true &&
                this.isEqualVariants(newVariants, oldVariants)
            ) {
                return;
            }

            if (isReordered === true) {
                this.notifyVariantsReordered();
            }

            if (newVariants.length > this.variantsLength) {
                // Variation added
                this.addVariants(newVariants, oldVariants);
            } else if (newVariants.length < this.variantsLength) {
                // Variation removed
                this.removeVariants(newVariants, oldVariants);
            } else if (newVariants.length === this.variantsLength) {
                // Variations reordered
                this.reorderVariants(newVariants, oldVariants);
            }

            this.variantsLength = newVariants.length;
            this.setDefaultVariant();
        },

        addVariants(newVariants, oldVariants) {
            this.notifyVariantsCreated(newVariants.length);

            // Add initial variation with single or multiple values when variants are empty
            if (oldVariants.length === 0) {
                newVariants.forEach((newVariant) => {
                    this.form.variants.push(
                        this.variantDefaultData(newVariant)
                    );
                });

                return;
            }

            // A new single value has been added with existing variation values
            if (this.hasCommonVariantUids(newVariants, oldVariants)) {
                const oldVariantsUids = oldVariants.map(({ uids }) => uids);

                newVariants.forEach((newVariant, index) => {
                    if (!oldVariantsUids.includes(newVariant.uids)) {
                        this.form.variants.splice(
                            index,
                            0,
                            this.variantDefaultData(newVariant)
                        );
                    }
                });

                return;
            }

            // A new variation with multiple values has been added
            const matchedUids = [];

            oldVariants.forEach(({ uids }) => {
                newVariants.forEach((newVariant, index) => {
                    const doesUidExist = uids
                        .split(".")
                        .every((uids) =>
                            newVariant.uids.split(".").includes(uids)
                        );

                    if (doesUidExist && !matchedUids.includes(uids)) {
                        matchedUids.push(uids);
                        this.setVariantData(newVariant, index);

                        return;
                    }

                    if (doesUidExist) {
                        this.form.variants.splice(
                            index,
                            0,
                            this.variantDefaultData(newVariant)
                        );
                    }
                });
            });
        },

        removeVariants(newVariants, oldVariants) {
            this.resetBulkEditVariantFields();
            this.notifyVariantsRemoved(oldVariants.length - newVariants.length);

            // Variation single value has been removed
            if (this.hasCommonVariantUids(newVariants, oldVariants)) {
                const newVariantsUids = newVariants.map(({ uids }) => uids);

                oldVariants.forEach(({ uids }) => {
                    if (!newVariantsUids.includes(uids)) {
                        const index = this.form.variants.findIndex(
                            (variant) => variant.uids === uids
                        );

                        this.clearErrors({
                            name: "variants",
                            uid: this.form.variants[index].uid,
                        });
                        this.form.variants.splice(index, 1);
                    }
                });

                return;
            }

            // A variation with multiple values has been removed
            const matchedUids = [];

            newVariants.forEach(({ uids, name }) => {
                oldVariants.forEach((oldVariant) => {
                    const index = this.form.variants.findIndex(
                        (variant) => variant.uids === oldVariant.uids
                    );
                    const doesUidExist = uids
                        .split(".")
                        .every((uids) =>
                            oldVariant.uids.split(".").includes(uids)
                        );

                    if (doesUidExist && !matchedUids.includes(uids)) {
                        matchedUids.push(uids);
                        this.setVariantData({ uids, name }, index);

                        return;
                    }

                    if (doesUidExist) {
                        this.clearErrors({
                            name: "variants",
                            uid: this.form.variants[index].uid,
                        });
                        this.form.variants.splice(index, 1);
                    }
                });
            });
        },

        reorderVariants(newVariants, oldVariants) {
            // Reordered variations or variation values
            const newVariantUids = newVariants.map(({ uids }) => uids);

            if (this.hasCommonVariantUids(newVariants, oldVariants)) {
                oldVariants.forEach(({ uids }) => {
                    const index = newVariantUids.indexOf(uids);
                    const formIndex = this.form.variants.findIndex(
                        (variant) => variant.uids === uids
                    );

                    // Update variant data before swap
                    this.setVariantData(
                        { name: newVariants[index].name },
                        formIndex
                    );

                    // Swap variant elements
                    this.form.variants[formIndex] = this.form.variants.splice(
                        index,
                        1,
                        this.form.variants[formIndex]
                    )[0];
                });

                return;
            }

            // A new variation with a single value has been added
            newVariants.forEach((newVariant, index) => {
                this.setVariantData(newVariant, index);
            });
        },

        hasCommonVariantUids(newVariants, oldVariants) {
            // Check if the old variants UID is present in the new variants
            return oldVariants.some(({ uids }) =>
                newVariants.map(({ uids }) => uids).includes(uids)
            );
        },

        setVariantData({ uids, name }, index) {
            if (uids !== undefined) {
                this.$set(this.form.variants[index], "uid", md5(uids));
                this.$set(this.form.variants[index], "uids", uids);
            }

            this.$set(this.form.variants[index], "name", name);
        },

        variantDefaultData({ uids, name }) {
            return {
                position: this.variantPosition++,
                uid: md5(uids),
                uids,
                name,
                media: [],
                is_active: true,
                is_open: false,
                is_default: false,
                is_selected: false,
                special_price_type: "fixed",
                manage_stock: 0,
                in_stock: 1,
            };
        },

        resetVariants() {
            this.form.variants = [];
        },

        addVariantMedia(index) {
            const picker = new MediaPicker({ type: "image", multiple: true });

            picker.on("select", ({ id, path }) => {
                this.form.variants[index].media.push({
                    id: +id,
                    path,
                });
            });
        },

        removeVariantMedia(variantIndex, mediaIndex) {
            this.form.variants[variantIndex].media.splice(mediaIndex, 1);
        },

        notifyVariantChanges({ count, status }) {
            toaster(
                trans(`product::products.variants.variants_${status}`, {
                    count,
                    suffix: trans(
                        `product::products.variants.${
                            count > 1 ? "variants" : "variant"
                        }`
                    ),
                }).toLowerCase(),
                {
                    type: "default",
                }
            );
        },

        notifyVariantsCreated(count) {
            this.notifyVariantChanges({ count, status: "created" });
        },

        notifyVariantsRemoved(count) {
            this.notifyVariantChanges({ count, status: "removed" });
        },

        notifyVariantsReordered() {
            toaster(trans("product::products.variants.variants_reordered"), {
                type: "default",
            });
        },
    },
};
