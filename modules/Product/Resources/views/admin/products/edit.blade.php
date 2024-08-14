@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('product::products.product')]))
    @slot('subtitle', $product->name)

    <li><a href="{{ route('admin.products.index') }}">{{ trans('product::products.products') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('product::products.product')]) }}</li>
@endcomponent

@section('content')
    <div id="app" v-cloak>
        <form
            class="product-form form-horizontal"
            @input="errors.clear($event.target.name)"
            @submit.prevent
            ref="form"
        >
            <div class="row">
                <div class="product-form-left-column col-lg-8 col-md-12">
                    @include('product::admin.products.layouts.left_column')
                </div>

                <div class="product-form-right-column col-lg-4 col-md-12">
                    @include('product::admin.products.layouts.right_column')
                </div>
            </div>

            <div class="page-form-footer">
                <button
                    type="button"
                    class="btn btn-default"
                    :class="{ 'btn-loading': formSubmissionType === 'save' }"
                    :disabled="formSubmissionType"
                    @click="submit({ submissionType: 'save' })"
                >
                    {{ trans('product::products.save') }}
                </button>

                <button
                    type="button"
                    class="btn btn-primary"
                    :class="{ 'btn-loading': formSubmissionType === 'save_and_exit' }"
                    :disabled="formSubmissionType"
                    @click="submit({ submissionType: 'save_and_exit' })"
                >
                    {{ trans('product::products.save_and_exit') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@include('product::admin.products.partials.shortcuts')

@if (session()->has('exit_flash'))
    @push('notifications')
        <div class="alert alert-success alert-exit-flash fade in alert-dismissible clearfix">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM11.25 8C11.25 7.59 11.59 7.25 12 7.25C12.41 7.25 12.75 7.59 12.75 8V13C12.75 13.41 12.41 13.75 12 13.75C11.59 13.75 11.25 13.41 11.25 13V8ZM12.92 16.38C12.87 16.51 12.8 16.61 12.71 16.71C12.61 16.8 12.5 16.87 12.38 16.92C12.26 16.97 12.13 17 12 17C11.87 17 11.74 16.97 11.62 16.92C11.5 16.87 11.39 16.8 11.29 16.71C11.2 16.61 11.13 16.51 11.08 16.38C11.03 16.26 11 16.13 11 16C11 15.87 11.03 15.74 11.08 15.62C11.13 15.5 11.2 15.39 11.29 15.29C11.39 15.2 11.5 15.13 11.62 15.08C11.86 14.98 12.14 14.98 12.38 15.08C12.5 15.13 12.61 15.2 12.71 15.29C12.8 15.39 12.87 15.5 12.92 15.62C12.97 15.74 13 15.87 13 16C13 16.13 12.97 16.26 12.92 16.38Z" fill="#555555"/>
            </svg>

            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M5.00082 14.9995L14.9999 5.00041" stroke="#555555" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M14.9999 14.9996L5.00082 5.00049" stroke="#555555" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <span class="alert-text">{{ session('exit_flash') }}</span>
        </div>
    @endpush
@endif

@push('globals')
    <script>
        FleetCart.data['product'] = {!! $product_resource !!};
        FleetCart.data['attribute-sets'] = @json($attributeSets);
        FleetCart.langs['product::products.section.order_saved'] = '{{ trans('product::products.section.order_saved') }}';
        FleetCart.langs['product::products.variants.variants'] = '{{ trans('product::products.variants.variants') }}';
        FleetCart.langs['product::products.variants.variant'] = '{{ trans('product::products.variants.variant') }}';
        FleetCart.langs['product::products.variants.bulk_variants_updated'] = '{{ trans('product::products.variants.bulk_variants_updated') }}';
        FleetCart.langs['product::products.variants.variants_created'] = '{{ trans('product::products.variants.variants_created') }}';
        FleetCart.langs['product::products.variants.variants_removed'] = '{{ trans('product::products.variants.variants_removed') }}';
        FleetCart.langs['product::products.variants.variants_reordered'] = '{{ trans('product::products.variants.variants_reordered') }}';
        FleetCart.langs['product::products.variants.disable_default_variant'] = '{{ trans('product::products.variants.disable_default_variant') }}';
        FleetCart.langs['product::products.options.option_inserted'] = '{{ trans('product::products.options.option_inserted') }}';
    </script>

    @vite([
        'modules/Product/Resources/assets/admin/sass/main.scss',
        'modules/Product/Resources/assets/admin/js/edit.js',
        'modules/Attribute/Resources/assets/admin/sass/main.scss',
        'modules/Variation/Resources/assets/admin/sass/main.scss',
        'modules/Option/Resources/assets/admin/sass/main.scss',
        'modules/Media/Resources/assets/admin/sass/main.scss',
        'modules/Media/Resources/assets/admin/js/main.js',
    ])
@endpush
