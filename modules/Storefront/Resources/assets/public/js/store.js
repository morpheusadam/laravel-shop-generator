import Vue from "vue";
import { isEmpty } from "./functions";

export default {
    state: Vue.observable({
        cart: FleetCart.cart,
        wishlist: FleetCart.wishlist,
        compareList: FleetCart.compareList,
        coupon: {},
    }),

    cartIsEmpty() {
        return isEmpty(this.state.cart.items);
    },

    updateCart(cart) {
        this.state.cart = cart;

        this.setCoupon(cart);
    },

    removeCartItem(cartItem) {
        Vue.delete(this.state.cart.items, cartItem.id);
    },

    clearCart() {
        this.state.cart.items = {};
    },

    hasShippingMethod() {
        return (
            Object.keys(this.state.cart.availableShippingMethods).length !== 0
        );
    },

    hasCoupon() {
        return this.state.cart.coupon.code !== undefined;
    },

    getCoupon() {
        return this.state.cart.coupon.code;
    },

    setCoupon(cart) {
        if (cart.coupon.code) {
            this.state.cart.coupon = cart.coupon;
        }
    },

    compareCount() {
        return this.state.compareList.length;
    },

    wishlistCount() {
        return this.state.wishlist.length;
    },

    inWishlist(productId) {
        return this.state.wishlist.includes(productId);
    },

    syncWishlist(productId) {
        if (this.inWishlist(productId)) {
            this.removeFromWishlist(productId);
        } else {
            this.addToWishlist(productId);
        }
    },

    async addToWishlist(productId) {
        if (FleetCart.loggedIn) {
            this.state.wishlist.push(productId);
        } else {
            return (window.location.href = route("login"));
        }

        await axios.post(route("account.wishlist.products.store"), {
            productId,
        });
    },

    removeFromWishlist(productId) {
        this.state.wishlist.splice(this.state.wishlist.indexOf(productId), 1);

        axios.delete(
            route("account.wishlist.products.destroy", { product: productId })
        );
    },

    inCompareList(productId) {
        return this.state.compareList.includes(productId);
    },

    syncCompareList(productId) {
        if (this.inCompareList(productId)) {
            this.removeFromCompareList(productId);
        } else {
            this.addToCompareList(productId);
        }
    },

    addToCompareList(productId) {
        this.state.compareList.push(productId);

        axios.post(route("compare.store"), {
            productId,
        });
    },

    async removeFromCompareList(productId) {
        this.state.compareList.splice(
            this.state.compareList.indexOf(productId),
            1
        );

        await axios.delete(route("compare.destroy", { productId }));
    },
};
