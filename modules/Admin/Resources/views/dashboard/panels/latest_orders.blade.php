<div class="dashboard-panel latest-order">
    <div class="grid-header">
        <h5>{{ trans('admin::dashboard.latest_orders') }}</h5>
    </div>

    <div class="clearfix"></div>

    <div class="table-responsive anchor-table">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ trans('admin::dashboard.table.latest_orders.order_id') }}</th>
                    <th>{{ trans('admin::dashboard.table.customer') }}</th>
                    <th>{{ trans('admin::dashboard.table.latest_orders.status') }}</th>
                    <th>{{ trans('admin::dashboard.table.latest_orders.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($latestOrders as $latestOrder)
                    <tr>
                        <td>
                            <a href="{{ route('admin.orders.show', $latestOrder) }}">
                                {{ $latestOrder->id }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $latestOrder) }}">
                                {{ $latestOrder->customer_full_name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $latestOrder) }}">
                                <span class="badge {{ order_status_badge_class($latestOrder->status) }}">
                                    {{ $latestOrder->status() }}
                                </span>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $latestOrder) }}">
                                {{ $latestOrder->total->format() }}
                            </a>
                        </td>
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
