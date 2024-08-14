import Errors from "../../../Errors";

export default {
    props: ["initialAddresses", "initialDefaultAddress", "countries"],

    data() {
        return {
            addresses: this.initialAddresses,
            defaultAddress: this.initialDefaultAddress,
            form: { state: "" },
            states: {},
            errors: new Errors(),
            formOpen: false,
            editing: false,
            loading: false,
        };
    },

    computed: {
        firstCountry() {
            return Object.keys(this.countries)[0];
        },

        hasAddress() {
            return Object.keys(this.addresses).length !== 0;
        },

        hasNoStates() {
            return Object.keys(this.states).length === 0;
        },
    },

    created() {
        this.changeCountry(this.firstCountry);
    },

    methods: {
        changeDefaultAddress(address) {
            if (this.defaultAddress.address_id === address.id) return;

            this.$set(this.defaultAddress, "address_id", address.id);

            axios
                .post(route("account.addresses.change_default"), {
                    address_id: address.id,
                })
                .then((response) => {
                    this.$notify(response.data);
                })
                .catch((error) => {
                    this.$notify(error.response.data.message);
                });
        },

        changeCountry(country) {
            this.form.country = country;
            this.form.state = "";

            this.fetchStates(country);
        },

        async fetchStates(country) {
            const response = await axios.get(
                route("countries.states.index", { code: country })
            );

            this.$set(this, "states", response.data);
        },

        edit(address) {
            this.formOpen = true;
            this.editing = true;
            this.form = address;

            this.fetchStates(address.country);
        },

        remove(address) {
            if (
                !confirm(this.$trans("storefront::account.addresses.confirm"))
            ) {
                return;
            }

            axios
                .delete(route("account.addresses.destroy", address.id))
                .then((response) => {
                    this.$delete(this.addresses, address.id);
                    this.$notify(response.data.message);
                })
                .catch((error) => {
                    this.$notify(error.response.data.message);
                });
        },

        cancel() {
            this.editing = false;
            this.formOpen = false;

            this.errors.reset();
            this.resetForm();
        },

        save() {
            this.loading = true;

            if (this.editing) {
                this.update();
            } else {
                this.create();
            }
        },

        update() {
            axios
                .put(
                    route("account.addresses.update", { id: this.form.id }),
                    this.form
                )
                .then(({ data }) => {
                    this.formOpen = false;
                    this.editing = false;

                    this.addresses[this.form.id] = data.address;

                    this.resetForm();
                    this.$notify(data.message);
                })
                .catch(({ response }) => {
                    if (response.status === 422) {
                        this.errors.record(response.data.errors);
                    }

                    this.$notify(response.data.message);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        create() {
            axios
                .post(route("account.addresses.store"), this.form)
                .then(({ data }) => {
                    this.formOpen = false;

                    let address = { [data.address.id]: data.address };

                    this.$set(this, "addresses", {
                        ...this.addresses,
                        ...address,
                    });

                    this.resetForm();
                    this.$notify(data.message);
                })
                .catch(({ response }) => {
                    if (response.status === 422) {
                        this.errors.record(response.data.errors);
                    }

                    this.$notify(response.data.message);
                })
                .finally(() => {
                    this.loading = false;
                });
        },

        resetForm() {
            this.form = { state: "" };
        },
    },
};
