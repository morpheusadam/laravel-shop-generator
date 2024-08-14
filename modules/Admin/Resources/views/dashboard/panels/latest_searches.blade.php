<div class="dashboard-panel">
    <div class="grid-header">
        <h5>{{ trans('admin::dashboard.latest_searches') }}</h5>
    </div>

    <div class="clearfix"></div>

    <div class="table-responsive search-terms anchor-table">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ trans('admin::dashboard.table.latest_searches.keyword') }}</th>

                    <th>{{ trans('admin::dashboard.table.latest_searches.results') }}</th>
                    
                    <th>{{ trans('admin::dashboard.table.latest_searches.hits') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($latestSearchTerms as $latestSearchTerm)
                    <tr>
                        <td>{{ $latestSearchTerm->term }}</td>

                        <td>{{ $latestSearchTerm->results }}</td>

                        <td>{{ $latestSearchTerm->hits }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="empty" colspan="5">{{ trans('admin::dashboard.no_data') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
