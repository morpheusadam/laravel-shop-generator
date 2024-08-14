import Coloris from "@melloware/coloris";

export default {
    data() {
        return {
            globalVariationId: "",
            addingGlobalVariation: false,
            variations: [],
        };
    },

    computed: {
        isAddGlobalVariationDisabled() {
            return this.globalVariationId === "" || this.addingGlobalVariation;
        },

        isCollapsedVariationsAccordion() {
            return this.form.variations.every(
                ({ is_open }) => is_open === false
            );
        },
    },

    watch: {
        "form.variations": {
            immediate: true,
            handler(newValue) {
                if (newValue.length === 0) {
                    this.addVariation({ preventFocus: true });
                }
            },
        },
    },

    mounted() {
        this.initColorPicker();
        this.hideColorPicker();
    },

    methods: {
        prepareVariations(variations) {
            variations.forEach((variation) => {
                this.$set(variation, "is_open", false);
            });
        },

        regenerateVariationsUid() {
            this.form.variations.forEach((variation) => {
                this.$set(variation, "uid", this.uid());

                variation.values.forEach((_, valueIndex) => {
                    this.$set(variation.values[valueIndex], "uid", this.uid());
                });
            });
        },

        reorderVariations() {
            this.generateVariants();
            this.notifyVariantsReordered();
        },

        reorderVariationValues() {
            this.generateVariants(true);
        },

        addVariation({ preventFocus }) {
            const uid = this.uid();

            this.form.variations.push({
                uid,
                type: "",
                is_global: false,
                is_open: true,
                values: [
                    {
                        uid: this.uid(),
                        image: {
                            id: null,
                            path: null,
                        },
                    },
                ],
            });

            if (!preventFocus) {
                this.focusField({
                    selector: `#variations-${uid}-name`,
                });
            }
        },

        deleteVariation(index, uid) {
            this.form.variations.splice(index, 1);
            this.clearErrors({ name: "variations", uid });
            this.generateVariants();
        },

        changeVariationType(value, index, uid) {
            const variation = this.form.variations[index];

            if (value !== "" && variation.values.length === 1) {
                this.focusField({
                    selector: `#variations-${uid}-values-${variation.values[0].uid}-label`,
                });
            }

            if (value === "text") {
                variation.values.forEach((value) => {
                    this.errors.clear([
                        `variations.${uid}.values.${value.uid}.color`,
                        `variations.${uid}.values.${value.uid}.image`,
                    ]);
                });
            } else if (value === "color") {
                variation.values.forEach((value) => {
                    this.errors.clear(
                        `variations.${uid}.values.${value.uid}.image`
                    );
                });

                this.$nextTick(() => {
                    this.initColorPicker();
                });
            } else if (value === "image") {
                variation.values.forEach((value, valueIndex) => {
                    if (!value.image) {
                        this.$set(variation.values[valueIndex], "image", {
                            id: null,
                            path: null,
                        });
                    }
                });

                variation.values.forEach((value) => {
                    this.errors.clear(
                        `variations.${uid}.values.${value.uid}.color`
                    );
                });
            } else {
                this.clearValuesError(index, uid);
            }
        },

        chooseVariationImage(
            variationIndex,
            variationUid,
            valueIndex,
            valueUid
        ) {
            let picker = new MediaPicker({ type: "image" });

            picker.on("select", ({ id, path }) => {
                this.form.variations[variationIndex].values[valueIndex].image =
                    {
                        id: +id,
                        path,
                    };

                this.errors.clear(
                    `variations.${variationUid}.values.${valueUid}.image`
                );
            });
        },

        addVariationRow(index, variationUid) {
            const valueUid = this.uid();

            this.form.variations[index].values.push({
                uid: valueUid,
                image: {
                    id: null,
                    path: null,
                },
            });

            this.$nextTick(() => {
                this.initColorPicker();

                $(
                    `#variations-${variationUid}-values-${valueUid}-label`
                ).trigger("focus");
            });
        },

        addVariationRowOnPressEnter(event, variationIndex, valueIndex) {
            const variation = this.form.variations[variationIndex];
            const values = variation.values;

            if (event.target.value === "") return;

            if (values.length - 1 === valueIndex) {
                this.addVariationRow(variationIndex, variation.uid);

                return;
            }

            if (valueIndex < values.length - 1) {
                $(
                    `#variations-${variation.uid}-values-${
                        values[valueIndex + 1].uid
                    }-label`
                ).trigger("focus");
            }
        },

        deleteVariationRow(variationIndex, variationUid, valueIndex, valueUid) {
            const variation = this.form.variations[variationIndex];

            variation.values.splice(valueIndex, 1);

            this.clearValueRowErrors({
                name: "variations",
                variationUid,
                valueUid,
            });

            if (variation.values.length === 0) {
                this.addVariationRow(variationIndex, variationUid);
            }

            this.generateVariants();
        },

        updateColorThumbnails() {
            this.form.variations.forEach(({ uid, type, values }) => {
                if (type !== "color") return;

                const elements = document.querySelectorAll(
                    `.variation-${uid} .clr-field`
                );

                values.forEach(({ color }, valueIndex) => {
                    elements[valueIndex].style.color = color || "";
                });
            });
        },

        initColorPicker() {
            Coloris.init();

            Coloris({
                el: ".color-picker",
                alpha: false,
                rtl: FleetCart.rtl,
                theme: "large",
                wrap: true,
                format: "hex",
                selectInput: true,
                swatches: [
                    "#D01C1F",
                    "#3AA845",
                    "#118257",
                    "#0A33AE",
                    "#0D46A0",
                    "#000000",
                    "#5F4C3A",
                    "#726E6E",
                    "#F6D100",
                    "#C0E506",
                    "#FF540A",
                    "#C5A996",
                    "#4B80BE",
                    "#A1C3DA",
                    "#C8BFC2",
                    "#A9A270",
                ],
            });
        },

        hideColorPicker() {
            $(document).on("click", "#clr-swatches button", (e) => {
                $(e.currentTarget)
                    .parents("#clr-picker")
                    .removeClass("clr-open");
            });
        },

        addGlobalVariation() {
            if (this.globalVariationId === "") return;

            this.addingGlobalVariation = true;

            $.ajax({
                type: "GET",
                url: route("admin.variations.show", this.globalVariationId),
                dataType: "json",
                success: (variation) => {
                    variation.uid = this.uid();
                    variation.is_open = true;

                    variation.values.forEach((value) => {
                        value.uid = this.uid();
                    });

                    this.form.variations.push(variation);
                    this.generateVariants();

                    this.$nextTick(() => {
                        $(`#variations-${variation.uid}-name`).trigger("focus");
                    });
                },
            })
                .catch((error) => {
                    toaster(error.responseJSON.message, {
                        type: "error",
                    });
                })
                .always(() => {
                    this.globalVariationId = "";
                    this.addingGlobalVariation = false;
                });
        },
    },
};
