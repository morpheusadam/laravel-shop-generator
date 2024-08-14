export default {
    computed: {
        hasAnyVariationImage() {
            return this.variationImagePath !== null;
        },
    },

    created() {
        this.setActiveVariationsValue();
    },

    methods: {
        isVariationValueEnabled(variationUid, variationIndex, valueUid) {
            // Check if enabled first variation values
            if (variationIndex === 0) {
                return this.doesVariantExist(valueUid);
            }

            // Check if enabled variation values between first and last variation
            if (
                variationIndex > 0 &&
                variationIndex < this.product.variations.length - 1
            ) {
                return this.doesVariantExist(valueUid);
            }

            // Check if enabled last variation values
            if (variationIndex === this.product.variations.length - 1) {
                const variations = this.cartItemForm.variations;
                const valueUids = Object.values(variations).filter(
                    (uid) => uid !== variations[variationUid]
                );

                valueUids.push(valueUid);

                return this.doesVariantExist(valueUids.sort().join("."));
            }
        },

        setActiveVariationsValue() {
            if (!this.hasAnyVariant) return;

            this.item.uids.split(".").forEach((uid) => {
                this.product.variations.some((variation) => {
                    const value = variation.values.find(
                        (value) => value.uid === uid
                    );

                    if (value !== undefined) {
                        this.$set(
                            this.activeVariationValues,
                            variation.uid,
                            value.label
                        );
                        this.$set(
                            this.cartItemForm.variations,
                            variation.uid,
                            uid
                        );

                        return true;
                    }
                });
            });
        },

        setActiveVariationValueLabel(variationIndex) {
            this.variationImagePath = null;

            const variation = this.product.variations[variationIndex];
            const value = variation.values.find(
                (value) =>
                    value.uid === this.cartItemForm.variations[variation.uid]
            );

            this.$set(this.activeVariationValues, variation.uid, value.label);
        },

        setVariationValueLabel(variationIndex, valueIndex) {
            const variation = this.product.variations[variationIndex];
            const value = variation.values[valueIndex];

            if (!this.isMobileDevice() && variation.type === "image") {
                this.variationImagePath = value.image.path;
            }

            this.$set(this.activeVariationValues, variation.uid, value.label);
        },

        isActiveVariationValue(variationUid, valueUid) {
            if (!this.cartItemForm.variations.hasOwnProperty(variationUid)) {
                return false;
            }

            return this.cartItemForm.variations[variationUid] === valueUid;
        },

        syncVariationValue(variationUid, variationIndex, valueUid, valueIndex) {
            if (!this.isActiveVariationValue(variationUid, valueUid)) {
                this.$set(this.cartItemForm.variations, variationUid, valueUid);
                this.setVariationValueLabel(variationIndex, valueIndex);
                this.updateVariantDetails();
            }
        },
    },
};
