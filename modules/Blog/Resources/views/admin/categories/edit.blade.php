@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('blog::admin.blog_category.name')]))
    @slot('subtitle', $blogCategory->name)

    <li><a href="{{ route('admin.blog_categories.index') }}">{{ trans('blog::admin.blog_categories.name') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('blog::admin.blog_category.name')]) }}</li>
@endcomponent

@section('content')
    <div class="box">
        <div class="box-body">
            <form method="POST" action="{{ route('admin.blog_categories.update', $blogCategory) }}" class="form-horizontal blog-create-form-spacing" id="blog-edit-form" novalidate>
                {{ csrf_field() }}
                {{ method_field('put') }}
                
                @include('blog::admin.categories.partials.form')
            </form>
        </div>
    </div>
@endsection

@include('blog::admin.categories.partials.shortcuts')
