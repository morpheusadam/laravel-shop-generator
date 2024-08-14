@extends('admin::layout')

@section('title', trans('admin::dashboard.dashboard'))

@section('content_header')
    <h3 class="pull-left">{{ trans('admin::dashboard.dashboard') }}</h3>
@endsection

@section('content')
    <div class="grid clearfix">
        <div class="row">
            @hasAccess('admin.orders.index')
                @include('admin::dashboard.grids.total_sales')
                @include('admin::dashboard.grids.total_orders')
            @endHasAccess

            @hasAccess('admin.products.index')
                @include('admin::dashboard.grids.total_products')
            @endHasAccess

            @hasAccess('admin.users.index')
                @include('admin::dashboard.grids.total_customers')
            @endHasAccess
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            @hasAccess('admin.orders.index')
                @include('admin::dashboard.panels.sales_analytics')
            @endHasAccess

            @hasAccess('admin.orders.index')
                @include('admin::dashboard.panels.latest_orders')
            @endHasAccess
        </div>

        <div class="col-md-5">
            @include('admin::dashboard.panels.latest_searches')

            @hasAccess('admin.reviews.index')
                @include('admin::dashboard.panels.latest_reviews')
            @endHasAccess
        </div>
    </div>
@endsection

@push('globals')
    @vite([
        "modules/Admin/Resources/assets/sass/dashboard.scss",
        "modules/Admin/Resources/assets/js/dashboard.js",
    ])
@endpush
