<?php

namespace Modules\Admin\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Order\Entities\Order;

class SalesAnalyticsController
{
    /**
     * Display a listing of the resource.
     *
     * @param Order $order
     *
     * @return Response
     */
    public function index(Order $order)
    {
        return response()->json([
            'labels' => trans('admin::dashboard.sales_analytics.day_names'),
            'data' => $order->salesAnalytics(),
        ]);
    }
}
