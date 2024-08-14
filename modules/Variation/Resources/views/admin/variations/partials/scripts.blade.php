@push('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('admin::admin.shortcuts.back_to_index', ['name' => trans('variation::variations.variation')]) }}</dd>
    </dl>
@endpush

@push('scripts')
    <script type="module">
        keypressAction([{
            key: 'b',
            route: "{{ route('admin.variations.index') }}"
        }, ]);
    </script>
@endpush
