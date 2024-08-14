<sidebar-cart inline-template>
    <aside class="sidebar-cart-wrap" @click.stop>
        <div class="sidebar-cart-top">
            <h4 class="title">{{ trans('storefront::layout.my_cart') }} <div class="count" v-text="cart.quantity">{{ $cart->toArray()['quantity'] }}</div></h4>

            <div class="sidebar-cart-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M15.8338 4.16663L4.16705 15.8333M4.16705 4.16663L15.8338 15.8333" stroke="#0E1E3E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg> 
            </div>
        </div>
        
        <div class="sidebar-cart-middle" :class="{ 'custom-scrollbar': cartIsNotEmpty, empty: cartIsEmpty }">
            <div class="sidebar-cart-items-wrap" v-if="!cartIsEmpty">
                <sidebar-cart-item
                    v-for="cartItem in cart.items"
                    :key="cartItem.id"
                    :cart-item="cartItem"
                >
                </sidebar-cart-item>
            </div>

            <div class="empty-message" v-else>
                @include('storefront::public.layout.sidebar_cart.empty_logo')

                <h4>{{ trans('storefront::cart.your_cart_is_empty') }}</h4>
            </div>
        </div>

        <div class="sidebar-cart-bottom" v-if="cartIsNotEmpty">
            <h5 class="sidebar-cart-subtotal">
                {{ trans('storefront::layout.subtotal') }}
                <span v-html="cart.subTotal.inCurrentCurrency.formatted"></span>
            </h5>

            <div class="sidebar-cart-actions">
                <button type="button" @click="clearCart" class="btn btn-clear-cart">
                    {{ trans('storefront::layout.clear_cart') }}
                </button>

                <a href="{{ route('cart.index') }}" class="btn btn-default btn-view-cart">
                    {{ trans('storefront::layout.view_cart') }}
                </a>

                <a href="{{ route('checkout.create') }}" class="btn btn-primary btn-checkout">
                    {{ trans('storefront::layout.checkout') }}
                </a>
            </div>
        </div>
    </aside>
</sidebar-cart>
