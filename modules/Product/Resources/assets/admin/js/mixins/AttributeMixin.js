export default {
    watch: {
        "form.attributes": {
            immediate: true,
            handler(newValue) {
                if (newValue.length === 0) {
                    this.addAttribute();
                }
            },
        },
    },

    methods: {
        prepareAttributes(attributes) {
            attributes.forEach((attribute) => {
                this.$set(attribute, "uid", this.uid());
            });
        },

        getAttributeValuesById(id) {
            let values = null;
            let matched = false;

            if (id === "") return;

            Object.values(FleetCart.data["attribute-sets"]).some(
                (attributeSet) => {
                    attributeSet.attributes.some((attribute) => {
                        if (attribute.id === id) {
                            matched = true;
                            values = attribute.values;

                            return true;
                        }
                    });

                    if (matched) {
                        return true;
                    }
                }
            );

            return values;
        },

        focusAttributeValueField(index) {
            this.$refs.attributeValues[index].$el.selectize.focus();
        },

        addAttribute() {
            this.form.attributes.push({
                attribute_id: "",
                uid: this.uid(),
                values: [],
            });
        },

        deleteAttribute(index, uid) {
            this.form.attributes.splice(index, 1);
            this.clearErrors({ name: "attributes", uid });
        },
    },
};
