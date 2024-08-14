@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('support::sitemap.sitemap'))

    <li class="active">{{ trans('support::sitemap.sitemap') }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.sitemaps.store') }}" enctype="multipart/form-data"
          class="form-horizontal">
        @csrf

        <div class="accordion-content">
            <div class="accordion-box-content clearfix">
                <div class="col-md-12">
                    <div class="accordion-box-content">
                        <div class="tab-content clearfix">
                            <div class="tab-pane fade in active">
                                <h4 class="tab-content-title">
                                    {{ trans('support::sitemap.generate_sitemap') }}
                                </h4>

                                <div class="row btn-generate-sitemap">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" data-loading>
                                            {{ trans('support::sitemap.generate') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
