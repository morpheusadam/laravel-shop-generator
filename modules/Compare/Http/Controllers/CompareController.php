<?php

namespace Modules\Compare\Http\Controllers;

use Modules\Compare\Compare;
use Illuminate\Http\Response;

class CompareController
{
    /**
     * Display a listing of the resource.
     *
     * @param Compare $compare
     *
     * @return Response
     */
    public function index(Compare $compare)
    {
        return view('storefront::public.compare.index', compact('compare'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param Compare $compare
     *
     * @return Response
     */
    public function store(Compare $compare)
    {
        $compare->store(request('productId'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $productId
     * @param Compare $compare
     *
     * @return Response
     */
    public function destroy($productId, Compare $compare)
    {
        $compare->remove($productId);
    }
}
