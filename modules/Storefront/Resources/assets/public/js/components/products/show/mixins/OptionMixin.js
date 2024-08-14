export default {
    methods: {
        updateSelectTypeOptionValue(optionId, e) {
            this.$set(this.cartItemForm.options, optionId, $(e.target).val());

            this.errors.clear(`options.${optionId}`);
        },

        updateCheckboxTypeOptionValue(optionId, e) {
            let values = $(e.target)
                .parents(".variant-check")
                .find('input[type="checkbox"]:checked')
                .map((_, el) => {
                    return el.value;
                });

            this.$set(this.cartItemForm.options, optionId, values.get());
        },

        customRadioTypeOptionValueIsActive(optionId, valueId) {
            if (!this.cartItemForm.options.hasOwnProperty(optionId)) {
                return false;
            }

            return this.cartItemForm.options[optionId] === valueId;
        },

        syncCustomRadioTypeOptionValue(optionId, valueId) {
            if (this.customRadioTypeOptionValueIsActive(optionId, valueId)) {
                this.$delete(this.cartItemForm.options, optionId);
            } else {
                this.$set(this.cartItemForm.options, optionId, valueId);

                this.errors.clear(`options.${optionId}`);
            }
        },

        customCheckboxTypeOptionValueIsActive(optionId, valueId) {
            if (!this.cartItemForm.options.hasOwnProperty(optionId)) {
                this.$set(this.cartItemForm.options, optionId, []);

                return false;
            }

            return this.cartItemForm.options[optionId].includes(valueId);
        },

        syncCustomCheckboxTypeOptionValue(optionId, valueId) {
            if (this.customCheckboxTypeOptionValueIsActive(optionId, valueId)) {
                this.cartItemForm.options[optionId].splice(
                    this.cartItemForm.options[optionId].indexOf(valueId),
                    1
                );
            } else {
                this.cartItemForm.options[optionId].push(valueId);

                this.errors.clear(`options.${optionId}`);
            }
        },
    },
};
