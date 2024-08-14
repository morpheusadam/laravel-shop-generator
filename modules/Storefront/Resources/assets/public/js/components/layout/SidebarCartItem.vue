<template>
    <div class="cart-item sidebar-cart-item">
        <a :href="productUrl(cartItem)" class="product-image">
            <img
                :src="baseImage(cartItem)"
                :class="{
                    'image-placeholder': !hasBaseImage(cartItem),
                }"
                :alt="cartItem.product.name"
            />
        </a>

        <div class="product-info">
            <div class="remove-cart-item">
                <button class="btn-remove" @click="remove">
                    <i class="las la-times"></i>
                </button>
            </div>

            <a
                :href="productUrl(cartItem)"
                class="product-name"
                :title="cartItem.product.name"
            >
                {{ cartItem.product.name }}
            </a>

            <ul
                v-if="Object.entries(cartItem.variations).length !== 0"
                class="list-inline product-options"
            >
                <li
                    v-for="(variation, key, index) in cartItem.variations"
                    :key="index"
                >
                    <label>{{ variation.name }}:</label>
                    {{ variation.values[0].label
                    }}{{
                        Object.values(cartItem.variations).length === index + 1
                            ? ""
                            : ","
                    }}
                </li>
            </ul>

            <ul
                v-if="Object.entries(cartItem.options).length !== 0"
                class="list-inline product-options"
            >
                <li
                    v-for="(option, key, index) in cartItem.options"
                    :key="option.id"
                >
                    <label>{{ option.name }}:</label>
                    {{ optionValues(option)
                    }}{{
                        Object.entries(cartItem.options).length === index + 1
                            ? ""
                            : ","
                    }}
                </li>
            </ul>

            <div
                class="product-info-bottom d-flex flex-wrap align-items-center justify-content-between"
            >
                <div class="number-picker">
                    <div class="input-group-quantity">
                        <button
                            type="button"
                            class="btn btn-number btn-minus"
                            :disabled="cartItem.qty <= 1"
                            @click="
                                updateQuantity(
                                    $event,
                                    cartItem,
                                    cartItem.qty - 1
                                )
                            "
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 16 16"
                                fill="none"
                            >
                                <path
                                    d="M13.3333 8H2.66663"
                                    stroke="#0E1E3E"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </button>

                        <input
                            ref="input"
                            type="text"
                            :value="cartItem.qty"
                            min="1"
                            :max="maxQuantity(cartItem)"
                            class="form-control input-number input-quantity"
                            @focus="$event.target.select()"
                            @input="
                                changeQuantity(
                                    cartItem,
                                    Number($event.target.value)
                                )
                            "
                            @keydown.up="
                                updateQuantity(
                                    $event,
                                    cartItem,
                                    cartItem.qty + 1
                                )
                            "
                            @keydown.down="
                                updateQuantity(
                                    $event,
                                    cartItem,
                                    cartItem.qty - 1
                                )
                            "
                        />

                        <button
                            type="button"
                            class="btn btn-number btn-plus"
                            :disabled="isQtyIncreaseDisabled(cartItem)"
                            @click="
                                updateQuantity(
                                    $event,
                                    cartItem,
                                    cartItem.qty + 1
                                )
                            "
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                viewBox="0 0 16 16"
                                fill="none"
                            >
                                <path
                                    d="M7.99996 2.66669V13.3334M13.3333 8.00002H2.66663"
                                    stroke="#0E1E3E"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="product-price">
                    x {{ cartItem.unitPrice.inCurrentCurrency.formatted }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import store from "../../store";
import CartItemHelpersMixin from "../../mixins/CartItemHelpersMixin";

export default {
    mixins: [CartItemHelpersMixin],

    props: ["cartItem"],

    data() {
        return {
            controller: null,
        };
    },

    methods: {
        updateCart(cartItem, qty) {
            if (this.controller) {
                this.controller.abort();
            }

            this.controller = new AbortController();

            axios
                .put(
                    route("cart.items.update", {
                        id: cartItem.id,
                    }),
                    {
                        qty: qty || 1,
                    },
                    {
                        signal: this.controller.signal,
                    }
                )
                .then((response) => {
                    store.updateCart(response.data);
                })
                .catch((error) => {
                    if (error.code !== "ERR_CANCELED") {
                        store.updateCart(error.response.data.cart);

                        this.$notify(error.response.data.message);
                    }
                });
        },

        remove() {
            store.removeCartItem(this.cartItem);

            axios
                .delete(
                    route("cart.items.destroy", {
                        id: this.cartItem.id,
                    })
                )
                .then((response) => {
                    store.updateCart(response.data);
                });
        },
    },
};
</script>
