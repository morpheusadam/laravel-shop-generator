import simplebar from "simplebar-vue";
import Errors from "../Errors";

export default {
    components: {
        simplebar,
    },

    props: ["requirementSatisfied", "permissionProvided"],

    data() {
        return {
            step: 1,
            formSubmitting: false,
            animateAlert: false,
            appInstalled: false,
            errorMessage: null,
            form: {
                db_host: "127.0.0.1",
                db_port: 3306,
                store_search_engine: "mysql",
            },
            errors: new Errors(),
        };
    },

    computed: {
        isShowPrev() {
            return this.step === 2 || this.step === 3;
        },

        isPrevDisabled() {
            return this.formSubmitting;
        },

        isNextDisabled() {
            if (this.step === 1) {
                return !this.requirementSatisfied || this.formSubmitting;
            }

            if (this.step === 2) {
                return !this.permissionProvided || this.formSubmitting;
            }

            if (this.step === 3) {
                return this.formSubmitting;
            }
        },

        hasErrorMessage() {
            return this.errorMessage !== null;
        },
    },

    methods: {
        prevStep() {
            if (this.isPrevDisabled) {
                return;
            }

            if (this.step > 1) {
                this.step--;
            }
        },

        nextStep() {
            if (this.isNextDisabled) {
                return;
            }

            if (this.step === 3) {
                this.submitForm();

                return;
            }

            this.step++;

            this.focusInitialFormField();
        },

        focusInitialFormField() {
            if (this.step === 3) {
                this.$nextTick(() => {
                    this.$refs.configurationForm.elements[0].focus();
                });
            }
        },

        setErrorMessage(message) {
            this.errorMessage = message;

            this.triggerAlertAnimation();
        },

        resetErrorMessage() {
            this.errorMessage = null;
        },

        triggerAlertAnimation() {
            this.animateAlert = true;

            setTimeout(() => {
                this.animateAlert = false;
            }, 1000);
        },

        scrollToTop() {
            this.$nextTick(() => {
                this.$refs.configurationContent.SimpleBar.getScrollElement().scrollTo(
                    {
                        top: 0,
                        left: 0,
                        behavior: "smooth",
                    }
                );
            });
        },

        scrollToBottom(value) {
            if (value !== "mysql") {
                this.$nextTick(() => {
                    const formFields = this.$refs.configurationForm.elements;

                    this.$refs.configurationContent.SimpleBar.getScrollElement().scrollTo(
                        {
                            top: formFields[formFields.length - 1].offsetTop,
                            left: 0,
                            behavior: "smooth",
                        }
                    );

                    formFields[formFields.length - 2].focus();
                });
            }
        },

        focusFirstErrorField(errors) {
            [...this.$refs.configurationForm.elements].some((el) => {
                if (el.name === Object.keys(errors)[0]) {
                    this.$nextTick(() => {
                        this.$refs.configurationContent.SimpleBar.getScrollElement().scrollTo(
                            {
                                top: el.offsetTop - 10,
                                left: 0,
                                behavior: "smooth",
                            }
                        );
                    });

                    el.focus();

                    return true;
                }
            });
        },

        resetForm() {
            this.form = {
                db_host: "127.0.0.1",
                db_port: 3306,
                store_search_engine: "mysql",
            };
        },

        submitForm() {
            this.formSubmitting = true;

            axios
                .post(route("install.do"), this.form)
                .then(() => {
                    this.appInstalled = true;

                    this.resetForm();
                    this.resetErrorMessage();
                    this.errors.reset();
                })
                .catch(({ response }) => {
                    if (response.status === 422) {
                        const errors = response.data.errors;

                        this.resetErrorMessage();
                        this.errors.record(errors);
                        this.focusFirstErrorField(errors);

                        return;
                    }

                    this.setErrorMessage(response.data.message);
                    this.scrollToTop();
                })
                .finally(() => {
                    this.formSubmitting = false;
                });
        },
    },
};
