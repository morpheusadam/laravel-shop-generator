import Vue from "vue";

export default class {
    constructor() {
        this.errors = {};
    }

    record(errors) {
        this.errors = Object.assign({}, this.errors, errors);
    }

    any() {
        return Object.keys(this.errors).length > 0;
    }

    has(key) {
        return this.errors.hasOwnProperty(this.normalizeKey(key));
    }

    get(key) {
        if (this.errors[this.normalizeKey(key)]) {
            return this.errors[this.normalizeKey(key)][0];
        }
    }

    set(errors = {}) {
        this.errors = Object.assign({}, this.errors, errors);
    }

    clear(keys) {
        if (keys === undefined) {
            return;
        }

        keys = Array.isArray(keys) ? keys : [keys];

        keys.forEach((key) => {
            Vue.delete(this.errors, this.normalizeKey(key));
        });
    }

    reset() {
        this.errors = {};
    }

    normalizeKey(key) {
        let keyParts = key.split("[");

        // No need to normalize the key.
        if (keyParts.length === 1) {
            return key;
        }

        return keyParts.join(".").slice(0, -1).replace(/]/g, "");
    }
}
