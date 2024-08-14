@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('variation::variations.variations'))

    <li class="active">{{ trans('variation::variations.variations') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'variations')
    @slot('name', trans('variation::variations.variation'))

    @slot('thead')
        <tr>
            @include('admin::partials.table.select_all')

            <th>{{ trans('admin::admin.table.id') }}</th>
            <th>{{ trans('variation::variations.table.name') }}</th>
            <th>{{ trans('variation::variations.table.type') }}</th>
            <th data-sort>{{ trans('admin::admin.table.updated') }}</th>
        </tr>
    @endslot
@endcomponent

@push('scripts')
    <script type="module">
        new DataTable('#variations-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'id', width: '5%' },
                { data: 'name', name: 'translations.name', orderable: false, defaultContent: '' },
                { data: 'type', name: 'type' },
                { data: 'updated', name: 'updated_at' },
            ],
        });
    </script>
@endpush
