@extends('storefront::public.account.layout')

@section('title', trans('storefront::account.pages.my_reviews'))

@section('account_breadcrumb')
    <li class="active">{{ trans('storefront::account.pages.my_reviews') }}</li>
@endsection

@section('panel')
    <my-reviews inline-template>
        <div class="panel">
            <div class="panel-header">
                <h4>{{ trans('storefront::account.pages.my_reviews') }}</h4>
            </div>

            <div class="panel-body" :class="{ loading: fetchingReviews }" v-cloak>
                <div class="empty-message" v-if="reviewIsEmpty">
                    <h3 v-if="!fetchingReviews">
                        {{ trans('storefront::account.reviews.no_reviews') }}
                    </h3>
                </div>

                <div class="table-responsive" v-else>
                    <table class="table table-borderless my-reviews-table">
                        <thead>
                            <tr>
                                <th>{{ trans('storefront::account.image') }}</th>
                                <th>{{ trans('storefront::account.product_name') }}</th>
                                <th>{{ trans('storefront::account.status') }}</th>
                                <th>{{ trans('storefront::account.date') }}</th>
                                <th>{{ trans('storefront::account.reviews.rating') }}</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr v-for="review in reviews.data" :key="review.id">
                                <td>
                                    <div class="product-image">
                                        <img
                                            :src="baseImage(review.product)"
                                            :class="{ 'image-placeholder': ! hasBaseImage(review.product) }"
                                            :alt="review.product.name"
                                        >
                                    </div>
                                </td>

                                <td>
                                    <a :href="productUrl(review.product)" class="product-name">
                                        @{{ review.product.name }}
                                    </a>
                                </td>

                                <td>
                                    <span
                                        class="badge"
                                        :class="review.is_approved ? 'badge-success' : 'badge-warning'"
                                    >
                                        @{{ review.status }}
                                    </span>
                                </td>

                                <td>
                                    @{{ review.created_at_formatted }}
                                </td>

                                <td>
                                    <product-rating
                                        :rating-percent="review.rating_percent"
                                    >
                                    </product-rating>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="panel-footer">
                <v-pagination
                    :total-page="totalPage"
                    :current-page="currentPage"
                    @page-changed="changePage"
                    v-if="reviews.total > 10"
                >
                </v-pagination>
            </div>
        </div>
    </my-reviews>
@endsection
