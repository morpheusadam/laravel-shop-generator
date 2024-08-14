@extends('storefront::public.layout')

@section('title', trans('storefront::cart.cart'))

@section('content')
    <cart-index inline-template>
        <div>
            <section class="shopping-cart-wrap">
                <div class="container">
                    <template v-if="cartIsNotEmpty">
                        @include('storefront::public.cart.index.steps')

                        <div class="shopping-cart">
                            <div class="shopping-cart-inner">
                                @include('storefront::public.cart.index.cart_items')
                            </div>

                            @include('storefront::public.cart.index.order_summary')
                        </div>
                    </template>

                    @include('storefront::public.cart.index.empty_cart')
                </div>
            </section>

            <landscape-products title="{{ trans('storefront::product.you_might_also_like') }}" v-if="hasAnyCrossSellProduct"
                :products="crossSellProducts">
            </landscape-products>
        </div>
    </cart-index>
@endsection
