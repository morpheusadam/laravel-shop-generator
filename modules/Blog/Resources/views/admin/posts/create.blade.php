@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.create', ['resource' => trans('blog::admin.blog_post.name')]))

    <li><a href="{{ route('admin.blog_posts.index') }}">{{ trans('blog::admin.blog_posts.name') }}</a></li>
    <li class="active">{{ trans('admin::resource.create', ['resource' => trans('blog::admin.blog_post.name')]) }}</li>
@endcomponent

@section('content')
    <form
        x-data="postCreate"
        @input="errors.clear($event.target.name)"
        @submit.prevent
        class="blog-post-form form"
        id="blog-create-form"
        x-ref="form"
    >
        <div class="row">
            <div class="form-left-column col-lg-8 col-md-12">
                @include('blog::admin.posts.groups.general')
                @include('blog::admin.posts.groups.seo')
            </div>

            <div class="form-right-column col-lg-4 col-md-12">
                @include('blog::admin.posts.groups.featured_image')
                @include('blog::admin.posts.groups.publish')
                @include('blog::admin.posts.groups.categories')
                @include('blog::admin.posts.groups.tags')
            </div>
        </div>

        <div class="page-form-footer">
            <button
                type="button"
                class="btn btn-default"
                :class="{ 'btn-loading': formSubmissionType === 'save' }"
                :disabled="formSubmitting"
                @click="handleSubmit({
                    submissionType: 'save'
                })"
            >
                {{ trans('admin::admin.buttons.save') }}
            </button>

            <button
                type="button"
                class="btn btn-secondary"
                :class="{ 'btn-loading': formSubmissionType === 'save_and_edit' }"
                :disabled="formSubmitting"
                @click="handleSubmit({
                    submissionType: 'save_and_edit'
                })"
            >
                {{ trans('admin::admin.buttons.save_and_edit') }}
            </button>

            <button
                type="button"
                class="btn btn-primary"
                :class="{ 'btn-loading': formSubmissionType === 'save_and_exit' }"
                :disabled="formSubmitting"
                @click="handleSubmit({
                    submissionType: 'save_and_exit'
                })"
            >
                {{ trans('admin::admin.buttons.save_and_exit') }}
            </button>
        </div>
    </form>
@endsection

@include('blog::admin.posts.partials.shortcuts')

@push('globals')
    @vite([
        'modules/Blog/Resources/assets/admin/posts/sass/main.scss',
        'modules/Blog/Resources/assets/admin/posts/js/create.js',
        'modules/Media/Resources/assets/admin/sass/main.scss',
        'modules/Media/Resources/assets/admin/js/main.js',
    ])
@endpush
