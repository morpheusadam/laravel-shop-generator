<?php

namespace Modules\Checkout\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Cart\Facades\Cart;
use Modules\Order\Entities\Order;
use Modules\Checkout\Services\OrderService;

class PaymentCanceledController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param int $orderId
     * @param string $paymentMethod
     * @param OrderService $orderService
     */
    public function store(Request $request, $orderId)
    {
        Order::where('id', $orderId)->forceDelete();

        Cart::restoreStock();

        if ($request->ajax()) {
            return response()->json(
                [
                    'success' => true,
                    'message' => trans('payment::messages.payment_cancelled'),
                ]
            );
        }

        return redirect()
            ->route('checkout.create')
            ->with('error', trans('payment::messages.payment_cancelled'));
    }
}
