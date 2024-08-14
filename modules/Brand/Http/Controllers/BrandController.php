<?php

namespace Modules\Brand\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Brand\Entities\Brand;

class BrandController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index()
    {
        return view('storefront::public.brands.index', [
            'brands' => Brand::with('files')->get(),
        ]);
    }
}
