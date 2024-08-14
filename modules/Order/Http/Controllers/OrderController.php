<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Http\Response;

class OrderController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('order::index');
    }


    /**
     * Show the specified resource.
     *
     * @return Response
     */
    public function show()
    {
        return view('order::show');
    }
}
