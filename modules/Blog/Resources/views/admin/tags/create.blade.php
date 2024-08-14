@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.create', ['resource' => trans('blog::admin.blog_tag.name')]))

    <li><a href="{{ route('admin.blog_tags.index') }}">{{ trans('blog::admin.blog_tags.name') }}</a></li>
    <li class="active">{{ trans('admin::resource.create', ['resource' => trans('blog::admin.blog_tag.name')]) }}</li>
@endcomponent

@section('content')
    <div class="box">
        <div class="box-body">
            <form method="POST" action="{{ route('admin.blog_tags.store') }}" class="form-horizontal blog-create-form-spacing" id="blog-create-form" novalidate>
                {{ csrf_field() }}
                
                @include('blog::admin.tags.partials.form')
            </form>
        </div>
    </div>
@endsection

@include('blog::admin.tags.partials.shortcuts')
