@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('report::admin.reports'))

    <li class="active">{{ trans('report::admin.reports') }}</li>
@endcomponent

@section('content')
    <div class="report-wrapper">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="report-result box">
                    @yield('report_result')
                </div>
            </div>

            <div class="col-lg-3 col-md-4">
                <div class="filter-report box">
                    <div class="box-header">
                        <h5 class="tab-content-title">{{ trans('report::admin.filter') }}</h5>
                    </div>

                    <div class="box-body">
                        <form method="GET" action="{{ route('admin.reports.index') }}">
                            <div class="form-group">
                                <label for="report-type">{{ trans('report::admin.filters.report_type') }}</label>

                                <select name="type" id="report-type" class="custom-select-black">
                                    @foreach (trans('report::admin.filters.report_types') as $type => $label)
                                        <option value="{{ $type }}" {{ $request->type === $type ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @yield('filters')

                            <button type="submit" class="btn btn-default" data-loading>
                                {{ trans('report::admin.filter') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('globals')
    @vite([
        'modules/Report/Resources/assets/admin/sass/main.scss',
        'modules/Report/Resources/assets/admin/js/main.js'
    ])
@endpush
