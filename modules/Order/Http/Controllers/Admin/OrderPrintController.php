<?php

namespace Modules\Order\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Order\Entities\Order;

class OrderPrintController
{
    /**
     * Show the specified resource.
     *
     * @param Order $order
     *
     * @return Response
     */
    public function show(Order $order)
    {
        $order->load('products', 'coupon', 'taxes');

        return view('order::admin.orders.print.show', compact('order'));
    }
}
