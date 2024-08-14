import Vue from "vue";
import VariationMixin from "./mixins/VariationMixin";
import { toaster } from "@admin/js/Toaster";

new Vue({
    el: "#app",

    mixins: [VariationMixin],

    created() {
        this.form = this.prepareFormData(FleetCart.data["variation"]);
    },

    mounted() {
        this.initColorPicker();
    },

    methods: {
        prepareFormData(formData) {
            formData.uid = this.uid();

            formData.values.forEach((value) => {
                value.uid = this.uid();
            });

            return formData;
        },

        submit() {
            this.formSubmitting = true;

            $.ajax({
                type: "PUT",
                url: route("admin.variations.update", this.form.id),
                data: this.transformData(this.form),
                dataType: "json",
                success: (response) => {
                    toaster(response.message, {
                        type: "success",
                    });

                    this.errors.reset();
                },
            })
                .catch((error) => {
                    toaster(error.responseJSON.message, {
                        type: "default",
                    });

                    this.errors.reset();
                    this.errors.record(error.responseJSON.errors);
                    this.focusFirstErrorField(this.$refs.form.elements);
                })
                .always(() => {
                    this.formSubmitting = false;
                });
        },
    },
});
