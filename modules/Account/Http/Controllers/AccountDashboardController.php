<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Http\Response;

class AccountDashboardController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('storefront::public.account.dashboard.index', [
            'account' => auth()->user(),
            'recentOrders' => auth()->user()->recentOrders(5),
        ]);
    }
}
