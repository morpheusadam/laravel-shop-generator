export default {
    data() {
        return {
            globalOptionId: "",
            addingGlobalOption: false,
        };
    },

    computed: {
        isAddGlobalOptionDisabled() {
            return this.globalOptionId === "" || this.addingGlobalOption;
        },

        isCollapsedOptionsAccordion() {
            return this.form.options.every(({ is_open }) => is_open === false);
        },
    },

    watch: {
        "form.options": {
            immediate: true,
            handler(newValue) {
                if (newValue.length === 0) {
                    this.addOption({ preventFocus: true });
                }
            },
        },
    },

    methods: {
        prepareOptions(options) {
            options.forEach((option) => {
                this.$set(option, "uid", this.uid());
                this.$set(option, "is_open", false);

                option.values.forEach((_, valueIndex) => {
                    this.$set(option.values[valueIndex], "uid", this.uid());
                });
            });
        },

        addOption({ preventFocus }) {
            const options = this.form.options;
            const uid = this.uid();

            options.push({
                uid,
                type: "",
                is_open: true,
                is_global: false,
                is_required: false,
                values: [
                    {
                        uid: this.uid(),
                        price_type: "fixed",
                    },
                ],
            });

            if (!preventFocus) {
                this.focusField({
                    selector: `#options-${uid}-name`,
                });
            }
        },

        deleteOption(index, uid) {
            this.form.options.splice(index, 1);
            this.clearErrors({ name: "options", uid });
        },

        changeOptionType(index, uid) {
            let option = this.form.options[index];
            const fieldName = this.isOptionTypeText(option) ? "price" : "label";

            this.clearValuesError({ name: "options", uid });

            if (option.values.length === 1) {
                this.focusField({
                    selector: `#options-${uid}-values-${option.values[0].uid}-${fieldName}`,
                });
            }
        },

        isOptionTypeText(option) {
            const TYPES = ["field", "textarea", "date", "date_time", "time"];

            if (TYPES.includes(option.type)) {
                option.values.length > 1 && option.values.splice(1);

                return true;
            }

            return false;
        },

        isOptionTypeSelect({ type }) {
            const TYPES = [
                "dropdown",
                "checkbox",
                "checkbox_custom",
                "radio",
                "radio_custom",
                "multiple_select",
            ];

            return TYPES.includes(type) ? true : false;
        },

        addOptionRow(index, optionUid) {
            const valueUid = this.uid();

            this.form.options[index].values.push({
                uid: valueUid,
                price_type: "fixed",
            });

            this.focusField({
                selector: `#options-${optionUid}-values-${valueUid}-label`,
            });
        },

        addOptionRowOnPressEnter(event, optionIndex, valueIndex) {
            const option = this.form.options[optionIndex];
            const values = option.values;

            if (event.target.value === "") return;

            if (values.length - 1 === valueIndex) {
                this.addOptionRow(optionIndex, option.uid);

                return;
            }

            if (valueIndex < values.length - 1) {
                $(
                    `#options-${option.uid}-values-${
                        values[valueIndex + 1].uid
                    }-label`
                ).trigger("focus");
            }
        },

        deleteOptionRow(optionIndex, optionUid, valueIndex, valueUid) {
            const option = this.form.options[optionIndex];

            option.values.splice(valueIndex, 1);

            this.clearValueRowErrors({ name: "options", optionUid, valueUid });

            if (option.values.length === 0) {
                this.addOptionRow(optionIndex, optionUid);
            }
        },

        addGlobalOption() {
            if (this.globalOptionId === "") return;

            this.addingGlobalOption = true;

            $.ajax({
                type: "GET",
                url: route("admin.options.show", this.globalOptionId),
                dataType: "json",
                success: (option) => {
                    option.uid = this.uid();
                    option.is_open = true;

                    option.values.forEach((value) => {
                        value.uid = this.uid();
                    });

                    this.form.options.push(option);

                    this.$nextTick(() => {
                        $(`#options-${option.uid}-name`).trigger("focus");
                    });

                    toaster(
                        trans("product::products.options.option_inserted"),
                        {
                            type: "default",
                        }
                    );
                },
            })
                .catch((error) => {
                    toaster(error.responseJSON.message, {
                        type: "error",
                    });
                })
                .always(() => {
                    this.globalOptionId = "";
                    this.addingGlobalOption = false;
                });
        },
    },
};
