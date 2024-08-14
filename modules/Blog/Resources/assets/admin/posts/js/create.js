import Alpine from "alpinejs";
import tinyMce from "@admin/js/wysiwyg";
import Errors from "@admin/js/Errors";
import { nprogress } from "@admin/js/NProgress";

window.Alpine = Alpine;

let textEditor;
let tagsSelect;

Alpine.data("postCreate", () => ({
    formSubmitting: false,
    formSubmissionType: null,
    form: {
        meta: {},
        featured_image: {},
        publish_status: "published",
        blog_category_id: "",
    },
    errors: new Errors(),

    init() {
        nprogress();

        this.fullscreenMode();

        textEditor = this.initTinyMce();
        tagsSelect = this.initTagsSelectize();
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
            delimiter: ",",
            persist: false,
            create: function (input) {
                return {
                    value: input,
                    text: input,
                };
            },
            onChange: (values) => {
                this.form.tags = values;
            },
            load: function (query, callback) {
                var url = route("admin.blog_tags.index");

                if (url === undefined || query.length === 0) {
                    return callback();
                }

                $.get(url + "?query=" + query, callback, "json");
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

    resetForm() {
        this.errors.reset();

        this.form = {
            meta: {},
            featured_image: {},
            publish_status: "published",
            blog_category_id: "",
        };

        textEditor.get("description").setContent("");
        textEditor.get("description").execCommand("mceCancel");
        tagsSelect[0].selectize.clear();
    },

    handleSubmit({ submissionType }) {
        this.formSubmitting = true;
        this.formSubmissionType = submissionType;

        const {
            title,
            description,
            meta,
            featured_image,
            publish_status,
            blog_category_id,
            tags,
        } = this.form;

        $.ajax({
            type: "POST",
            url: route("admin.blog_posts.store", {
                ...((submissionType === "save_and_edit" ||
                    submissionType === "save_and_exit") && {
                    exit_flash: true,
                }),
            }),
            data: {
                title,
                description,
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
            success: ({ message, blog_post_id }) => {
                if (this.formSubmissionType === "save_and_edit") {
                    location.href = route(
                        "admin.blog_posts.edit",
                        blog_post_id
                    );

                    return;
                }

                if (this.formSubmissionType === "save_and_exit") {
                    location.href = route("admin.blog_posts.index");

                    return;
                }

                success(message);

                this.resetForm();
                this.$refs.form.elements[0].focus();
            },
        })
            .catch(({ responseJSON }) => {
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
