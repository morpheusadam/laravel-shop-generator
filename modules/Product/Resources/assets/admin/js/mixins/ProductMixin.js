import md5 from "blueimp-md5";
import tinyMCE from "@admin/js/wysiwyg";
import draggable from "vuedraggable";
import Selectize from "vue2-selectize";
import flatPickr from "vue-flatpickr-component";
import FormSectionMixin from "./FormSectionMixin";
import AttributeMixin from "./AttributeMixin";
import VariationMixin from "./VariationMixin";
import VariantMixin from "./VariantMixin";
import BulkEditVariantsMixin from "./BulkEditVariantsMixin";
import OptionMixin from "./OptionMixin";
import DownloadMixin from "./DownloadMixin";
import DataTransformMixin from "./DataTransformMixin";
import { nprogress } from "@admin/js/NProgress";
import { toaster } from "@admin/js/Toaster";

window.md5 = md5;
window.toaster = toaster;

export default {
    components: {
        draggable,
        Selectize,
        flatPickr,
    },

    mixins: [
        FormSectionMixin,
        AttributeMixin,
        VariationMixin,
        VariantMixin,
        BulkEditVariantsMixin,
        OptionMixin,
        DownloadMixin,
        DataTransformMixin,
    ],

    data() {
        return {
            textEditor: null,
        };
    },

    mounted() {
        nprogress();

        this.fullscreenMode();
        this.textEditor = tinyMCE({
            setup: (editor) => {
                editor.on("change", () => {
                    editor.save();
                    editor.getElement().dispatchEvent(new Event("input"));

                    this.errors.clear("description");
                });
            },
        });
    },

    methods: {
        fullscreenMode() {
            $(".fullscreen-mode-open").on("click", (e) => {
                e.preventDefault();

                if (!document.fullscreenElement) {
                    $(".fullscreen-mode-open .fullscreen-one").removeClass(
                        "exit-full-screen"
                    );
                    $(".fullscreen-mode-open .fullscreen-two").addClass(
                        "enter-full-screen"
                    );

                    document.documentElement
                        .requestFullscreen()
                        .catch((err) => {
                            alert(
                                `Error attempting to enable full-screen mode: ${err.message} (${err.name})`
                            );
                        });
                } else {
                    $(".fullscreen-mode-open .fullscreen-two").removeClass(
                        "enter-full-screen"
                    );
                    $(".fullscreen-mode-open .fullscreen-one").addClass(
                        "exit-full-screen"
                    );

                    document.exitFullscreen().catch((err) => {
                        alert(
                            `Error attempting to disable full-screen mode: ${err.message} (${err.name})`
                        );
                    });
                }
            });
        },

        uid() {
            return Math.random().toString(36).slice(3);
        },

        focusEditor() {
            this.textEditor.get("description").focus();
        },

        focusField({ selector, key }) {
            if (key !== undefined) {
                this.errors.clear(key);
            }

            this.$nextTick(() => {
                $(`${selector}`).trigger("focus");
            });
        },

        removeDatePickerValue(key) {
            this.form[key] = null;
        },

        removeVariantDatePickerValue(index, key) {
            this.form.variants[index][key] = null;
        },

        regenerateVariationsAndVariantsUid() {
            this.regenerateVariationsUid();

            const newVariants = this.generateNewVariants(
                this.getFilteredVariations()
            );

            newVariants.forEach(({ uids }, index) => {
                this.$set(this.form.variants[index], "uid", md5(uids));
                this.$set(this.form.variants[index], "uids", uids);
            });
        },

        hasAnyError({ name, uid }) {
            return Object.keys(this.errors.errors).some((key) =>
                key.startsWith(`${name}.${uid}`)
            );
        },

        clearErrors({ name, uid }) {
            this.clearMatchedErrors(`${name}.${uid}`);
        },

        clearValuesError({ name, uid }) {
            this.clearMatchedErrors(`${name}.${uid}.values`);
        },

        clearValueRowErrors({ name, uid, valueUid }) {
            this.clearMatchedErrors(`${name}.${uid}.values.${valueUid}`);
        },

        clearMatchedErrors(str) {
            Object.keys(this.errors.errors).forEach((key) => {
                if (key.startsWith(str)) {
                    this.errors.clear(key);
                }
            });
        },

        focusFirstErrorField(elements) {
            this.$nextTick(() => {
                [...elements]
                    .find(
                        (el) => el.name === Object.keys(this.errors.errors)[0]
                    )
                    .focus();
            });
        },

        addMedia() {
            const picker = new MediaPicker({ type: "image", multiple: true });

            picker.on("select", ({ id, path }) => {
                this.form.media.push({
                    id: +id,
                    path,
                });
            });
        },

        removeMedia(index) {
            this.form.media.splice(index, 1);
        },

        preventLastSlideDrag(event) {
            return event.related.className.indexOf("disabled") === -1;
        },

        toggleAccordions({ selector, state, data }) {
            const event = new Event("click");
            const elements = document.querySelectorAll(selector);

            if (!state) {
                data.forEach(({ is_open }, index) => {
                    if (is_open) {
                        elements[index].dispatchEvent(event);
                    }
                });

                return;
            }

            [...elements].forEach((element) => {
                element.dispatchEvent(event);
            });
        },

        toggleAccordion(event, data) {
            const target = $(event.currentTarget);
            const panelTitle = target.find('[data-toggle="collapse"]');
            const panelBody = target.next();

            if (data.is_open) {
                panelBody.css("display", "block");
            }

            panelTitle.attr("data-transition", true);

            this.$set(data, "is_open", !data.is_open);

            panelBody.slideToggle(300, () => {
                panelTitle.attr("data-transition", false);
                panelBody.removeAttr("style");
            });
        },

        setSearchableSelectizeConfig() {
            this.searchableSelectizeConfig = {
                valueField: "id",
                labelField: "name",
                searchField: "name",
                load: function (query, callback) {
                    var url = route("admin.products.index");

                    if (url === undefined || query.length === 0) {
                        return callback();
                    }

                    $.get(url + "?query=" + query, callback, "json");
                },
                plugins: ["remove_button"],
            };
        },

        setCategoriesSelectizeConfig() {
            this.categoriesSelectizeConfig = {
                plugins: ["remove_button"],
                delimiter: ",",
                persist: true,
                selectOnTab: true,
                hideSelected: false,
                allowEmptyOption: true,
                onItemRemove(value) {
                    $("#categories")
                        .next()
                        .find(".option")
                        .each((_, el) => {
                            if (el.getAttribute("data-value") === value) {
                                el.classList.remove("selected");
                            }
                        });
                },
            };
        },
    },
};
