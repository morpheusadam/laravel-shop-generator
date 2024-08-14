@extends('storefront::public.layout')

@section('title', trans('storefront::compare.compare'))

@section('content')
    <compare-index :compare="{{ $compare }}" inline-template>
        <div>
            <section class="compare-wrap">
                <div class="container" v-cloak>
                    <div class="table-responsive" v-if="hasAnyProduct">
                        <table class="table table-bordered compare-table">
                            <tbody>
                                <tr>
                                    <td>{{ trans('storefront::compare.product_overview') }}</td>

                                    <td v-for="product in products">
                                        <a :href="productUrl(product)" class="product-image">
                                            <img :src="baseImage(product)" :class="{ 'image-placeholder': !hasBaseImage(product) }" :alt="product.name">
                                        </a>

                                        <a :href="productUrl(product)" v-text="product.name" class="product-name"></a>

                                        <button class="btn btn-remove" @click="remove(product)">
                                            <i class="las la-times"></i>
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ trans('storefront::compare.description') }}</td>

                                    <td v-for="product in products" v-text="product.short_description || '-'"></td>
                                </tr>

                                <tr>
                                    <td>{{ trans('storefront::compare.rating') }}</td>

                                    <td v-for="product in products">
                                        <product-rating
                                            :rating-percent="product.rating_percent"
                                            :review-count="product.reviews.length"
                                        >
                                        </product-rating>
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ trans('storefront::compare.price') }}</td>

                                    <td v-for="product in products">
                                        <span class="product-price" v-html="productPrice(product)"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ trans('storefront::compare.availability') }}</td>

                                    <td v-for="product in products">
                                        <span class="badge badge-success" v-if="productIsInStock(product)">
                                            {{ trans('storefront::compare.in_stock') }}
                                        </span>

                                        <span class="badge badge-danger" v-else>
                                            {{ trans('storefront::compare.out_of_stock') }}
                                        </span>
                                    </td>
                                </tr>

                                <tr v-for="attribute in attributes">
                                    <td v-text="attribute.name"></td>

                                    <td v-for="product in products">
                                        <template v-if="hasAttribute(product, attribute)">
                                            @{{ attributeValues(product, attribute) }}
                                        </template>

                                        <template v-else>
                                            &ndash;
                                        </template>
                                    </td>
                                </tr>

                                <tr>
                                    <td>{{ trans('storefront::compare.actions') }}</td>

                                    <td v-for="product in products">
                                        <button
                                            title="{{ trans('storefront::product_card.wishlist') }}"
                                            class="btn btn-wishlist"
                                            :class="{ 'added': inWishlist(product) }"
                                            @click="syncWishlist(product)"
                                        >
                                            <svg v-if="inWishlist(product)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M16.44 3.1001C14.63 3.1001 13.01 3.9801 12 5.3301C10.99 3.9801 9.37 3.1001 7.56 3.1001C4.49 3.1001 2 5.6001 2 8.6901C2 9.8801 2.19 10.9801 2.52 12.0001C4.1 17.0001 8.97 19.9901 11.38 20.8101C11.72 20.9301 12.28 20.9301 12.62 20.8101C15.03 19.9901 19.9 17.0001 21.48 12.0001C21.81 10.9801 22 9.8801 22 8.6901C22 5.6001 19.51 3.1001 16.44 3.1001Z" fill="#292D32"/>
                                            </svg>

                                            <svg v-else xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M12.62 20.81C12.28 20.93 11.72 20.93 11.38 20.81C8.48 19.82 2 15.69 2 8.68998C2 5.59998 4.49 3.09998 7.56 3.09998C9.38 3.09998 10.99 3.97998 12 5.33998C13.01 3.97998 14.63 3.09998 16.44 3.09998C19.51 3.09998 22 5.59998 22 8.68998C22 15.69 15.52 19.82 12.62 20.81Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>

                                        <button
                                            :title="
                                                hasAnyOption(product)
                                                ? '{{ trans('storefront::compare.view_options') }}'
                                                : '{{ trans('storefront::compare.add_to_cart') }}'
                                            "
                                            class="btn btn-add-to-cart"
                                            :disabled="!productIsInStock(product)"
                                            @click="addToCart(product)"
                                        >
                                            <svg v-if="hasAnyOption(product)" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                <path d="M15.58 12C15.58 13.98 13.98 15.58 12 15.58C10.02 15.58 8.42004 13.98 8.42004 12C8.42004 10.02 10.02 8.41998 12 8.41998C13.98 8.41998 15.58 10.02 15.58 12Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M12 20.27C15.53 20.27 18.82 18.19 21.11 14.59C22.01 13.18 22.01 10.81 21.11 9.39997C18.82 5.79997 15.53 3.71997 12 3.71997C8.46997 3.71997 5.17997 5.79997 2.88997 9.39997C1.98997 10.81 1.98997 13.18 2.88997 14.59C5.17997 18.19 8.46997 20.27 12 20.27Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>

                                            <i class="las la-shopping-cart" v-else></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="empty-message" v-else>
                        <svg version="1.1"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 500 500"
                            preserveAspectRatio="xMidYMid meet">
                            <g>
                                <path d="M250,26.72c-74.8,0-135.42,60.62-135.42,135.42c0,33.9,12.44,64.84,33.01,88.56c16.47,19.06,38.19,33.49,62.92,40.97
                                    c12.47,3.85,25.76,5.88,39.49,5.88c13.73,0,27.02-2.04,39.49-5.88c24.72-7.48,46.45-21.91,62.92-40.97
                                    c20.58-23.72,33.01-54.66,33.01-88.56C385.41,87.34,324.79,26.72,250,26.72z M308.73,202.41c1.52,1.52,1.52,4,0,5.51l-12.92,12.92
                                    c-1.55,1.55-4.03,1.55-5.55,0L250,180.57l-40.27,40.27c-1.52,1.55-4,1.55-5.51,0l-12.95-12.92c-1.52-1.52-1.52-4,0-5.51
                                    l40.27-40.27l-40.27-40.27c-1.52-1.52-1.52-4,0-5.55l12.95-12.92c1.52-1.52,4-1.52,5.51,0L250,143.67l40.27-40.27
                                    c1.52-1.52,4-1.52,5.55,0l12.92,12.92c1.52,1.55,1.52,4.03,0,5.55l-40.27,40.27L308.73,202.41z"/>
                                <path d="M68.59,491.26H5.68V209.21c0-1.1,0.89-1.99,1.99-1.99H66.6c1.1,0,1.99,0.89,1.99,1.99V491.26z"/>
                                <path d="M147.6,291.47c18.25,14.47,39.64,25.17,62.92,30.9v168.88H147.6V291.47z"/>
                                <path d="M289.49,322.38c23.28-5.74,44.67-16.43,62.92-30.9v199.78h-62.92V322.38z"/>
                                <path d="M494.32,491.26h-62.92V10.75c0-1.11,0.9-2.01,2.01-2.01h58.89c1.11,0,2.01,0.9,2.01,2.01V491.26z"/>
                            </g>
                        </svg>

                        <h3>{{ trans('storefront::compare.no_product') }}</h3>
                    </div>
                </div>
            </section>

            <landscape-products
                title="{{ trans('storefront::product.related_products') }}"
                v-if="hasAnyRelatedProduct"
                :products="relatedProducts"
                :class="{ loading: fetchingRelatedProducts }"
            >
            </landscape-products>
        </div>
    </compare-index>
@endsection
