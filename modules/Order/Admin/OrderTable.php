<?php

namespace Modules\Order\Admin;

use Modules\Admin\Ui\AdminTable;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Exceptions\Exception;

class OrderTable extends AdminTable
{
    /**
     * Raw columns that will not be escaped.
     *
     * @var array
     */
    protected array $defaultRawColumns = [
        'status',
    ];

    /**
     * Make table response for the resource.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function make()
    {
        return $this->newTable()
            ->addColumn('customer_name', function ($order) {
                return $order->customer_full_name;
            })
            ->editColumn('total', function ($order) {
                return $order->total->format();
            })
            ->editColumn('status', function ($order) {
                return '<span class="badge ' . order_status_badge_class($order->status) . '">' . $order->status() . '</span>';
            });
    }
}
