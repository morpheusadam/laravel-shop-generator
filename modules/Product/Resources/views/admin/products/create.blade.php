@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.create', ['resource' => trans('product::products.product')]))

    <li><a href="{{ route('admin.products.index') }}">{{ trans('product::products.products') }}</a></li>
    <li class="active">{{ trans('admin::resource.create', ['resource' => trans('product::products.product')]) }}</li>
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
                    class="btn btn-secondary"
                    :class="{ 'btn-loading': formSubmissionType === 'save_and_edit' }"
                    :disabled="formSubmissionType"
                    @click="submit({ submissionType: 'save_and_edit' })"
                >
                    {{ trans('product::products.save_and_edit') }}
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

@push('globals')
    <script>
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
        'modules/Product/Resources/assets/admin/js/create.js',
        'modules/Attribute/Resources/assets/admin/sass/main.scss',
        'modules/Variation/Resources/assets/admin/sass/main.scss',
        'modules/Option/Resources/assets/admin/sass/main.scss',
        'modules/Media/Resources/assets/admin/sass/main.scss',
        'modules/Media/Resources/assets/admin/js/main.js',
    ])
@endpush
