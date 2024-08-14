@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('blog::admin.blog')]))

    <li><a href="{{ route('admin.blog_tags.index') }}">{{ trans('blog::admin.blogs.name') }}</a></li>
    <li class="active">{{ trans('admin::resource.create', ['resource' => trans('blog::admin.blog')]) }}</li>
@endcomponent

@section('content')
    <div class="box">
        <div class="box-body">
            <form method="POST" action="{{ route('admin.blog_tags.update', $blogTag) }}" class="form-horizontal blog-create-form-spacing" id="blog-create-form" novalidate>
                {{ csrf_field() }}
                {{ method_field('put') }}
                
                @include('blog::admin.tags.partials.form')
            </form>
        </div>
    </div>
@endsection

@include('blog::admin.tags.partials.shortcuts')
