export default {
    methods: {
        transformMedia(formData) {
            formData.media = formData.media.map((data) => data.id);
        },

        transformAttributes(formData) {
            formData.attributes = formData.attributes
                .filter(({ attribute_id }) => attribute_id !== "")
                .reduce((accumulator, { attribute_id, uid, values }) => {
                    return { ...accumulator, [uid]: { attribute_id, values } };
                }, {});
        },

        transformDownloads(formData) {
            formData.downloads = formData.downloads
                .filter(({ id }) => id !== null)
                .map(({ id }) => id);
        },

        transformVariations(formData) {
            const PATHS = {
                text: ["id", "uid", "label"],
                color: ["id", "uid", "label", "color"],
                image: ["id", "uid", "label", "image"],
            };

            formData.variations = formData.variations
                .filter(({ name, type }) => Boolean(name) || type !== "")
                .reduce((accumulator, variation) => {
                    if (variation.type === "") {
                        variation.values = [];
                    } else {
                        variation.values = variation.values.reduce(
                            (valueAccumulator, value) => {
                                value = _.pick(value, PATHS[variation.type]);

                                if (variation.type === "image") {
                                    value.image = value.image.id;
                                }

                                return {
                                    ...valueAccumulator,
                                    [value.uid]: value,
                                };
                            },
                            {}
                        );
                    }

                    return { ...accumulator, [variation.uid]: variation };
                }, {});
        },

        transformVariants(formData) {
            formData.variants = formData.variants.reduce(
                (accumulator, variant) => {
                    variant.media = variant.media.map(({ id }) => id);

                    return { ...accumulator, [variant.uid]: variant };
                },
                {}
            );
        },

        transformOptions(formData) {
            const PATHS = {
                text: ["id", "uid", "price", "price_type"],
                select: ["id", "uid", "label", "price", "price_type"],
            };

            formData.options = formData.options
                .filter(({ name, type }) => Boolean(name) || type !== "")
                .reduce((accumulator, option) => {
                    if (option.type === "") {
                        option.values = [];
                    } else {
                        option.values = option.values.reduce(
                            (valueAccumulator, value) => {
                                const optionType = this.isOptionTypeText(option)
                                    ? "text"
                                    : "select";

                                value = _.pick(value, PATHS[optionType]);

                                return {
                                    ...valueAccumulator,
                                    [value.uid]: value,
                                };
                            },
                            {}
                        );
                    }

                    return { ...accumulator, [option.uid]: option };
                }, {});
        },

        transformData(data) {
            let formData = JSON.parse(JSON.stringify(data));

            if (this.hasAnyVariant) {
                formData = Object.assign({}, formData, {
                    price: null,
                    special_price: null,
                    special_price_type: "fixed",
                    special_price_start: null,
                    special_price_end: null,
                    sku: null,
                    manage_stock: 0,
                    qty: null,
                    in_stock: 1,
                });
            }

            this.transformMedia(formData);
            this.transformAttributes(formData);
            this.transformDownloads(formData);
            this.transformVariations(formData);
            this.transformVariants(formData);
            this.transformOptions(formData);

            return formData;
        },
    },
};
