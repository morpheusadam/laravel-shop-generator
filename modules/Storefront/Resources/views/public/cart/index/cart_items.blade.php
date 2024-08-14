<div class="table-responsive">
    <table class="table table-borderless shopping-cart-table">
        <thead>
            <tr>
                <th>{{ trans('storefront::cart.table.image') }}</th>
                <th>{{ trans('storefront::cart.table.product_name') }}</th>
                <th>{{ trans('storefront::cart.table.unit_price') }}</th>
                <th>{{ trans('storefront::cart.table.quantity') }}</th>
                <th>{{ trans('storefront::cart.table.line_total') }}</th>
                <th>
                    <button class="btn-remove" @click="clearCart">
                        <i class="las la-times"></i>
                    </button>
                </th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="cartItem in cart.items" :key="cartItem.id">
                <td>
                    <a :href="productUrl(cartItem)" class="product-image">
                        <img
                            :src="baseImage(cartItem)"
                            :class="{ 'image-placeholder': !hasBaseImage(cartItem) }"
                            :alt="cartItem.product.name"
                        >
                    </a>
                </td>

                <td>
                    <a
                        :href="productUrl(cartItem)"
                        class="product-name"
                        v-text="cartItem.product.name"
                    >
                    </a>

                    <ul v-cloak v-if="Object.values(cartItem.variations).length !== 0" class="list-inline product-options">
                        <li
                            v-for="(variation, key, index) in cartItem.variations"
                            :key="index"
                        >
                            <label>@{{ variation.name }}:</label>
                            @{{ variation.values[0].label }}@{{ Object.values(cartItem.variations).length === index + 1 ? "" : "," }}
                        </li>
                    </ul>

                    <ul v-cloak v-if="Object.values(cartItem.options).length !== 0" class="list-inline product-options">
                        <li v-for="(option, key, index) in cartItem.options">
                            <label>@{{ option.name }}:</label> @{{ optionValues(option) }}@{{ Object.entries(cartItem.options).length === index + 1 ? "" : "," }}
                        </li>
                    </ul>
                </td>

                <td>
                    <label>{{ trans('storefront::cart.table.unit_price:') }}</label>

                    <span class="product-price" v-html="cartItem.unitPrice.inCurrentCurrency.formatted"></span>
                </td>

                <td>
                    <label>{{ trans('storefront::cart.table.quantity:') }}</label>

                    <div class="number-picker">
                        <div class="input-group-quantity">
                            <button
                                type="button"
                                class="btn btn-number btn-minus"
                                :disabled="cartItem.qty <= 1"
                                @click="updateQuantity($event, cartItem, cartItem.qty - 1)"
                            >
                                -
                            </button>

                            <input
                                type="text"
                                :value="cartItem.qty"
                                min="1"
                                :max="maxQuantity(cartItem)"
                                class="form-control input-number input-quantity"
                                @focus="$event.target.select()"
                                @input="changeQuantity(cartItem, Number($event.target.value))"
                                @keydown.up="updateQuantity($event, cartItem, cartItem.qty + 1)"
                                @keydown.down="updateQuantity($event, cartItem, cartItem.qty - 1)"
                            >

                            <button
                                type="button"
                                class="btn btn-number btn-plus"
                                :disabled="isQtyIncreaseDisabled(cartItem)"
                                @click="updateQuantity($event, cartItem, cartItem.qty + 1)"
                            >
                                +
                            </button>
                        </div>
                    </div>
                </td>

                <td>
                    <label>{{ trans('storefront::cart.table.line_total:') }}</label>

                    <span class="product-price" v-html="cartItem.total.inCurrentCurrency.formatted"></span>
                </td>

                <td>
                    <button class="btn-remove" @click="removeCartItem(cartItem)">
                        <i class="las la-times"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
