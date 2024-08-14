import Vue from "vue";
import VariationMixin from "./mixins/VariationMixin";
import { toaster } from "@admin/js/Toaster";

new Vue({
    el: "#app",

    mixins: [VariationMixin],

    created() {
        this.setFormDefaultData();
    },

    mounted() {
        this.focusInitialField();
    },

    methods: {
        setFormDefaultData() {
            this.form = {
                uid: this.uid(),
                type: "",
                values: [
                    {
                        uid: this.uid(),
                        image: {
                            id: null,
                            path: null,
                        },
                    },
                ],
            };
        },

        focusInitialField() {
            this.$nextTick(() => {
                $("#name").trigger("focus");
            });
        },

        submit() {
            this.formSubmitting = true;

            $.ajax({
                type: "POST",
                url: route("admin.variations.store"),
                data: this.transformData(this.form),
                dataType: "json",
                success: (response) => {
                    toaster(response.message, {
                        type: "success",
                    });

                    this.resetForm();
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
