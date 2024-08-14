import Alpine from "alpinejs";
import tinyMce from "@admin/js/wysiwyg";
import Errors from "@admin/js/Errors";
import { nprogress } from "@admin/js/NProgress";

window.Alpine = Alpine;

let textEditor;
let tagsSelect;

Alpine.data("postEdit", ({ formData = {}, meta = {}, tags = [] }) => ({
    formSubmitting: false,
    formSubmissionType: null,
    form: {
        ...formData,
        featured_image: Array.isArray(formData.featured_image)
            ? {}
            : formData.featured_image,
    },
    errors: new Errors(),

    init() {
        this.form.meta = {
            ...(meta.meta_title && {
                meta_title: meta.meta_title,
            }),
            ...(meta.meta_description && {
                meta_description: meta.meta_description,
            }),
        };

        nprogress();

        this.fullscreenMode();

        textEditor = this.initTinyMce();
        tagsSelect = this.initTagsSelectize();

        tagsSelect[0].selectize.setValue(tags.map((tag) => tag.id));
    },

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

                document.documentElement.requestFullscreen().catch((err) => {
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

    initTinyMce() {
        return tinyMce({
            setup: (editor) => {
                editor.on("change", () => {
                    editor.save();
                    editor.getElement().dispatchEvent(new Event("input"));

                    this.errors.clear("description");
                });
            },
        });
    },

    initTagsSelectize() {
        return $(".selectize").selectize({
            plugins: ["remove_button"],
            onChange: (values) => {
                this.form.tags = values;
            },
        });
    },

    focusDescriptionField() {
        textEditor.get("description").focus();
    },

    addFeaturedImage() {
        const picker = new MediaPicker({ type: "image" });

        picker.on("select", ({ id, path }) => {
            this.form.featured_image = {
                id: +id,
                path,
            };
        });
    },

    removeFeaturedImage() {
        this.form.featured_image = {};
    },

    focusFirstErrorField(formElements) {
        const errorKeys = Object.keys(this.errors.errors);

        const firstErrorField = [...formElements].find((element) => {
            return errorKeys.includes(element.name);
        });

        if (firstErrorField.classList.contains("wysiwyg")) {
            textEditor.get(firstErrorField.getAttribute("name")).focus();

            return;
        }

        firstErrorField.focus();
    },

    handleSubmit({ submissionType }) {
        this.formSubmitting = true;
        this.formSubmissionType = submissionType;

        const {
            id,
            title,
            description,
            slug,
            meta,
            featured_image,
            publish_status,
            blog_category_id,
            tags,
        } = this.form;

        $.ajax({
            type: "PUT",
            url: route("admin.blog_posts.update", {
                id: this.form.id,
                ...(submissionType === "save_and_exit" && {
                    exit_flash: true,
                }),
            }),
            data: {
                id,
                title,
                description,
                slug,
                meta,
                publish_status,
                blog_category_id,
                tags,
                files: {
                    featured_image: featured_image.id
                        ? [featured_image.id]
                        : [],
                },
            },
            dataType: "json",
            success: ({ message }) => {
                if (submissionType === "save_and_exit") {
                    location.href = route("admin.blog_posts.index");

                    return;
                }

                success(message);
            },
        })
            .catch(({ responseJSON }) => {
                this.errors.reset();
                this.errors.record(responseJSON.errors);
                this.focusFirstErrorField(this.$refs.form.elements);

                error(responseJSON.message);
            })
            .always(() => {
                this.formSubmitting = false;
                this.formSubmissionType = null;
            });
    },
}));

Alpine.start();
