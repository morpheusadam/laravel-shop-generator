import Vue from "vue";
import VueToast from "vue-toast-notification";

Vue.use(VueToast);

export function toaster(message, options = {}) {
    Vue.$toast.open({
        message,
        type: options.type || "default",
        duration: 5000,
        dismissible: true,
        position: "bottom-right",
        pauseOnHover: true,
        ...options,
    });
}
